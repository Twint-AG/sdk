<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Twint\Sdk\Certificate\Certificate;
use Twint\Sdk\Certificate\ConvertibleCertificate;
use Twint\Sdk\Certificate\Pkcs12Certificate;
use Twint\Sdk\Certificate\Pkcs1Certificate;
use Twint\Sdk\Certificate\Pkcs8Certificate;
use Twint\Sdk\Certificate\TlsBackend\MemoizingCertificateConverter;
use Twint\Sdk\Certificate\TlsBackend\MemoizingCertificateReader;
use Twint\Sdk\Certificate\TlsBackend\OpenSslCertificateConverter;
use Twint\Sdk\Certificate\TlsBackend\OpenSslCertificateReader;
use Twint\Sdk\Certificate\ToPkcs1;
use Twint\Sdk\Certificate\ToPkcs12;
use Twint\Sdk\Certificate\ToPkcs8;
use Twint\Sdk\Exception\CryptographyFailure;
use Twint\Sdk\Exception\InvalidCertificate;
use Twint\Sdk\Factory\DefaultCertificateReaderFactory;
use Twint\Sdk\Io\InMemoryStream;
use function Psl\Type\non_empty_string;
use function Psl\Type\shape;

/**
 * @internal
 */
#[CoversClass(Pkcs1Certificate::class)]
#[CoversClass(Pkcs8Certificate::class)]
#[CoversClass(Pkcs12Certificate::class)]
#[CoversClass(InvalidCertificate::class)]
#[CoversClass(ConvertibleCertificate::class)]
#[CoversClass(MemoizingCertificateConverter::class)]
#[CoversClass(OpenSslCertificateConverter::class)]
#[CoversClass(DefaultCertificateReaderFactory::class)]
#[CoversClass(MemoizingCertificateReader::class)]
#[CoversClass(OpenSslCertificateReader::class)]
final class CertificateConversionTest extends CertificateIntegrationTest
{
    /**
     * @return iterable<array{ToPkcs1}>
     */
    public static function getToPkcs1(): iterable
    {
        yield [self::getPkcs8()];
        yield [self::getPkcs12()];
    }

    /**
     * @return iterable<array{ToPkcs12}>
     */
    public static function getToPkcs12(): iterable
    {
        yield [self::getPkcs8()];
        yield [self::getPkcs1()];
    }

    /**
     * @return iterable<array{ToPkcs8}>
     */
    public static function getToPkcs8(): iterable
    {
        yield [self::getPkcs12()];
        yield [self::getPkcs1()];
    }

    #[DataProvider('getToPkcs1')]
    public function testPkcs1Conversion(ToPkcs1 $asPkcs1): void
    {
        self::assertStringContainsString('-----BEGIN CERTIFICATE-----', $asPkcs1->pkcs1()->content());
        self::assertStringContainsString('-----BEGIN RSA PRIVATE KEY-----', $asPkcs1->pkcs1()->content());
        self::assertStringContainsString('Proc-Type: 4,ENCRYPTED', $asPkcs1->pkcs1()->content());
        self::assertStringContainsString('DEK-Info: DES-EDE3-CBC', $asPkcs1->pkcs1()->content());
    }

    #[DataProvider('getToPkcs1')]
    public function testDeterministicPkcs1Conversion(ToPkcs1 $asPkcs1): void
    {
        $pkcs1 = $asPkcs1->pkcs1();
        $pkcs1ViaPkcs8 = $pkcs1->pkcs8()
            ->pkcs1();
        $pkcs1ViaPkcs12 = $pkcs1->pkcs12()
            ->pkcs1();

        self::assertSame($pkcs1->content(), $pkcs1ViaPkcs8->content());
        self::assertSame($pkcs1->passphrase(), $pkcs1ViaPkcs8->passphrase());
        self::assertSame($pkcs1->content(), $pkcs1ViaPkcs8->pkcs12()->pkcs1()->content());
        self::assertSame($pkcs1->passphrase(), $pkcs1ViaPkcs8->pkcs12()->pkcs1()->passphrase());
        self::assertSame($pkcs1->content(), $pkcs1ViaPkcs8->pkcs8()->pkcs1()->content());
        self::assertSame($pkcs1->passphrase(), $pkcs1ViaPkcs8->pkcs8()->pkcs1()->passphrase());

        self::assertSame($pkcs1->content(), $pkcs1ViaPkcs12->content());
        self::assertSame($pkcs1->passphrase(), $pkcs1ViaPkcs12->passphrase());
        self::assertSame($pkcs1->content(), $pkcs1ViaPkcs12->pkcs12()->pkcs1()->content());
        self::assertSame($pkcs1->passphrase(), $pkcs1ViaPkcs12->pkcs12()->pkcs1()->passphrase());
        self::assertSame($pkcs1->content(), $pkcs1ViaPkcs12->pkcs8()->pkcs1()->content());
        self::assertSame($pkcs1->passphrase(), $pkcs1ViaPkcs12->pkcs8()->pkcs1()->passphrase());
    }

    #[DataProvider('getToPkcs8')]
    public function testPkcs8Conversion(ToPkcs8 $asPkcs8): void
    {
        self::assertStringContainsString('-----BEGIN CERTIFICATE-----', $asPkcs8->pkcs8()->content());
        self::assertStringContainsString('-----BEGIN ENCRYPTED PRIVATE KEY-----', $asPkcs8->pkcs8()->content());
    }

    #[DataProvider('getToPkcs8')]
    public function testDeterministicPkcs8Conversion(ToPkcs8 $asPkcs8): void
    {
        $pkcs8 = $asPkcs8->pkcs8();

        $pkcs8ViaPkcs12 = $pkcs8->pkcs12()
            ->pkcs8();
        $pkcs8ViaPkcs1 = $pkcs8->pkcs1()
            ->pkcs8();

        self::assertSame($pkcs8->content(), $pkcs8ViaPkcs12->content());
        self::assertSame($pkcs8->passphrase(), $pkcs8ViaPkcs12->passphrase());
        self::assertSame($pkcs8->content(), $pkcs8ViaPkcs12->pkcs1()->pkcs8()->content());
        self::assertSame($pkcs8->passphrase(), $pkcs8ViaPkcs12->pkcs1()->pkcs8()->passphrase());
        self::assertSame($pkcs8->content(), $pkcs8ViaPkcs12->pkcs12()->pkcs8()->content());
        self::assertSame($pkcs8->passphrase(), $pkcs8ViaPkcs12->pkcs12()->pkcs8()->passphrase());

        self::assertSame($pkcs8->content(), $pkcs8ViaPkcs1->content());
        self::assertSame($pkcs8->passphrase(), $pkcs8ViaPkcs1->passphrase());
        self::assertSame($pkcs8->content(), $pkcs8ViaPkcs1->pkcs1()->pkcs8()->content());
        self::assertSame($pkcs8->passphrase(), $pkcs8ViaPkcs1->pkcs1()->pkcs8()->passphrase());
        self::assertSame($pkcs8->content(), $pkcs8ViaPkcs1->pkcs12()->pkcs8()->content());
        self::assertSame($pkcs8->passphrase(), $pkcs8ViaPkcs1->pkcs12()->pkcs8()->passphrase());
    }

    #[DataProvider('getToPkcs12')]
    public function testPkcs12Conversion(ToPkcs12 $asPkcs12): void
    {
        $firstBytes = shape([
            1 => non_empty_string(),
        ])->assert(unpack('H*', substr($asPkcs12->pkcs12()->content(), 0, 3)));
        self::assertStringStartsWith('30820c', $firstBytes[1]);
    }

    #[DataProvider('getToPkcs12')]
    public function testDeterministicPkcs12Conversion(ToPkcs12 $asPkcs12): void
    {
        $pkcs12 = $asPkcs12->pkcs12();
        $pkcs12ViaPkcs8 = $pkcs12->pkcs8()
            ->pkcs12();
        $pkcs12ViaPkcs1 = $pkcs12->pkcs1()
            ->pkcs12();

        self::assertSame($pkcs12->content(), $pkcs12ViaPkcs8->content());
        self::assertSame($pkcs12->passphrase(), $pkcs12ViaPkcs8->passphrase());
        self::assertSame($pkcs12->content(), $pkcs12ViaPkcs8->pkcs1()->pkcs12()->content());
        self::assertSame($pkcs12->passphrase(), $pkcs12ViaPkcs8->pkcs1()->pkcs12()->passphrase());
        self::assertSame($pkcs12->content(), $pkcs12ViaPkcs8->pkcs8()->pkcs12()->content());
        self::assertSame($pkcs12->passphrase(), $pkcs12ViaPkcs8->pkcs8()->pkcs12()->passphrase());

        self::assertSame($pkcs12->content(), $pkcs12ViaPkcs1->content());
        self::assertSame($pkcs12->passphrase(), $pkcs12ViaPkcs1->passphrase());
        self::assertSame($pkcs12->content(), $pkcs12ViaPkcs1->pkcs1()->pkcs12()->content());
        self::assertSame($pkcs12->passphrase(), $pkcs12ViaPkcs1->pkcs1()->pkcs12()->passphrase());
        self::assertSame($pkcs12->content(), $pkcs12ViaPkcs1->pkcs8()->pkcs12()->content());
        self::assertSame($pkcs12->passphrase(), $pkcs12ViaPkcs1->pkcs8()->pkcs12()->passphrase());
    }

    #[DataProvider('getToPkcs1')]
    public function testInvalidPasswordForPkcs1Conversion(ToPkcs1&Certificate $cert): void
    {
        $cert = new $cert(new InMemoryStream($cert->content()), 'wrongPassphrase');

        $this->expectException(CryptographyFailure::class);
        $cert->pkcs1()
            ->content();
    }

    #[DataProvider('getToPkcs8')]
    public function testInvalidPasswordForPkcs8Conversion(ToPkcs8&Certificate $cert): void
    {
        $cert = new $cert(new InMemoryStream($cert->content()), 'wrongPassphrase');

        $this->expectException(CryptographyFailure::class);
        $cert->pkcs8()
            ->content();
    }

    #[DataProvider('getToPkcs12')]
    public function testInvalidPasswordForPkcs12Conversion(ToPkcs12&Certificate $cert): void
    {
        $cert = new $cert(new InMemoryStream($cert->content()), 'wrongPassphrase');

        $this->expectException(CryptographyFailure::class);
        $cert->pkcs12()
            ->content();
    }
}
