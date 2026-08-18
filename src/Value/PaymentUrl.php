<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Stringable;
use function Psl\Type\instance_of;

/**
 * @template-implements Value<self>
 */
final class PaymentUrl implements Stringable, Value
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public function __construct(
        private readonly Url $url
    ) {
    }

    #[Override]
    public function __toString(): string
    {
        return (string) $this->url;
    }

    public function withSuccessUrl(Url $redirectUrl): self
    {
        return new self($this->url->withQueryParameter('redirectURL', (string) $redirectUrl));
    }

    public function withCancelUrl(Url $cancellationUrl): self
    {
        return new self($this->url->withQueryParameter('cancelOrderCallbackURL', (string) $cancellationUrl));
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->url->compare($other->url);
    }

    /**
     * @return non-empty-string
     */
    #[Override]
    public function jsonSerialize(): string
    {
        return (string) $this->url;
    }
}
