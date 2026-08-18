<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\Hermeticism;

use RuntimeException;

final class HermeticismViolated extends RuntimeException
{
    public static function forUrl(string $url, ?string $allowedHost): self
    {
        return new self(
            sprintf(
                'Request to "%s" is not allowed: only the WireMock host (%s) may be contacted unless '
                . '%s is set. If this test needs the real TWINT API, annotate it with #[Group(\'%s\')] '
                . 'and run it via `just test-empirical`; otherwise stub the SOAP operation via '
                . 'enableWireMockForSoapMethod().',
                $url,
                $allowedHost ?? '<none configured>',
                Empirical::ENV_VAR,
                Empirical::GROUP
            )
        );
    }
}
