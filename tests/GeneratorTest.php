<?php
class GeneratorTest extends PHPUnit_Framework_TestCase{
    public function test_Generator_is_Traversable(){
        if(version_compare(PHP_VERSION, '5.5.0', '>=')){
             eval('$generator = current([function(){
                yield 1;
                yield 2;
                yield 3;
            }])->__invoke();');
            $this->assertTrue($generator instanceof Traversable);
        }
    }
}
