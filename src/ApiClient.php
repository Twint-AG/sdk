<?php

declare(strict_types=1);

namespace Twint\Sdk;

use DateTimeImmutable;
use DOMNode;

use GuzzleHttp\Client as HttpClient;
use Http\Client\Common\PluginClient;
use Phpro\SoapClient\Caller\EngineCaller;
use Soap\Engine\Transport;
use Soap\ExtSoapEngine\ExtSoapEngineFactory;
use Soap\ExtSoapEngine\ExtSoapOptions;
use Soap\Psr18Transport\Middleware\SoapHeaderMiddleware;
use Soap\Psr18Transport\Psr18Transport;
use Soap\Xml\Builder\SoapHeader;
use Twint\Sdk\Generated\TwintSoapClassMap;
use Twint\Sdk\Generated\TwintSoapClient;
use Twint\Sdk\Generated\Type\GetCertificateValidityRequestType;
use Twint\Sdk\Value\CertificateValidity;
use Twint\Sdk\Value\MerchantId;
use function VeeWee\Xml\Dom\Builder\children;
use function VeeWee\Xml\Dom\Builder\element;
use function VeeWee\Xml\Dom\Builder\value;

final class ApiClient implements Client
{
    private const CLIENT_SOFTWARE_NAME = 'TWINT SDK for PHP';

    private ?TwintSoapClient $client = null;

    public function __construct(
        private readonly Certificate $certificate
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
        return $this->client ??= self::createSoapClient($this->certificate);
    }

    private static function createSoapClient(Certificate $certificate): TwintSoapClient
    {
        return new TwintSoapClient(
            new EngineCaller(
                ExtSoapEngineFactory::fromOptionsWithTransport(
                    ExtSoapOptions::defaults(
                        ApiVersion::wsdlPath(),
                        [
                            'trace' => true,
                            'local_cert' => $certificate->getCombinedPemPath(),
                            'passphrase' => $certificate->getPemPassphrase(),
                            'location' => ApiVersion::endpoint('pat'),
                        ]
                    )->withClassMap(TwintSoapClassMap::getCollection()),
                    self::createTransport($certificate)
                )
            )
        );
    }

    private static function createTransport(Certificate $certificate): Transport
    {
        return Psr18Transport::createForClient(
            new PluginClient(
                new HttpClient([
                    'cert' => [$certificate->getCombinedPemPath(), $certificate->getPemPassphrase()],
                ]),
                [
                    new SoapHeaderMiddleware(
                        new SoapHeader(
                            ApiVersion::targetNamespace(),
                            'RequestHeaderElement',
                            static fn (DOMNode $node) => children(
                                element('MessageId', value('77e99e8a-c0c3-4a3e-afcc-ab222165d9ac')),
                                element('ClientSoftwareName', value(self::CLIENT_SOFTWARE_NAME)),
                                element('ClientSoftwareVersion', value(Version::VERSION))
                            )($node)
                        )
                    ),
                ]
            )
        );
    }
}
