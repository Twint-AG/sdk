<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use Composer\CaBundle\CaBundle;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\Clock\Clock;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Twint\Sdk\Capability\SystemAdministration;
use Twint\Sdk\Certificate\Pkcs12Certificate;
use Twint\Sdk\Certificate\Pkcs8Certificate;
use Twint\Sdk\Factory\DefaultHttpClientFactory;
use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Io\InMemoryStream;
use Twint\Sdk\Io\NonEmptyStream;
use Twint\Sdk\Tools\Hermeticism\Empirical;
use Twint\Sdk\Tools\SystemEnvironment;
use Twint\Sdk\Value\ExistingPath;

/**
 * @template-extends IntegrationTest<SystemAdministration>
 * @internal
 */
#[CoversClass(DefaultHttpClientFactory::class)]
#[Group(Empirical::GROUP)]
final class FallbackToBundledCaTest extends IntegrationTest
{
    private const ENV_VAR_DESTRUCTIVE_TESTS_ENABLED = 'TWINT_SDK_TESTS_DESTRUCTIVE';

    /**
     * @var array<string, string>
     */
    private static array $files;

    #[Override]
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        if (!self::destructiveTestsEnabled()) {
            return;
        }

        $fs = new Filesystem();
        self::$files = self::makeSystemCaBundlesUnavailable($fs);
    }

    #[Override]
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        if (!self::destructiveTestsEnabled()) {
            return;
        }

        $fs = new Filesystem();
        self::restoreSystemBundles($fs, self::$files);
    }

    private static function destructiveTestsEnabled(): bool
    {
        return filter_var(getenv(self::ENV_VAR_DESTRUCTIVE_TESTS_ENABLED), FILTER_VALIDATE_BOOLEAN);
    }

    private static function skipIfDestructiveTestsDisabled(): void
    {
        if (self::destructiveTestsEnabled()) {
            return;
        }

        self::markTestSkipped(
            sprintf(
                'Dangerous tests are disabled. Enable them by setting the %s environment variable to true.',
                self::ENV_VAR_DESTRUCTIVE_TESTS_ENABLED
            )
        );
    }

    public function testFallbackToBundledCaWhenSystemCaIsNotAvailable(): void
    {
        self::skipIfDestructiveTestsDisabled();

        self::retry(function () {
            $systemStatus = $this->createClient()
                ->checkSystemStatus();

            self::assertTrue($systemStatus->isOk());
        });
    }

    public function testPkcs8CertificateConversionWorksWhenSystemCaIsNotAvailable(): void
    {
        self::skipIfDestructiveTestsDisabled();

        self::retry(static function () {
            $pkcs12 = Pkcs12Certificate::establishTrust(
                new NonEmptyStream(
                    new FileStream(new ExistingPath(SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PATH')))
                ),
                SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PASSPHRASE'),
                new Clock()
            );

            self::assertNotEmpty($pkcs12->pkcs8()->content());
        });
    }

    public function testPkcs12CertificateConversionWorksWhenSystemCaIsNotAvailable(): void
    {
        self::skipIfDestructiveTestsDisabled();

        self::retry(static function () {
            $pkcs12 = Pkcs12Certificate::establishTrust(
                new NonEmptyStream(
                    new FileStream(new ExistingPath(SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PATH')))
                ),
                SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PASSPHRASE'),
                new Clock()
            );

            $pem = new Pkcs8Certificate(
                new InMemoryStream($pkcs12->pkcs8()->content()),
                SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PASSPHRASE')
            );

            self::assertNotEmpty($pem->pkcs12()->content());
        });
    }

    /**
     * @return array<string, string>
     */
    private static function makeSystemCaBundlesUnavailable(Filesystem $fs): array
    {
        $bundledCaBundle = CaBundle::getBundledCaBundlePath();

        if ($bundledCaBundle === self::getCurrentSystemCaBundle()) {
            self::markTestSkipped('System CA bundle is not available');
        }

        $tempDir = $fs->tempnam(sys_get_temp_dir(), 'twint-sdk-ca-bundle-backup-');
        $fs->remove($tempDir);
        $fs->mkdir($tempDir);

        $files = [];

        while (($systemCaBundle = self::getCurrentSystemCaBundle()) !== $bundledCaBundle) {
            $target = $tempDir . DIRECTORY_SEPARATOR . hash('sha512', $systemCaBundle);

            try {
                $fs->rename($systemCaBundle, $target);
            } catch (IOException $e) {
                self::markTestSkipped(
                    sprintf('Cannot rename system CA bundle "%s": %s', $systemCaBundle, $e->getMessage())
                );
            }

            $files[$systemCaBundle] = $target;
        }

        return $files;
    }

    private static function getCurrentSystemCaBundle(): string
    {
        CaBundle::reset();

        return CaBundle::getSystemCaRootBundlePath();
    }

    /**
     * @param array<string, string> $files
     */
    private static function restoreSystemBundles(Filesystem $fs, array $files): void
    {
        foreach (array_reverse($files) as $orig => $backup) {
            try {
                $fs->rename($backup, $orig);
            } catch (IOException $e) {
                self::markTestSkipped(sprintf('Cannot restore system CA bundle "%s": %s', $orig, $e->getMessage()));
            }
        }
    }
}
