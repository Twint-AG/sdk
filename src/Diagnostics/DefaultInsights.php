<?php

declare(strict_types=1);

namespace Twint\Sdk\Diagnostics;

use DateTimeInterface;
use Throwable;
use function Psl\Type\string;

/**
 * @phpstan-import-type Insight from Collector
 * @internal
 */
final class DefaultInsights
{
    /**
     * @return list<Insight>
     */
    public static function get(DateTimeInterface $now): array
    {
        return [
            ['OS family', PHP_OS_FAMILY],
            ['PHP version', PHP_VERSION],
            ['PHP memory limit', self::maybeIni('memory_limit')],
            ['PHP open basedir', self::maybeIni('open_basedir')],
            ['PHP default charset', self::maybeIni('default_charset')],
            ['PHP disabled functions', self::maybeIni('disable_functions')],
            ['PHP disabled classes', self::maybeIni('disable_classes')],
            ['PHP temp dir', self::maybeIni('sys_temp_dir')],
            ['PHP max execution time', self::maybeIni('max_execution_time')],
            ['PHP post max size', self::maybeIni('post_max_size')],
            ['PHP upload max filesize', self::maybeIni('upload_max_filesize')],
            ['PHP max input time', self::maybeIni('max_input_time')],
            ['PHP allow URL fopen', self::maybeIni('allow_url_fopen')],
            ['PHP display errors', self::maybeIni('display_errors')],
            ['PHP log errors', self::maybeIni('log_errors')],
            ['PHP error log', self::maybeIni('error_log')],
            ['cURL version', self::maybeCurl('version')],
            ['PHP extensions', get_loaded_extensions()],
            ['libcurl SSL engine', self::maybeCurl('ssl_version')],
            ['libcurl CA info', self::maybeIni('curl.cainfo')],
            ['OpenSSL version', self::maybeConst('OPENSSL_VERSION_TEXT')],
            ['OpenSSL CA file', self::maybeIni('openssl.cafile')],
            ['OpenSSL CA path', self::maybeIni('openssl.capath')],
            ['libxml version', self::maybeConst('LIBXML_DOTTED_VERSION')],
            ['libxslt version', self::maybeConst('LIBXSLT_DOTTED_VERSION')],
            ['Sodium version', self::maybeConst('SODIUM_LIBRARY_VERSION')],
            ['PCRE version', self::maybeConst('PCRE_VERSION')],
            ['zlib version', self::maybeConst('ZLIB_VERSION')],
            ['ICU version', self::maybeConst('INTL_ICU_VERSION')],
            [
                'OPcache enabled',
                extension_loaded('Zend OPcache') && ini_get('opcache.enable') !== false ? 'yes' : 'no',
            ],
            ['Date', $now->format(DateTimeInterface::ATOM)],
            ['Timezone', date_default_timezone_get()],
        ];
    }

    private static function maybeConst(string $const): string
    {
        try {
            return defined($const)
                ? string()
                    ->coerce(constant($const))
                : 'n/a';
            // @codeCoverageIgnoreStart
        } catch (Throwable $e) {
            return 'err';
        }
        // @codeCoverageIgnoreEnd
    }

    private static function maybeIni(string $key): string
    {
        $value = ini_get($key);

        return !in_array($value, [false, ''], true) ? $value : 'n/a';
    }

    private static function maybeCurl(string $key): string
    {
        $version = curl_version();

        try {
            return isset($version[$key]) ? string()->coerce($version[$key]) : 'n/a';
            // @codeCoverageIgnoreStart
        } catch (Throwable $e) {
            return 'err';
        }
        // @codeCoverageIgnoreEnd
    }
}
