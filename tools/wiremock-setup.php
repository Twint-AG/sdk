<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools;

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
use Twint\Sdk\Tools\WireMock\DefaultWireMockFactory;
use WireMock\Client\ListStubMappingsResult;
use WireMock\Client\WireMock;
use WireMock\Serde\SerializerFactory;
use function Psl\Type\instance_of;
use function Psl\Type\non_empty_string;

$env = new Dotenv();
$env->load(__DIR__ . '/../.env');

$wireMock = (new DefaultWireMockFactory())();
$wireMock->isAlive();

$mappings = instance_of(ListStubMappingsResult::class)
    ->assert(SerializerFactory::default()->deserialize(
        non_empty_string()
            ->assert(file_get_contents(__DIR__ . '/../tests/fixtures/wiremock/stubs.json')),
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
