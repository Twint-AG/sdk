<?php

declare(strict_types=1);

namespace Twint\Sdk\CodeGeneration;

use Phpro\SoapClient\CodeGenerator\Assembler;
use Phpro\SoapClient\CodeGenerator\Config\Config;
use Phpro\SoapClient\CodeGenerator\Rules;
use Phpro\SoapClient\Soap\DefaultEngineFactory;
use Phpro\SoapClient\Soap\ExtSoap\Metadata\Manipulators\DuplicateTypes\IntersectDuplicateTypesStrategy;
use Phpro\SoapClient\Soap\Metadata\Manipulators\TypesManipulatorChain;
use Phpro\SoapClient\Soap\Metadata\Manipulators\TypesManipulatorInterface;
use Phpro\SoapClient\Soap\Metadata\MetadataOptions;
use Soap\Engine\Metadata\Collection\PropertyCollection;
use Soap\Engine\Metadata\Collection\TypeCollection;
use Soap\Engine\Metadata\Model\Type;
use Soap\ExtSoapEngine\ExtSoapOptions;
use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;
use Twint\Sdk\TwintEnvironment;
use Twint\Sdk\TwintVersion;

const BASE_DIR = __DIR__ . '/../..';
const GENERATED_NAMESPACE = 'Twint\Sdk\Generated';
const GENERATED_PATH = BASE_DIR . '/src/Generated';
const GENERATED_TYPES_NAMESPACE = 'Twint\Sdk\Generated\Type';
const GENERATED_TYPES_PATH = BASE_DIR . '/src/Generated/Type';
const GENERATED_CLIENT_NAME = 'TwintSoapClient';
const GENERATED_CLASS_MAP_NAME = 'TwintSoapClassMap';

$handleExtension = new class() implements TypesManipulatorInterface {
    /**
     * @var array<string, string>
     */
    private static array $extensions = [
        'OrderType' => 'OrderRequestType',
    ];

    public function __invoke(TypeCollection $types): TypeCollection
    {
        return new TypeCollection(...$types->map(
            static function (Type $type) use ($types): Type {
                $name = $type->getName();

                if (!array_key_exists($name, self::$extensions)) {
                    return $type;
                }

                $extensionType = self::findType($types, self::$extensions[$name]);

                if ($extensionType === null) {
                    return $type;
                }

                return new Type(
                    $type->getXsdType(),
                    // @phpstan-ignore-next-line
                    new PropertyCollection(...$extensionType->getProperties(), ...$type->getProperties())
                );
            }
        ));
    }

    /**
     * @throws AssertionFailed
     */
    private static function findType(TypeCollection $types, string $name): ?Type
    {
        foreach ($types as $type) {
            Assertion::isInstanceOf($type, Type::class);
            if ($type->getName() === $name) {
                return $type;
            }
        }

        return null;
    }
};

$engine = DefaultEngineFactory::create(
    ExtSoapOptions::defaults(
        (string) TwintEnvironment::PRODUCTION()->soapWsdlPath(TwintVersion::latest())
    )->disableWsdlCache(),
    null,
    MetadataOptions::empty()->withTypesManipulator(
        new TypesManipulatorChain(new IntersectDuplicateTypesStrategy(), $handleExtension)
    )
);

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
        (new Assembler\ImmutableSetterAssemblerOptions())
            ->withReturnTypes()
            ->withTypeHints()
            ->withDocBlocks(false)
    )))
    ->addRule(new Rules\AssembleRule(new Assembler\FinalClassAssembler()))
    ->addRule(new Rules\AssembleRule(new Assembler\StrictTypesAssembler()))
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
