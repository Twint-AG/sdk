<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;
use Phpro\SoapClient\Type\RequestInterface;

#[AllowDynamicProperties]
final class MonitorOrderRequestType implements RequestInterface
{
    /**
     * @var MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * @var string
     */
    private $OrderUuid;

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
     * @param string $OrderUuid
     * @param string $MerchantTransactionReference
     * @param bool $WaitForResponse
     */
    public function __construct($MerchantInformation, $OrderUuid, $MerchantTransactionReference, $WaitForResponse)
    {
        $this->MerchantInformation = $MerchantInformation;
        $this->OrderUuid = $OrderUuid;
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

    /**
     * @param MerchantInformationType $MerchantInformation
     * @return MonitorOrderRequestType
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
    public function getOrderUuid()
    {
        return $this->OrderUuid;
    }

    /**
     * @param string $OrderUuid
     * @return MonitorOrderRequestType
     */
    public function withOrderUuid($OrderUuid)
    {
        $new = clone $this;
        $new->OrderUuid = $OrderUuid;

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
     * @return MonitorOrderRequestType
     */
    public function withMerchantTransactionReference($MerchantTransactionReference)
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

    /**
     * @param bool $WaitForResponse
     * @return MonitorOrderRequestType
     */
    public function withWaitForResponse($WaitForResponse)
    {
        $new = clone $this;
        $new->WaitForResponse = $WaitForResponse;

        return $new;
    }
}
