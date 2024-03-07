<?php

declare(strict_types=1);

namespace Twint\Sdk\CodeGeneration;

use Phpro\SoapClient\CodeGenerator\Assembler;
use Phpro\SoapClient\CodeGenerator\Config\Config;
use Phpro\SoapClient\CodeGenerator\Rules;
use Soap\ExtSoapEngine\ExtSoapEngineFactory;
use Soap\ExtSoapEngine\ExtSoapOptions;
use Twint\Sdk\ApiVersion;

const BASE_DIR = __DIR__ . '/../..';
const GENERATED_NAMESPACE = 'Twint\Sdk\Generated';
const GENERATED_PATH = BASE_DIR . '/src/Generated';
const GENERATED_TYPES_NAMESPACE = 'Twint\Sdk\Generated\Type';
const GENERATED_TYPES_PATH = BASE_DIR . '/src/Generated/Type';
const GENERATED_CLIENT_NAME = 'TwintSoapClient';
const GENERATED_CLASS_MAP_NAME = 'TwintSoapClassMap';

$engine = ExtSoapEngineFactory::fromOptions(ExtSoapOptions::defaults(ApiVersion::wsdlPath())->disableWsdlCache());

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
