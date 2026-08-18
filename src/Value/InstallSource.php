<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

enum InstallSource: string
{
    case DIRECT = 'D';

    case STORE = 'S';
}
