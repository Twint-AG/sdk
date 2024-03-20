<?php

declare(strict_types=1);

namespace Twint\Sdk;

use Twint\Sdk\Exception\AssertionFailed;
use Twint\Sdk\Value\Comparable;
use Twint\Sdk\Value\ComparableToEquality;
use Twint\Sdk\Value\Enum;
use Twint\Sdk\Value\Equality;

/**
 * @phpstan-type ExistingVersionId = TwintVersion::V*
 * @phpstan-type FutureVersionId = int<self::NEXT,max>
 * @phpstan-type VersionId = ExistingVersionId|FutureVersionId
 * @template-implements Enum<ExistingVersionId>
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class TwintVersion implements Enum, Comparable, Equality
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public const V8_5_0 = 8_05_00;

    public const V8_6_0 = 8_06_00;

    public const NEXT = self::V8_6_0;

    public const LATEST = self::V8_5_0;

    /**
     * @param VersionId $versionId
     */
    public function __construct(
        private readonly int $versionId
    ) {
    }

    public static function latest(): self
    {
        return new self(self::LATEST);
    }

    public static function next(): self
    {
        return new self(self::NEXT);
    }

    public static function all(): array
    {
        return [self::V8_5_0, self::V8_6_0];
    }

    public function __toString(): string
    {
        return (string) $this->versionId;
    }

    /**
     * @throws AssertionFailed
     */
    public function compare($other): int
    {
        Assertion::isInstanceOf($other, self::class);

        return $this->versionId <=> $other->versionId;
    }

    public function id(): int
    {
        return $this->versionId;
    }

    public function major(): int
    {
        return (int) ($this->versionId / 10_000);
    }

    public function minor(): int
    {
        return ((int) ($this->versionId / 1_00)) % 1_00;
    }

    public function patch(): int
    {
        return $this->versionId % 1_00;
    }

    public function dotVersion(): string
    {
        return $this->formatVersion('.');
    }

    public function underscoreVersion(): string
    {
        return $this->formatVersion('_');
    }

    private function formatVersion(string $separator): string
    {
        return array_reduce(
            [$this->minor(), $this->patch()],
            static fn (string $carry, int $part) => $part > 0 ? sprintf('%s%s%d', $carry, $separator, $part) : $carry,
            (string) $this->major()
        );
    }
}