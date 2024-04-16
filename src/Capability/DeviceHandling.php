<?php

declare(strict_types=1);

namespace Twint\Sdk\Capability;

use Twint\Sdk\Value\DetectedDevice;
use Twint\Sdk\Value\IosAppScheme;

interface DeviceHandling extends Capability
{
    public function detectDevice(string $userAgent): DetectedDevice;

    /**
     * @return list<IosAppScheme>
     */
    public function getIosAppSchemes(): array;
}
