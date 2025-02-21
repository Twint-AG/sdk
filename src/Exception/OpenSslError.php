<?php

declare(strict_types=1);

namespace Twint\Sdk\Exception;

use RuntimeException;
use Throwable;

final class OpenSslError extends RuntimeException implements SdkError
{
    public function __construct(
        string $message,
        string $code,
        ?Throwable $previous = null,
        private readonly ?string $library = null,
        private readonly ?string $function = null
    ) {
        parent::__construct($message, 0, $previous);
        $this->code = $code;
    }

    /**
     * @param list<string> $errors
     */
    public static function fromErrors(array $errors): ?self
    {
        $exception = null;
        foreach (array_reverse($errors) as $error) {
            $exception = self::parse($error, $exception);
        }

        return $exception;
    }

    /**
     * @return list<string>
     */
    public static function flushOpenSslErrors(): array
    {
        $errors = [];

        while (($error = openssl_error_string()) !== false) {
            $errors[] = $error;
        }

        return $errors;
    }

    public static function fromOpenSslErrors(): ?self
    {
        return self::fromErrors(self::flushOpenSslErrors());
    }

    private static function parse(string $error, ?Throwable $previous): self
    {
        $parts = explode(':', $error, 5);

        if (count($parts) !== 5) {
            return new self($error, '0', $previous);
        }

        // See ERR_lib_error_string() in OpenSSL
        [, $code, $library, $function, $message] = $parts;

        return new self(sprintf('%s: %s (%s)', $library, $message, $code), $code, $previous, $library, $function);
    }

    public function getLibrary(): ?string
    {
        return $this->library;
    }

    public function getFunction(): ?string
    {
        return $this->function;
    }
}
