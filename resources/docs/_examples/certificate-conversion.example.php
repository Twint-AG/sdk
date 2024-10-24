<?php

namespace Acme;

use Psr\Clock\ClockInterface;
use Twint\Sdk\Certificate\Pkcs12Certificate;
use Twint\Sdk\Io\ContentSensitiveFileWriter;
use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Io\NonEmptyStream;
use Twint\Sdk\Io\StaticFileWriter;
use Twint\Sdk\Io\TemporaryFileWriter;
use Twint\Sdk\Value\ExistingPath;
use function Psl\Type\string;

$pkcs12 = Pkcs12Certificate::establishTrust(
    new NonEmptyStream(
        new FileStream(new ExistingPath($certificatePath))
    ),
    $certificatePassphrase,
    /** @var ClockInterface $clock */
    $clock
);

$pem = $pkcs12->pem();

// Access PEM encoded content
$pem->content();

// Write to static file
$staticStream = $pem->toFile(
    new StaticFileWriter('build/certificate')
);

// Return ./build/certificate.pem
$staticStream->path();

// Write to temporary file
$temporaryStream = $pem->toFile(new TemporaryFileWriter());

// Return path to temporary file
$temporaryStream->path();

// Write to a static file with the certificate fingerprint as the
// filename This also ensures that the file is only written once
$contentSensitiveStream = $pem->toFile(
    new ContentSensitiveFileWriter(
        new ExistingPath('./build'),
        static fn (string $content) => string()
            ->assert(openssl_x509_fingerprint($content))
    )
);

// Return ./build/<fingerprint>.pem
$contentSensitiveStream->path();
