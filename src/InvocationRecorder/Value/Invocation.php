<?php

declare(strict_types=1);

namespace Twint\Sdk\InvocationRecorder\Value;

use Psl\Option\Option;
use Throwable;
use function Psl\Option\none;
use function Psl\Option\some;

final class Invocation
{
    /**
     * @param non-empty-string $methodName
     * @param list<mixed> $arguments
     * @param Option<mixed> $returnValue
     * @param list<SoapMessage> $messages
     */
    private function __construct(
        private readonly string $methodName,
        private readonly array $arguments,
        private readonly Option $returnValue,
        private readonly ?Throwable $exception,
        private readonly array $messages
    ) {
    }

    /**
     * @param non-empty-string $methodName
     * @param list<mixed> $arguments
     */
    public static function fromException(string $methodName, array $arguments, Throwable $t): self
    {
        return new self($methodName, $arguments, none(), $t, []);
    }

    /**
     * @param non-empty-string $methodName
     * @param list<mixed> $arguments
     */
    public static function fromReturnValue(string $methodName, array $arguments, mixed $returnValue): self
    {
        return new self($methodName, $arguments, some($returnValue), null, []);
    }

    public function withMessage(SoapMessage $message): self
    {
        return new self(
            $this->methodName,
            $this->arguments,
            $this->returnValue,
            $this->exception,
            [...$this->messages, $message]
        );
    }

    /**
     * @return list<SoapMessage>
     */
    public function messages(): array
    {
        return $this->messages;
    }

    public function methodName(): string
    {
        return $this->methodName;
    }

    /**
     * @return list<mixed>
     */
    public function arguments(): array
    {
        return $this->arguments;
    }

    public function returnValue(): mixed
    {
        return $this->returnValue->unwrapOr(null);
    }

    public function exception(): ?Throwable
    {
        return $this->exception;
    }

    /**
     * @phpstan-assert-if-true !null $this->exception()
     * @phpstan-assert-if-true null $this->returnValue()
     */
    public function threwException(): bool
    {
        return $this->exception !== null;
    }

    /**
     * @phpstan-assert-if-true null $this->exception()
     * @phpstan-assert-if-true !null $this->returnValue()
     */
    public function returnedValue(): bool
    {
        return $this->returnValue->isSome();
    }
}
