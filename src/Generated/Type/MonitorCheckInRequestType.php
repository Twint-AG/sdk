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

    public function withMerchantInformation(MerchantInformationType $MerchantInformation): self
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

    public function withCustomerRelationUuid(string $CustomerRelationUuid): self
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

    public function withPairingUuid(string $PairingUuid): self
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

    public function withWaitForResponse(bool $WaitForResponse): self
    {
        $new = clone $this;
        $new->WaitForResponse = $WaitForResponse;

        return $new;
    }
}
