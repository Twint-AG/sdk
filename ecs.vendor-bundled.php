<?php

declare(strict_types=1);

use SlevomatCodingStandard\Sniffs\TypeHints\NullableTypeForNullDefaultValueSniff;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([__DIR__ . '/vendor-bundled'])
    ->withRules([NullableTypeForNullDefaultValueSniff::class]);
