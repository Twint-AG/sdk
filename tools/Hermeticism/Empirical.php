<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\Hermeticism;

/**
 * Names the deliberate exceptions to {@see Hermeticism}.
 *
 * A test in this group is expected to leave the hermetic boundary and talk to the real
 * TWINT API, and only runs when the environment says that is wanted.
 */
final class Empirical
{
    /**
     * PHPUnit group marking a test as one that must reach the real TWINT API.
     */
    public const GROUP = 'empirical';

    /**
     * Set to a truthy value to allow requests to leave the hermetic boundary.
     */
    public const ENV_VAR = 'TWINT_SDK_TESTS_EMPIRICAL';

    /**
     * Names a file to append the real API's responses to; see {@see LoggingHttpClient}.
     */
    public const LOG_ENV_VAR = 'TWINT_SDK_TESTS_EMPIRICAL_LOG';
}
