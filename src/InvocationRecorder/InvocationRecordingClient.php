<?php

declare(strict_types=1);

namespace Twint\Sdk\InvocationRecorder;

use Override;
use Throwable;
use Twint\Sdk\Capability\CoreCapabilities;
use Twint\Sdk\InvocationRecorder\Capability\InvocationRecorder;
use Twint\Sdk\InvocationRecorder\Soap\MessageRecorder;
use Twint\Sdk\InvocationRecorder\Value\Invocation;
use Twint\Sdk\InvocationRecorder\Value\SoapMessage;
use Twint\Sdk\Value\CustomerDataScopes;
use Twint\Sdk\Value\DetectedDevice;
use Twint\Sdk\Value\FastCheckoutCheckIn;
use Twint\Sdk\Value\InteractiveFastCheckoutCheckIn;
use Twint\Sdk\Value\IosAppScheme;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderReference;
use Twint\Sdk\Value\PairingToken;
use Twint\Sdk\Value\PairingUuid;
use Twint\Sdk\Value\ShippingMethods;
use Twint\Sdk\Value\SystemStatus;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;
use Twint\Sdk\Value\Url;

final class InvocationRecordingClient implements CoreCapabilities, InvocationRecorder
{
    /**
     * @var list<Invocation>
     */
    private array $invocations = [];

    public function __construct(
        private readonly CoreCapabilities $client,
        private readonly MessageRecorder $messageRecorder
    ) {
    }

    #[Override]
    public function detectDevice(string $userAgent): DetectedDevice
    {
        return $this->record1(__FUNCTION__, [$this->client, 'detectDevice'], $userAgent);
    }

    #[Override]
    public function getIosAppSchemes(): array
    {
        return $this->record0(__FUNCTION__, [$this->client, 'getIosAppSchemes']);
    }

    #[Override]
    public function getIosAppUrl(IosAppScheme $scheme, PairingToken $token): Url
    {
        return $this->record2(__FUNCTION__, [$this->client, 'getIosAppUrl'], $scheme, $token);
    }

    #[Override]
    public function getAndroidAppUrl(PairingToken $token): Url
    {
        return $this->record1(__FUNCTION__, [$this->client, 'getAndroidAppUrl'], $token);
    }

    #[Override]
    public function cancelOrder(OrderReference $orderReference): Order
    {
        return $this->record1(__FUNCTION__, [$this->client, 'cancelOrder'], $orderReference);
    }

    #[Override]
    public function confirmOrder(OrderReference $orderReference, Money $requestedAmount): Order
    {
        return $this->record2(__FUNCTION__, [$this->client, 'confirmOrder'], $orderReference, $requestedAmount);
    }

    #[Override]
    public function startOrder(UnfiledMerchantTransactionReference $orderReference, Money $requestedAmount): Order
    {
        return $this->record2(__FUNCTION__, [$this->client, 'startOrder'], $orderReference, $requestedAmount);
    }

    #[Override]
    public function monitorOrder(OrderReference $orderReference): Order
    {
        return $this->record1(__FUNCTION__, [$this->client, 'monitorOrder'], $orderReference);
    }

    #[Override]
    public function reverseOrder(
        UnfiledMerchantTransactionReference $reversalReference,
        OrderReference $orderReference,
        Money $reversalAmount
    ): Order {
        return $this->record3(
            __FUNCTION__,
            [$this->client, 'reverseOrder'],
            $reversalReference,
            $orderReference,
            $reversalAmount
        );
    }

    #[Override]
    public function checkSystemStatus(): SystemStatus
    {
        return $this->record0(__FUNCTION__, [$this->client, 'checkSystemStatus']);
    }

    /**
     * @template T
     * @param non-empty-string $methodName
     * @param callable(): T $fn
     * @return T
     */
    private function record0(string $methodName, callable $fn): mixed
    {
        return $this->doRecord($methodName, $fn, []);
    }

    /**
     * @template T
     * @template A
     * @param non-empty-string $methodName
     * @param callable(A): T $fn
     * @param A $arg1
     * @return T
     */
    private function record1(string $methodName, callable $fn, mixed $arg1): mixed
    {
        return $this->doRecord($methodName, static fn () => $fn($arg1), [$arg1]);
    }

    /**
     * @template T
     * @template A
     * @template B
     * @param non-empty-string $methodName
     * @param callable(A, B): T $fn
     * @param A $arg1
     * @param B $arg2
     * @return T
     */
    private function record2(string $methodName, callable $fn, mixed $arg1, mixed $arg2): mixed
    {
        return $this->doRecord($methodName, static fn () => $fn($arg1, $arg2), [$arg1, $arg2]);
    }

    /**
     * @template T
     * @template A
     * @template B
     * @template C
     * @param non-empty-string $methodName
     * @param callable(A, B, C): T $fn
     * @param A $arg1
     * @param B $arg2
     * @param C $arg3
     * @return T
     */
    private function record3(string $methodName, callable $fn, mixed $arg1, mixed $arg2, mixed $arg3): mixed
    {
        return $this->doRecord($methodName, static fn () => $fn($arg1, $arg2, $arg3), [$arg1, $arg2, $arg3]);
    }

    /**
     * @template T
     * @param non-empty-string $methodName
     * @param callable(): T $fn
     * @param list<mixed> $args
     * @return T
     */
    private function doRecord(string $methodName, callable $fn, array $args): mixed
    {
        try {
            $returnValue = $fn();
            $invocation = Invocation::fromReturnValue($methodName, $args, $returnValue);
            return $returnValue;
        } catch (Throwable $throwable) {
            $invocation = Invocation::fromException($methodName, $args, $throwable);
            throw $throwable;
        } finally {
            if (isset($invocation)) {
                $this->invocations[] = array_reduce(
                    $this->messageRecorder->flush(),
                    static fn (Invocation $invocation, SoapMessage $message) => $invocation->withMessage($message),
                    $invocation
                );
            }
        }
    }

    /**
     * @phpstan-impure
     */
    #[Override]
    public function flushInvocations(): array
    {
        try {
            return $this->invocations;
        } finally {
            $this->invocations = [];
        }
    }

    #[Override]
    public function requestFastCheckoutCheckIn(
        Money $amountWithoutShipping,
        CustomerDataScopes $scopes,
        ShippingMethods $shippingMethods
    ): InteractiveFastCheckoutCheckIn {
        return $this->record3(
            __FUNCTION__,
            [$this->client, 'requestFastCheckoutCheckIn'],
            $amountWithoutShipping,
            $scopes,
            $shippingMethods
        );
    }

    #[Override]
    public function monitorFastCheckoutCheckIn(PairingUuid $pairingUuid): FastCheckoutCheckIn
    {
        return $this->record1(__FUNCTION__, [$this->client, 'monitorFastCheckoutCheckIn'], $pairingUuid);
    }

    #[Override]
    public function cancelFastCheckoutCheckIn(PairingUuid $pairingUuid): void
    {
        $this->record1(__FUNCTION__, [$this->client, 'cancelFastCheckoutCheckIn'], $pairingUuid);
    }

    #[Override]
    public function startFastCheckoutOrder(
        PairingUuid $pairingUuid,
        UnfiledMerchantTransactionReference $orderReference,
        Money $requestedAmount
    ): Order {
        return $this->record3(
            __FUNCTION__,
            [$this->client, 'startFastCheckoutOrder'],
            $pairingUuid,
            $orderReference,
            $requestedAmount
        );
    }
}
