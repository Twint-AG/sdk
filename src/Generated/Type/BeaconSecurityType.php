<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class BeaconSecurityType
{
    /**
     * @var string
     */
    private $BeaconUuid;

    /**
     * @var int
     */
    private $MajorId;

    /**
     * @var int
     */
    private $MinorId;

    /**
     * @var string
     */
    private $BeaconInitString;

    /**
     * @var string
     */
    private $BeaconSecret;

    /**
     * @return string
     */
    public function getBeaconUuid()
    {
        return $this->BeaconUuid;
    }

    public function withBeaconUuid(string $BeaconUuid): self
    {
        $new = clone $this;
        $new->BeaconUuid = $BeaconUuid;

        return $new;
    }

    /**
     * @return int
     */
    public function getMajorId()
    {
        return $this->MajorId;
    }

    public function withMajorId(int $MajorId): self
    {
        $new = clone $this;
        $new->MajorId = $MajorId;

        return $new;
    }

    /**
     * @return int
     */
    public function getMinorId()
    {
        return $this->MinorId;
    }

    public function withMinorId(int $MinorId): self
    {
        $new = clone $this;
        $new->MinorId = $MinorId;

        return $new;
    }

    /**
     * @return string
     */
    public function getBeaconInitString()
    {
        return $this->BeaconInitString;
    }

    public function withBeaconInitString(string $BeaconInitString): self
    {
        $new = clone $this;
        $new->BeaconInitString = $BeaconInitString;

        return $new;
    }

    /**
     * @return string
     */
    public function getBeaconSecret()
    {
        return $this->BeaconSecret;
    }

    public function withBeaconSecret(string $BeaconSecret): self
    {
        $new = clone $this;
        $new->BeaconSecret = $BeaconSecret;

        return $new;
    }
}
