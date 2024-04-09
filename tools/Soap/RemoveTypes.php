<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\Soap;

use Phpro\SoapClient\Soap\Metadata\Manipulators\TypesManipulatorInterface;
use Soap\Engine\Metadata\Collection\TypeCollection;
use Soap\Engine\Metadata\Model\Type;

final class RemoveTypes implements TypesManipulatorInterface
{
    /**
     * @param callable(Type):bool $matcher
     */
    public function __construct(
        private readonly mixed $matcher
    ) {
    }

    public function __invoke(TypeCollection $types): TypeCollection
    {
        return $types->filter(fn (Type $t) => !($this->matcher)($t));
    }
}
