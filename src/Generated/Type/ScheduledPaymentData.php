<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use DateTimeInterface;

class ScheduledPaymentData
{
    /**
     * The Billing Adapter will pass with this field the due date, at when the payment
     *  will be authorized and confirmed. A private customer has the option
     *  to cancel the scheduled payment beforehand.
     */
    protected DateTimeInterface $ScheduledProcessingDate;

    /**
     * Swiss QR Bill reference type
     *
     * @var 'QRR'|'SCOR'|'NON'|null
     */
    protected ?string $ReferenceType = null;

    /**
     * Swiss QR Bill reference - (it might be undefined for the direct debit-case).
     *  Example: 210000000003139471430009017
     */
    protected ?string $Reference = null;

    /**
     * Additional information (Swiss QR Bill)
     *  Example: Order from 28.04.2025
     */
    protected ?string $AdditionalInformation = null;

    public function getScheduledProcessingDate(): DateTimeInterface
    {
        return $this->ScheduledProcessingDate;
    }

    public function withScheduledProcessingDate(DateTimeInterface $ScheduledProcessingDate): static
    {
        $new = clone $this;
        $new->ScheduledProcessingDate = $ScheduledProcessingDate;

        return $new;
    }

    /**
     * @return 'QRR'|'SCOR'|'NON'|null
     */
    public function getReferenceType(): ?string
    {
        return $this->ReferenceType;
    }

    /**
     * @param 'QRR'|'SCOR'|'NON'|null $ReferenceType
     */
    public function withReferenceType(?string $ReferenceType): static
    {
        $new = clone $this;
        $new->ReferenceType = $ReferenceType;

        return $new;
    }

    public function getReference(): ?string
    {
        return $this->Reference;
    }

    public function withReference(?string $Reference): static
    {
        $new = clone $this;
        $new->Reference = $Reference;

        return $new;
    }

    public function getAdditionalInformation(): ?string
    {
        return $this->AdditionalInformation;
    }

    public function withAdditionalInformation(?string $AdditionalInformation): static
    {
        $new = clone $this;
        $new->AdditionalInformation = $AdditionalInformation;

        return $new;
    }
}
