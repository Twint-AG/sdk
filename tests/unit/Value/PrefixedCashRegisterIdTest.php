<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Psl\Exception\InvariantViolationException;
use Twint\Sdk\Value\PrefixedCashRegisterId;
use Twint\Sdk\Value\StoreUuid;

/**
 * @template-extends ValueTest<PrefixedCashRegisterId>
 * @internal
 */
#[CoversClass(PrefixedCashRegisterId::class)]
final class PrefixedCashRegisterIdTest extends ValueTest
{
    public const STORE_UUID = '00000000-0000-0000-0000-000000000000';

    /**
     * @return iterable<array{string}>
     */
    public static function getErrorExamples(): iterable
    {
        yield [str_repeat('a', 14)];
        yield [''];
        yield ['ö'];
        yield [' space '];
    }

    /**
     * @return iterable<array{string}>
     */
    public static function getSuccessExamples(): iterable
    {
        yield ['some-client'];
        yield ['id-123'];
        yield ['id_123'];
        yield ['WooCommerce'];
        yield ['Shopware'];
        yield ['Magento'];
    }

    #[DataProvider('getErrorExamples')]
    public function testThrowsOnInvariantViolation(string $id): void
    {
        $this->expectException(InvariantViolationException::class);

        /** @phpstan-ignore-next-line */
        new PrefixedCashRegisterId(StoreUuid::fromString(self::STORE_UUID), $id);
    }

    #[DataProvider('getSuccessExamples')]
    public function testCanBeCreated(string $id): void
    {
        self::assertSame(
            $id . '-' . self::STORE_UUID,
            /** @phpstan-ignore-next-line */
            (string) new PrefixedCashRegisterId(StoreUuid::fromString(self::STORE_UUID), $id)
        );
    }

    public function testReturnsSelfForCashRegisterId(): void
    {
        $cashRegisterId = PrefixedCashRegisterId::unknown(StoreUuid::fromString(self::STORE_UUID));

        self::assertSame($cashRegisterId, $cashRegisterId->cashRegisterId());
    }

    public function testReturnsStoreUuidForStoreUuid(): void
    {
        $cashRegisterId = PrefixedCashRegisterId::unknown(StoreUuid::fromString(self::STORE_UUID));

        self::assertObjectEquals(StoreUuid::fromString(self::STORE_UUID), $cashRegisterId->storeUuid());
    }

    #[Override]
    protected function createValue(): object
    {
        return PrefixedCashRegisterId::unknown(StoreUuid::fromString(self::STORE_UUID));
    }

    #[Override]
    protected static function getValueType(): string
    {
        return PrefixedCashRegisterId::class;
    }
}
