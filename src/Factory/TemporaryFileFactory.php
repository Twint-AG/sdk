<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\Timeout;
use Twint\Sdk\Util\Resilience;
use Twint\Sdk\Value\File;

final class TemporaryFileFactory
{
    public function __construct(
        private readonly string $prefix = 'twint-sdk',
        private readonly int $attempts = 10,
    ) {
    }

    /**
     * @throws Timeout
     */
    public function __invoke(): File
    {
        return Resilience::retry(
            $this->attempts,
            function (): File {
                $path = tempnam(sys_get_temp_dir(), $this->prefix);

                Assertion::notEmpty($path, 'Creating temporary file failed');
                Assertion::writeable($path, 'Temporary file is not writeable');

                return new File($path);
            }
        );
    }
}
