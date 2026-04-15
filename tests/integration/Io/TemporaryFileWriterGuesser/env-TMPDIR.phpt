--TEST--
Fallback to TMPDIR var if sys_temp_dir is wrong
--INI--
sys_temp_dir=/non-existent
--ENV--
TMPDIR=/tmp/twint-TMPDIR
--FILE--
<?php
@mkdir('/tmp/twint-TMPDIR');
(require __DIR__ . '/guesser-test.inc')();
--CLEAN--
@rmdir('/tmp/twint-TMPDIR');
--EXPECT--
/tmp/twint-TMPDIR
