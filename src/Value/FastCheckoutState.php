<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

interface FastCheckoutState
{
    public function pairingUuid(): PairingUuid;

    public function pairingStatus(): PairingStatus;

    public function isPaired(): bool;
}
