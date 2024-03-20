<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

final class MonitorOrderAndUofRegistrationRequestType implements RequestInterface
{
    /**
     * @var MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * @var string
     */
    private $PaymentOrderUuid;

    /**
     * @var string
     */
    private $MerchantTransactionReference;

    /**
     * @var bool
     */
    private $WaitForResponse;

    /**
     * Constructor
     *
     * @param MerchantInformationType $MerchantInformation
     * @param string $PaymentOrderUuid
     * @param string $MerchantTransactionReference
     * @param bool $WaitForResponse
     */
    public function __construct($MerchantInformation, $PaymentOrderUuid, $MerchantTransactionReference, $WaitForResponse)
    {
        $this->MerchantInformation = $MerchantInformation;
        $this->PaymentOrderUuid = $PaymentOrderUuid;
        $this->MerchantTransactionReference = $MerchantTransactionReference;
        $this->WaitForResponse = $WaitForResponse;
    }

    /**
     * @return MerchantInformationType
     */
    public function getMerchantInformation()
    {
        return $this->MerchantInformation;
    }

    public function withMerchantInformation(MerchantInformationType $MerchantInformation): self
    {
        $new = clone $this;
        $new->MerchantInformation = $MerchantInformation;

        return $new;
    }

    /**
     * @return string
     */
    public function getPaymentOrderUuid()
    {
        return $this->PaymentOrderUuid;
    }

    public function withPaymentOrderUuid(string $PaymentOrderUuid): self
    {
        $new = clone $this;
        $new->PaymentOrderUuid = $PaymentOrderUuid;

        return $new;
    }

    /**
     * @return string
     */
    public function getMerchantTransactionReference()
    {
        return $this->MerchantTransactionReference;
    }

    public function withMerchantTransactionReference(string $MerchantTransactionReference): self
    {
        $new = clone $this;
        $new->MerchantTransactionReference = $MerchantTransactionReference;

        return $new;
    }

    /**
     * @return bool
     */
    public function getWaitForResponse()
    {
        return $this->WaitForResponse;
    }

    public function withWaitForResponse(bool $WaitForResponse): self
    {
        $new = clone $this;
        $new->WaitForResponse = $WaitForResponse;

        return $new;
    }
}
