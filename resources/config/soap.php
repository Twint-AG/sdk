<?php

declare(strict_types=1);

namespace Twint\Sdk\CodeGeneration;

use Laminas\Code\Generator\DocBlockGenerator;
use Phpro\SoapClient\CodeGenerator\Assembler;
use Phpro\SoapClient\CodeGenerator\Config\Config;
use Phpro\SoapClient\CodeGenerator\Context\ContextInterface;
use Phpro\SoapClient\CodeGenerator\Context\TypeContext;
use Phpro\SoapClient\CodeGenerator\Rules;
use Soap\ExtSoapEngine\ExtSoapEngineFactory;
use Soap\ExtSoapEngine\ExtSoapOptions;
use Twint\Sdk\ApiVersion;
use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

const BASE_DIR = __DIR__ . '/../..';
const GENERATED_NAMESPACE = 'Twint\Sdk\Generated';
const GENERATED_PATH = BASE_DIR . '/src/Generated';
const GENERATED_TYPES_NAMESPACE = 'Twint\Sdk\Generated\Type';
const GENERATED_TYPES_PATH = BASE_DIR . '/src/Generated/Type';
const GENERATED_CLIENT_NAME = 'TwintSoapClient';
const GENERATED_CLASS_MAP_NAME = 'TwintSoapClassMap';

$engine = ExtSoapEngineFactory::fromOptions(ExtSoapOptions::defaults(ApiVersion::wsdlPath())->disableWsdlCache());

$allowDynamicPropertiesAssembler = new class() implements Assembler\AssemblerInterface {
    public function canAssemble(ContextInterface $context): bool
    {
        return $context instanceof TypeContext;
    }

    /**
     * @throws AssertionFailed
     */
    public function assemble(ContextInterface $context): void
    {
        Assertion::isInstanceOf($context, TypeContext::class);

        $class = $context->getClass();

        $class->setDocBlock(new class() extends DocBlockGenerator {
            public function generate(): string
            {
                return self::LINE_FEED . '#[\AllowDynamicProperties]' . parent::generate();
            }
        });
    }
};

return Config::create()
    ->setEngine($engine)
    ->setTypeDestination(GENERATED_TYPES_PATH)
    ->setTypeNamespace(GENERATED_TYPES_NAMESPACE)

    ->setClientDestination(GENERATED_PATH)
    ->setClientNamespace(GENERATED_NAMESPACE)
    ->setClientName(GENERATED_CLIENT_NAME)

    ->setClassMapDestination(GENERATED_PATH)
    ->setClassMapName(GENERATED_CLASS_MAP_NAME)
    ->setClassMapNamespace(GENERATED_NAMESPACE)

    ->addRule(new Rules\AssembleRule(new Assembler\GetterAssembler(new Assembler\GetterAssemblerOptions())))
    ->addRule(new Rules\AssembleRule(new Assembler\ImmutableSetterAssembler(
        new Assembler\ImmutableSetterAssemblerOptions()
    )))
    ->addRule(new Rules\AssembleRule($allowDynamicPropertiesAssembler))
    ->addRule(
        new Rules\IsRequestRule(
            $engine->getMetadata(),
            new Rules\MultiRule([
                new Rules\AssembleRule(new Assembler\RequestAssembler()),
                new Rules\AssembleRule(new Assembler\ConstructorAssembler(new Assembler\ConstructorAssemblerOptions())),
            ])
        )
    )
    ->addRule(
        new Rules\IsResultRule(
            $engine->getMetadata(),
            new Rules\MultiRule([new Rules\AssembleRule(new Assembler\ResultAssembler())])
        )
    )
;
