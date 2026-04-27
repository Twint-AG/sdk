<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use Closure;
use Throwable;
use Twint\Sdk\Exception\CryptographyFailure;
use Twint\Sdk\Util\Resilience;
use Twint\Sdk\Value\Uuid;
use function Psl\invariant;

/**
 * @phpstan-import-type Attempts from Resilience
 * @phpstan-type RandomByteLength int<1, max>
 */
final class Uuid4Factory
{
    /**
     * @param callable(RandomByteLength): string $randomBytes
     */
    public function __construct(
        private readonly mixed $randomBytes = 'random_bytes'
    ) {
    }

    /**
     * @throws CryptographyFailure
     * @phpstan-impure
     */
    public function __invoke(): Uuid
    {
        $bytes = self::getRandomBytes(32, 5, ($this->randomBytes)(...));

        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        return new Uuid(vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4)));
    }

    /**
     * @param RandomByteLength $length
     * @param Attempts $attempts
     * @param Closure(RandomByteLength): string $randomBytes
     * @throws CryptographyFailure
     * @phpstan-impure
     */
    private static function getRandomBytes(int $length, int $attempts, Closure $randomBytes): string
    {
        try {
            return Resilience::retry(
                $attempts,
                static function () use ($randomBytes, $length): string {
                    $random = $randomBytes($length);

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
