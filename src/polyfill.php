<?php

declare(strict_types=1);

if (PHP_VERSION_ID < 80200) {
    #[Attribute(Attribute::TARGET_PARAMETER)]
    final class SensitiveParameter
    {
    }
}

if (PHP_VERSION_ID < 80300) {
    #[Attribute(Attribute::TARGET_METHOD)]
    final class Override
    {
    }
}

if (PHP_VERSION_ID < 80400) {
    #[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION | Attribute::TARGET_CLASS_CONSTANT)]
    final class Deprecated
    {
        public function __construct(
            public ?string $message = null,
            public ?string $since = null
        ) {
        }
    }
}
