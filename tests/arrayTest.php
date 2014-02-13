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

	public function test_配列oneが参照渡しされた配列refを要素に持つ場合、配列oneをコピーしても配列refの参照が切れない(){
		$ref = array('ref');
		$one = array(array('foo'));
		$one[] = &$ref;
		$two = $one;
		$two[0][] = 'bar';
		$two[1][] = 'bar';
		$this->assertEquals(array(array('foo'), array('ref', 'bar')), $one);
		$this->assertEquals(array(array('foo', 'bar'), array('ref', 'bar')), $two);
	}

	public function test_foreach内でvalueをunsetしても配列に影響しない(){
		$ary = array('foo', 'bar', 'baz');
		foreach($ary as $value){
			if('bar' === $value) unset($value);
		}

		$expected = array('foo', 'bar', 'baz');
		$this->assertEquals($expected, $ary);

		// foreach ref
		$ary = array('foo', 'bar', 'baz');
		foreach($ary as &$value){
			if('baz' === $value) $value = strtoupper($value);
			if('bar' === $value) unset($value);
		}

		$expected = array('foo', 'bar', 'BAZ');
		$this->assertEquals($expected, $ary);
	}
}
