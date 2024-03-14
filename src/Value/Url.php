<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

final class Url
{
    /**
     * @throws AssertionFailed
     */
    public function __construct(
        private readonly string $url
    ) {
        Assertion::url($url, 'URL "%s" is not valid');
    }

    public function __toString(): string
    {
        return $this->url;
    }
}
