--TEST--
Fallback to TMP var if sys_temp_dir is wrong
--INI--
sys_temp_dir=/non-existent
--ENV--
TMP=/tmp/twint-TMP
--FILE--
<?php
@mkdir('/tmp/twint-TMP');
(require_once 'guesser-test.inc')();
--CLEAN--
@rmdir('/tmp/twint-TMP');
--EXPECT--
/tmp/twint-TMP
