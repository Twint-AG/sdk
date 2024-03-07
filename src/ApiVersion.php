<?php

declare(strict_types=1);

namespace Twint\Sdk;

final class ApiVersion
{
    public const V_LATEST = self::V8_5_0;

    public const V8_5_0 = 8_05_00;

    public const V8_6_0 = 8_06_00;

    public const V_DEV = self::V8_6_0;

    public const ENV_PAT = 'pat';

    /**
     * @param self::V* $versionId
     */
    public static function major(int $versionId = self::V_LATEST): int
    {
        return (int) ($versionId / 10_000);
    }

    /**
     * @param self::V* $versionId
     */
    public static function minor(int $versionId = self::V_LATEST): int
    {
        return (int) ($versionId / 1_00) % 1_00;
    }

    /**
     * @param self::V* $versionId
     */
    public static function patch(int $versionId = self::V_LATEST): int
    {
        return $versionId % 1_00;
    }

    /**
     * @param self::V* $versionId
     */
    public static function version(int $versionId = self::V_LATEST): string
    {
        return self::versionString($versionId, '.');
    }

    /**
     * @param self::ENV_* $env
     * @param self::V_* $versionId
     */
    public static function endpoint($env, int $versionId = self::V_LATEST): string
    {
        return sprintf(
            'https://service-%s.twint.ch/merchant/service/TWINTMerchantServiceV%s',
            $env,
            self::versionString($versionId, '_')
        );
    }

    /**
     * @param self::V_* $versionId
     */
    public static function wsdlPath(int $versionId = self::V_LATEST): string
    {
        return sprintf(
            __DIR__ . '/../resources/wsdl/v%1$s/TWINTMerchantService_v%1$s.wsdl',
            self::versionString($versionId, '.')
        );
    }

    /**
     * @param self::V_* $versionId
     */
    public static function targetNamespace(int $versionId = self::V_LATEST): string
    {
        return sprintf('http://service.twint.ch/header/types/v%s', self::versionString($versionId, '_'));
    }

    /**
     * @param self::V* $versionId
     */
    private static function versionString(int $versionId, string $separator): string
    {
        return array_reduce(
            [self::minor($versionId), self::patch($versionId)],
            static fn (string $carry, int $part) => $part > 0 ? sprintf('%s%s%d', $carry, $separator, $part) : $carry,
            (string) self::major($versionId)
        );
    }
}
