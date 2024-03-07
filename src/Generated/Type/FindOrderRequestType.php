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

    /**
     * @param string $MerchantUuid
     * @return FindOrderRequestType
     */
    public function withMerchantUuid($MerchantUuid)
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

    /**
     * @param string $MerchantAliasId
     * @return FindOrderRequestType
     */
    public function withMerchantAliasId($MerchantAliasId)
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

    /**
     * @param string $CashRegisterId
     * @return FindOrderRequestType
     */
    public function withCashRegisterId($CashRegisterId)
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

    /**
     * @param DateTimeInterface $SearchStartDate
     * @return FindOrderRequestType
     */
    public function withSearchStartDate($SearchStartDate)
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

    /**
     * @param DateTimeInterface $SearchEndDate
     * @return FindOrderRequestType
     */
    public function withSearchEndDate($SearchEndDate)
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

    /**
     * @param string $OrderUuid
     * @return FindOrderRequestType
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
     * @return FindOrderRequestType
     */
    public function withMerchantTransactionReference($MerchantTransactionReference)
    {
        $new = clone $this;
        $new->MerchantTransactionReference = $MerchantTransactionReference;

        return $new;
    }
}
