<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use DateTimeInterface;
use Phpro\SoapClient\Type\RequestInterface;

final class FindOrderRequestType implements RequestInterface
{
    /**
     * @var string
     */
    private $MerchantUuid;

    /**
     * @var string
     */
    private $MerchantAliasId;

    /**
     * @var string
     */
    private $CashRegisterId;

    /**
     * @var DateTimeInterface
     */
    private $SearchStartDate;

    /**
     * @var DateTimeInterface
     */
    private $SearchEndDate;

    /**
     * @var string
     */
    private $OrderUuid;

    /**
     * @var string
     */
    private $MerchantTransactionReference;

    /**
     * Constructor
     *
     * @param string $MerchantUuid
     * @param string $MerchantAliasId
     * @param string $CashRegisterId
     * @param DateTimeInterface $SearchStartDate
     * @param DateTimeInterface $SearchEndDate
     * @param string $OrderUuid
     * @param string $MerchantTransactionReference
     */
    public function __construct($MerchantUuid, $MerchantAliasId, $CashRegisterId, $SearchStartDate, $SearchEndDate, $OrderUuid, $MerchantTransactionReference)
    {
        $this->MerchantUuid = $MerchantUuid;
        $this->MerchantAliasId = $MerchantAliasId;
        $this->CashRegisterId = $CashRegisterId;
        $this->SearchStartDate = $SearchStartDate;
        $this->SearchEndDate = $SearchEndDate;
        $this->OrderUuid = $OrderUuid;
        $this->MerchantTransactionReference = $MerchantTransactionReference;
    }

    /**
     * @return string
     */
    public function getMerchantUuid()
    {
        return $this->MerchantUuid;
    }

    public function withMerchantUuid(string $MerchantUuid): self
    {
        $new = clone $this;
        $new->MerchantUuid = $MerchantUuid;

        return $new;
    }

    /**
     * @return string
     */
    public function getMerchantAliasId()
    {
        return $this->MerchantAliasId;
    }

    public function withMerchantAliasId(string $MerchantAliasId): self
    {
        $new = clone $this;
        $new->MerchantAliasId = $MerchantAliasId;

        return $new;
    }

    /**
     * @return string
     */
    public function getCashRegisterId()
    {
        return $this->CashRegisterId;
    }

    public function withCashRegisterId(string $CashRegisterId): self
    {
        $new = clone $this;
        $new->CashRegisterId = $CashRegisterId;

        return $new;
    }

    /**
     * @return DateTimeInterface
     */
    public function getSearchStartDate()
    {
        return $this->SearchStartDate;
    }

    public function withSearchStartDate(DateTimeInterface $SearchStartDate): self
    {
        $new = clone $this;
        $new->SearchStartDate = $SearchStartDate;

        return $new;
    }

    /**
     * @return DateTimeInterface
     */
    public function getSearchEndDate()
    {
        return $this->SearchEndDate;
    }

    public function withSearchEndDate(DateTimeInterface $SearchEndDate): self
    {
        $new = clone $this;
        $new->SearchEndDate = $SearchEndDate;

        return $new;
    }

    /**
     * @return string
     */
    public function getOrderUuid()
    {
        return $this->OrderUuid;
    }

    public function withOrderUuid(string $OrderUuid): self
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

    public function withMerchantTransactionReference(string $MerchantTransactionReference): self
    {
        $new = clone $this;
        $new->MerchantTransactionReference = $MerchantTransactionReference;

        return $new;
    }
}
