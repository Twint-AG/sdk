<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\WhiteSpace\LanguageConstructSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Commenting\DocCommentAlignmentSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\SuperfluousWhitespaceSniff;
use PhpCsFixer\Fixer\AttributeNotation\AttributeEmptyParenthesesFixer;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\FinalClassFixer;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleTraitInsertPerStatementFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionTypehintSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\FunctionNotation\StaticLambdaFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer;
use PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\NamespaceNotation\NoLeadingNamespaceWhitespaceFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\OperatorLinebreakFixer;
use PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocAnnotationRemoveFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAlignFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocIndentFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoUselessInheritdocFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocOrderByValueFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocParamOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSingleLineVarSpacingFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitConstructFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDataProviderNameFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDataProviderReturnTypeFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDataProviderStaticFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertInternalTypeFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitExpectationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitInternalClassFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMockFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMockShortWillReturnFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitNamespacedFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestCaseStaticMethodCallsFixer;
use PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Semicolon\SpaceAfterSemicolonFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use PhpCsFixer\Fixer\Strict\StrictParamFixer;
use PhpCsFixer\Fixer\Whitespace\IndentationTypeFixer;
use PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\NoSpacesAroundOffsetFixer;
use PhpCsFixer\Fixer\Whitespace\NoWhitespaceInBlankLineFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocTypesCommaSpacesFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocTypesTrimFixer;
use PhpCsFixerCustomFixers\Fixer\StringableInterfaceFixer;
use SlevomatCodingStandard\Sniffs\Attributes\AttributeAndTargetSpacingSniff;
use SlevomatCodingStandard\Sniffs\Attributes\AttributesOrderSniff;
use SlevomatCodingStandard\Sniffs\Attributes\DisallowAttributesJoiningSniff;
use SlevomatCodingStandard\Sniffs\Attributes\DisallowMultipleAttributesPerLineSniff;
use SlevomatCodingStandard\Sniffs\Attributes\RequireAttributeAfterDocCommentSniff;
use SlevomatCodingStandard\Sniffs\Classes\RequireMultiLineMethodSignatureSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\ReferenceUsedNamesOnlySniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DNFTypeHintFormatSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\NullableTypeForNullDefaultValueSniff;
use Symplify\CodingStandard\Fixer\Spacing\StandaloneLinePromotedPropertyFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([__DIR__])
    ->withSkip([
        __DIR__ . '/vendor',
        __DIR__ . '/build',
        FinalClassFixer::class => [__DIR__ . '/src/Generated/'],
        PhpUnitDataProviderNameFixer::class,
    ])
    ->withFileExtensions(['php', 'inc'])
    ->withRules([
        NoUnusedImportsFixer::class,
        FinalClassFixer::class,
        FullyQualifiedStrictTypesFixer::class,
        GlobalNamespaceImportFixer::class,
        NoLeadingImportSlashFixer::class,
        StaticLambdaFixer::class,
        ReferenceUsedNamesOnlySniff::class,
        NullableTypeForNullDefaultValueSniff::class,
        StandaloneLinePromotedPropertyFixer::class,
        BlankLineAfterOpeningTagFixer::class,
        IndentationTypeFixer::class,
        MethodChainingIndentationFixer::class,
        CastSpacesFixer::class,
        SingleTraitInsertPerStatementFixer::class,
        FunctionTypehintSpaceFixer::class,
        NoBlankLinesAfterClassOpeningFixer::class,
        NoSinglelineWhitespaceBeforeSemicolonsFixer::class,
        NoLeadingNamespaceWhitespaceFixer::class,
        NoSpacesAroundOffsetFixer::class,
        NoWhitespaceInBlankLineFixer::class,
        ReturnTypeDeclarationFixer::class,
        SpaceAfterSemicolonFixer::class,
        TernaryOperatorSpacesFixer::class,
        MethodArgumentSpaceFixer::class,
        LanguageConstructSpacingSniff::class,
        RequireMultiLineMethodSignatureSniff::class,
        PhpUnitConstructFixer::class,
        PhpUnitDataProviderNameFixer::class,
        PhpUnitDataProviderReturnTypeFixer::class,
        PhpUnitDataProviderStaticFixer::class,
        PhpUnitDedicateAssertFixer::class,
        PhpUnitDedicateAssertInternalTypeFixer::class,
        PhpUnitExpectationFixer::class,
        PhpUnitInternalClassFixer::class,
        PhpUnitMethodCasingFixer::class,
        PhpUnitMockFixer::class,
        PhpUnitMockShortWillReturnFixer::class,
        PhpUnitNamespacedFixer::class,
        PhpUnitStrictFixer::class,
        PhpdocSingleLineVarSpacingFixer::class,
        PhpdocIndentFixer::class,
        PhpdocOrderFixer::class,
        PhpdocParamOrderFixer::class,
        PhpdocOrderByValueFixer::class,
        DocCommentAlignmentSniff::class,
        PhpdocNoUselessInheritdocFixer::class,
        PhpdocTypesCommaSpacesFixer::class,
        PhpdocTypesTrimFixer::class,
        AttributeEmptyParenthesesFixer::class,
        RequireAttributeAfterDocCommentSniff::class,
        DisallowMultipleAttributesPerLineSniff::class,
        DisallowAttributesJoiningSniff::class,
        AttributeAndTargetSpacingSniff::class,
        StrictParamFixer::class,
        StrictComparisonFixer::class,
        DeclareStrictTypesFixer::class,
        StringableInterfaceFixer::class,
    ])
    ->withConfiguredRule(OrderedImportsFixer::class, [
        'imports_order' => ['class', 'const', 'function'],
    ])
    ->withConfiguredRule(DNFTypeHintFormatSniff::class, [
        'enable' => true,
        'enableForDocComments' => true,
        'nullPosition' => 'last',
        'withSpacesAroundOperators' => 'no',
        'withSpacesInsideParentheses' => 'no',
        'shortNullable' => 'yes',
    ])
    ->withConfiguredRule(ClassAttributesSeparationFixer::class, [
        'elements' => [
            'const' => 'one',
            'property' => 'one',
            'method' => 'one',
        ],
    ])
    ->withConfiguredRule(ConcatSpaceFixer::class, [
        'spacing' => 'one',
    ])
    ->withConfiguredRule(SuperfluousWhitespaceSniff::class, [
        'ignoreBlankLines' => false,
    ])
    ->withConfiguredRule(BinaryOperatorSpacesFixer::class, [
        'operators' => [
            '=>' => 'single_space',
            '=' => 'single_space',
        ],
    ])
    ->withConfiguredRule(OperatorLinebreakFixer::class, [
        'only_booleans' => true,
        'position' => 'beginning',
    ])
    ->withConfiguredRule(OrderedClassElementsFixer::class, [
        'order' => [
            'use_trait',
            'constant',
            'property',
            'construct',
            'destruct',
            'method_public_static',
            'magic',
            'method',
        ],
    ])
    ->withConfiguredRule(PhpUnitTestCaseStaticMethodCallsFixer::class, [
        'call_type' => 'self',
    ])
    ->withConfiguredRule(GeneralPhpdocAnnotationRemoveFixer::class, [
        'annotations' => ['author', 'package', 'category'],
    ])
    ->withConfiguredRule(PhpdocAlignFixer::class, [
        'align' => 'left',
    ])
    ->withConfiguredRule(AttributesOrderSniff::class, [
        'orderAlphabetically' => true,
    ])
    ->withPreparedSets(
        psr12: true,
        symplify: true,
        arrays: true,
        comments: true,
        docblocks: true,
        namespaces: true,
        controlStructures: true,
        cleanCode: true,
    )
    ->withParallel(120, 2, 10);
