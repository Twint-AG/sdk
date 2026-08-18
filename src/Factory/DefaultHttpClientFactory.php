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
        $curlOptions = [];

        if ($certificate !== null) {
            if (self::curlCompiledAgainstNss()) {
                $certificate = $certificate->pkcs1();

                // NSS negotiates TLS 1.3 and then sends an empty client Certificate message, so
                // the server sees no client certificate and rejects the request. NSS reports no
                // error of its own -- curl logs "NSS: client certificate from file" and the
                // handshake completes -- so this only ever shows up as a rejection from the far
                // end. Capping at TLS 1.2 makes NSS present the certificate again.
                //
                // Scoped to this branch on purpose: no other TLS backend needs it, and requests
                // made without a client certificate keep negotiating TLS 1.3 even on NSS.
                $curlOptions[CURLOPT_SSLVERSION] = CURL_SSLVERSION_TLSv1_2 | CURL_SSLVERSION_MAX_TLSv1_2;
            } else {
                $certificate = $certificate->pkcs8();
            }

            $cert = [(string) $certificate->toFile($writer)->path(), $certificate->passphrase()];
        }

        return new Client([
            'cert' => $cert,
            'curl' => $curlOptions,
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
