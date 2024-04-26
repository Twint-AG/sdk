<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use DateTimeImmutable;
use OpenSSLCertificate;
use Override;
use Psl\Type\Exception\AssertException;
use Psr\Clock\ClockInterface;
use Twint\Sdk\Exception\InvalidCertificate;
use function Psl\Type\non_empty_string;
use function Psl\Type\shape;
use function Psl\Type\uint;

final class DefaultTrustor implements Trustor
{
    private const ISSUER_ORG = 'TWINT AG';

    private const ISSUER_COUNTRY = 'CH';

    /**
     * @param callable(OpenSSLCertificate|string): (array<string,mixed>|false) $opensslX509Parse
     */
    public function __construct(
        private readonly ClockInterface $clock,
        private readonly mixed $opensslX509Parse = 'openssl_x509_parse'
    ) {
    }

    /**
     * @throws InvalidCertificate
     */
    #[Override]
    public function check(OpenSSLCertificate|string $certificate): void
    {
        $errors = [...$this->validate($certificate)];

        if (count($errors) > 0) {
            // @phpstan-ignore-next-line
            throw InvalidCertificate::notTrusted($errors);
        }
    }

    /**
     * @throws InvalidCertificate
     * @return iterable<InvalidCertificate::*>
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
                ->assert(($this->opensslX509Parse)($certificate));
        } catch (AssertException $e) {
            throw InvalidCertificate::notTrusted([InvalidCertificate::ERROR_CANNOT_PARSE_CERTIFICATE], $e);
        }

        if ($metadata['issuer']['C'] !== self::ISSUER_COUNTRY) {
            yield InvalidCertificate::ERROR_INVALID_ISSUER_COUNTRY;
        }

        if ($metadata['issuer']['O'] !== self::ISSUER_ORG) {
            yield InvalidCertificate::ERROR_INVALID_ISSUER_ORGANIZATION;
        }

        // @phpstan-ignore-next-line
        $from = new DateTimeImmutable('@' . $metadata['validFrom_time_t']);
        // @phpstan-ignore-next-line
        $to = new DateTimeImmutable('@' . $metadata['validTo_time_t']);

        $now = $this->clock->now();

        if ($now > $to) {
            yield InvalidCertificate::ERROR_CERTIFICATE_EXPIRED;
        }

        if ($now < $from) {
            yield InvalidCertificate::ERROR_CERTIFICATE_NOT_YET_VALID;
        }
    }
}
