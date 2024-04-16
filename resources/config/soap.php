<?php

declare(strict_types=1);

namespace Twint\Sdk\CodeGeneration;

use Phpro\SoapClient\CodeGenerator\Assembler;
use Phpro\SoapClient\CodeGenerator\Config\Config;
use Phpro\SoapClient\CodeGenerator\Rules;
use Phpro\SoapClient\Soap\CodeGeneratorEngineFactory;
use Phpro\SoapClient\Soap\ExtSoap\Metadata\Manipulators\DuplicateTypes\IntersectDuplicateTypesStrategy;
use Phpro\SoapClient\Soap\Metadata\Manipulators\TypesManipulatorChain;
use Phpro\SoapClient\Soap\Metadata\MetadataOptions;
use Soap\Engine\Metadata\Model\Type;
use Soap\Engine\Metadata\Model\TypeMeta;
use Soap\Engine\Metadata\Model\XsdType;
use Soap\Wsdl\Loader\FlatteningLoader;
use Soap\Wsdl\Loader\StreamWrapperLoader;
use Twint\Sdk\Tools\Soap\ManipulatePropertyType;
use Twint\Sdk\Tools\Soap\RemoveTypes;
use Twint\Sdk\Tools\Soap\RenameReturnTypeByRegex;
use Twint\Sdk\Value\Environment;
use Twint\Sdk\Value\Version;

const BASE_DIR = __DIR__ . '/../..';
const GENERATED_NAMESPACE = 'Twint\Sdk\Generated';
const GENERATED_PATH = BASE_DIR . '/src/Generated';
const GENERATED_TYPES_NAMESPACE = 'Twint\Sdk\Generated\Type';
const GENERATED_TYPES_PATH = BASE_DIR . '/src/Generated/Type';
const GENERATED_CLIENT_NAME = 'TwintSoapClient';
const GENERATED_CLASS_MAP_NAME = 'TwintSoapClassMap';

$engine = CodeGeneratorEngineFactory::create(
    (string) Environment::PRODUCTION()->soapWsdlPath(Version::latest()),
    new FlatteningLoader(new StreamWrapperLoader()),
    MetadataOptions::empty()
        ->withTypesManipulator(
            new TypesManipulatorChain(
                new IntersectDuplicateTypesStrategy(),
                new ManipulatePropertyType(
                    'OrderRequestType',
                    'MerchantTransactionReference',
                    static fn (XsdType $type) => $type->withMeta(static fn (TypeMeta $m) => $m->withIsNullable(true))
                ),
                new RemoveTypes(static fn (Type $type) => str_ends_with($type->getName(), 'ResponseElement')),
            )
        )
        ->withMethodsManipulator(new RenameReturnTypeByRegex('/ResponseElement$/', 'ResponseType')),
);

return Config::create()
    ->setEngine($engine)

    ->setTypeNamespace(GENERATED_TYPES_NAMESPACE)
    ->setTypeDestination(GENERATED_TYPES_PATH)

    ->setClientName(GENERATED_CLIENT_NAME)
    ->setClientNamespace(GENERATED_NAMESPACE)
    ->setClientDestination(GENERATED_PATH)

    ->setClassMapName(GENERATED_CLASS_MAP_NAME)
    ->setClassMapNamespace(GENERATED_NAMESPACE)
    ->setClassMapDestination(GENERATED_PATH)

    ->setRuleSet(new Rules\RuleSet(
        [
            new Rules\AssembleRule(new Assembler\PropertyAssembler(
                Assembler\PropertyAssemblerOptions::create()
                    ->withVisibility('protected')
            )),
            new Rules\AssembleRule(new Assembler\ClassMapAssembler()),
            new Rules\AssembleRule(new Assembler\ClientConstructorAssembler()),
            new Rules\AssembleRule(new Assembler\ClientMethodAssembler()),
            new Rules\AssembleRule(new Assembler\GetterAssembler(new Assembler\GetterAssemblerOptions())),
            new Rules\AssembleRule(new Assembler\ImmutableSetterAssembler(
                new Assembler\ImmutableSetterAssemblerOptions()
            )),
            new Rules\AssembleRule(new Assembler\StrictTypesAssembler()),
            new Rules\IsRequestRule(
                $engine->getMetadata(),
                new Rules\MultiRule([
                    new Rules\AssembleRule(new Assembler\RequestAssembler()),
                    new Rules\AssembleRule(new Assembler\ConstructorAssembler(
                        new Assembler\ConstructorAssemblerOptions()
                    )),
                ])
            ),
            new Rules\IsResultRule(
                $engine->getMetadata(),
                new Rules\MultiRule([new Rules\AssembleRule(new Assembler\ResultAssembler())])
            ),
            new Rules\IsExtendingTypeRule(
                $engine->getMetadata(),
                new Rules\AssembleRule(new Assembler\ExtendingTypeAssembler())
            ),
            new Rules\IsAbstractTypeRule(
                $engine->getMetadata(),
                new Rules\AssembleRule(new Assembler\AbstractClassAssembler())
            ),
        ]
    ))
;
