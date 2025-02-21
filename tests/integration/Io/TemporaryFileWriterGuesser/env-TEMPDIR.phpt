--TEST--
Fallback to TEMPDIR var if sys_temp_dir is wrong
--INI--
sys_temp_dir=/non-existent
--ENV--
TEMPDIR=/tmp/twint-TEMPDIR
--FILE--
<?php
@mkdir('/tmp/twint-TEMPDIR');
(require 'guesser-test.inc')();
--CLEAN--
@rmdir('/tmp/twint-TEMPDIR');
--EXPECT--
/tmp/twint-TEMPDIR
