<?php

declare(strict_types=1);

namespace Twint\Sdk\Util;

use Transliterator;
use function Psl\invariant;
use function Psl\Type\instance_of;

final class ShippingLabelWorkaround
{
    private const RULES = [
        # Transliterate to Latin characters
        ':: Any-Latin',
        # Transliterate to ASCII characters
        ':: Latin-ASCII',
        # Replace symbols (e.g. emojis) with \N(SymbolName}
        ':: [:Symbol:] name',
        # Replace \N{ with just {
        "'\N{' > '{'",
        # Convert to normal form composed
        ':: NFC',
        # Final cleanup
        ":: [^\p{block=Basic_Latin}\p{P}\p{Sm}\p{Sc}] Remove",
    ];

    /**
     * @readonly
     */
    private static Transliterator $transliterator;

    public function __invoke(string $in): string
    {
        $out = self::transliterator()->transliterate($in);
        invariant($out !== false, 'Failed to transliterate "%s"', $in);

        return $out;
    }

    private static function transliterator(): Transliterator
    {
        return self::$transliterator ??= instance_of(Transliterator::class)
            ->assert(Transliterator::createFromRules(implode(';', self::RULES) . ';'));
    }
}
