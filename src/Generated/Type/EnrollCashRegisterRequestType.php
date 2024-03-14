<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

class EnrollCashRegisterRequestType implements RequestInterface
{
    /**
     * Restriction of the Base Merchant Information.
     *  In contrary to that it MUST contain a CashRegister Id. Used as the default type for operations
     *  within the *-POS Cases, where the Actions are performed by specific CashRegisters
     */
    protected MerchantInformationType $MerchantInformation;

    /**
     * @var 'POS-Serviced' | 'POS-Selfservice' | 'POS-VendingMachine' | 'EPOS' | 'MPOS' | 'OTHER'
     */
    protected string $CashRegisterType;

    protected ?string $FormerCashRegisterId;

    protected ?string $BeaconInventoryNumber;

    protected ?string $BeaconDaemonVersion;

    /**
     * Constructor
     *
     * @param 'POS-Serviced' | 'POS-Selfservice' | 'POS-VendingMachine' | 'EPOS' | 'MPOS' | 'OTHER' $CashRegisterType
     */
    public function __construct(MerchantInformationType $MerchantInformation, string $CashRegisterType, ?string $FormerCashRegisterId, ?string $BeaconInventoryNumber, ?string $BeaconDaemonVersion)
    {
        $this->MerchantInformation = $MerchantInformation;
        $this->CashRegisterType = $CashRegisterType;
        $this->FormerCashRegisterId = $FormerCashRegisterId;
        $this->BeaconInventoryNumber = $BeaconInventoryNumber;
        $this->BeaconDaemonVersion = $BeaconDaemonVersion;
    }

    public function getMerchantInformation(): MerchantInformationType
    {
        return $this->MerchantInformation;
    }

    public function withMerchantInformation(MerchantInformationType $MerchantInformation): static
    {
        $new = clone $this;
        $new->MerchantInformation = $MerchantInformation;

        return $new;
    }

    /**
     * @return 'POS-Serviced' | 'POS-Selfservice' | 'POS-VendingMachine' | 'EPOS' | 'MPOS' | 'OTHER'
     */
    public function getCashRegisterType(): string
    {
        return $this->CashRegisterType;
    }

    /**
     * @param 'POS-Serviced' | 'POS-Selfservice' | 'POS-VendingMachine' | 'EPOS' | 'MPOS' | 'OTHER' $CashRegisterType
     */
    public function withCashRegisterType(string $CashRegisterType): static
    {
        $new = clone $this;
        $new->CashRegisterType = $CashRegisterType;

        return $new;
    }

    public function getFormerCashRegisterId(): ?string
    {
        return $this->FormerCashRegisterId;
    }

    public function withFormerCashRegisterId(?string $FormerCashRegisterId): static
    {
        $new = clone $this;
        $new->FormerCashRegisterId = $FormerCashRegisterId;

        return $new;
    }

    public function getBeaconInventoryNumber(): ?string
    {
        return $this->BeaconInventoryNumber;
    }

    public function withBeaconInventoryNumber(?string $BeaconInventoryNumber): static
    {
        $new = clone $this;
        $new->BeaconInventoryNumber = $BeaconInventoryNumber;

        return $new;
    }

    public function getBeaconDaemonVersion(): ?string
    {
        return $this->BeaconDaemonVersion;
    }

    public function withBeaconDaemonVersion(?string $BeaconDaemonVersion): static
    {
        $new = clone $this;
        $new->BeaconDaemonVersion = $BeaconDaemonVersion;

        return $new;
    }
}
