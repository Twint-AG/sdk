<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class TerminalReferenceType
{
    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected ?string $TerminalUuid = null;

    protected ?string $TerminalExternalId = null;

    protected ?string $SignedQrCodePart = null;

    public function getTerminalUuid(): ?string
    {
        return $this->TerminalUuid;
    }

    public function withTerminalUuid(?string $TerminalUuid): static
    {
        $new = clone $this;
        $new->TerminalUuid = $TerminalUuid;

        return $new;
    }

    public function getTerminalExternalId(): ?string
    {
        return $this->TerminalExternalId;
    }

    public function withTerminalExternalId(?string $TerminalExternalId): static
    {
        $new = clone $this;
        $new->TerminalExternalId = $TerminalExternalId;

        return $new;
    }

    public function getSignedQrCodePart(): ?string
    {
        return $this->SignedQrCodePart;
    }

    public function withSignedQrCodePart(?string $SignedQrCodePart): static
    {
        $new = clone $this;
        $new->SignedQrCodePart = $SignedQrCodePart;

        return $new;
    }
}
