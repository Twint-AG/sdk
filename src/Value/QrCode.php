<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use function Psl\invariant;
use function Psl\Type\non_empty_string;

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

    private const PROTOCOL_PREFIX = 'data:image/png;base64,';

    /**
     * @param non-empty-string $qrCode
     */
    public function __construct(
        private readonly string $qrCode
    ) {
        invariant(str_starts_with($qrCode, self::PROTOCOL_PREFIX), 'Invalid QR code format');
    }

    /**
     * @return non-empty-string
     */
    #[Override]
    public function __toString(): string
    {
        return $this->qrCode;
    }

    /**
     * @return non-empty-string
     */
    public function binary(): string
    {
        return non_empty_string()->assert(base64_decode(substr($this->qrCode, strlen(self::PROTOCOL_PREFIX)), true));
    }

    #[Override]
    public function compare($other): int
    {
        return $this->qrCode <=> $other->qrCode;
    }
}
