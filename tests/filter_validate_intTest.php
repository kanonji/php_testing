<?php
class FilterValidateIntTest extends PHPUnit_Framework_TestCase{

    public function test_FILTER_VALIDATE_INTで正しいと扱われる(){
        $this->assertNotSame(false, filter_var(1, FILTER_VALIDATE_INT));
        $this->assertNotSame(false, filter_var('1', FILTER_VALIDATE_INT));
        $this->assertNotSame(false, filter_var(-1, FILTER_VALIDATE_INT));
        $this->assertNotSame(false, filter_var('-1', FILTER_VALIDATE_INT));
        $this->assertNotSame(false, filter_var(0, FILTER_VALIDATE_INT));
        $this->assertNotSame(false, filter_var('0', FILTER_VALIDATE_INT));
        $this->assertNotSame(false, filter_var(1.0, FILTER_VALIDATE_INT));
        $this->assertNotSame(false, filter_var(00, FILTER_VALIDATE_INT));
        $this->assertNotSame(false, filter_var(0x00, FILTER_VALIDATE_INT));
        $this->assertNotSame(false, filter_var(0x10, FILTER_VALIDATE_INT));
    }

    public function test_FILTER_VALIDATE_INTで正しいと扱われない(){
        $this->assertSame(false, filter_var(1.1, FILTER_VALIDATE_INT));
        $this->assertSame(false, filter_var('1.0', FILTER_VALIDATE_INT));
        $this->assertSame(false, filter_var('1.1', FILTER_VALIDATE_INT));
        $this->assertSame(false, filter_var('00', FILTER_VALIDATE_INT));
        $this->assertSame(false, filter_var('1a', FILTER_VALIDATE_INT));
        $this->assertSame(false, filter_var('a1', FILTER_VALIDATE_INT));
        $this->assertSame(false, filter_var('１', FILTER_VALIDATE_INT));
        $this->assertSame(false, filter_var('0x00', FILTER_VALIDATE_INT));
        $this->assertSame(false, filter_var('0x10', FILTER_VALIDATE_INT));
    }

    public function test_FILTER_VALIDATE_INTで数値の範囲も検査出来る(){
        $option = array(
            'options' => array(
                'min_range' => 1,
                'max_range' => 3,
            ),
        );
        $this->assertSame(false, filter_var(0, FILTER_VALIDATE_INT, $option));
        $this->assertNotSame(false, filter_var(1, FILTER_VALIDATE_INT, $option));
        $this->assertNotSame(false, filter_var(2, FILTER_VALIDATE_INT, $option));
        $this->assertNotSame(false, filter_var(3, FILTER_VALIDATE_INT, $option));
        $this->assertSame(false, filter_var(4, FILTER_VALIDATE_INT, $option));
    }

    public function test_FILTER_VALIDATE_INTで範囲が負の値でも検査出来る(){
        $option = array(
            'options' => array(
                'min_range' => -1,
                'max_range' => 1,
            ),
        );
        $this->assertSame(false, filter_var(-2, FILTER_VALIDATE_INT, $option));
        $this->assertNotSame(false, filter_var(-1, FILTER_VALIDATE_INT, $option));
        $this->assertNotSame(false, filter_var(0, FILTER_VALIDATE_INT, $option));
        $this->assertNotSame(false, filter_var(1, FILTER_VALIDATE_INT, $option));
        $this->assertSame(false, filter_var(2, FILTER_VALIDATE_INT, $option));
    }

    public function test_FILTER_VALIDATE_INTで範囲が不正だと全て失敗する(){
        $option = array(
            'options' => array(
                'min_range' => 3,
                'max_range' => 1,
            ),
        );
        $this->assertSame(false, filter_var(0, FILTER_VALIDATE_INT, $option));
        $this->assertSame(false, filter_var(1, FILTER_VALIDATE_INT, $option));
        $this->assertSame(false, filter_var(2, FILTER_VALIDATE_INT, $option));
        $this->assertSame(false, filter_var(3, FILTER_VALIDATE_INT, $option));
        $this->assertSame(false, filter_var(4, FILTER_VALIDATE_INT, $option));
    }
}
