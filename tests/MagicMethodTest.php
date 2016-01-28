<?php
class MagicMethod extends PHPUnit_Framework_TestCase{
    private $counter = 0;

    public function __get($key){
        return $this->foo();
    }

    private function foo(){
        if($this->counter < 2){
            ++$this->counter;
            return $this->foo;
        }
        return false;
    }

    public function test_MagicMethodの__get（）が複数回呼ばれるようなプロパティアクセスは、無限ループじゃなくてもUndefined　Propertyとなる(){
        try {
            $this->foo;
        } catch(Exception $e) {
        }
        $this->assertEquals('Undefined property: MagicMethod::$foo', $e->getMessage());
        $this->assertEquals(8, $e->getCode());
        $this->assertEquals(1, $this->counter);
    }
}
