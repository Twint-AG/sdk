<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Basic\PsrAutoloadingFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->import(__DIR__ . '/ecs.base.php');
    $ecsConfig->paths([__DIR__]);
    $ecsConfig->skip([__DIR__ . '/resources/docs/_examples']);

    $ecsConfig->ruleWithConfiguration(PsrAutoloadingFixer::class, [
        'dir' => 'src',
    ]);
    $ecsConfig->ruleWithConfiguration(PsrAutoloadingFixer::class, [
        'dir' => 'tests',
    ]);
    $ecsConfig->ruleWithConfiguration(PsrAutoloadingFixer::class, [
        'dir' => 'tools',
    ]);

    $ecsConfig->cacheDirectory(__DIR__ . '/build/ecs/src');
};
