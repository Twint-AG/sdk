<?php

declare(strict_types=1);

namespace Twint\Sdk\Exception;

use RuntimeException;
use Throwable;
use function Psl\invariant;

final class InvalidCertificate extends RuntimeException implements SdkError
{
    public const ERROR_INVALID_ISSUER_COUNTRY = 'Invalid issuer country code';

    public const ERROR_INVALID_ISSUER_ORGANIZATION = 'Invalid issuer organization';

    public const ERROR_CANNOT_PARSE_CERTIFICATE = 'Cannot parse certificate';

    public const ERROR_INVALID_EXPIRY_DATE = 'Invalid expiry date';

    public const ERROR_INVALID_CERTIFICATE_FORMAT = 'Invalid certificate';

    public const ERROR_INVALID_PASSPHRASE = 'Invalid passphrase';

    public const ERROR_CERTIFICATE_EXPIRED = 'Certificate expired';

    public const ERROR_CERTIFICATE_NOT_YET_VALID = 'Certificate not yet valid';

    /**
     * @param non-empty-list<self::*> $errors
     */
    public function __construct(
        string $message,
        private readonly array $errors,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
    }

    /**
     * @param non-empty-list<self::*> $errors
     */
    public static function notTrusted(array $errors, ?Throwable $previous = null): self
    {
        return new self('Cannot trust certificate', $errors, $previous);
    }

    public static function fromOpensslErrors(): self
    {
        return new self('Cannot trust certificate', self::accumulateErrors());
    }

    /**
     * @return non-empty-list<self::*>
     */
    private static function accumulateErrors(): array
    {
        $errors = [];

        while (($error = openssl_error_string()) !== false) {
            $errors[] = match ($error) {
                'error:11800071:PKCS12 routines::mac verify failure' => self::ERROR_INVALID_PASSPHRASE,
                default => self::ERROR_INVALID_CERTIFICATE_FORMAT
            };
        }

        invariant(count($errors) > 0, 'Expected at least one error');

        return array_unique($errors);
    }

    /**
     * @return non-empty-list<self::*>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
