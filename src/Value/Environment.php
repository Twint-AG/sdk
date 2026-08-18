<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

enum Environment: string
{
    case TESTING = 'TESTING';

    case PRODUCTION = 'PRODUCTION';

    public function appSchemeUrl(): Url
    {
        return new Url('https://' . $this->appSchemeHost() . '/appSwitch/v1/configs');
    }

    public function soapWsdlPath(Version $version): ExistingPath
    {
        return new ExistingPath(
            __DIR__ . '/../../resources/wsdl/v' . $version->dotVersion() . '/TWINTMerchantService_v' . $version->dotVersion() . '.wsdl'
        );
    }

    public function soapEndpoint(Version $version): Url
    {
        return new Url(
            'https://' . $this->getServiceHost() . '/merchant/service/TWINTMerchantServiceV' . $version->underscoreVersion()
        );
    }

    private function getServiceHost(): string
    {
        return match ($this) {
            self::TESTING => 'service-pat.twint.ch',
            self::PRODUCTION => 'service.twint.ch',
        };
    }

    private function appSchemeHost(): string
    {
        return match ($this) {
            self::TESTING => 'app.scheme-pat.twint.ch',
            self::PRODUCTION => 'app.scheme.twint.ch',
        };
    }
}
