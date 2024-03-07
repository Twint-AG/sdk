<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class OrderStatusType
{
    /**
     * @var CodeValueType
     */
    private $Status;

    /**
     * @var CodeValueType
     */
    private $Reason;

    /**
     * @return CodeValueType
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param CodeValueType $Status
     * @return OrderStatusType
     */
    public function withStatus($Status)
    {
        $new = clone $this;
        $new->Status = $Status;

        return $new;
    }

    /**
     * @return CodeValueType
     */
    public function getReason()
    {
        return $this->Reason;
    }

    /**
     * @param CodeValueType $Reason
     * @return OrderStatusType
     */
    public function withReason($Reason)
    {
        $new = clone $this;
        $new->Reason = $Reason;

        return $new;
    }
}
