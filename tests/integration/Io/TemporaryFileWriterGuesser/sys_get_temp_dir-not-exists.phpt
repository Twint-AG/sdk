--TEST--
Fallback to hard-coded /tmp even if setting is wrong
--INI--
sys_temp_dir=/non-existent
--FILE--
<?php
(require_once 'guesser-test.inc')();
--EXPECT--
/tmp
