<?php
class PregTest extends PHPUnit_Framework_TestCase{

    public function test_：alnumに「あ」はマッチする(){
        $this->assertEquals(1, preg_match('/[[:alnum:]]/', 'あ'));
    }

    public function test_：alnum＋u（PCRE_UTF8）に「あ」はマッチする(){
        $this->assertEquals(1, preg_match('/[[:alnum:]]/u', 'あ'));
    }

    public function test_＼wに「あ」はマッチする(){
        $this->assertEquals(1, preg_match('/[\w]/', 'あ'));
    }

    public function test_＼w＋u（PCRE_UTF8）に「あ」はマッチする(){
        $this->assertEquals(1, preg_match('/[\w]/u', 'あ'));
    }

    public function test_：digitに全角「１」はマッチしない(){
        $this->assertEquals(0, preg_match('/[[:digit:]]/', '１'));
    }

    public function test_：digit＋u（PCRE_UTF8）に全角「１」はマッチする(){
        $this->assertEquals(1, preg_match('/[[:digit:]]/u', '１'));
    }

    public function test_＼dに全角「１」はマッチしない(){
        $this->assertEquals(0, preg_match('/[\d]/', '１'));
    }

    public function test_＼d＋u（PCRE_UTF8）に全角「１」はマッチする(){
        $this->assertEquals(1, preg_match('/[\d]/u', '１'));
    }
}
