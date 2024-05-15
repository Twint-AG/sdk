<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use DOMNode;
use Http\Client\Common\PluginClient;
use Phpro\SoapClient\Soap\ExtSoap\Metadata\Manipulators\DuplicateTypes\IntersectDuplicateTypesStrategy;
use Phpro\SoapClient\Soap\Metadata\MetadataFactory;
use Phpro\SoapClient\Soap\Metadata\MetadataOptions;
use Psr\Http\Client\ClientInterface;
use Soap\Engine\Decoder;
use Soap\Engine\Encoder;
use Soap\Engine\Engine;
use Soap\Engine\LazyEngine;
use Soap\Engine\SimpleEngine;
use Soap\ExtSoapEngine\AbusedClient;
use Soap\ExtSoapEngine\ExtSoapDecoder;
use Soap\ExtSoapEngine\ExtSoapDriver;
use Soap\ExtSoapEngine\ExtSoapEncoder;
use Soap\ExtSoapEngine\ExtSoapMetadata;
use Soap\ExtSoapEngine\ExtSoapOptions;
use Soap\ExtSoapEngine\Generator\DummyMethodArgumentsGenerator;
use Soap\Psr18Transport\Middleware\SoapHeaderMiddleware;
use Soap\Psr18Transport\Psr18Transport;
use Soap\Xml\Builder\SoapHeader;
use Twint\Sdk\Certificate\CertificateContainer;
use Twint\Sdk\Generated\TwintSoapClassMap;
use Twint\Sdk\Io\FileWriter;
use Twint\Sdk\SdkVersion;
use Twint\Sdk\Util\HigherOrder;
use Twint\Sdk\Value\Environment;
use Twint\Sdk\Value\Uuid;
use Twint\Sdk\Value\Version;
use function VeeWee\Xml\Dom\Builder\children;
use function VeeWee\Xml\Dom\Builder\element;
use function VeeWee\Xml\Dom\Builder\value;

final class DefaultSoapEngineFactory
{
    /**
     * @param callable(): Uuid $createUuid
     * @param callable(FileWriter, CertificateContainer): ClientInterface $createHttpClient
     * @param callable(Encoder): Encoder $wrapEncoder
     * @param callable(Decoder): Decoder $wrapDecoder
     */
    public function __construct(
        private readonly mixed $createUuid = new Uuid4Factory(),
        private readonly mixed $createHttpClient = new DefaultHttpClientFactory(),
        private readonly mixed $wrapEncoder = [HigherOrder::class, 'identity'],
        private readonly mixed $wrapDecoder = [HigherOrder::class, 'identity'],
    ) {
    }

    public function __invoke(
        FileWriter $writer,
        CertificateContainer $certificate,
        Version $version,
        Environment $environment
    ): Engine {
        return new LazyEngine(
            function () use ($environment, $certificate, $version, $writer) {
                $options = ExtSoapOptions::defaults(
                    (string) $environment->soapWsdlPath($version),
                    [
                        'local_cert' => (string) $certificate->pem()
                            ->toFile($writer)
                            ->path(),
                        'passphrase' => $certificate->pem()
                            ->passphrase(),
                        'location' => (string) $environment->soapEndpoint($version),
                    ]
                )->withClassMap(TwintSoapClassMap::getCollection());

                $client = AbusedClient::createFromOptions($options);
                $metadataOptions = MetadataOptions::empty()
                    ->withTypesManipulator(new IntersectDuplicateTypesStrategy());
                $metadata = MetadataFactory::manipulated(new ExtSoapMetadata($client), $metadataOptions);
                $encoder = ($this->wrapEncoder)(new ExtSoapEncoder($client));
                $decoder = ($this->wrapDecoder)(
                    new ExtSoapDecoder($client, new DummyMethodArgumentsGenerator($metadata))
                );
                $driver = new ExtSoapDriver($client, $encoder, $decoder, $metadata);

                return new SimpleEngine(
                    $driver,
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
                                            element('ClientSoftwareName', value(SdkVersion::NAME)),
                                            element('ClientSoftwareVersion', value(SdkVersion::VERSION))
                                        )($node)
                                    )
                                ),
                            ]
                        )
                    )
                );
            }
        );
    }
}
