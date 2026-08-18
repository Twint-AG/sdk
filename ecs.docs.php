<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\NoMultilineWhitespaceAroundDoubleArrowFixer;
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
    // NoMultilineWhitespaceAroundDoubleArrowFixer joins the two sides of a `=>` onto one
    // line, which the narrow documentation line length then rejects as too long. Neither
    // side gives way, so the examples would never format cleanly with both enabled.
    ->withSkip([DeclareStrictTypesFixer::class, NoMultilineWhitespaceAroundDoubleArrowFixer::class])
    ->withCache(__DIR__ . '/build/ecs/docs');
