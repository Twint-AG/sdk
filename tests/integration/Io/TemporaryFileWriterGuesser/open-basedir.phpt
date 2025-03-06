--TEST--
open_basedir restrictions are gracefully handled
--INI--
sys_temp_dir=/non-existent
open_basedir=/non-existent
--ENV--
TEMP=/tmp/twint-TEMP
--FILE--
<?php
@mkdir('/tmp/twint-TEMP');
try {
(require 'guesser-test.inc')();
} catch (\Twint\Sdk\Exception\IoError $e) {
    do {
        echo $e->getMessage() . "\n";
    } while ($e = $e->getPrevious());
}
--CLEAN--
@rmdir('/tmp/twint-TEMP');
--EXPECT--
All file writers exhausted
Cannot create temporary file writer from function sys_get_temp_dir() ('/non-existent')
File "/non-existent" is not readable
Cannot create temporary file writer from environment variable "TMPDIR" (NULL)
Expected "non-empty-string", got "null".
Cannot create temporary file writer from environment variable "XDG_RUNTIME_DIR" (NULL)
Expected "non-empty-string", got "null".
Cannot create temporary file writer from environment variable "TEMPDIR" (NULL)
Expected "non-empty-string", got "null".
Cannot create temporary file writer from environment variable "TMP" (NULL)
Expected "non-empty-string", got "null".
Cannot create temporary file writer from environment variable "TEMP" ('/tmp/twint-TEMP')
File "/tmp/twint-TEMP" is not readable
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
