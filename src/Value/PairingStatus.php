<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

enum PairingStatus: string
{
    case NO_PAIRING = 'NO_PAIRING';

    case PAIRING_IN_PROGRESS = 'PAIRING_IN_PROGRESS';

    case PAIRING_ACTIVE = 'PAIRING_ACTIVE';
}
