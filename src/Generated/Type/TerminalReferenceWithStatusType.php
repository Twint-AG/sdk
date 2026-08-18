<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class TerminalReferenceWithStatusType extends TerminalReferenceType
{
    /**
     * @var array<int<0, max>, 'INVALID_MCC'|'INVALID_STATUS'|'INVALID_IBAN'|'IBAN_NOT_UNIQUE'|'SYSTEM'>
     */
    protected array $Status;

    /**
     * @return array<int<0, max>, 'INVALID_MCC'|'INVALID_STATUS'|'INVALID_IBAN'|'IBAN_NOT_UNIQUE'|'SYSTEM'>
     */
    public function getStatus(): array
    {
        return $this->Status;
    }

    /**
     * @param array<int<0, max>, 'INVALID_MCC'|'INVALID_STATUS'|'INVALID_IBAN'|'IBAN_NOT_UNIQUE'|'SYSTEM'> $Status
     */
    public function withStatus(array $Status): static
    {
        $new = clone $this;
        $new->Status = $Status;

        return $new;
    }
}
