<?php
class array_mergeTest extends PHPUnit_Framework_TestCase{

    public function testIndexedArrayの加算は、配列2が長い場合に、その長い部分が配列1の後ろに付けられる(){
        $one = array('aa', 'bb', '0',  0,    null, false);
        $two = array('aa', 'xx', 'yy', 'yy', 'yy', 'yy', 'zz');
        $this->assertEquals(array('aa', 'bb', '0', 0, null, false, 'zz'), $one + $two);

        $one = array('aa', 'bb', 'cc');
        $two = array('xx', 'yy');
        $this->assertEquals(array('aa', 'bb', 'cc'), $one + $two);
    }

    public function testIndexedArrayのmergeは、内容に関わらず配列1の後ろに配列2が付けられる(){
        $one = array('aa', 'bb', '0',  0,    null, false);
        $two = array('aa', 'xx', 'yy', 'yy', 'yy', 'yy', 'zz');
        $this->assertEquals(array('aa', 'bb', '0', 0, null, false, 'aa', 'xx', 'yy', 'yy', 'yy', 'yy', 'zz'), array_merge($one, $two));
    }

    public function testNamedArrayの加算は、前者優先(){
        $one = array('AAA' => 'foo', 'BBB' => 0);
        $two = array('AAA' => 'bar', 'CCC' => 1);
        $this->assertEquals(array('AAA' => 'foo', 'BBB' => 0, 'CCC' => 1), $one + $two);
    }

    public function testNamedArrayのmergeは、後者優先(){
        $one = array('AAA' => 'foo', 'BBB' => 0);
        $two = array('AAA' => 'bar', 'CCC' => 1);
        $this->assertEquals(array('AAA' => 'bar', 'CCC' => 1, 'BBB' => 0), array_merge($one, $two));
        $this->assertEquals(array('AAA' => 'bar', 'BBB' => 0, 'CCC' => 1), array_merge($one, $two)); //assertEqualsは連想配列の順番にこだわらない
    }

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

    public function testNestedArrayのネスト部分はどちらか片方しか残らない(){
        $one = array(
            'foo' => array(
                'FOO' => 1,
            ),
        );
        $two = array(
            'foo' => array(
                'BAR' => 2,
            ),
        );

        $expected = array(
            'foo' => array(
                'BAR' => 2,
            ),
        );
        $this->assertEquals($expected, array_merge($one, $two));

        $expected = array(
            'foo' => array(
                'FOO' => 1,
            ),
        );
        $this->assertEquals($expected, $one + $two);
    }
}
