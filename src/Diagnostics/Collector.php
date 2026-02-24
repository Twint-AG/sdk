<?php

declare(strict_types=1);

namespace Twint\Sdk\Diagnostics;

use BadMethodCallException;
use DateTimeImmutable;
use DateTimeInterface;
use JsonException;
use Override;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\Filesystem\Path;
use ZipStream\Exception\FileNotFoundException;
use ZipStream\Exception\FileNotReadableException;
use ZipStream\ZipStream;

/**
 * @phpstan-type InsightValue = bool|float|int|string|list<bool>|list<float>|list<int>|list<string>
 * @phpstan-type Insight = array{non-empty-string, InsightValue}
 * @phpstan-type PathPredicate = null|pure-callable(non-empty-string): bool
 * @phpstan-type PathEntry = array{non-empty-string, PathPredicate}
 */
final class Collector
{
    /**
     * @param list<PathEntry> $paths
     * @param list<Insight> $insights
     */
    public function __construct(
        private readonly array $paths = [],
        private readonly array $insights = []
    ) {
    }

    public static function withDefaults(?DateTimeInterface $now = null): self
    {
        return new self(insights: DefaultInsights::get($now ?? new DateTimeImmutable()));
    }

    /**
     * @param non-empty-string $path
     * @param PathPredicate $predicate
     */
    public function includePath(string $path, ?callable $predicate = null): self
    {
        return new self(paths: [...$this->paths, [$path, $predicate]], insights: $this->insights);
    }

    /**
     * @param non-empty-string $key
     * @param InsightValue $value
     */
    public function includeInsight(string $key, string|int|float|bool|array $value): self
    {
        return new self(paths: $this->paths, insights: [...$this->insights, [$key, $value]]);
    }

    /**
     * @return list<Insight>
     */
    public function insights(): array
    {
        return $this->insights;
    }

    /**
     * @return list<PathEntry>
     */
    public function paths(): array
    {
        return $this->paths;
    }

    /**
     * @param callable(string): void $streamHandler
     * @param null|callable(non-empty-string): void $sendHttpHeader
     */
    public function collect(string $fileNamePrefix, callable $streamHandler, ?callable $sendHttpHeader = null): void
    {
        $sendHttpHeader = $sendHttpHeader !== null ? $sendHttpHeader(...) : header(...);
        $zip = new ZipStream(
            outputStream: new class($streamHandler) implements StreamInterface {
                private readonly mixed $handler;

                /**
                 * @param callable(string): void $handler
                 */
                public function __construct(callable $handler)
                {
                    $this->handler = $handler;
                }

                /**
                 * @throws BadMethodCallException
                 * @codeCoverageIgnore
                 */
                #[Override]
                public function __toString(): string
                {
                    throw new BadMethodCallException('Not implemented');
                }

                /**
                 * @throws BadMethodCallException
                 * @codeCoverageIgnore
                 */
                #[Override]
                public function close(): void
                {
                    throw new BadMethodCallException('Not implemented');
                }

                /**
                 * @throws BadMethodCallException
                 * @codeCoverageIgnore
                 */
                #[Override]
                public function detach()
                {
                    throw new BadMethodCallException('Not implemented');
                }

                /**
                 * @throws BadMethodCallException
                 * @codeCoverageIgnore
                 */
                #[Override]
                public function getSize(): ?int
                {
                    throw new BadMethodCallException('Not implemented');
                }

                /**
                 * @throws BadMethodCallException
                 * @codeCoverageIgnore
                 */
                #[Override]
                public function tell(): int
                {
                    throw new BadMethodCallException('Not implemented');
                }

                /**
                 * @throws BadMethodCallException
                 * @codeCoverageIgnore
                 */
                #[Override]
                public function eof(): bool
                {
                    throw new BadMethodCallException('Not implemented');
                }

                /**
                 * @codeCoverageIgnore
                 */
                #[Override]
                public function isSeekable(): bool
                {
                    return false;
                }

                /**
                 * @throws BadMethodCallException
                 * @codeCoverageIgnore
                 */
                #[Override]
                public function seek(int $offset, int $whence = SEEK_SET): void
                {
                    throw new BadMethodCallException('Not implemented');
                }

                /**
                 * @throws BadMethodCallException
                 * @codeCoverageIgnore
                 */
                #[Override]
                public function rewind(): void
                {
                    throw new BadMethodCallException('Not implemented');
                }

                #[Override]
                public function isWritable(): bool
                {
                    return true;
                }

                #[Override]
                public function write(string $string): int
                {
                    $size = strlen($string);
                    ($this->handler)($string);
                    return $size;
                }

                #[Override]
                public function isReadable(): bool
                {
                    return false;
                }

                /**
                 * @throws BadMethodCallException
                 * @codeCoverageIgnore
                 */
                #[Override]
                public function read(int $length): string
                {
                    throw new BadMethodCallException('Not implemented');
                }

                /**
                 * @throws BadMethodCallException
                 * @codeCoverageIgnore
                 */
                #[Override]
                public function getContents(): string
                {
                    throw new BadMethodCallException('Not implemented');
                }

                /**
                 * @throws BadMethodCallException
                 * @codeCoverageIgnore
                 */
                #[Override]
                public function getMetadata(?string $key = null)
                {
                    throw new BadMethodCallException('Not implemented');
                }
            },
            httpHeaderCallback: $sendHttpHeader,
            outputName: sprintf('%s-%s.zip', $fileNamePrefix, date(DATE_ISO8601))
        );

        $logs = [];

        $logger = static function (string $message, string ...$args) use (&$logs): void {
            $logs[] = sprintf($message, ...$args);
        };

        try {
            $zip->addFile(
                fileName: 'environment.json',
                data: json_encode($this->insights, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT),
            );
            // @codeCoverageIgnoreStart
        } catch (JsonException $e) {
            $logger('Failed to encode environment insights: "%s"', $e->getMessage());
        }
        // @codeCoverageIgnoreEnd

        foreach ($this->paths as [$path, $predicate]) {
            self::collectPath($zip, $path, $predicate, $logger);
        }

        $zip->addFile(fileName: 'diagnostics.log', data: implode("\n", $logs) . "\n");

        $zip->finish();
    }

    /**
     * @param non-empty-string $path
     * @param PathPredicate $predicate
     * @param callable(string, string ...$args): void $log
     */
    private static function collectPath(ZipStream $zip, string $path, ?callable $predicate, callable $log): void
    {
        if (is_file($path)) {
            if ($predicate === null || $predicate($path)) {
                try {
                    $zip->addFileFromPath($path, $path);

                    $log(
                        'Added file "%s" because %s',
                        $path,
                        $predicate !== null ? 'predicate evaluated true' : 'no predicate given'
                    );
                    return;
                } catch (FileNotFoundException|FileNotReadableException $e) {
                    $log('Failed to add file "%s": "%s"', $path, $e->getMessage());
                    return;
                }
            }

            $log('Predicate evaluated false for file "%s"', $path);
            return;
        }

        if (is_dir($path)) {
            $children = scandir($path);

            if ($children === false) {
                // @codeCoverageIgnoreStart
                $log('Failed to read directory "%s"', $path);
                return;
                // @codeCoverageIgnoreEnd
            }

            foreach ($children as $child) {
                if ($child === '..' || $child === '.') {
                    continue;
                }

                $fullPath = Path::join($path, $child);
                if ($fullPath === '') {
                    // @codeCoverageIgnoreStart
                    continue;
                    // @codeCoverageIgnoreEnd
                }

                self::collectPath($zip, $fullPath, $predicate, $log);
            }

            return;
        }

        $log('Path "%s" was not found', $path);
    }
}
