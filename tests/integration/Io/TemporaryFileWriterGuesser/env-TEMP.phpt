--TEST--
Fallback to TEMP var if sys_temp_dir is wrong
--INI--
sys_temp_dir=/non-existent
--ENV--
TEMP=/tmp/twint-TEMP
--FILE--
<?php
@mkdir('/tmp/twint-TEMP');
(require_once 'guesser-test.inc')();
--CLEAN--
@rmdir('/tmp/twint-TEMP');
--EXPECT--
/tmp/twint-TEMP
