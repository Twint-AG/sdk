--TEST--
Fallback to upload_tmp_dir var if sys_temp_dir is wrong
--INI--
sys_temp_dir=/non-existent
upload_tmp_dir=/tmp/twint-upload_tmp_dir
--FILE--
<?php
@mkdir('/tmp/twint-upload_tmp_dir');
(require 'guesser-test.inc')();
--CLEAN--
@rmdir('/tmp/twint-upload_tmp_dir');
--EXPECT--
/tmp/twint-upload_tmp_dir
