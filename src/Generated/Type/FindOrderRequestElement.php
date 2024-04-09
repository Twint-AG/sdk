<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use DateTimeInterface;
use Phpro\SoapClient\Type\RequestInterface;

class FindOrderRequestElement implements RequestInterface
{
    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected ?string $MerchantUuid;

    protected ?string $MerchantAliasId;

    protected ?string $CashRegisterId;

    protected DateTimeInterface $SearchStartDate;

    protected DateTimeInterface $SearchEndDate;

    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected ?string $OrderUuid;

    /**
     * Reference number by which the merchant might want to identify
     *  this voucher in his own applications.
     */
    protected ?string $MerchantTransactionReference;

    /**
     * Constructor
     */
    public function __construct(?string $MerchantUuid, ?string $MerchantAliasId, ?string $CashRegisterId, DateTimeInterface $SearchStartDate, DateTimeInterface $SearchEndDate, ?string $OrderUuid, ?string $MerchantTransactionReference)
    {
        $this->MerchantUuid = $MerchantUuid;
        $this->MerchantAliasId = $MerchantAliasId;
        $this->CashRegisterId = $CashRegisterId;
        $this->SearchStartDate = $SearchStartDate;
        $this->SearchEndDate = $SearchEndDate;
        $this->OrderUuid = $OrderUuid;
        $this->MerchantTransactionReference = $MerchantTransactionReference;
    }

    public function getMerchantUuid(): ?string
    {
        return $this->MerchantUuid;
    }

    public function withMerchantUuid(?string $MerchantUuid): static
    {
        $new = clone $this;
        $new->MerchantUuid = $MerchantUuid;

        return $new;
    }

    public function getMerchantAliasId(): ?string
    {
        return $this->MerchantAliasId;
    }

    public function withMerchantAliasId(?string $MerchantAliasId): static
    {
        $new = clone $this;
        $new->MerchantAliasId = $MerchantAliasId;

        return $new;
    }

    public function getCashRegisterId(): ?string
    {
        return $this->CashRegisterId;
    }

    public function withCashRegisterId(?string $CashRegisterId): static
    {
        $new = clone $this;
        $new->CashRegisterId = $CashRegisterId;

        return $new;
    }

    public function getSearchStartDate(): DateTimeInterface
    {
        return $this->SearchStartDate;
    }

    public function withSearchStartDate(DateTimeInterface $SearchStartDate): static
    {
        $new = clone $this;
        $new->SearchStartDate = $SearchStartDate;

        return $new;
    }

    public function getSearchEndDate(): DateTimeInterface
    {
        return $this->SearchEndDate;
    }

    public function withSearchEndDate(DateTimeInterface $SearchEndDate): static
    {
        $new = clone $this;
        $new->SearchEndDate = $SearchEndDate;

        return $new;
    }

    public function getOrderUuid(): ?string
    {
        return $this->OrderUuid;
    }

    public function withOrderUuid(?string $OrderUuid): static
    {
        $new = clone $this;
        $new->OrderUuid = $OrderUuid;

        return $new;
    }

    public function getMerchantTransactionReference(): ?string
    {
        return $this->MerchantTransactionReference;
    }

    public function withMerchantTransactionReference(?string $MerchantTransactionReference): static
    {
        $new = clone $this;
        $new->MerchantTransactionReference = $MerchantTransactionReference;

        return $new;
    }
}
