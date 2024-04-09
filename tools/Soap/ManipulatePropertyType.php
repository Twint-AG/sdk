<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\Soap;

use Phpro\SoapClient\Soap\Metadata\Manipulators\TypesManipulatorInterface;
use Soap\Engine\Exception\MetadataException;
use Soap\Engine\Metadata\Collection\PropertyCollection;
use Soap\Engine\Metadata\Collection\TypeCollection;
use Soap\Engine\Metadata\Model\Property;
use Soap\Engine\Metadata\Model\Type;
use Soap\Engine\Metadata\Model\XsdType;

final class ManipulatePropertyType implements TypesManipulatorInterface
{
    /**
     * @param callable(XsdType): XsdType $manipulation
     */
    public function __construct(
        private readonly string $type,
        private readonly string $property,
        private readonly mixed $manipulation
    ) {
    }

    /**
     * @throws MetadataException
     */
    public function __invoke(TypeCollection $types): TypeCollection
    {
        $originalType = $types->fetchFirstByName($this->type);
        $originalProperties = $originalType->getProperties();

        return new TypeCollection(
            new Type(
                $originalType->getXsdType(),
                new PropertyCollection(
                    ...$originalProperties->map(
                        fn (Property $property) => $property->getName() === $this->property
                            ? new Property($property->getName(), ($this->manipulation)($property->getType()))
                            : $property
                    )
                )
            ),
            ...$types->filter(fn (Type $type) => $type->getName() !== $this->type),
        );
    }
}
