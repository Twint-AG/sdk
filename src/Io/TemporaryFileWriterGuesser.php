<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

use Throwable;
use Twint\Sdk\Exception\IoError;
use Twint\Sdk\Value\ExistingPath;
use function Psl\Env\get_var;
use function Psl\Type\non_empty_string;

final class TemporaryFileWriterGuesser
{
    public function __invoke(): FileWriter
    {
        return new FileWriterStack(
            [
                self::from('sys_get_temp_dir', 'function sys_get_temp_dir()'),
                self::fromEnvVar('TMPDIR'),
                self::fromEnvVar('XDG_RUNTIME_DIR'),
                self::fromEnvVar('TEMPDIR'),
                self::fromEnvVar('TMP'),
                self::fromEnvVar('TEMP'),
                self::fromIniSetting('upload_tmp_dir'),
                self::fromPath('/tmp'),
                self::fromPath('/var/tmp'),
                self::fromPath('C:\Temp'),
                self::fromPath('C:\Windows\Temp'),
            ]
        );
    }

    /**
     * @param callable(): ?string $source
     * @return callable(): FileWriter
     */
    private static function from(callable $source, string $context): callable
    {
        return static function () use ($source, $context) {
            $value = $source();
            try {
                return new TemporaryFileWriter(new ExistingPath(non_empty_string()->assert($source())));
            } catch (Throwable $e) {
                throw new IoError(sprintf(
                    'Cannot create temporary file writer from %s (%s)',
                    $context,
                    var_export($value, true)
                ), 0, $e);
            }
        };
    }

    /**
     * @param non-empty-string $setting
     * @return callable(): FileWriter
     */
    private static function fromIniSetting(string $setting): callable
    {
        return self::from(
            static fn () => ($v = ini_get($setting)) === '' || $v === false ? null : $v,
            sprintf('php.ini setting "%s"', $setting)
        );
    }

    /**
     * @param non-empty-string $env
     * @return callable(): FileWriter
     */
    private static function fromEnvVar(string $env): callable
    {
        return self::from(static fn () => get_var($env), sprintf('environment variable "%s"', $env));
    }

    /**
     * @param non-empty-string $path
     * @return callable(): FileWriter
     */
    private static function fromPath(string $path): callable
    {
        return self::from(static fn () => $path, sprintf('path "%s"', $path));
    }
}
