<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

enum SystemStatus: string
{
    case OK = 'OK';

    case ERROR = 'ERROR';

    public function isOk(): bool
    {
        return $this === self::OK;
    }
}
