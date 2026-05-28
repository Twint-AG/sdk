<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use Composer\CaBundle\CaBundle;
use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;
use Twint\Sdk\Certificate\CertificateContainer;
use Twint\Sdk\Io\FileWriter;
use Twint\Sdk\SdkVersion;
use function Psl\Type\string;

final class DefaultHttpClientFactory
{
    private static bool $curlCompiledAgainstNss;

    public function __invoke(FileWriter $writer, ?CertificateContainer $certificate = null): ClientInterface
    {
        $cert = null;
        if ($certificate !== null) {
            $certificate = self::curlCompiledAgainstNss() ? $certificate->pkcs1() : $certificate->pkcs8();
            $cert = [(string) $certificate->toFile($writer)->path(), $certificate->passphrase()];
        }

        return new Client([
            'cert' => $cert,
            'headers' => [
                'user-agent' => SdkVersion::NAME . '/' . SdkVersion::VERSION,
            ],
            'verify' => CaBundle::getSystemCaRootBundlePath(),
        ]);
    }

    private static function curlCompiledAgainstNss(): bool
    {
        return self::$curlCompiledAgainstNss ??= str_starts_with(
            string()
                ->assert(curl_version()['ssl_version'] ?? ''),
            'NSS'
        );
    }
}
