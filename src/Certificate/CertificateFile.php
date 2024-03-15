<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use SensitiveParameter;
use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

final class CertificateFile
{
    private ?string $content = null;

    /**
     * @throws AssertionFailed
     */
    public function __construct(
        #[SensitiveParameter]
        private readonly string $path,
        #[SensitiveParameter]
        private readonly string $passphrase
    ) {
        Assertion::file($path);
        Assertion::readable($path);
    }

    public function path(): string
    {
        return $this->path;
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
        $content = file_get_contents($this->path);
        Assertion::string($content, sprintf('Reading file "%s" failed', $this->path));

        return $content;
    }
}
