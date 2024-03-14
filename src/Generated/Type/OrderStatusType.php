<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class OrderStatusType
{
    protected CodeValueType $Status;

    protected CodeValueType $Reason;

    public function getStatus(): CodeValueType
    {
        return $this->Status;
    }

    public function withStatus(CodeValueType $Status): static
    {
        $new = clone $this;
        $new->Status = $Status;

        return $new;
    }

    public function getReason(): CodeValueType
    {
        return $this->Reason;
    }

    public function withReason(CodeValueType $Reason): static
    {
        $new = clone $this;
        $new->Reason = $Reason;

        return $new;
    }
}
