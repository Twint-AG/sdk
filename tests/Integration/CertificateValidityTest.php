<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use DateTimeImmutable;
use DOMDocument;
use DOMNode;
use OpenSSLCertificate;
use OpenSSLCertificateSigningRequest;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\ApiClient;
use Twint\Sdk\Assertion;
use Twint\Sdk\Checks\PHPUnit\IntegrationTest;
use Twint\Sdk\Checks\PHPUnit\MutableResponse;
use Twint\Sdk\Checks\PHPUnit\Vcr;
use VCR\Request;
use VeeWee\Xml\Dom\Document;
use function VeeWee\Xml\Dom\Builder\value;
use function VeeWee\Xml\Dom\Locator\elements_with_namespaced_tagname;

#[CoversClass(ApiClient::class)]
final class CertificateValidityTest extends IntegrationTest
{
    public static function rewriteRenewCertificateRequest(Request $request): void
    {
        $doc = new DOMDocument('1.0');
        $doc->loadXML((string) $request->getBody());
        $element = $doc->getElementsByTagName('CertificatePassword')
            ->item(0);
        Assertion::isInstanceOf($element, DOMNode::class, 'CertificatePassword element not found');
        $element->nodeValue = base64_encode('secret');

        $body = $doc->saveXML();
        Assertion::string($body, 'Failed to save XML');

        $request->setBody($body);
    }

    public static function rewriteRenewCertificateResponse(MutableResponse $response): void
    {
        $config = [
            'digest_alg' => 'sha256',
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            'encrypt_key' => true,
        ];
        $privateKey = openssl_pkey_new($config);

        $dn = [
            'C' => 'CH',
            'O' => 'TWINT AG',
            'OU' => 'MerchantCustomers',
            'CN' => 'TWINT-TechUser NFQ Integration Test',
            'UID' => self::getMerchantId(),
        ];

        $csr = openssl_csr_new($dn, $privateKey, $config);
        Assertion::isInstanceOf($csr, OpenSSLCertificateSigningRequest::class, 'Failed to create CSR');
        $cert = openssl_csr_sign($csr, null, $privateKey, 365, $config);
        Assertion::isInstanceOf($cert, OpenSSLCertificate::class, 'Failed to sign CSR');

        $password = self::getEnvironmentVariable('TWINT_SDK_TEST_CERT_P12_PASSPHRASE');
        openssl_pkcs12_export($cert, $p12, $privateKey, $password);

        $response->setStatus(200);

        $doc = Document::fromXmlString(
            '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Header>
        <header:ResponseHeaderElement xmlns:header="http://service.twint.ch/header/types/v8_5">
            <header:MessageId>00000000-0000-0000-0000-000000000000</header:MessageId>
        </header:ResponseHeaderElement>
    </soap:Header>
    <soap:Body>
        <ns2:RenewCertificateResponseElement xmlns:ns2="http://service.twint.ch/merchant/types/v8_5">
            <ns2:ExpirationDate>2100-08-09+02:00</ns2:ExpirationDate>
            <ns2:MerchantCertificate>cert</ns2:MerchantCertificate>
        </ns2:RenewCertificateResponseElement>
    </soap:Body>
</soap:Envelope>
            ',
        );
        $doc
            ->locate(
                elements_with_namespaced_tagname('http://service.twint.ch/merchant/types/v8_5', 'MerchantCertificate')
            )
            ->map(value(base64_encode($p12)));
        $response->setBody($doc->toXmlString());
    }

    #[Vcr(fixtureRevision: 1, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testCertificateValidity(): void
    {
        $certificateValidity = $this->client->getCertificateValidity(self::getMerchantId());

        self::assertIsBool($certificateValidity->isRenewalAllowed());
        self::assertInstanceOf(DateTimeImmutable::class, $certificateValidity->expiresAt());
    }

    #[Vcr(
        fixtureRevision: 1,
        requestMatchers: self::SOAP_REQUEST_MATCHERS,
        censorRequest: [self::class, 'rewriteRenewCertificateRequest'],
        censorResponse: [self::class, 'rewriteRenewCertificateResponse']
    )]
    public function testRenewCertificate(): void
    {
        $renewal = $this->client->renewCertificate(self::getMerchantId());
        self::assertStringStartsWith('-----BEGIN CERTIFICATE-----', $renewal->certificate()->pem()->content());
        self::assertSame('2100-08-08T22:00:00+00:00', $renewal->expiresAt()->format('c'));
    }
}
