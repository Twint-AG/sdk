<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

final class EnrollCashRegisterResponseType implements ResultInterface
{
    /**
     * @var BeaconSecurityType
     */
    private $BeaconSecurity;

    /**
     * @return BeaconSecurityType
     */
    public function getBeaconSecurity()
    {
        return $this->BeaconSecurity;
    }

    public function withBeaconSecurity(BeaconSecurityType $BeaconSecurity): self
    {
        $new = clone $this;
        $new->BeaconSecurity = $BeaconSecurity;

        return $new;
    }
}
