<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

enum OrderStatus: string
{
    case IN_PROGRESS = 'IN_PROGRESS';

    case FAILURE = 'FAILURE';

    case SUCCESS = 'SUCCESS';
}
