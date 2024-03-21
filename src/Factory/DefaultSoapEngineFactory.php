<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use DOMNode;
use Http\Client\Common\PluginClient;
use Psr\Http\Client\ClientInterface;
use Soap\Engine\Engine;
use Soap\Engine\LazyEngine;
use Soap\ExtSoapEngine\ExtSoapEngineFactory;
use Soap\ExtSoapEngine\ExtSoapOptions;
use Soap\Psr18Transport\Middleware\SoapHeaderMiddleware;
use Soap\Psr18Transport\Psr18Transport;
use Soap\Xml\Builder\SoapHeader;
use Twint\Sdk\Certificate\CertificateContainer;
use Twint\Sdk\File\FileWriter;
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
     * @param callable(FileWriter, CertificateContainer): ClientInterface $createHttpClient
     */
    public function __construct(
        private readonly mixed $createUuid = new Uuid4Factory(),
        private readonly mixed $createHttpClient = new DefaultHttpClientFactory(),
    ) {
    }

    public function __invoke(
        FileWriter $writer,
        CertificateContainer $certificate,
        TwintVersion $version,
        TwintEnvironment $environment
    ): Engine {
        return new LazyEngine(
            fn () => ExtSoapEngineFactory::fromOptionsWithTransport(
                ExtSoapOptions::defaults(
                    (string) $environment->soapWsdlPath($version),
                    [
                        'local_cert' => (string) $certificate->pem()
                            ->toFile($writer)
                            ->path(),
                        'passphrase' => $certificate->pem()
                            ->passphrase(),
                        'location' => (string) $environment->soapEndpoint($version),
                    ]
                )->withClassMap(TwintSoapClassMap::getCollection()),
                Psr18Transport::createForClient(
                    new PluginClient(
                        ($this->createHttpClient)($writer, $certificate),
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
