<?php

declare(strict_types=1);

namespace Twint\Sdk\Exception;

use RuntimeException;

final class IoError extends RuntimeException implements SdkError
{
}
