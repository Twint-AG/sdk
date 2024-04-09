<?php

declare(strict_types=1);

namespace Twint\Sdk\CodeGeneration;

use Phpro\SoapClient\CodeGenerator\Assembler;
use Phpro\SoapClient\CodeGenerator\Config\Config;
use Phpro\SoapClient\CodeGenerator\Rules;
use Phpro\SoapClient\Soap\CodeGeneratorEngineFactory;
use Phpro\SoapClient\Soap\ExtSoap\Metadata\Manipulators\DuplicateTypes\IntersectDuplicateTypesStrategy;
use Phpro\SoapClient\Soap\Metadata\Manipulators\MethodsManipulatorInterface;
use Phpro\SoapClient\Soap\Metadata\Manipulators\TypesManipulatorChain;
use Phpro\SoapClient\Soap\Metadata\Manipulators\TypesManipulatorInterface;
use Phpro\SoapClient\Soap\Metadata\MetadataOptions;
use Soap\Engine\Exception\MetadataException;
use Soap\Engine\Metadata\Collection\MethodCollection;
use Soap\Engine\Metadata\Collection\ParameterCollection;
use Soap\Engine\Metadata\Collection\PropertyCollection;
use Soap\Engine\Metadata\Collection\TypeCollection;
use Soap\Engine\Metadata\Model\Method;
use Soap\Engine\Metadata\Model\Parameter;
use Soap\Engine\Metadata\Model\Property;
use Soap\Engine\Metadata\Model\Type;
use Soap\Engine\Metadata\Model\TypeMeta;
use Soap\Engine\Metadata\Model\XsdType;
use Soap\Wsdl\Loader\FlatteningLoader;
use Soap\Wsdl\Loader\StreamWrapperLoader;
use Twint\Sdk\TwintEnvironment;
use Twint\Sdk\TwintVersion;
use function Psl\Type\non_empty_string;

const BASE_DIR = __DIR__ . '/../..';
const GENERATED_NAMESPACE = 'Twint\Sdk\Generated';
const GENERATED_PATH = BASE_DIR . '/src/Generated';
const GENERATED_TYPES_NAMESPACE = 'Twint\Sdk\Generated\Type';
const GENERATED_TYPES_PATH = BASE_DIR . '/src/Generated/Type';
const GENERATED_CLIENT_NAME = 'TwintSoapClient';
const GENERATED_CLASS_MAP_NAME = 'TwintSoapClassMap';

const IGNORED_ELEMENTS = ['CheckSystemStatusRequestElement'];

$engine = CodeGeneratorEngineFactory::create(
    (string) TwintEnvironment::PRODUCTION()->soapWsdlPath(TwintVersion::latest()),
    new FlatteningLoader(new StreamWrapperLoader()),
    MetadataOptions::empty()
        ->withTypesManipulator(
            new TypesManipulatorChain(
                new IntersectDuplicateTypesStrategy(),
                new class() implements TypesManipulatorInterface {
                    private const ORDER_REQUEST_TYPE = 'OrderRequestType';

                    private const MERCHANT_TRANSACTION_REFERENCE = 'MerchantTransactionReference';

                    /**
                     * @throws MetadataException
                     */
                    public function __invoke(TypeCollection $types): TypeCollection
                    {
                        $orderType = $types->fetchFirstByName(self::ORDER_REQUEST_TYPE);
                        $orderTypeProperties = $orderType->getProperties();

                        return new TypeCollection(
                            new Type(
                                $orderType->getXsdType(),
                                new PropertyCollection(
                                    ...$orderTypeProperties->map(
                                        static fn (Property $property) => $property->getName() === self::MERCHANT_TRANSACTION_REFERENCE
                                            ? new Property(
                                                $property->getName(),
                                                $property
                                                    ->getType()
                                                    ->withMeta(static fn (TypeMeta $m) => $m ->withIsNullable(true))
                                            )
                                            : $property
                                    )
                                )
                            ),
                            ...$types->filter(static fn (Type $type) => $type->getName() !== self::ORDER_REQUEST_TYPE),
                        );
                    }
                },
                new class() implements TypesManipulatorInterface {
                    public function __invoke(TypeCollection $types): TypeCollection
                    {
                        return $types->filter(
                            static fn (Type $type) =>
                                !str_ends_with($type->getName(), 'Element')
                                || in_array($type->getName(), IGNORED_ELEMENTS, true)
                        );
                    }
                },
            )
        )
        ->withMethodsManipulator(new class() implements MethodsManipulatorInterface {
            public function __invoke(MethodCollection $methods): MethodCollection
            {
                return new MethodCollection(...$methods->map(
                    static fn (Method $method) => new Method(
                        $method->getName(),
                        new ParameterCollection(
                            ...$method->getParameters()
                                ->map(
                                    static fn (Parameter $parameter) => new Parameter(
                                        $parameter->getName(),
                                        new XsdType(self::replace($parameter->getType()->getName()))
                                    )
                                )
                        ),
                        new XsdType(self::replace($method->getReturnType()->getName()))
                    )
                ));
            }

            /**
             * @return non-empty-string
             */
            private static function replace(string $name): string
            {
                if (in_array($name, IGNORED_ELEMENTS, true)) {
                    return $name;
                }

                return non_empty_string()->assert(preg_replace('/Element$/', 'Type', $name));
            }
        }),
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
