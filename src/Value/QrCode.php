<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use function Psl\invariant;

/**
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class QrCode implements Comparable, Equality
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    /**
     * @param non-empty-string $qrCode
     */
    public function __construct(
        private readonly string $qrCode
    ) {
        invariant(str_starts_with($qrCode, 'data:image/png;base64,'), 'Invalid QR code format');
    }

    /**
     * @return non-empty-string
     */
    #[Override]
    public function __toString(): string
    {
        return $this->qrCode;
    }

    #[Override]
    public function compare($other): int
    {
        return $this->qrCode <=> $other->qrCode;
    }
}
