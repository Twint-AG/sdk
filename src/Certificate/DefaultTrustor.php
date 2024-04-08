<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use DateTimeImmutable;
use OpenSSLCertificate;
use Psl\Type\Exception\AssertException;
use Psr\Clock\ClockInterface;
use Throwable;
use Twint\Sdk\Exception\InvalidCertificate;
use function Psl\Type\non_empty_string;
use function Psl\Type\shape;
use function Psl\Type\uint;

final class DefaultTrustor implements Trustor
{
    public function __construct(
        private readonly ClockInterface $clock
    ) {
    }

    /**
     * @throws InvalidCertificate
     */
    public function check(OpenSSLCertificate|string $certificate): void
    {
        $errors = [...$this->validate($certificate)];

        if (count($errors) > 0) {
            // @phpstan-ignore-next-line
            throw InvalidCertificate::notTrusted($errors);
        }
    }

    /**
     * @return iterable<InvalidCertificate::*>
     * @throws InvalidCertificate
     */
    private function validate(OpenSSLCertificate|string $certificate): iterable
    {
        try {
            $metadata = shape([
                'issuer' => shape([
                    'C' => non_empty_string(),
                    'O' => non_empty_string(),
                ], true),
                'validFrom_time_t' => uint(),
                'validTo_time_t' => uint(),
            ], true)
                ->assert(openssl_x509_parse($certificate));
        } catch (AssertException $e) {
            throw InvalidCertificate::notTrusted([InvalidCertificate::ERROR_CANNOT_PARSE_CERTIFICATE], $e);
        }

        if ($metadata['issuer']['C'] !== 'CH') {
            yield InvalidCertificate::ERROR_INVALID_ISSUER_COUNTRY;
        }

        if ($metadata['issuer']['O'] !== 'TWINT AG') {
            yield InvalidCertificate::ERROR_INVALID_ISSUER_ORGANIZATION;
        }

        try {
            $from = new DateTimeImmutable('@' . $metadata['validFrom_time_t']);
            $to = new DateTimeImmutable('@' . $metadata['validTo_time_t']);
        } catch (Throwable $e) {
            throw InvalidCertificate::notTrusted([InvalidCertificate::ERROR_INVALID_EXPIRY_DATE], $e);
        }

        $now = $this->clock->now();

        if ($now > $to) {
            yield InvalidCertificate::ERROR_CERTIFICATE_EXPIRED;
        }

        if ($now < $from) {
            yield InvalidCertificate::ERROR_CERTIFICATE_NOT_YET_VALID;
        }
    }
}
