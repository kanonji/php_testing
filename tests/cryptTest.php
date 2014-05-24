<?php
/*
 * http://php.net/manual/ja/faq.passwords.php
 */
class CryptTest extends PHPUnit_Framework_TestCase{

    /*
     * salt is...
     * $2a$: algorithm
     * 04$: cost from 04 upto 30
     * 22 length string
     */
    public function test_cryptで作ったhashをsaltにして検証が出来る(){
        $salt = '$2a$04$0123456789012345678901';
        $hashed = crypt('foo', $salt);
        $this->assertEquals('$2a$04$012345678901234567890u8k59IBiNFaMMG.gK0GD0jzhrbQAcpgi', $hashed);
        $this->assertEquals('$2a$04$012345678901234567890u8k59IBiNFaMMG.gK0GD0jzhrbQAcpgi', crypt('foo', $hashed));
    }
}
