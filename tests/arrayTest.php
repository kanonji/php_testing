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

    public function test_foreachは配列をコピーして無い(){
        $ary = array(1,2,3);

        $expected = array(
            array(
                'ary' => 'ary: (refcount=2, is_ref=0)=array (0 => (refcount=2, is_ref=0)=1, 1 => (refcount=1, is_ref=0)=2, 2 => (refcount=1, is_ref=0)=3)',
                'item' => 'item: (refcount=2, is_ref=0)=1',
            ),
            array(
                'ary' => 'ary: (refcount=2, is_ref=0)=array (0 => (refcount=1, is_ref=0)=1, 1 => (refcount=2, is_ref=0)=2, 2 => (refcount=1, is_ref=0)=3)',
                'item' => 'item: (refcount=2, is_ref=0)=2',
            ),
            array(
                'ary' => 'ary: (refcount=2, is_ref=0)=array (0 => (refcount=1, is_ref=0)=1, 1 => (refcount=1, is_ref=0)=2, 2 => (refcount=2, is_ref=0)=3)',
                'item' => 'item: (refcount=2, is_ref=0)=3',
            ),
        );
        foreach($ary as $key => $item){
            ob_start();
            xdebug_debug_zval('ary');
            $ob_ary = rtrim(ob_get_contents(), PHP_EOL);
            ob_end_clean();
            ob_start();
            xdebug_debug_zval('item');
            $ob_item = rtrim(ob_get_contents(), PHP_EOL);
            ob_end_clean();
            $this->assertEquals($expected[$key]['ary'], $ob_ary);
            $this->assertEquals($expected[$key]['item'], $ob_item);
        }

        $ary = array(1,2,3);
        $expected = array(
            array(
                'ary' => 'ary: (refcount=2, is_ref=1)=array (0 => (refcount=2, is_ref=1)=1, 1 => (refcount=1, is_ref=0)=2, 2 => (refcount=1, is_ref=0)=3)',
                'ref' => 'ref: (refcount=2, is_ref=1)=1',
            ),
            array(
                'ary' => 'ary: (refcount=2, is_ref=1)=array (0 => (refcount=1, is_ref=0)=1, 1 => (refcount=2, is_ref=1)=2, 2 => (refcount=1, is_ref=0)=3)',
                'ref' => 'ref: (refcount=2, is_ref=1)=2',
            ),
            array(
                'ary' => 'ary: (refcount=2, is_ref=1)=array (0 => (refcount=1, is_ref=0)=1, 1 => (refcount=1, is_ref=0)=2, 2 => (refcount=2, is_ref=1)=3)',
                'ref' => 'ref: (refcount=2, is_ref=1)=3',
            ),
        );
        foreach($ary as $key => &$ref){
            ob_start();
            xdebug_debug_zval('ary');
            $ob_ary = rtrim(ob_get_contents(), PHP_EOL);
            ob_end_clean();
            ob_start();
            xdebug_debug_zval('ref');
            $ob_ref = rtrim(ob_get_contents(), PHP_EOL);
            ob_end_clean();
            $this->assertEquals($expected[$key]['ary'], $ob_ary);
            $this->assertEquals($expected[$key]['ref'], $ob_ref);
        }
    }
}
