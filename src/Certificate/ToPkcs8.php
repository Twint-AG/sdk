<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

interface ToPkcs8
{
    public function pkcs8(): Pkcs8Certificate;
}
