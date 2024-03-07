<?php

declare(strict_types=1);

namespace Twint\Sdk;

use Assert\Assertion as BaseAssertion;
use Twint\Sdk\Exception\AssertionFailed;

final class Assertion extends BaseAssertion
{
    protected static $exceptionClass = AssertionFailed::class;
}
