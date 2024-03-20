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
use Twint\Sdk\Certificate\Certificate;
use Twint\Sdk\Generated\TwintSoapClassMap;
use Twint\Sdk\TwintEnvironment;
use Twint\Sdk\TwintVersion;
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

    public function __invoke(Certificate $certificate, TwintVersion $version, TwintEnvironment $environment): Engine
    {
        return new LazyEngine(
            fn () => ExtSoapEngineFactory::fromOptionsWithTransport(
                ExtSoapOptions::defaults(
                    (string) $environment->soapWsdlPath($version),
                    [
                        'local_cert' => (string) $certificate->pem()
                            ->file(),
                        'passphrase' => $certificate->pem()
                            ->passphrase(),
                        'location' => (string) $environment->soapEndpoint($version),
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
                                    (string) $environment->soapTargetNamespace($version),
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
