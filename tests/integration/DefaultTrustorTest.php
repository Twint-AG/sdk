<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Psr\Clock\ClockInterface;
use Symfony\Component\Clock\Clock;
use Symfony\Component\Clock\MockClock;
use Twint\Sdk\Certificate\DefaultTrustor;
use Twint\Sdk\Certificate\Pkcs12Certificate;
use Twint\Sdk\Exception\InvalidCertificate;
use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Io\NonEmptyStream;
use Twint\Sdk\Tools\SystemEnvironment;
use Twint\Sdk\Value\ExistingPath;
use function Psl\invariant;
use function Psl\Type\instance_of;

/**
 * @internal
 */
#[CoversClass(DefaultTrustor::class)]
final class DefaultTrustorTest extends CertificateIntegrationTest
{
    private const PASSPHRASE = 'secret';

    /**
     * @return iterable<string, array{ClockInterface, string, list<string>}>
     */
    public static function getCertificates(): iterable
    {
        yield 'Invalid issuer country and org' => [
            ...self::invalidCertificateFixture('now', ...self::fakeCert(self::PASSPHRASE, 'DE', 'ACME')),
            ['Invalid issuer country code', 'Invalid issuer organization'],
        ];
        yield 'Invalid issuer org' => [
            ...self::invalidCertificateFixture('now', ...self::fakeCert(self::PASSPHRASE, 'CH', 'ACME')),
            ['Invalid issuer organization'],
        ];
        yield 'Invalid issuer country' => [
            ...self::invalidCertificateFixture('now', ...self::fakeCert(self::PASSPHRASE, 'DE', 'TWINT AG')),
            ['Invalid issuer country code'],
        ];
        yield 'Inclusive validity (upper bound)' => [
            ...self::invalidCertificateFixture('+365 days', ...self::fakeCert(self::PASSPHRASE, 'CH', 'TWINT AG')),
            [],
        ];
        yield 'Just expired' => [
            ...self::invalidCertificateFixture(
                '+365 days +1 millisecond',
                ...self::fakeCert(self::PASSPHRASE, 'CH', 'TWINT AG')
            ),
            [InvalidCertificate::ERROR_CERTIFICATE_EXPIRED],
        ];
        yield 'Just not yet valid' => [
            ...self::invalidCertificateFixture('-1 millisecond', ...self::fakeCert(self::PASSPHRASE, 'CH', 'TWINT AG')),
            [InvalidCertificate::ERROR_CERTIFICATE_NOT_YET_VALID],
        ];
        yield 'Inclusive validity (lower bound)' => [
            ...self::invalidCertificateFixture('now', ...self::fakeCert(self::PASSPHRASE, 'CH', 'TWINT AG')),
            [],
        ];
    }

    /**
     * @return array{ClockInterface, string}
     */
    private static function invalidCertificateFixture(
        string $clockAdjustment,
        string $cert,
        DateTimeImmutable $from,
        DateTimeImmutable $to
    ): array {
        return [new MockClock(instance_of(DateTimeImmutable::class)->assert($from->modify($clockAdjustment))), $cert];
    }

    private static function readCert(string $cert, string $passphrase): string
    {
        invariant(openssl_pkcs12_read($cert, $certs, $passphrase), 'Cannot read certificate');

        return $certs['cert'];
    }

    /**
     * @param list<InvalidCertificate::*> $expectedErrors
     */
    #[DataProvider('getCertificates')]
    public function testEstablishTrustCases(ClockInterface $clock, string $cert, array $expectedErrors): void
    {
        try {
            (new DefaultTrustor($clock))->check(self::readCert($cert, self::PASSPHRASE));

            if (count($expectedErrors) > 0) {
                self::fail('Expected exception');
            }

            $this->addToAssertionCount(1);
        } catch (InvalidCertificate $e) {
            self::assertSame($expectedErrors, $e->getErrors());
        }
    }

    public function testX509ParseReturnsIncorrectShape(): void
    {
        try {
            Pkcs12Certificate::establishTrustVia(
                new NonEmptyStream(
                    new FileStream(new ExistingPath(SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PATH')))
                ),
                SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PASSPHRASE'),
                new DefaultTrustor(new Clock(), static fn () => [])
            );

            self::fail('Expected exception');
        } catch (InvalidCertificate $e) {
            self::assertSame([InvalidCertificate::ERROR_CANNOT_PARSE_CERTIFICATE], $e->getErrors());
        }
    }
}
