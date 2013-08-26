<?php
class array_mergeTest extends PHPUnit_Framework_TestCase{
	public function testIndexedArray(){
		$one = array('a', 'b', 'c');
		$two = array('a', 'b', 'c');
		$this->assertEquals(array('a', 'b', 'c', 'a', 'b', 'c'), array_merge($one, $two));
		$this->assertEquals(array('a', 'b', 'c'), $one + $two);
		$one = array('a', 'b', 'c');
		$two = array('b', 'b', 'b');
		$this->assertEquals(array('a', 'b', 'c', 'b', 'b', 'b'), array_merge($one, $two));
		$this->assertEquals(array('a', 'b', 'c'), $one + $two);
		$one = array('a', 'b', 'c');
		$two = array('b', 'b', 'b', 'b');
		$this->assertEquals(array('a', 'b', 'c', 'b', 'b', 'b', 'b'), array_merge($one, $two));
		$this->assertEquals(array('a', 'b', 'c', 'b'), $one + $two);
	}

	public function testNamedArray(){
		$one = array('foo'=>'a', 'bar'=>'b', 'baz'=>'c');
		$two = array('foo'=>'a', 'bar'=>'b', 'baz'=>'c');
		$this->assertEquals(array('foo'=>'a', 'bar'=>'b', 'baz'=>'c'), array_merge($one, $two));
		$this->assertEquals(array('foo'=>'a', 'bar'=>'b', 'baz'=>'c'), $one + $two);
		$one = array('foo'=>'a', 'bar'=>'b', 'baz'=>'c');
		$two = array('foo'=>'d', 'bar'=>'d', 'baz'=>'d');
		$this->assertEquals(array('foo'=>'d', 'bar'=>'d', 'baz'=>'d'), array_merge($one, $two));
		$this->assertEquals(array('foo'=>'a', 'bar'=>'b', 'baz'=>'c'), $one + $two);
		$one = array('foo'=>'a', 'bar'=>'b', 'baz'=>'c');
		$two = array('FOO'=>'d', 'bar'=>'e', 'BAZ'=>'f');
		$this->assertEquals(array('foo'=>'a', 'bar'=>'e', 'baz'=>'c', 'FOO' => 'd', 'BAZ' => 'f'), array_merge($one, $two));
		$this->assertEquals(array('foo'=>'a', 'bar'=>'b', 'baz'=>'c', 'FOO' => 'd', 'BAZ' => 'f'), $one + $two);
	}

	public function testNestedArray(){
		$one = array(
			'foo' => array(
				'foo.foo' => 'a',
				'foo.bar' => 'b'
			),
			'bar' => array(
				'bar.foo' => 'c',
				'bar.bar' => 'd'
			)
		);
		$two = array(
			'foo' => array(
				'foo.foo' => 'a',
				'foo.bar' => 'b'
			),
			'bar' => array(
				'bar.foo' => 'c',
				'bar.bar' => 'd'
			)
		);
		$this->assertEquals(array(
			'foo' => array(
				'foo.foo' => 'a',
				'foo.bar' => 'b'
			),
			'bar' => array(
				'bar.foo' => 'c',
				'bar.bar' => 'd'
			)
		), array_merge($one, $two));
		$this->assertEquals(array(
			'foo' => array(
				'foo.foo' => 'a',
				'foo.bar' => 'b'
			),
			'bar' => array(
				'bar.foo' => 'c',
				'bar.bar' => 'd'
			)
		), $one + $two);
		$one = array(
			'foo' => array(
				'foo.foo' => 'a',
				'foo.bar' => 'b'
			),
			'bar' => array(
				'bar.foo' => 'c',
				'bar.bar' => 'd'
			)
		);
		$two = array(
			'foo' => array(
				'foo.foo' => 'e',
				'foo.bar' => 'e'
			),
			'bar' => array(
				'bar.foo' => 'e',
				'bar.bar' => 'e'
			)
		);
		$this->assertEquals(array(
			'foo' => array(
				'foo.foo' => 'e',
				'foo.bar' => 'e'
			),
			'bar' => array(
				'bar.foo' => 'e',
				'bar.bar' => 'e'
			)
		), array_merge($one, $two));
		$this->assertEquals(array(
			'foo' => array(
				'foo.foo' => 'a',
				'foo.bar' => 'b'
			),
			'bar' => array(
				'bar.foo' => 'c',
				'bar.bar' => 'd'
			)
		), $one + $two);
	}
}
