<?php
class arrayTest extends PHPUnit_Framework_TestCase{
	public function test_空配列はemptyでtrue(){
		$one = array();
		$this->assertTrue(empty($one));
		$this->assertFalse((bool)$one);
	}
	public function test_空配列を持つ配列はemptyでfalse(){
		$one = array(array());
		$this->assertFalse(empty($one));
		$this->assertTrue((bool)$one);
	}
}
