<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use DOMNode;
use GuzzleHttp\Client as HttpClient;
use Http\Client\Common\PluginClient;
use Soap\Engine\Engine;
use Soap\Engine\LazyEngine;
use Soap\ExtSoapEngine\ExtSoapEngineFactory;
use Soap\ExtSoapEngine\ExtSoapOptions;
use Soap\Psr18Transport\Middleware\SoapHeaderMiddleware;
use Soap\Psr18Transport\Psr18Transport;
use Soap\Xml\Builder\SoapHeader;
use Twint\Sdk\ApiVersion;
use Twint\Sdk\Certificate\Certificate;
use Twint\Sdk\Generated\TwintSoapClassMap;
use Twint\Sdk\Value\Uuid;
use Twint\Sdk\Version;
use function VeeWee\Xml\Dom\Builder\children;
use function VeeWee\Xml\Dom\Builder\element;
use function VeeWee\Xml\Dom\Builder\value;

final class DefaultSoapEngineFactory
{
    /**
     * @param callable(): Uuid $createUuid
     */
    public function __construct(
        private readonly mixed $createUuid = new Uuid4Factory()
    ) {
    }

    public function __invoke(Certificate $certificate): Engine
    {
        return new LazyEngine(
            fn () => ExtSoapEngineFactory::fromOptionsWithTransport(
                ExtSoapOptions::defaults(
                    ApiVersion::wsdlPath(),
                    [
                        'local_cert' => (string) $certificate->pem()
                            ->file(),
                        'passphrase' => $certificate->pem()
                            ->passphrase(),
                        'location' => ApiVersion::endpoint('pat'),
                    ]
                )->withClassMap(TwintSoapClassMap::getCollection()),
                Psr18Transport::createForClient(
                    new PluginClient(
                        new HttpClient([
                            'cert' => [$certificate->pem()->file(), $certificate->pem()->passphrase()],
                        ]),
                        [
                            new SoapHeaderMiddleware(
                                new SoapHeader(
                                    ApiVersion::targetNamespace(),
                                    'RequestHeaderElement',
                                    fn (DOMNode $node) => children(
                                        element('MessageId', value((string) ($this->createUuid)())),
                                        element('ClientSoftwareName', value(Version::NAME)),
                                        element('ClientSoftwareVersion', value(Version::VERSION))
                                    )($node)
                                )
                            ),
                        ]
                    )
                )
            )
        );
    }
}
