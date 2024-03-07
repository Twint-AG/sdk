<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

final class CancelOrderAndUofRegistrationRequestType implements RequestInterface
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
     * Constructor
     *
     * @param MerchantInformationType $MerchantInformation
     * @param string $PaymentOrderUuid
     * @param string $MerchantTransactionReference
     */
    public function __construct($MerchantInformation, $PaymentOrderUuid, $MerchantTransactionReference)
    {
        $this->MerchantInformation = $MerchantInformation;
        $this->PaymentOrderUuid = $PaymentOrderUuid;
        $this->MerchantTransactionReference = $MerchantTransactionReference;
    }

    /**
     * @return MerchantInformationType
     */
    public function getMerchantInformation()
    {
        return $this->MerchantInformation;
    }

    /**
     * @param MerchantInformationType $MerchantInformation
     * @return CancelOrderAndUofRegistrationRequestType
     */
    public function withMerchantInformation($MerchantInformation)
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

    /**
     * @param string $PaymentOrderUuid
     * @return CancelOrderAndUofRegistrationRequestType
     */
    public function withPaymentOrderUuid($PaymentOrderUuid)
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

    /**
     * @param string $MerchantTransactionReference
     * @return CancelOrderAndUofRegistrationRequestType
     */
    public function withMerchantTransactionReference($MerchantTransactionReference)
    {
        $new = clone $this;
        $new->MerchantTransactionReference = $MerchantTransactionReference;

        return $new;
    }
}
