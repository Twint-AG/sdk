<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

enum ShopPlatform: string
{
    case MAGENTO = 'mg';

    case SHOPWARE = 'sw';

    case WOOCOMMERCE = 'wc';

    case OTHER = 'ot';
}
