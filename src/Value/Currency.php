<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

enum Currency: string
{
    case CHF = 'CHF';

    /**
     * @internal
     */
    case XXX = 'XXX';
}
