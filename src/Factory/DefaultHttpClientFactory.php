<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use Composer\CaBundle\CaBundle;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
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
        $config = [
            'headers' => [
                'user-agent' => SdkVersion::NAME . '/' . SdkVersion::VERSION,
            ],
            'verify' => CaBundle::getSystemCaRootBundlePath(),
        ];

        return new Client($certificate === null ? $config : [
            ...$config,
            ...self::clientCertificateOptions($writer, $certificate),
        ]);
    }

    /**
     * @return array{
     *     cert: array{string, string},
     *     crypto_method?: int,
     *     crypto_method_max?: int,
     *     curl?: array<int, int>
     * }
     */
    private static function clientCertificateOptions(FileWriter $writer, CertificateContainer $certificate): array
    {
        $tlsOptions = [];

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
            $tlsOptions = self::capTlsAtV12();
        } else {
            $certificate = $certificate->pkcs8();
        }

        return [
            'cert' => [(string) $certificate->toFile($writer)->path(), $certificate->passphrase()],
            ...$tlsOptions,
        ];
    }

    /**
     * @return array{crypto_method?: int, crypto_method_max?: int, curl?: array<int, int>}
     */
    private static function capTlsAtV12(): array
    {
        // Guzzle derives CURLOPT_SSLVERSION from the TLS version range request options: 7.11
        // deprecates passing the curl option directly, 8.0 rejects it outright. Both spellings
        // resolve to the same CURLOPT_SSLVERSION value, so the curl option is only for Guzzle
        // below 7.11, where crypto_method_max does not exist yet. Keyed off the constant rather
        // than ClientInterface::MAJOR_VERSION because that is the version boundary that matters,
        // and because a constant comparison leaves one branch looking like dead code to static
        // analysis.
        if (defined(RequestOptions::class . '::CRYPTO_METHOD_MAX')) {
            return [
                'crypto_method' => STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT,
                'crypto_method_max' => STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT,
            ];
        }

        return [
            'curl' => [
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2 | CURL_SSLVERSION_MAX_TLSv1_2,
            ],
        ];
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
