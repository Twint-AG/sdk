<?php

declare(strict_types=1);

use SlevomatCodingStandard\Sniffs\TypeHints\NullableTypeForNullDefaultValueSniff;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([__DIR__ . '/vendor-bundled']);

    $ecsConfig->rules([NullableTypeForNullDefaultValueSniff::class]);
};
