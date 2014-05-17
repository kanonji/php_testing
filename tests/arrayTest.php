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

    public function test_array_map内でreturnしない場合nullが入る(){
        $ary = array(1,2,3,4,5);
        $result = array_map(function($v){if(3 !== $v) return $v;}, $ary);
        $expected = array(1, 2, null, 4, 5);
        $this->assertEquals($expected, $result);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function test_連想配列はlistで受け取れない(){
        list($one, $two) = array('foo' => 'bar');
    }

    public function test_foreachの参照はunsetしないと危険(){
        $ary = array(1, 2, 3);
        foreach($ary as &$item){
            ++$item;
        }
        $item = 0;
        $expected = array(2, 3, 0);
        $this->assertEquals($expected, $ary);

        $ary = array(1, 2, 3);
        foreach($ary as &$item){
            ++$item;
        }
        unset($item); // This is important.
        $item = 0;
        $expected = array(2, 3, 4);
        $this->assertEquals($expected, $ary);
    }
}
