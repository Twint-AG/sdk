<?php

declare(strict_types=1);

namespace Twint\Sdk;

use DateTimeImmutable;

use Phpro\SoapClient\Caller\EngineCaller;
use Soap\Engine\Engine;
use Twint\Sdk\Factory\DefaultSoapEngineFactory;
use Twint\Sdk\Generated\TwintSoapClient;
use Twint\Sdk\Generated\Type\GetCertificateValidityRequestType;
use Twint\Sdk\Value\CertificateValidity;
use Twint\Sdk\Value\MerchantId;

final class ApiClient implements Client
{
    private ?TwintSoapClient $client = null;

    /**
     * @param callable(Certificate): Engine $soapEngineFactory
     */
    public function __construct(
        private readonly Certificate $certificate,
        private readonly mixed $soapEngineFactory = new DefaultSoapEngineFactory()
    ) {
    }

    public function getCertificateValidity(MerchantId $merchantId): CertificateValidity
    {
        $response = $this->soapClient()
            ->getCertificateValidity(new GetCertificateValidityRequestType((string) $merchantId, ''));

        return new CertificateValidity(
            DateTimeImmutable::createFromInterface($response->getCertificateExpiryDate()),
            $response->getRenewalAllowed()
        );
    }

    private function soapClient(): TwintSoapClient
    {
        return $this->client ??= new TwintSoapClient(new EngineCaller(($this->soapEngineFactory)($this->certificate)));
    }
}
