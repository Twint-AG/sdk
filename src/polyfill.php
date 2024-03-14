<?php

declare(strict_types=1);

if (PHP_VERSION_ID < 80200) {
    #[Attribute(Attribute::TARGET_PARAMETER)]
    final class SensitiveParameter
    {
    }
}
