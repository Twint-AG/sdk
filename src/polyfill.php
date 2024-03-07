<?php

declare(strict_types=1);

if (PHP_VERSION_ID < 802000) {
    #[Attribute(Attribute::TARGET_PARAMETER)]
    final class SensitiveParameter
    {
    }
}
