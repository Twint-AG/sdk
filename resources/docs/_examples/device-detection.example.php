<?php

namespace Acme;

use Twint\Sdk\Client;
use Twint\Sdk\Value\StoreUuid;
use function Psl\Type\string;

$client = new Client(
    $certificateContainer,
    StoreUuid::fromString($storeUuid),
    $version,
    $environment
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
