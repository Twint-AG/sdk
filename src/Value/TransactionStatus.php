<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

enum TransactionStatus: string
{
    case ORDER_OK = 'ORDER_OK';

    case ORDER_PARTIAL_OK = 'ORDER_PARTIAL_OK';

    case ORDER_RECEIVED = 'ORDER_RECEIVED';

    case ORDER_PENDING = 'ORDER_PENDING';

    case ORDER_CONFIRMATION_PENDING = 'ORDER_CONFIRMATION_PENDING';

    case GENERAL_ERROR = 'GENERAL_ERROR';

    case CLIENT_TIMEOUT = 'CLIENT_TIMEOUT';

    case MERCHANT_ABORT = 'MERCHANT_ABORT';

    case CUSTOMER_ABORT = 'CUSTOMER_ABORT';

    case CLIENT_ABORT = 'CLIENT_ABORT';
}
