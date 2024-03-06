<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class EnrollCashRegisterResponseType implements ResultInterface
{
    /**
     * @var \Twint\Sdk\Generated\Type\BeaconSecurityType
     */
    private $BeaconSecurity;

    /**
     * @return \Twint\Sdk\Generated\Type\BeaconSecurityType
     */
    public function getBeaconSecurity()
    {
        return $this->BeaconSecurity;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\BeaconSecurityType $BeaconSecurity
     * @return EnrollCashRegisterResponseType
     */
    public function withBeaconSecurity($BeaconSecurity)
    {
        $new = clone $this;
        $new->BeaconSecurity = $BeaconSecurity;

        return $new;
    }
}

