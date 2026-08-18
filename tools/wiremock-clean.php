<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools;

require_once __DIR__ . '/../vendor/autoload.php';

use JsonException;
use Symfony\Component\Dotenv\Dotenv;
use Twint\Sdk\Factory\Uuid5Factory;
use Twint\Sdk\Value\Uuid;
use function Psl\Type\non_empty_string;
use function Psl\Type\shape;
use function Psl\Type\uint;
use function Psl\Type\vec;

$env = new Dotenv();
$env->load(__DIR__ . '/../.env');

const UUID_NAMESPACE = '2f796948-c3f2-4988-a441-57f8c02f8e90';

/**
 * @param array{'id': string, 'uuid': string} $stub
 * @throws JsonException
 * @return array{'id': non-empty-string, 'uuid': non-empty-string}
 */
function rekeyMapping(array $stub): array
{
    unset($stub['id'], $stub['uuid']);
    $id = non_empty_string()
        ->assert((string) (new Uuid5Factory(new Uuid(UUID_NAMESPACE), json_encode($stub, JSON_THROW_ON_ERROR)))());

    return [
        'id' => $id,
        'uuid' => $id,
        ...$stub,
    ];
}

/**
 * @throws JsonException
 */
function rekeyMappings(string $file): void
{
    $content = non_empty_string()
        ->assert(file_get_contents($file));

    $stubs = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

    $stubs = shape([
        'mappings' => vec(shape([
            'id' => non_empty_string(),
            'uuid' => non_empty_string(),
        ], true)),
        'meta' => shape([
            'total' => uint(),
        ], true),
    ], true)->assert($stubs);

    $stubs['mappings'] = array_map(rekeyMapping(...), $stubs['mappings']);

    file_put_contents($file, json_encode($stubs, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
}

array_map(
    rekeyMappings(...),
    vec(non_empty_string())
        ->assert(glob(__DIR__ . '/../tests/fixtures/wiremock/stubs-*.json'))
);
