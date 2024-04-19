<?php

namespace Acme;

use Twint\Sdk\Client;
use Twint\Sdk\Value\Environment;
use Twint\Sdk\Value\MerchantId;
use Twint\Sdk\Value\Version;
use function Psl\Type\string;

$client = new Client(
    $certificateContainer,
    MerchantId::fromString($merchantId),
    Version::latest(),
    Environment::TESTING()
);

$device = $client->detectDevice(
    string()
        ->assert($_SERVER['HTTP_USER_AGENT'] ?? '')
);

if ($device->isAndroid()) {
    // Android flow
    handle();
} elseif ($device->isIos()) {
    // iOS flow
    handle();
} else {
    // Regular flow
    handle();
}
