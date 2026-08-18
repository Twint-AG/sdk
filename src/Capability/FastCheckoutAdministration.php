<?php

declare(strict_types=1);

namespace Twint\Sdk\Capability;

use Twint\Sdk\Value\FastCheckoutCheckIn;
use Twint\Sdk\Value\PairingUuid;

interface FastCheckoutAdministration extends OrderAdministration
{
    public function monitorFastCheckoutCheckIn(PairingUuid $pairingUuid): FastCheckoutCheckIn;

    public function cancelFastCheckoutCheckIn(PairingUuid $pairingUuid): void;
}
