<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use Twint\Sdk\Assertion;
use Twint\Sdk\Value\Uuid;

final class Uuid4Factory
{
    public function __invoke(): Uuid
    {
        $data = random_bytes(32);

        Assertion::minLength($data, 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return new Uuid(vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)));
    }
}
