<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

interface ToPkcs1
{
    public function pkcs1(): Pkcs1Certificate;
}
