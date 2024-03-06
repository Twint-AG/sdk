<?php

namespace Twint\Sdk\Generated\Type;

class OrderStatusType
{
    /**
     * @var \Twint\Sdk\Generated\Type\CodeValueType
     */
    private $Status;

    /**
     * @var \Twint\Sdk\Generated\Type\CodeValueType
     */
    private $Reason;

    /**
     * @return \Twint\Sdk\Generated\Type\CodeValueType
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CodeValueType $Status
     * @return OrderStatusType
     */
    public function withStatus($Status)
    {
        $new = clone $this;
        $new->Status = $Status;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\CodeValueType
     */
    public function getReason()
    {
        return $this->Reason;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CodeValueType $Reason
     * @return OrderStatusType
     */
    public function withReason($Reason)
    {
        $new = clone $this;
        $new->Reason = $Reason;

        return $new;
    }
}

