<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools;

require_once __DIR__ . '/../vendor/autoload.php';

use JsonException;
use Symfony\Component\Dotenv\Dotenv;
use Twint\Sdk\Tools\WireMock\DefaultWireMockFactory;
use Twint\Sdk\Value\Version;
use WireMock\Client\ListStubMappingsResult;
use WireMock\Client\WireMock;
use WireMock\Serde\SerializationException;
use WireMock\Serde\SerializerFactory;
use function Psl\invariant_violation;
use function Psl\Type\bool;
use function Psl\Type\dict;
use function Psl\Type\instance_of;
use function Psl\Type\non_empty_string;
use function Psl\Type\optional;
use function Psl\Type\shape;
use function Psl\Type\string;
use function Psl\Type\uint;
use function Psl\Type\union;
use function Psl\Type\vec;

$env = new Dotenv();
$env->load(__DIR__ . '/../.env');

/**
 * @param array<string,mixed> $bodyPattern
 * @return array<string,mixed>
 */
function fixBodyPatterns(array $bodyPattern): array
{
    if (!isset($bodyPattern['not'])) {
        return $bodyPattern;
    }

    $negated = dict(string(), union(string(), bool()))
        ->assert($bodyPattern['not']);

    return [
        negate(array_keys($negated)[0]) => array_values($negated)[0],
    ];
}

function negate(string $operator): string
{
    return match ($operator) {
        'contains' => 'doesNotContain',
        'match' => 'doesNotMatch',
        default => invariant_violation('Unknown operator: "%s"', $operator),
    };
}

/**
 * @throws JsonException
 * @return array{mappings: list<mixed>, meta: array{total: int}}
 */
function clean(string $file): array
{
    $content = non_empty_string()
        ->assert(file_get_contents($file));

    $stubs = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

    $stringPatterns = [
        'contains',
        'doesNotContain',
        'binaryEqualTo',
        'doesNotMatch',
        'matches',
        'before',
        'equalToDateTime',
        'after',
        'equalTo',
        'matchesXPath',
        'equalToXml',
        'matchesJsonPath',
        'equalToJson',
    ];

    $patterns = union(
        shape([
            'absent' => bool(),
        ]),
        ...array_map(static fn (string $pattern) => shape([
            $pattern => string(),
        ]), $stringPatterns),
    );

    $logical = shape([
        'and' => vec($patterns),
        'or' => vec($patterns),
    ]);

    $not = shape([
        'not' => $patterns,
    ]);

    $brokenBodyPattern = union($patterns, $logical, $not);
    $fixedBodyPattern = union($patterns, $logical);

    $stubs = shape([
        'mappings' => vec(shape([
            'request' => optional(shape([
                'bodyPatterns' => optional(vec($brokenBodyPattern)),
            ], true)),
        ], true)),
    ], true)->assert($stubs);

    $stubs['mappings'] = array_map(
        static fn (array $stub) => isset($stub['request']['bodyPatterns'])
            ? [...$stub, ...[
                'request' => [
                    ...$stub['request'],
                    'bodyPatterns' => array_map(fixBodyPatterns(...), $stub['request']['bodyPatterns']),
                ],
            ]]
            : $stub,
        $stubs['mappings']
    );

    return shape([
        'mappings' => vec(shape([
            'request' => optional(shape([
                'bodyPatterns' => optional(vec($fixedBodyPattern)),
            ], true)),
        ], true)),
        'meta' => shape([
            'total' => uint(),
        ], true),
    ], true)->assert($stubs);
}

/**
 * @param list<string> $files
 * @throws JsonException
 * @throws SerializationException
 */
function import(WireMock $wireMock, array $files): void
{
    $mergedStubs = [
        'mappings' => [],
    ];

    foreach ($files as $file) {
        $stubs = clean($file);

        $mergedStubs['mappings'] = [...$mergedStubs['mappings'], ...$stubs['mappings']];
        $mergedStubs['meta'] = [
            'total' => count($mergedStubs['mappings']),
        ];
    }

    $mappings = instance_of(ListStubMappingsResult::class)
        ->assert(
            SerializerFactory::default()
                ->deserialize(json_encode($mergedStubs, JSON_THROW_ON_ERROR), ListStubMappingsResult::class)
        );

    $wireMock->importStubs(
        array_reduce(
            $mappings->getMappings(),
            static fn ($import, $mapping) => $import->stub($mapping),
            WireMock::stubImport()
                ->deleteAllExistingStubsNotInImport()
                ->overwriteExisting()
        )
    );
}


$wireMock = (new DefaultWireMockFactory())();
$wireMock->isAlive();

import(
    $wireMock,
    [
        __DIR__ . '/../tests/fixtures/wiremock/stubs-v' . Version::latest()->dotVersion() . '.json',
        __DIR__ . '/../tests/fixtures/wiremock/stubs-v' . Version::next()->dotVersion() . '.json',
    ]
);
