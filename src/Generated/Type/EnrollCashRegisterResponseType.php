<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;
use Phpro\SoapClient\Type\ResultInterface;

#[AllowDynamicProperties]
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

    /**
     * @param BeaconSecurityType $BeaconSecurity
     * @return EnrollCashRegisterResponseType
     */
    public function withBeaconSecurity($BeaconSecurity)
    {
        $new = clone $this;
        $new->BeaconSecurity = $BeaconSecurity;

        return $new;
    }
}
