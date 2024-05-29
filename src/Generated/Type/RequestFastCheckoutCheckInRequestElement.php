<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

class RequestFastCheckoutCheckInRequestElement implements RequestInterface
{
    /**
     * Restriction of the Base Merchant Information.
     *  In contrary to that it MUST contain a CashRegister Id. Used as the default type for operations
     *  within the *-POS Cases, where the Actions are performed by specific CashRegisters
     */
    protected MerchantInformationType $MerchantInformation;

    protected CurrencyAmountType $NetAmount;

    /**
     * The list of scopes of customer twint id that the merchant wants to access.
     *
     * @var non-empty-array<int<0,19>, string>
     */
    protected array $RequestedScopes;

    /**
     * The list of shipping options that the merchant supports for the fast checkout being requested.
     *
     * @var array<int<0,19>, \Twint\Sdk\Generated\Type\ShippingMethodReferenceType>
     */
    protected array $ShippingMethods;

    protected ?bool $QRCodeRendering = null;

    /**
     * Constructor
     *
     * @param non-empty-array<int<0,19>, string> $RequestedScopes
     * @param array<int<0,19>, \Twint\Sdk\Generated\Type\ShippingMethodReferenceType> $ShippingMethods
     */
    public function __construct(MerchantInformationType $MerchantInformation, CurrencyAmountType $NetAmount, array $RequestedScopes, array $ShippingMethods, ?bool $QRCodeRendering)
    {
        $this->MerchantInformation = $MerchantInformation;
        $this->NetAmount = $NetAmount;
        $this->RequestedScopes = $RequestedScopes;
        $this->ShippingMethods = $ShippingMethods;
        $this->QRCodeRendering = $QRCodeRendering;
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

    public function getNetAmount(): CurrencyAmountType
    {
        return $this->NetAmount;
    }

    public function withNetAmount(CurrencyAmountType $NetAmount): static
    {
        $new = clone $this;
        $new->NetAmount = $NetAmount;

        return $new;
    }

    /**
     * @return non-empty-array<int<0,19>, string>
     */
    public function getRequestedScopes(): array
    {
        return $this->RequestedScopes;
    }

    /**
     * @param non-empty-array<int<0,19>, string> $RequestedScopes
     */
    public function withRequestedScopes(array $RequestedScopes): static
    {
        $new = clone $this;
        $new->RequestedScopes = $RequestedScopes;

        return $new;
    }

    /**
     * @return array<int<0,19>, \Twint\Sdk\Generated\Type\ShippingMethodReferenceType>
     */
    public function getShippingMethods(): array
    {
        return $this->ShippingMethods;
    }

    /**
     * @param array<int<0,19>, \Twint\Sdk\Generated\Type\ShippingMethodReferenceType> $ShippingMethods
     */
    public function withShippingMethods(array $ShippingMethods): static
    {
        $new = clone $this;
        $new->ShippingMethods = $ShippingMethods;

        return $new;
    }

    public function getQRCodeRendering(): ?bool
    {
        return $this->QRCodeRendering;
    }

    public function withQRCodeRendering(?bool $QRCodeRendering): static
    {
        $new = clone $this;
        $new->QRCodeRendering = $QRCodeRendering;

        return $new;
    }
}
