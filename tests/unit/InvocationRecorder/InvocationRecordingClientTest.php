<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\InvocationRecorder;

use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Capability\CoreCapabilities;
use Twint\Sdk\Exception\SdkError;
use Twint\Sdk\InvocationRecorder\InvocationRecordingClient;
use Twint\Sdk\InvocationRecorder\Soap\MessageRecorder;
use Twint\Sdk\Value\DetectedDevice;
use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\IosAppScheme;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderId;
use Twint\Sdk\Value\OrderStatus;
use Twint\Sdk\Value\SystemStatus;
use Twint\Sdk\Value\TransactionStatus;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;

/**
 * @internal
 */
#[CoversClass(InvocationRecordingClient::class)]
final class InvocationRecordingClientTest extends TestCase
{
    /**
     * @return iterable<array{non-empty-string, list<mixed>}>
     */
    public static function getInvocations(): iterable
    {
        yield ['checkSystemStatus', []];
        yield ['startOrder', [new UnfiledMerchantTransactionReference('123'), Money::CHF(1.99)]];
        yield ['monitorOrder', [new FiledMerchantTransactionReference('456')]];
        yield ['confirmOrder', [new FiledMerchantTransactionReference('456'), Money::CHF(1.99)]];
        yield ['cancelOrder', [new FiledMerchantTransactionReference('456')]];
        yield [
            'reverseOrder',
            [new UnfiledMerchantTransactionReference('100'),
                new FiledMerchantTransactionReference('456'),
                Money::CHF(1.99),
            ]];
        yield ['detectDevice', ['iOS']];
        yield ['getIosAppSchemes', []];
    }

    /**
     * @param list<mixed> $args
     */
    #[DataProvider('getInvocations')]
    public function testInvocationIsRecorded(string $method, array $args): void
    {
        $order = new Order(
            OrderId::fromString('e598ad27-9200-4c0d-ae9e-657226643f7c'),
            new FiledMerchantTransactionReference('456'),
            OrderStatus::SUCCESS(),
            TransactionStatus::ORDER_OK(),
            Money::CHF(1.99)
        );

        $client = new InvocationRecordingClient(
            $this->createConfiguredMock(
                CoreCapabilities::class,
                [
                    'checkSystemStatus' => SystemStatus::OK(),
                    'startOrder' => $order,
                    'monitorOrder' => $order,
                    'confirmOrder' => $order,
                    'cancelOrder' => $order,
                    'reverseOrder' => $order,
                    'detectDevice' => DetectedDevice::IOS('iOS'),
                    'getIosAppSchemes' => [new IosAppScheme('twint-issuer0://', 'App Name')],
                ]
            ),
            new MessageRecorder()
        );

        // @phpstan-ignore-next-line
        $result = $client->{$method}(...$args);

        $invocations = $client->flushInvocations();

        self::assertCount(1, $invocations);

        self::assertSame($method, $invocations[0]->methodName());
        self::assertSame($args, $invocations[0]->arguments());
        self::assertSame($result, $invocations[0]->returnValue());
    }

    /**
     * @param list<mixed> $args
     */
    #[DataProvider('getInvocations')]
    public function testInvocationsWithExceptionsAreRecorded(string $method, array $args): void
    {
        $exception = new class() extends Exception implements SdkError {
        };

        $innerClient = $this->createMock(CoreCapabilities::class);
        $innerClient
            ->method($method)
            ->willThrowException($exception);

        $client = new InvocationRecordingClient($innerClient, new MessageRecorder());

        try {
            // @phpstan-ignore-next-line
            $client->{$method}(...$args);
        } catch (SdkError $e) {
            $invocations = $client->flushInvocations();

            self::assertCount(1, $invocations);

            self::assertSame($method, $invocations[0]->methodName());
            self::assertSame($args, $invocations[0]->arguments());
            self::assertSame($e, $invocations[0]->exception());
        }
    }
}
