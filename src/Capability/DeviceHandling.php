<?php

declare(strict_types=1);

namespace Twint\Sdk\Capability;

use Twint\Sdk\Value\DetectedDevice;
use Twint\Sdk\Value\IosAppScheme;
use Twint\Sdk\Value\PairingToken;
use Twint\Sdk\Value\Url;

interface DeviceHandling extends Capability
{
    public function detectDevice(string $userAgent): DetectedDevice;

    /**
     * @return list<IosAppScheme>
     */
    public function getIosAppSchemes(): array;

    /**
     * @param PairingToken<scalar> $token
     */
    public function getIosAppUrl(IosAppScheme $scheme, PairingToken $token): Url;

    /**
     * @param PairingToken<scalar> $token
     */
    public function getAndroidAppUrl(PairingToken $token): Url;
}
