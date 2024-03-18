<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use SensitiveParameter;
use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;
use Twint\Sdk\Value\File;

final class CertificateFile
{
    private ?string $content = null;

    /**
     * @throws AssertionFailed
     */
    public function __construct(
        #[SensitiveParameter]
        private readonly File $file,
        #[SensitiveParameter]
        private readonly string $passphrase
    ) {
        Assertion::file((string) $file);
    }

    public function file(): File
    {
        return $this->file;
    }

    public function passphrase(): string
    {
        return $this->passphrase;
    }

    /**
     * @throws AssertionFailed
     */
    public function content(): string
    {
        return $this->content ??= $this->readFile();
    }

    /**
     * @throws AssertionFailed
     */
    public function readFile(): string
    {
        $content = file_get_contents((string) $this->file);
        Assertion::string($content, sprintf('Reading file "%s" failed', $this->file));

        return $content;
    }
}
