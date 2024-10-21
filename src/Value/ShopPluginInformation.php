<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use danielburger1337\SHA3Shake\SHA3Shake;
use Override;
use Twint\Sdk\Util\Comparison;
use function Psl\Type\instance_of;

/**
 * @template-implements Value<self>
 */
final class ShopPluginInformation implements CashRegisterId, Value
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public function __construct(
        private readonly StoreUuid $storeUuid,
        private readonly ShopPlatform $platform,
        private readonly PlatformVersion $platformVersion,
        private readonly PluginVersion $pluginVersion,
        private readonly InstallSource $installSource
    ) {
    }

    #[Override]
    public function __toString(): string
    {
        // Must be below 50 bytes
        return $this->platform .                                            // 2 bytes
            '|' .                                                           // 1 byte
            substr((string) $this->platformVersion, 0, 15) .                // max 15 bytes
            '|' .                                                           // 1 byte
            substr((string) $this->pluginVersion, 0, 15) .                  // max 15 bytes
            '|' .                                                           // 1 byte
            $this->installSource .                                          // max 1 byte
            '|' .                                                           // 1 byte
            $this->uniqueId()                                               // 8 bytes
        ;                                                                   // = max 45 bytes
    }

    private function uniqueId(): string
    {
        // Variable output length hash
        return SHA3Shake::shake128(
            implode('|', [$this->platform, $this->platformVersion, $this->pluginVersion, $this->installSource]),
            8
        );
    }

    #[Override]
    public function storeUuid(): StoreUuid
    {
        return $this->storeUuid;
    }

    #[Override]
    public function cashRegisterId(): CashRegisterId
    {
        return $this;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return Comparison::comparePairs(
            [
                [$this->storeUuid, $other->storeUuid],
                [$this->platform, $other->platform],
                [$this->platformVersion, $other->platformVersion],
                [$this->pluginVersion, $other->pluginVersion],
                [$this->installSource, $other->installSource],
            ]
        );
    }

    /**
     * @return array{
     *     storeUuid: StoreUuid,
     *     platform: ShopPlatform,
     *     platformVersion: PlatformVersion,
     *     pluginVersion: PluginVersion,
     *     installSource: InstallSource
     * }
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'storeUuid' => $this->storeUuid,
            'platform' => $this->platform,
            'platformVersion' => $this->platformVersion,
            'pluginVersion' => $this->pluginVersion,
            'installSource' => $this->installSource,
        ];
    }
}
