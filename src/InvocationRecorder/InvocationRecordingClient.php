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
use Twint\Sdk\Value\DetectedDevice;
use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderId;
use Twint\Sdk\Value\SystemStatus;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;

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
        return $this->record(__FUNCTION__, [$this->client, 'detectDevice'], [$userAgent]);
    }

    #[Override]
    public function getIosAppSchemes(): array
    {
        return $this->record(__FUNCTION__, [$this->client, 'getIosAppSchemes'], []);
    }

    #[Override]
    public function cancelOrder(OrderId|FiledMerchantTransactionReference $orderIdOrRef): Order
    {
        return $this->record(__FUNCTION__, [$this->client, 'cancelOrder'], [$orderIdOrRef]);
    }

    #[Override]
    public function confirmOrder(OrderId|FiledMerchantTransactionReference $orderIdOrRef, Money $requestedAmount): Order
    {
        return $this->record(__FUNCTION__, [$this->client, 'confirmOrder'], [$orderIdOrRef, $requestedAmount]);
    }

    #[Override]
    public function startOrder(UnfiledMerchantTransactionReference $orderReference, Money $requestedAmount): Order
    {
        return $this->record(__FUNCTION__, [$this->client, 'startOrder'], [$orderReference, $requestedAmount]);
    }

    #[Override]
    public function monitorOrder(OrderId|FiledMerchantTransactionReference $orderIdOrRef): Order
    {
        return $this->record(__FUNCTION__, [$this->client, 'monitorOrder'], [$orderIdOrRef]);
    }

    #[Override]
    public function reverseOrder(
        UnfiledMerchantTransactionReference $reversalReference,
        OrderId|FiledMerchantTransactionReference $orderIdOrRef,
        Money $reversalAmount
    ): Order {
        return $this->record(
            __FUNCTION__,
            [$this->client, 'reverseOrder'],
            [$reversalReference, $orderIdOrRef, $reversalAmount]
        );
    }

    #[Override]
    public function checkSystemStatus(): SystemStatus
    {
        return $this->record(__FUNCTION__, [$this->client, 'checkSystemStatus'], []);
    }

    /**
     * @template TArg0
     * @template TArg1
     * @template TArg2
     * @template TArg3
     * @template TArg4
     * @template TArg5
     * @template TArg6
     * @template TArg7
     * @template TArg8
     * @template TArg9
     * @template TReturn
     * @param non-empty-string $methodName
     * @param callable(): TReturn|callable(TArg0, TArg1, TArg2, TArg3, TArg4, TArg5, TArg6, TArg7, TArg8, TArg9): TReturn $fn
     * @param array{}|array{TArg0}|array{TArg0, TArg1, TArg2, TArg3, TArg4, TArg5, TArg6, TArg7, TArg8, TArg9} $args
     * @throws Throwable
     * @return TReturn
     */
    private function record(string $methodName, callable $fn, array $args): mixed
    {
        try {
            $returnValue = $fn(...$args);

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

    #[Override]
    public function flushInvocations(): array
    {
        try {
            return $this->invocations;
        } finally {
            $this->invocations = [];
        }
    }
}
