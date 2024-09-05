<?php

declare(strict_types=1);

namespace Twint\Sdk\Soap;

use Throwable;

interface ErrorClassifier
{
    public const STATUS_TRANSITION_ERROR = 'STATUS_TRANSITION_ERROR';

    /**
     * @param self::* $type
     */
    public function isOfType(Throwable $t, string $type): bool;
}
