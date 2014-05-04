<?php
class array_diffTest extends PHPUnit_Framework_TestCase{
    public function testIndexedArray(){
        $one = array('a', 'b', 'c');
        $two = array('a', 'b', 'c');
        $this->assertEquals(array(), array_diff($one, $two));
        $one = array('a', 'b', 'c');
        $two = array('a', 'c', 'b');
        $this->assertEquals(array(), array_diff($one, $two));
        $one = array('a', 'b', 'c');
        $two = array('b', 'b', 'b');
        $this->assertEquals(array(0 => 'a', 2 => 'c'), array_diff($one, $two));
        $one = array('a', 'b', 'c');
        $two = array('a', 'b', 'c', 'd');
        $this->assertEquals(array(), array_diff($one, $two));
        $one = array('a', 'b', 'c');
        $two = array('a', 'b', 'd');
        $this->assertEquals(array(2 => 'c'), array_diff($one, $two));
    }
}
