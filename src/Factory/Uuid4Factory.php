<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use Throwable;
use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;
use Twint\Sdk\Exception\CryptographyFailure;
use Twint\Sdk\Value\Uuid;

final class Uuid4Factory
{
    /**
     * @throws AssertionFailed
     * @throws CryptographyFailure
     */
    public function __invoke(): Uuid
    {
        try {
            $data = random_bytes(32);
        } catch (Throwable $e) {
            throw CryptographyFailure::fromThrowable($e);
        }

        Assertion::minLength($data, 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return new Uuid(vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)));
    }
}
