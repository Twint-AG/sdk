<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\Soap;

use Phpro\SoapClient\Soap\Metadata\Manipulators\MethodsManipulatorInterface;
use Soap\Engine\Metadata\Collection\MethodCollection;
use Soap\Engine\Metadata\Model\Method;
use Soap\Engine\Metadata\Model\XsdType;
use function Psl\Regex\replace;

final class RenameReturnTypeByRegex implements MethodsManipulatorInterface
{
    /**
     * @param non-empty-string $pattern
     */
    public function __construct(
        private readonly string $pattern,
        private readonly string $replacement
    ) {
    }

    public function __invoke(MethodCollection $methods): MethodCollection
    {
        return new MethodCollection(...$methods->map(
            fn (Method $method) => new Method(
                $method->getName(),
                $method->getParameters(),
                new XsdType(replace($method->getReturnType()->getName(), $this->pattern, $this->replacement))
            )
        ));
    }
}
