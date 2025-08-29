<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Diagnostics;

use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Diagnostics\DefaultInsights;
use function Psl\Type\bool;

/**
 * @internal
 */
#[CoversClass(DefaultInsights::class)]
final class DefaultInsightsTest extends TestCase
{
    public function testDefaultInsights(): void
    {
        self::assertSame(
            [
                ['OS family', PHP_OS_FAMILY],
                ['PHP version', PHP_VERSION],
                [
                    'PHP memory limit',
                    !in_array(ini_get('memory_limit'), ['', false], true) ? ini_get('memory_limit') : 'n/a',
                ],
                [
                    'PHP open basedir',
                    !in_array(ini_get('open_basedir'), ['', false], true) ? ini_get('open_basedir') : 'n/a',
                ],
                [
                    'PHP default charset',
                    !in_array(ini_get('default_charset'), ['', false], true) ? ini_get('default_charset') : 'n/a',
                ],
                [
                    'PHP disabled functions',
                    !in_array(ini_get('disable_functions'), ['', false], true) ? ini_get('disable_functions') : 'n/a',
                ],
                [
                    'PHP disabled classes',
                    !in_array(ini_get('disable_classes'), ['', false], true) ? ini_get('disable_classes') : 'n/a',
                ],
                [
                    'PHP temp dir',
                    !in_array(ini_get('sys_temp_dir'), ['', false], true) ? ini_get('sys_temp_dir') : 'n/a',
                ],
                [
                    'PHP max execution time',
                    !in_array(ini_get('max_execution_time'), ['', false], true) ? ini_get('max_execution_time') : 'n/a',
                ],
                [
                    'PHP post max size',
                    !in_array(ini_get('post_max_size'), ['', false], true) ? ini_get('post_max_size') : 'n/a',
                ],
                [
                    'PHP upload max filesize',
                    !in_array(ini_get('upload_max_filesize'), ['', false], true)
                        ? ini_get('upload_max_filesize')
                        : 'n/a',
                ],
                [
                    'PHP max input time',
                    !in_array(ini_get('max_input_time'), ['', false], true) ? ini_get('max_input_time') : 'n/a',
                ],
                [
                    'PHP allow URL fopen',
                    !in_array(ini_get('allow_url_fopen'), ['', false], true) ? ini_get('allow_url_fopen') : 'n/a',
                ],
                [
                    'PHP display errors',
                    !in_array(ini_get('display_errors'), ['', false], true) ? ini_get('display_errors') : 'n/a',
                ],
                [
                    'PHP log errors',
                    !in_array(ini_get('log_errors'), ['', false], true) ? ini_get('log_errors') : 'n/a',
                ],
                [
                    'PHP error log',
                    !in_array(ini_get('error_log'), ['', false], true) ? ini_get('error_log') : 'n/a',
                ],
                ['cURL version', curl_version()['version'] ?? 'n/a'],
                ['PHP extensions', get_loaded_extensions()],
                ['libcurl SSL engine', curl_version()['ssl_version'] ?? 'n/a'],
                [
                    'libcurl CA info',
                    !in_array(ini_get('curl.cainfo'), ['', false], true) ? ini_get('curl.cainfo') : 'n/a',
                ],
                [
                    'OpenSSL version',
                    defined('OPENSSL_VERSION_TEXT') ? (string) constant('OPENSSL_VERSION_TEXT') : 'n/a',
                ],
                [
                    'OpenSSL CA file',
                    !in_array(ini_get('openssl.cafile'), ['', false], true) ? ini_get('openssl.cafile') : 'n/a',
                ],
                [
                    'OpenSSL CA path',
                    !in_array(ini_get('openssl.capath'), ['', false], true) ? ini_get('openssl.capath') : 'n/a',
                ],
                [
                    'libxml version',
                    defined('LIBXML_DOTTED_VERSION') ? (string) constant('LIBXML_DOTTED_VERSION') : 'n/a',
                ],
                [
                    'libxslt version',
                    defined('LIBXSLT_DOTTED_VERSION') ? (string) constant('LIBXSLT_DOTTED_VERSION') : 'n/a',
                ],
                [
                    'Sodium version',
                    defined('SODIUM_LIBRARY_VERSION') ? (string) constant('SODIUM_LIBRARY_VERSION') : 'n/a',
                ],
                ['PCRE version', defined('PCRE_VERSION') ? (string) constant('PCRE_VERSION') : 'n/a'],
                ['zlib version', defined('ZLIB_VERSION') ? (string) constant('ZLIB_VERSION') : 'n/a'],
                ['ICU version', defined('INTL_ICU_VERSION') ? (string) constant('INTL_ICU_VERSION') : 'n/a'],
                [
                    'OPcache enabled',
                    extension_loaded('Zend OPcache') && bool()
                        ->coerce(ini_get('opcache.enable')) ? 'yes' : 'no',
                ],
                ['Date', '2024-01-01T12:00:00+01:00'],
                ['Timezone', date_default_timezone_get()],
            ],
            DefaultInsights::get(new DateTimeImmutable('2024-01-01T12:00:00+01:00'))
        );
    }
}
