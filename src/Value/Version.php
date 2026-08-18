<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

enum Version: int
{
    public const LATEST = self::V10;

    public const NEXT = self::V10;

    case V8_5_0 = 8_05_00;

    case V8_6_0 = 8_06_00;

    case V8_7_0 = 8_07_00;

    case V9 = 9_00_00;

    case V10 = 10_00_00;

    public function major(): int
    {
        return (int) ($this->value / 10_000);
    }

    public function minor(): int
    {
        return ((int) ($this->value / 1_00)) % 1_00;
    }

    public function patch(): int
    {
        return $this->value % 1_00;
    }

    public function dotVersion(): string
    {
        return $this->formatVersion('.');
    }

    public function underscoreVersion(): string
    {
        return $this->formatVersion('_');
    }

    public function soapNamespaceForBaseTypes(): Url
    {
        return $this->soapNamespace('base');
    }

    public function soapNamespaceForCommonTypes(): Url
    {
        return $this->soapNamespace('common');
    }

    public function soapNamespaceForHeaderTypes(): Url
    {
        return $this->soapNamespace('header');
    }

    public function soapNamespaceForFaultTypes(): Url
    {
        return $this->soapNamespace('fault');
    }

    public function soapNamespaceForMerchantTypes(): Url
    {
        return $this->soapNamespace('merchant');
    }

    private function formatVersion(string $separator): string
    {
        return array_reduce(
            [$this->minor(), $this->patch()],
            static fn (string $carry, int $part) => $part > 0 ? sprintf('%s%s%d', $carry, $separator, $part) : $carry,
            (string) $this->major()
        );
    }

    /**
     * @param "base"|"common"|"header"|"fault"|"merchant" $type
     */
    private function soapNamespace(string $type): Url
    {
        return new Url('http://service.twint.ch/' . $type . '/types/v' . $this->underscoreVersion());
    }
}
