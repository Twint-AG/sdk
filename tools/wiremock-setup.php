<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools;

require_once __DIR__ . '/../vendor/autoload.php';

use InvalidArgumentException;
use Symfony\Component\Dotenv\Dotenv;
use Twint\Sdk\Tools\WireMock\DefaultWireMockFactory;
use WireMock\Client\ListStubMappingsResult;
use WireMock\Client\WireMock;
use WireMock\Serde\SerializerFactory;
use function Psl\Type\bool;
use function Psl\Type\dict;
use function Psl\Type\instance_of;
use function Psl\Type\non_empty_string;
use function Psl\Type\optional;
use function Psl\Type\shape;
use function Psl\Type\string;
use function Psl\Type\union;
use function Psl\Type\vec;

$env = new Dotenv();
$env->load(__DIR__ . '/../.env');

$content = non_empty_string()
    ->assert(file_get_contents(__DIR__ . '/../tests/fixtures/wiremock/stubs.json'));

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

/**
 * @param array<string,mixed> $bodyPattern
 * @throws InvalidArgumentException
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

/**
 * @throws InvalidArgumentException
 */
function negate(string $operator): string
{
    return match ($operator) {
        'contains' => 'doesNotContain',
        'match' => 'doesNotMatch',
        default => throw new InvalidArgumentException(sprintf('Unknown operator: "%s"', $operator))
    };
}

$stubs['mappings'] = array_map(
    static fn (array $stub) => isset($stub['request']['bodyPatterns'])
        ? [...$stub, ...[
            'request' => [
                ...$stub['request'],
                'bodyPatterns' => array_map('Twint\Sdk\Tools\fixBodyPatterns', $stub['request']['bodyPatterns']),
            ],
        ]]
        : $stub,
    $stubs['mappings']
);

$stubs = shape([
    'mappings' => vec(shape([
        'request' => optional(shape([
            'bodyPatterns' => optional(vec($fixedBodyPattern)),
        ], true)),
    ], true)),
], true)->assert($stubs);


$wireMock = (new DefaultWireMockFactory())();
$wireMock->isAlive();

$mappings = instance_of(ListStubMappingsResult::class)
    ->assert(SerializerFactory::default()->deserialize(
        json_encode($stubs, JSON_THROW_ON_ERROR),
        ListStubMappingsResult::class
    ));

$wireMock->importStubs(
    array_reduce(
        $mappings->getMappings(),
        static fn ($import, $mapping) => $import->stub($mapping),
        WireMock::stubImport()
            ->deleteAllExistingStubsNotInImport()
            ->overwriteExisting()
    )
);
