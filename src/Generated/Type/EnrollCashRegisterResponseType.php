<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class EnrollCashRegisterResponseType implements ResultInterface
{
    protected BeaconSecurityType $BeaconSecurity;

    public function getBeaconSecurity(): BeaconSecurityType
    {
        return $this->BeaconSecurity;
    }

    public function withBeaconSecurity(BeaconSecurityType $BeaconSecurity): static
    {
        $new = clone $this;
        $new->BeaconSecurity = $BeaconSecurity;

        return $new;
    }
}
