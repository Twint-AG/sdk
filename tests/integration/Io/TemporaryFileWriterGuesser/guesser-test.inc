<?php

declare(strict_types=1);

use Twint\Sdk\Io\TemporaryFileWriterGuesser;

require_once 'vendor/autoload.php';

$writer = (new TemporaryFileWriterGuesser())();

return static function () use ($writer) {
    $file = $writer->write('Hello, World!', '.txt');

    echo dirname((string) $file) . "\n";
};
