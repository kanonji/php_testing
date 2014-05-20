<?php
class copyOnWriteTest extends PHPUnit_Framework_TestCase{
    public function test_arrayの場合、要素に変更が有ればコピーされる(){
        $ary = array('foo' => 'bar');
        $expected = array('foo' => 'bar');
        $copied = $ary;
        $copied['foo'] = 'BAR';

        $this->assertEquals($expected, $ary);
    }

    public function test_objectの場合、プロパティへの変更ではまだコピーされない（同じデータを参照した状態のまま）(){
        $obj = new stdclass;
        $obj->foo = 'bar';
        $copied = $obj;
        $copied->foo = 'BAR';
        $this->assertEquals('BAR', $obj->foo);

        $copied = 'baz';
        $this->assertEquals('BAR', $obj->foo);
    }
}
