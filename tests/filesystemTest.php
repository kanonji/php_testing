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

    public function test_php_memory_streamはハンドルを開き直すと別データになる(){
        $handle = new SplFileObject('php://memory', 'r+');
        $handle->fwrite('foo'.PHP_EOL);
        $handle->fwrite('bar'.PHP_EOL);
        $handle->fwrite('baz'.PHP_EOL);

        $this->assertEmpty($handle->fgets());

        $handle->rewind();
        $this->assertEquals('foo'.PHP_EOL, $handle->fgets());
        $this->assertEquals('bar'.PHP_EOL, $handle->fgets());
        $this->assertEquals('baz'.PHP_EOL, $handle->fgets());

        $handle2 = new SplFileObject('php://memory', 'r+');
        $result = '';
        foreach($handle2 as $line){
            $result .= $line;
        }
        $this->assertEmpty($result);
    }
}
