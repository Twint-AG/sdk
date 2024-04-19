<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use SlevomatCodingStandard\Sniffs\Files\LineLengthSniff;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $config) {
    static $docLineLength = 70;

    $config->import(__DIR__ . '/ecs.base.php');

    $config->paths([__DIR__ . '/resources/docs/_examples']);
    $config->ruleWithConfiguration(LineLengthFixer::class, [
        'line_length' => $docLineLength,
    ]);
    $config->ruleWithConfiguration(
        LineLengthSniff::class,
        [
            'lineLengthLimit' => $docLineLength,
            'ignoreComments' => false,
        ]
    );

    $config->skip([DeclareStrictTypesFixer::class]);

    $config->cacheDirectory(__DIR__ . '/build/ecs/docs');

    return $config;
};
