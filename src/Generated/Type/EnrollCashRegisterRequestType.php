<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

class EnrollCashRegisterRequestType implements RequestInterface
{
    /**
     * @var \Twint\Sdk\Generated\Type\MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * @var string
     */
    private $CashRegisterType;

    /**
     * @var string
     */
    private $FormerCashRegisterId;

    /**
     * @var string
     */
    private $BeaconInventoryNumber;

    /**
     * @var string
     */
    private $BeaconDaemonVersion;

    /**
     * Constructor
     *
     * @var \Twint\Sdk\Generated\Type\MerchantInformationType $MerchantInformation
     * @var string $CashRegisterType
     * @var string $FormerCashRegisterId
     * @var string $BeaconInventoryNumber
     * @var string $BeaconDaemonVersion
     */
    public function __construct($MerchantInformation, $CashRegisterType, $FormerCashRegisterId, $BeaconInventoryNumber, $BeaconDaemonVersion)
    {
        $this->MerchantInformation = $MerchantInformation;
        $this->CashRegisterType = $CashRegisterType;
        $this->FormerCashRegisterId = $FormerCashRegisterId;
        $this->BeaconInventoryNumber = $BeaconInventoryNumber;
        $this->BeaconDaemonVersion = $BeaconDaemonVersion;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\MerchantInformationType
     */
    public function getMerchantInformation()
    {
        return $this->MerchantInformation;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\MerchantInformationType $MerchantInformation
     * @return EnrollCashRegisterRequestType
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
    public function getCashRegisterType()
    {
        return $this->CashRegisterType;
    }

    /**
     * @param string $CashRegisterType
     * @return EnrollCashRegisterRequestType
     */
    public function withCashRegisterType($CashRegisterType)
    {
        $new = clone $this;
        $new->CashRegisterType = $CashRegisterType;

        return $new;
    }

    /**
     * @return string
     */
    public function getFormerCashRegisterId()
    {
        return $this->FormerCashRegisterId;
    }

    /**
     * @param string $FormerCashRegisterId
     * @return EnrollCashRegisterRequestType
     */
    public function withFormerCashRegisterId($FormerCashRegisterId)
    {
        $new = clone $this;
        $new->FormerCashRegisterId = $FormerCashRegisterId;

        return $new;
    }

    /**
     * @return string
     */
    public function getBeaconInventoryNumber()
    {
        return $this->BeaconInventoryNumber;
    }

    /**
     * @param string $BeaconInventoryNumber
     * @return EnrollCashRegisterRequestType
     */
    public function withBeaconInventoryNumber($BeaconInventoryNumber)
    {
        $new = clone $this;
        $new->BeaconInventoryNumber = $BeaconInventoryNumber;

        return $new;
    }

    /**
     * @return string
     */
    public function getBeaconDaemonVersion()
    {
        return $this->BeaconDaemonVersion;
    }

    /**
     * @param string $BeaconDaemonVersion
     * @return EnrollCashRegisterRequestType
     */
    public function withBeaconDaemonVersion($BeaconDaemonVersion)
    {
        $new = clone $this;
        $new->BeaconDaemonVersion = $BeaconDaemonVersion;

        return $new;
    }
}

