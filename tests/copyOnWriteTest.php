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

    public function test_配列のコピーオンライトは要素毎に行われる(){
        echo PHP_EOL;
        $one = array('target' => 'AAAAAAA', 'foo' => 'FOO');

        ob_start();
            xdebug_debug_zval('one');
            $ob_one = rtrim(ob_get_contents(), PHP_EOL);
        ob_end_clean();

        $expected = "one: (refcount=1, is_ref=0)=array ('target' => (refcount=1, is_ref=0)='AAAAAAA', 'foo' => (refcount=1, is_ref=0)='FOO')";
        $this->assertEquals($expected, $ob_one);


        //単純にコピーしてみる
        $two = $one;

        ob_start();
            xdebug_debug_zval('one');
            $ob_one = rtrim(ob_get_contents(), PHP_EOL);
        ob_end_clean();

        ob_start();
            xdebug_debug_zval('two');
            $ob_two = rtrim(ob_get_contents(), PHP_EOL);
        ob_end_clean();

        $expected_one = "one: (refcount=2, is_ref=0)=array ('target' => (refcount=1, is_ref=0)='AAAAAAA', 'foo' => (refcount=1, is_ref=0)='FOO')";
        $expected_two = "two: (refcount=2, is_ref=0)=array ('target' => (refcount=1, is_ref=0)='AAAAAAA', 'foo' => (refcount=1, is_ref=0)='FOO')";
        $this->assertEquals($expected_one, $ob_one);
        $this->assertEquals($expected_two, $ob_two);


        //片方の要素を変更してみる
        $one['target'] = 'changed';

        ob_start();
            xdebug_debug_zval('one');
            $ob_one = rtrim(ob_get_contents(), PHP_EOL);
        ob_end_clean();

        ob_start();
            xdebug_debug_zval('two');
            $ob_two = rtrim(ob_get_contents(), PHP_EOL);
        ob_end_clean();

        $expected_one = "one: (refcount=1, is_ref=0)=array ('target' => (refcount=1, is_ref=0)='changed', 'foo' => (refcount=2, is_ref=0)='FOO')";
        $expected_two = "two: (refcount=1, is_ref=0)=array ('target' => (refcount=1, is_ref=0)='AAAAAAA', 'foo' => (refcount=2, is_ref=0)='FOO')";
        $this->assertEquals($expected_one, $ob_one);
        $this->assertEquals($expected_two, $ob_two);

        //単純にコピーした後、2次元目の要素を変更してみる
        $one = array('foo' => 'FOO', 'bar' => array('target' => 'BBBBBBB', 'baz' => 'BAZ'));
        $two = $one;
        $one['bar']['target'] = 'changed';

        ob_start();
            xdebug_debug_zval('one');
            $ob_one = rtrim(ob_get_contents(), PHP_EOL);
        ob_end_clean();

        ob_start();
            xdebug_debug_zval('two');
            $ob_two = rtrim(ob_get_contents(), PHP_EOL);
        ob_end_clean();

        $expected_one = "one: (refcount=1, is_ref=0)=array ('foo' => (refcount=2, is_ref=0)='FOO', 'bar' => (refcount=1, is_ref=0)=array ('target' => (refcount=1, is_ref=0)='changed', 'baz' => (refcount=2, is_ref=0)='BAZ'))";
        $expected_two = "two: (refcount=1, is_ref=0)=array ('foo' => (refcount=2, is_ref=0)='FOO', 'bar' => (refcount=1, is_ref=0)=array ('target' => (refcount=1, is_ref=0)='BBBBBBB', 'baz' => (refcount=2, is_ref=0)='BAZ'))";
        $this->assertEquals($expected_one, $ob_one);
        $this->assertEquals($expected_two, $ob_two);
    }
}
