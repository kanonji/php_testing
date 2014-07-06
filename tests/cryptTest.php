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

    /*
     * for passwords without characters with the 8th bit set, there's no issue, all three prefixes work exactly the same. 
     * http://www.php.net/security/crypt_blowfish.php
     */
    public function test_ASCIIをハッシュ化する場合＄2a、＄2x、＄2yは同じ結果になる(){
        if( version_compare(PHP_VERSION, '5.3.7') < 0 ) return;
        $password = "foo";
        $salt = array(
            'algorithm' => '$2a$',
            'cost' =>      '04$',
            'string' =>    '0123456789012345678901',
        );
        $hashed_2a = crypt($password, implode('', $salt));

        $salt['algorithm'] = '$2x$';
        $hashed_2x = crypt($password, implode('', $salt));

        $salt['algorithm'] = '$2y$';
        $hashed_2y = crypt($password, implode('', $salt));

        //$2a$04$012345678901234567890u8k59IBiNFaMMG.gK0GD0jzhrbQAcpgi
        //    04$012345678901234567890u8k59IBiNFaMMG.gK0GD0jzhrbQAcpgi
        $hashed_2a = substr($hashed_2a, 4);
        $hashed_2x = substr($hashed_2x, 4);
        $hashed_2y = substr($hashed_2y, 4);

        $this->assertEquals($hashed_2a, $hashed_2x);
        $this->assertEquals($hashed_2a, $hashed_2y);
    }

    public function test_非ASCII文字を含む場合、algorithmによって結果が変わる(){
        if( version_compare(PHP_VERSION, '5.3.7') < 0 ) return;
        $password = "f\x80oo";
        $salt = array(
            'algorithm' => '$2a$',
            'cost' =>      '04$',
            'string' =>    '0123456789012345678901',
        );
        $hashed_2a = crypt($password, implode('', $salt));

        $salt['algorithm'] = '$2x$';
        $hashed_2x = crypt($password, implode('', $salt));

        $salt['algorithm'] = '$2y$';
        $hashed_2y = crypt($password, implode('', $salt));

        //$2a$04$012345678901234567890u8k59IBiNFaMMG.gK0GD0jzhrbQAcpgi
        //    04$012345678901234567890u8k59IBiNFaMMG.gK0GD0jzhrbQAcpgi
        $hashed_2a = substr($hashed_2a, 4);
        $hashed_2x = substr($hashed_2x, 4);
        $hashed_2y = substr($hashed_2y, 4);

        $this->assertNotEquals($hashed_2a, $hashed_2x);
        $this->assertEquals($hashed_2a, $hashed_2y);
    }
}
