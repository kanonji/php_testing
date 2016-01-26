<?php
if(version_compare(PHP_VERSION, '5.5.0', '>=')){
     eval('function getGenerator(){
        yield 1;
        yield 2;
        yield 3;
    }');
}

class GeneratorTest extends PHPUnit_Framework_TestCase{
    public function test_Generator_is_Traversable(){
        if(function_exists('getGenerator')){
            $generator = getGenerator();
            $this->assertTrue($generator instanceof Traversable);
        }
    }

    public function test_Generator_is_Iterator(){
        if(function_exists('getGenerator')){
            $generator = getGenerator();
            $this->assertTrue($generator instanceof Iterator);
        }
    }
}
