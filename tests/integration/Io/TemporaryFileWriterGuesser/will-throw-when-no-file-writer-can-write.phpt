--TEST--
Will throw if no file can be written
--INI--
sys_temp_dir=/twint-temp
--SKIPIF--
<?php
if (!filter_var(getenv('TWINT_SDK_TESTS_DESTRUCTIVE'), FILTER_VALIDATE_BOOLEAN)) {
    echo "skip destructive tests";
}
--FILE--
<?php
require_once 'vendor/autoload.php';

exec('mv /tmp /tmp.bak');
exec('mv /var/tmp /var-tmp.bak');
mkdir('/twint-temp');

$test = require 'guesser-test.inc';

try {
    $test();

    exec('rm -rf /twint-temp');

    $test();

} catch (\Twint\Sdk\Exception\IoError $e) {
    do {
        echo $e->getMessage() . "\n";
    } while ($e = $e->getPrevious());
} finally {
    exec('mv /tmp.bak /tmp');
    exec('mv /var-tmp.bak /var/tmp');
}
--EXPECT--
/twint-temp
All file writers exhausted
Cannot create temporary file writer from environment variable "TMPDIR" (NULL)
Expected "non-empty-string", got "null".
Cannot create temporary file writer from environment variable "XDG_RUNTIME_DIR" (NULL)
Expected "non-empty-string", got "null".
Cannot create temporary file writer from environment variable "TEMPDIR" (NULL)
Expected "non-empty-string", got "null".
Cannot create temporary file writer from environment variable "TMP" (NULL)
Expected "non-empty-string", got "null".
Cannot create temporary file writer from environment variable "TEMP" (NULL)
Expected "non-empty-string", got "null".
Cannot create temporary file writer from php.ini setting "upload_tmp_dir" (NULL)
Expected "non-empty-string", got "null".
Cannot create temporary file writer from path "/tmp" ('/tmp')
File "/tmp" is not readable
Cannot create temporary file writer from path "/var/tmp" ('/var/tmp')
File "/var/tmp" is not readable
Cannot create temporary file writer from path "C:\Temp" ('C:\\Temp')
File "C:\Temp" is not readable
Cannot create temporary file writer from path "C:\Windows\Temp" ('C:\\Windows\\Temp')
File "C:\Windows\Temp" is not readable
Operation timed out after 5 retries with 0ms delay
Could not create temporary file in directory "/twint-temp"
