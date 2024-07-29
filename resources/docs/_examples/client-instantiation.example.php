<?php

namespace Acme;

use Twint\Sdk\Client;
use Twint\Sdk\Io\ContentSensitiveFileWriter;
use Twint\Sdk\Value\Environment;
use Twint\Sdk\Value\ExistingPath;
use Twint\Sdk\Value\StoreUuid;
use Twint\Sdk\Value\Version;
use function Psl\Type\string;

$client = new Client(
    $certificateContainer,
    StoreUuid::fromString($storeUuid),
    Version::latest(),
    Environment::TESTING()
);


// Production start
$client = new Client(
    $certificateContainer,
    StoreUuid::fromString($storeUuid),
    Version::latest(),
    Environment::PRODUCTION()
);
// Production end


// Custom file writer start
$client = new Client(
    $certificateContainer,
    StoreUuid::fromString($storeUuid),
    Version::latest(),
    Environment::PRODUCTION(),
    new ContentSensitiveFileWriter(
        new ExistingPath($certificatePath),
        static fn (string $content) => string()
            ->assert(openssl_x509_fingerprint($content))
    )
);
// Custom file writer end
