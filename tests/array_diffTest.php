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
		$two = array('a', 'a', 'a');
		$this->assertEquals(array('b', 'c'), array_diff($one, $two));
		$one = array('a', 'b', 'c');
		$two = array('a', 'b', 'd');
		$this->assertEquals(array('c', 'd'), array_diff($one, $two));
	}
}
