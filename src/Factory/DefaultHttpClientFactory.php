<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;
use Twint\Sdk\Certificate\CertificateContainer;
use Twint\Sdk\File\FileWriter;
use Twint\Sdk\Version;

final class DefaultHttpClientFactory
{
    public function __invoke(FileWriter $writer, CertificateContainer $certificate): ClientInterface
    {
        return new Client([
            'cert' => [$certificate->pem()->toFile($writer)->path(), $certificate->pem()->passphrase()],
            'headers' => [
                'user-agent' => Version::NAME . '/' . Version::VERSION,
            ],
        ]);
    }
}
