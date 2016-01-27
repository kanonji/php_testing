<?php
class FunctionTest extends PHPUnit_Framework_TestCase{
    public function test_明示的にnullを渡すと引数のデフォルト値は使用されない(){
        $outerFunction = function($bar = null) {
            $innerFunction = function($foo = 'foo'){
                $this->assertEquals(null, $foo);
            };
            $innerFunction($bar);
        };
        $outerFunction();
    }
}
