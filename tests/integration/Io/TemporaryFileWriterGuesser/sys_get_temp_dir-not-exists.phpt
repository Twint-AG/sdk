--TEST--
Fallback to hard-coded /tmp even if setting is wrong
--INI--
sys_temp_dir=/non-existent
--FILE--
<?php
(require __DIR__ . '/guesser-test.inc')();
--EXPECT--
/tmp
