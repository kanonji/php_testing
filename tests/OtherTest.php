<?php
class OtherTest extends PHPUnit_Framework_TestCase{

    public function testDivide(){
        $this->assertEquals(7.5, 15 / 2);
    }

    public function test_number_format(){
        $val = 1111.49;
        $this->assertEquals('1,111', number_format($val));
        $this->assertEquals('1,111', number_format((int)$val));
        $this->assertEquals('1,111', number_format((string)$val));
        $val = 1111.5;
        $this->assertEquals('1,112', number_format($val));
        $this->assertEquals('1,111', number_format((int)$val));
        $this->assertEquals('1,112', number_format((string)$val));
    }
}
