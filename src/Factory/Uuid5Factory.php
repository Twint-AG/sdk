<?php


declare(strict_types=1);

namespace Twint\Sdk\Factory;

use Twint\Sdk\Value\Uuid;

final class Uuid5Factory
{
    public const NAMESPACE_DNS = '6ba7b810-9dad-11d1-80b4-00c04fd430c8';

    public const NAMESPACE_URL = '6ba7b811-9dad-11d1-80b4-00c04fd430c8';

    public const NAMESPACE_OID = '6ba7b812-9dad-11d1-80b4-00c04fd430c8';

    public const NAMESPACE_X500 = '6ba7b814-9dad-11d1-80b4-00c04fd430c8';

    /**
     * @param non-empty-string $name
     */
    public function __construct(
        private readonly Uuid $namespace,
        private readonly string $name
    ) {
    }

    public function __invoke(): Uuid
    {
        $bin = hex2bin(str_replace('-', '', (string) $this->namespace));
        $hash = sha1($bin . $this->name);

        return new Uuid(sprintf(
            '%08s-%04s-%04x-%04x-%12s',
            substr($hash, 0, 8),
            substr($hash, 8, 4),
            (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,
            (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
            substr($hash, 20, 12)
        ));
    }
}
