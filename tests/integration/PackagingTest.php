<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use Override;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @internal
 */
#[CoversNothing]
final class PackagingTest extends TestCase
{
    public const ARCHIVE_PATH = '/tmp/test-archive';

    #[Override]
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::removeArchive();
        exec(
            sprintf(
                'git archive --format=tar --prefix=%s/ HEAD | (cd %s && tar xf -)',
                basename(self::ARCHIVE_PATH),
                dirname(self::ARCHIVE_PATH)
            ),
            $output,
            $returnCode
        );
        self::assertSame(0, $returnCode, implode('', $output));
    }

    #[Override]
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        self::removeArchive();
    }

    /**
     * @return list<array{0: non-empty-string}>
     */
    public static function getPresentFiles(): iterable
    {
        return [
            ['composer.json'],
            ['src/'],
            ['src/Client.php'],
            ['src/SdkVersion.php'],
            ['src/polyfill.php'],
            ['vendor-bundled/phpro/soap-client-minimal/src/Phpro/SoapClient/Caller/Caller.php'],
            ['resources/config/openssl.cnf'],
            ['resources/wsdl/v8.6/TWINTMerchantService_v8.6.wsdl'],
        ];
    }

    /**
     * @return list<array{0: non-empty-string}>
     */
    public static function getAbsentFiles(): iterable
    {
        return [
            ['tests/'],
            ['vendor/'],
            ['tools/'],
            ['build/'],
            ['resources/config/soap.php'],
            ['resources/docs'],
            ['docker-compose.yml'],
            ['Dockerfile'],
            ['phpunit.xml.dist'],
            ['env.dist'],
            ['gitlab-ci.yml'],
            ['composer.lock'],
            ['php-extensions.txt'],
            ['.gitattributes'],
        ];
    }

    private static function removeArchive(): void
    {
        $fs = new Filesystem();
        $fs->remove(self::ARCHIVE_PATH);
    }

    #[DataProvider('getPresentFiles')]
    public function testPresentFiles(string $file): void
    {
        self::assertFileExists(self::ARCHIVE_PATH . '/' . $file);
    }

    #[DataProvider('getAbsentFiles')]
    public function testAbsentFiles(string $file): void
    {
        self::assertFileDoesNotExist(self::ARCHIVE_PATH . '/' . $file);
    }
}
