<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

final class EnrollCashRegisterRequestType implements RequestInterface
{
    /**
     * @var MerchantInformationType
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
     * @param MerchantInformationType $MerchantInformation
     * @param string $CashRegisterType
     * @param string $FormerCashRegisterId
     * @param string $BeaconInventoryNumber
     * @param string $BeaconDaemonVersion
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
     * @return MerchantInformationType
     */
    public function getMerchantInformation()
    {
        return $this->MerchantInformation;
    }

    /**
     * @param MerchantInformationType $MerchantInformation
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
