<?php

namespace Twint\Sdk\Generated\Type;

class BeaconSecurityType
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

    /**
     * @param string $BeaconUuid
     * @return BeaconSecurityType
     */
    public function withBeaconUuid($BeaconUuid)
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

    /**
     * @param int $MajorId
     * @return BeaconSecurityType
     */
    public function withMajorId($MajorId)
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

    /**
     * @param int $MinorId
     * @return BeaconSecurityType
     */
    public function withMinorId($MinorId)
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

    /**
     * @param string $BeaconInitString
     * @return BeaconSecurityType
     */
    public function withBeaconInitString($BeaconInitString)
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

    /**
     * @param string $BeaconSecret
     * @return BeaconSecurityType
     */
    public function withBeaconSecret($BeaconSecret)
    {
        $new = clone $this;
        $new->BeaconSecret = $BeaconSecret;

        return $new;
    }
}

