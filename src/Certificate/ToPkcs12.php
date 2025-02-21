<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

interface ToPkcs12
{
    public function pkcs12(): Pkcs12Certificate;
}
