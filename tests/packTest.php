<?php
class PackTest extends PHPUnit_Framework_TestCase{
    public function test_packで文字コードから文字(){
        $this->assertEquals('あ', pack('C*', 0xE3, 0x81, 0x82));
        $this->assertEquals('あ', mb_convert_encoding( pack('C*', 0x82, 0xA0), 'UTF-8', 'Shift_JIS'));
    }

    public function test_packでUnicodeエスケープシーケンスから文字(){
        $unicodeEscaped = '\u3042';
        preg_match('|\\\\u([0-9a-f]{4})|i', $unicodeEscaped, $match);
        $unicode = $match[1];
        $this->assertEquals('あ', mb_convert_encoding( pack('H*', $unicode), 'UTF-8', 'UTF-16' ));
    }
}
