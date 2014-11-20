<?php
class StaticTestClass{
    public static function publicMethod(){
        $instance = new self();
        return $instance->privateMethod();
    }
    private function privateMethod(){
        return 'private method called.';
    }
}

class StaticTest extends PHPUnit_Framework_TestCase{

    public function test_staticメソッド内で自身をnewしてprivateなインスタンスメソッドが呼べる(){
        $result = StaticTestClass::publicMethod();
        $this->assertEquals('private method called.', $result);
    }
}
