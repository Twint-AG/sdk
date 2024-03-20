<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;
use Twint\Sdk\Certificate\Certificate;
use Twint\Sdk\Version;

final class DefaultHttpClientFactory
{
    public function __invoke(Certificate $certificate): ClientInterface
    {
        return new Client([
            'cert' => [$certificate->pem()->file(), $certificate->pem()->passphrase()],
            'headers' => [
                'user-agent' => Version::NAME . '/' . Version::VERSION,
            ],
        ]);
    }
}
