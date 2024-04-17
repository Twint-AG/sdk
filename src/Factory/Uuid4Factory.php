<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use Throwable;
use Twint\Sdk\Exception\CryptographyFailure;
use Twint\Sdk\Util\Resilience;
use Twint\Sdk\Value\Uuid;
use function Psl\invariant;

/**
 * @phpstan-import-type Attempts from Resilience
 */
final class Uuid4Factory
{
    /**
     * @param callable(int<1,max>): string $randomBytes
     */
    public function __construct(
        private readonly mixed $randomBytes = 'random_bytes'
    ) {
    }

    /**
     * @throws CryptographyFailure
     */
    public function __invoke(): Uuid
    {
        $bytes = $this->getRandomBytes(32, 5);

        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return new Uuid(vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4)));
    }

    /**
     * @param int<1, max> $length
     * @param Attempts $attempts
     * @throws CryptographyFailure
     */
    private function getRandomBytes(int $length, int $attempts): string
    {
        try {
            return Resilience::retry(
                $attempts,
                function () use ($length): string {
                    $random = ($this->randomBytes)($length);

                    invariant(
                        strlen($random) === $length,
                        'Random data has to be exactly %d bytes long, got %d',
                        $length,
                        strlen($random)
                    );

                    return $random;
                }
            );
        } catch (Throwable $e) {
            throw CryptographyFailure::fromThrowable($e);
        }
    }
}
