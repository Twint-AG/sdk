<?php

namespace Acme;

use Symfony\Component\Clock\Clock;
use Symfony\Component\Dotenv\Dotenv;
use Twint\Sdk\Certificate\CertificateContainer;
use Twint\Sdk\Certificate\Pkcs12Certificate;
use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Io\NonEmptyStream;
use Twint\Sdk\Tools\SystemEnvironment;
use Twint\Sdk\Value\Environment;
use Twint\Sdk\Value\ExistingPath;
use Twint\Sdk\Value\Version;

require_once __DIR__ . '/../../../vendor/autoload.php';

$env = new Dotenv();
$env->load(__DIR__ . '/../../../.env');

$orderReference = bin2hex(random_bytes(16));
$merchantId = SystemEnvironment::get('TWINT_SDK_TEST_MERCHANT_ID');
$certificatePath = SystemEnvironment::get(
    'TWINT_SDK_TEST_CERT_P12_PATH'
);
$certificatePassphrase = SystemEnvironment::get(
    'TWINT_SDK_TEST_CERT_P12_PASSPHRASE'
);
$clock = new Clock();
$certificateContainer = CertificateContainer::fromPkcs12(
    new Pkcs12Certificate(
        new NonEmptyStream(
            new FileStream(new ExistingPath($certificatePath)),
        ),
        $certificatePassphrase
    )
);

$version = Version::next();
$environment = Environment::TESTING();

function handle(): void
{
}
