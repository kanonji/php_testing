<?php
class filesystemTest extends PHPUnit_Framework_TestCase{
	public function test_mkdirは引数よりumaskを優先する(){
		$tmp = sys_get_temp_dir().DIRECTORY_SEPARATOR.'php_testing_filesystemTest';
		umask(0077);
		mkdir($tmp, 0777);
		$this->assertEquals('0700', substr(sprintf('%o', fileperms($tmp)), -4) );
		rmdir($tmp);

		umask(0070);
		mkdir($tmp, 0777);
		$this->assertEquals('0707', substr(sprintf('%o', fileperms($tmp)), -4) );
		rmdir($tmp);

		umask(0002);
		mkdir($tmp);
		$this->assertEquals('0775', substr(sprintf('%o', fileperms($tmp)), -4) );
		rmdir($tmp);
	}
}
