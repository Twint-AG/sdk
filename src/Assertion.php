<?php

declare(strict_types=1);

namespace Twint\Sdk;

use Assert\Assertion as BaseAssertion;
use Twint\Sdk\Exception\AssertionFailed;

final class Assertion extends BaseAssertion
{
    public const INVALID_BYTE_LENGTH = 1000;

    protected static $exceptionClass = AssertionFailed::class;

    /**
     * @throws AssertionFailed
     */
    public static function byteLength(string $value, int $length, string $message = null): void
    {
        $actualLength = strlen($value);

        if ($actualLength !== $length) {
            /** @var AssertionFailed */
            throw self::createException(
                $value,
                $message ?? sprintf('Expected a string of %d bytes, got %d', $length, $actualLength),
                self::INVALID_BYTE_LENGTH
            );
        }
    }
}
