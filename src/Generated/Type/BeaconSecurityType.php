<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class BeaconSecurityType
{
    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected string $BeaconUuid;

    protected int $MajorId;

    protected int $MinorId;

    protected string $BeaconInitString;

    protected string $BeaconSecret;

    public function getBeaconUuid(): string
    {
        return $this->BeaconUuid;
    }

    public function withBeaconUuid(string $BeaconUuid): static
    {
        $new = clone $this;
        $new->BeaconUuid = $BeaconUuid;

        return $new;
    }

    public function getMajorId(): int
    {
        return $this->MajorId;
    }

    public function withMajorId(int $MajorId): static
    {
        $new = clone $this;
        $new->MajorId = $MajorId;

        return $new;
    }

    public function getMinorId(): int
    {
        return $this->MinorId;
    }

    public function withMinorId(int $MinorId): static
    {
        $new = clone $this;
        $new->MinorId = $MinorId;

        return $new;
    }

    public function getBeaconInitString(): string
    {
        return $this->BeaconInitString;
    }

    public function withBeaconInitString(string $BeaconInitString): static
    {
        $new = clone $this;
        $new->BeaconInitString = $BeaconInitString;

        return $new;
    }

    public function getBeaconSecret(): string
    {
        return $this->BeaconSecret;
    }

    public function withBeaconSecret(string $BeaconSecret): static
    {
        $new = clone $this;
        $new->BeaconSecret = $BeaconSecret;

        return $new;
    }
}
