<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\Hermeticism;

/**
 * Decides whether a test may talk to the real TWINT API.
 *
 * Reaching the real API is opt-in: unless {@see Empirical::ENV_VAR} is set, only the WireMock
 * host may be contacted and anything else fails loudly instead of quietly reaching
 * service-pat.twint.ch. WireMock is served over plain HTTP, so nothing in the hermetic
 * lane performs a TLS handshake -- which is exactly why the client certificate path can
 * only be exercised by the empirical lane.
 */
final class Hermeticism
{
    private const WIREMOCK_BASE_URL_ENV_VAR = 'TWINT_SDK_TEST_WIREMOCK_BASE_URL';

    public static function isEnforced(): bool
    {
        return !filter_var($_SERVER[Empirical::ENV_VAR] ?? false, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @throws HermeticismViolated
     */
    public static function enforce(string $url): void
    {
        if (!self::isEnforced()) {
            return;
        }

        $allowedHost = self::wireMockHost();

        if ($allowedHost !== null && parse_url($url, PHP_URL_HOST) === $allowedHost) {
            return;
        }

        throw HermeticismViolated::forUrl($url, $allowedHost);
    }

    private static function wireMockHost(): ?string
    {
        $host = parse_url(self::env(self::WIREMOCK_BASE_URL_ENV_VAR), PHP_URL_HOST);

        return is_string($host) && $host !== '' ? $host : null;
    }

    private static function env(string $name): string
    {
        return is_string($_SERVER[$name] ?? null) ? $_SERVER[$name] : '';
    }
}
