<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

use Override;
use Throwable;
use Twint\Sdk\Exception\IoError;
use Twint\Sdk\Util\Throwables;
use Twint\Sdk\Value\ExistingPath;

final class FileWriterStack implements FileWriter
{
    /**
     * @var list<FileWriter>|null
     */
    private ?array $fileWriters = null;

    /**
     * @var list<Throwable>
     */
    private array $creationErrors = [];

    /**
     * @param list<callable(): FileWriter> $createFileWriters
     */
    public function __construct(
        private readonly array $createFileWriters
    ) {
    }

    /**
     * @throws IoError
     */
    #[Override]
    public function write(string $input, string $extension = ''): ExistingPath
    {
        if ($this->fileWriters === null) {
            $this->fileWriters = array_values(
                array_filter(
                    array_map(
                        function (callable $createFileWriter): ?FileWriter {
                            try {
                                return $createFileWriter();
                            } catch (Throwable $e) {
                                $this->creationErrors[] = $e;

                                return null;
                            }
                        },
                        $this->createFileWriters
                    ),
                    'is_object'
                )
            );
        }

        $writeErrors = [];
        foreach ($this->fileWriters as $fileWriter) {
            try {
                return $fileWriter->write($input, $extension);
            } catch (Throwable $e) {
                $writeErrors[] = $e;
            }
        }

        throw new IoError(
            'All file writers exhausted',
            0,
            Throwables::chain([...$this->creationErrors, ...$writeErrors])
        );
    }
}
