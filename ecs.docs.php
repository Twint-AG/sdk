<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use SlevomatCodingStandard\Sniffs\Files\LineLengthSniff;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;

$docLineLength = 70;

return (require __DIR__ . '/ecs.base.php')
    ->withPaths([__DIR__ . '/resources/docs/_examples'])
    ->withConfiguredRule(LineLengthFixer::class, [
        'line_length' => $docLineLength,
    ])
    ->withConfiguredRule(LineLengthSniff::class, [
        'lineLengthLimit' => $docLineLength,
        'ignoreComments' => false,
    ])
    ->withSkip([DeclareStrictTypesFixer::class])
    ->withCache(__DIR__ . '/build/ecs/docs');
