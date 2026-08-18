<?php

declare(strict_types=1);

use Twint\Sdk\Capability\CustomUiFastCheckout;
use Twint\Sdk\Capability\CustomUiOrderCheckout;
use Twint\Sdk\Capability\FastCheckout;
use Twint\Sdk\Capability\OrderCheckout;
use Twint\Sdk\Certificate\PemCertificate;
use Twint\Sdk\Certificate\Pkcs8Certificate;

if (PHP_VERSION_ID < 80200 && !class_exists(SensitiveParameter::class)) {
    #[Attribute(Attribute::TARGET_PARAMETER)]
    final class SensitiveParameter
    {
    }
}

if (PHP_VERSION_ID < 80300 && !class_exists(Override::class)) {
    #[Attribute(Attribute::TARGET_METHOD)]
    final class Override
    {
    }
}

if (PHP_VERSION_ID < 80400 && !class_exists(Deprecated::class)) {
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

class_alias(Pkcs8Certificate::class, PemCertificate::class);
class_alias(CustomUiFastCheckout::class, FastCheckout::class);
class_alias(CustomUiOrderCheckout::class, OrderCheckout::class);
