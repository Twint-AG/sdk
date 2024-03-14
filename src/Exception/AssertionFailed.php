<?php

declare(strict_types=1);

namespace Twint\Sdk\Exception;

use Assert\InvalidArgumentException;

/**
 * @internal
 */
final class AssertionFailed extends InvalidArgumentException implements SdkError
{
}
