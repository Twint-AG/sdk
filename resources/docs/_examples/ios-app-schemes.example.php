<?php

namespace Acme;

use Twint\Sdk\Client;
use Twint\Sdk\Value\MerchantId;

$client = new Client(
    $certificateContainer,
    MerchantId::fromString($merchantId),
    $version,
    $environment
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
