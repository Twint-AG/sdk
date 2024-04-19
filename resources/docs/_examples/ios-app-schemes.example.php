<?php

namespace Acme;

use Twint\Sdk\Client;
use Twint\Sdk\Value\Environment;
use Twint\Sdk\Value\MerchantId;
use Twint\Sdk\Value\Version;

$client = new Client(
    $certificateContainer,
    MerchantId::fromString($merchantId),
    Version::latest(),
    Environment::TESTING()
);

$schemes = $client->getIosAppSchemes();

// Print list of links
foreach ($schemes as $scheme) {
    printf(
        '<a href="%s">%s</a>%s',
        $scheme->scheme(),
        $scheme->displayName(),
        PHP_EOL
    );
}
