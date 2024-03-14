<?php

declare(strict_types=1);

namespace Twint\Sdk;

use SensitiveParameter;
use Twint\Sdk\Exception\AssertionFailed;

final class Certificate
{
    private string $certificate;

    private string $key;

    private string $pemPassphrase;

    private ?string $certificateAsPem; // @phpstan-ignore-line

    private ?string $keyAsPem;  // @phpstan-ignore-line

    private bool $read = false;

    private bool $converted = false;

    private string $pemCombinedPath;

    private bool $pemWritten = false;

    /**
     * @param string $path
     * @param string $passphrase
     */
    public function __construct(
        #[SensitiveParameter]
        private string $path,
        #[SensitiveParameter]
        private string $passphrase
    ) {
        // @todo file exists
    }

    /**
     * @throws AssertionFailed
     */
    public function getCombinedPem(): string
    {
        $this->convert();
        return $this->certificate . $this->key;
    }

    /**
     * @throws AssertionFailed
     */
    public function getCombinedPemPath(): string
    {
        $this->writeCombinedPem();

        return $this->pemCombinedPath;
    }

    /**
     * @throws AssertionFailed
     */
    public function getPemPassphrase(): string
    {
        $this->convert();
        return $this->pemPassphrase;
    }

    /**
     * @throws AssertionFailed
     */
    private function read(): void
    {
        if ($this->read) {
            return;
        }

        $p12 = file_get_contents($this->path);

        Assertion::string($p12, 'Could not read certificate file');

        openssl_pkcs12_read($p12, $certs, $this->passphrase);
        $this->certificate = $certs['cert'];
        $this->key = $certs['pkey'];

        $this->read = true;
    }

    /**
     * @throws AssertionFailed
     */
    private function convert(): void
    {
        $this->read();

        if ($this->converted) {
            return;
        }

        $this->pemPassphrase = 'secret123'; // @todo generate random passphrase
        assert(openssl_pkey_export($this->key, $this->keyAsPem, $this->pemPassphrase));
        assert(openssl_x509_export($this->certificate, $this->certificateAsPem));

        $this->converted = true;
    }

    /**
     * @throws AssertionFailed
     */
    private function writeCombinedPem(): void
    {
        $this->convert();

        if ($this->pemWritten) {
            return;
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'twint-sdk');
        Assertion::string($tempPath, 'Could not create temporary file');

        $this->pemCombinedPath = $tempPath;
        touch($this->pemCombinedPath);
        chmod($this->pemCombinedPath, 0600);
        file_put_contents($this->pemCombinedPath, $this->certificateAsPem . $this->keyAsPem);
        chmod($this->pemCombinedPath, 0400);

        $this->pemWritten = true;
    }
}
