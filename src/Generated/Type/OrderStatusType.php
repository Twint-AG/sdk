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

    public function withStatus(CodeValueType $Status): self
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

    public function withReason(CodeValueType $Reason): self
    {
        $new = clone $this;
        $new->Reason = $Reason;

        return $new;
    }
}
