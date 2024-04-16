<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools;

use function Psl\Type\non_empty_string;

final class SystemEnvironment
{
    /**
     * @param non-empty-string $name
     * @return non-empty-string
     */
    public static function get(string $name): string
    {
        return non_empty_string()->assert($_SERVER[$name] ?? '');
    }
}
