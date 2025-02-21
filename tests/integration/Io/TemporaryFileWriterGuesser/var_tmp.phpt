--TEST--
Fallback to /var/tmp var if sys_temp_dir is wrong and /tmp does not exist
--INI--
sys_temp_dir=/non-existent
--SKIPIF--
<?php
if (!filter_var(getenv('TWINT_SDK_TESTS_DESTRUCTIVE'), FILTER_VALIDATE_BOOLEAN)) {
    echo "skip destructive tests";
}
--FILE--
<?php
exec('mv /tmp /tmp.bak');
try {
    (require 'guesser-test.inc')();
} finally {
    exec('mv /tmp.bak /tmp');
}
--EXPECT--
/var/tmp
