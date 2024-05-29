<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\CustomerDataScopes;

/**
 * @template-extends ValueTest<CustomerDataScopes>
 * @internal
 */
#[CoversClass(CustomerDataScopes::class)]
final class CustomerDataScopesTest extends ValueTest
{
    #[Override]
    protected function createValue(): object
    {
        return new CustomerDataScopes();
    }

    #[Override]
    protected static function getValueType(): string
    {
        return CustomerDataScopes::class;
    }

    public function testToList(): void
    {
        $scopes = new CustomerDataScopes(CustomerDataScopes::EMAIL, CustomerDataScopes::DATE_OF_BIRTH);

        self::assertSame([CustomerDataScopes::DATE_OF_BIRTH, CustomerDataScopes::EMAIL], $scopes->toList());
    }
}
