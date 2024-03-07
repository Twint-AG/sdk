<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

final class MonitorCheckInRequestType implements RequestInterface
{
    /**
     * @var MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * @var string
     */
    private $CustomerRelationUuid;

    /**
     * @var string
     */
    private $PairingUuid;

    /**
     * @var bool
     */
    private $WaitForResponse;

    /**
     * Constructor
     *
     * @param MerchantInformationType $MerchantInformation
     * @param string $CustomerRelationUuid
     * @param string $PairingUuid
     * @param bool $WaitForResponse
     */
    public function __construct($MerchantInformation, $CustomerRelationUuid, $PairingUuid, $WaitForResponse)
    {
        $this->MerchantInformation = $MerchantInformation;
        $this->CustomerRelationUuid = $CustomerRelationUuid;
        $this->PairingUuid = $PairingUuid;
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
     * @return MonitorCheckInRequestType
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
    public function getCustomerRelationUuid()
    {
        return $this->CustomerRelationUuid;
    }

    /**
     * @param string $CustomerRelationUuid
     * @return MonitorCheckInRequestType
     */
    public function withCustomerRelationUuid($CustomerRelationUuid)
    {
        $new = clone $this;
        $new->CustomerRelationUuid = $CustomerRelationUuid;

        return $new;
    }

    /**
     * @return string
     */
    public function getPairingUuid()
    {
        return $this->PairingUuid;
    }

    /**
     * @param string $PairingUuid
     * @return MonitorCheckInRequestType
     */
    public function withPairingUuid($PairingUuid)
    {
        $new = clone $this;
        $new->PairingUuid = $PairingUuid;

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
     * @return MonitorCheckInRequestType
     */
    public function withWaitForResponse($WaitForResponse)
    {
        $new = clone $this;
        $new->WaitForResponse = $WaitForResponse;

        return $new;
    }
}
