<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Basic\PsrAutoloadingFixer;
use PhpCsFixer\Fixer\ClassNotation\FinalClassFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDataProviderNameFixer;

return (require __DIR__ . '/ecs.base.php')
    ->withPaths([__DIR__])
    ->withSkip([
        __DIR__ . '/vendor',
        __DIR__ . '/build',
        FinalClassFixer::class => [__DIR__ . '/src/Generated/'],
        PhpUnitDataProviderNameFixer::class,
        __DIR__ . '/resources/docs/_examples',
    ])
    ->withConfiguredRule(PsrAutoloadingFixer::class, [
        'dir' => 'src',
    ])
    ->withConfiguredRule(PsrAutoloadingFixer::class, [
        'dir' => 'tests',
    ])
    ->withConfiguredRule(PsrAutoloadingFixer::class, [
        'dir' => 'tools',
    ])
    ->withCache(__DIR__ . '/build/ecs/src');
