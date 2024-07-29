<?php

namespace Acme;

use Psr\Clock\ClockInterface;
use Twint\Sdk\Certificate\Pkcs12Certificate;
use Twint\Sdk\Client;
use Twint\Sdk\Exception\InvalidCertificate;
use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Io\NonEmptyStream;
use Twint\Sdk\Value\ExistingPath;
use Twint\Sdk\Value\StoreUuid;

// Establish trust
try {
    $certificate = Pkcs12Certificate::establishTrust(
        new NonEmptyStream(
            new FileStream(new ExistingPath($certificatePath))
        ),
        $certificatePassphrase,
        /** @var ClockInterface $clock */
        $clock
    );

    // Handle errors
} catch (InvalidCertificate $e) {
    foreach ($e->getErrors() as $error) {
        match ($error) {
            InvalidCertificate::ERROR_INVALID_CERTIFICATE_FORMAT
                => handle(),
            InvalidCertificate::ERROR_CANNOT_PARSE_CERTIFICATE
                => handle(),
            InvalidCertificate::ERROR_INVALID_PASSPHRASE
                => handle(),
            InvalidCertificate::ERROR_INVALID_ISSUER_COUNTRY
                => handle(),
            InvalidCertificate::ERROR_INVALID_ISSUER_ORGANIZATION
                => handle(),
            InvalidCertificate::ERROR_INVALID_EXPIRY_DATE
                => handle(),
            InvalidCertificate::ERROR_CERTIFICATE_EXPIRED
                => handle(),
            InvalidCertificate::ERROR_CERTIFICATE_NOT_YET_VALID
                => handle(),
        };
    }
}

// Check API connectivity
$client = new Client(
    $certificateContainer,
    StoreUuid::fromString($storeUuid),
    $version,
    $environment
);

if ($client->checkSystemStatus()->isOk()) {
    // We are good to go
}
