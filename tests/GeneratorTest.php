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

    public function test_1度でもnext（）を呼んだGeneratorはrewind（）出来ない(){
        if(function_exists('getGenerator')){
            $generator = getGenerator();
            $generator->rewind();
            $this->assertEquals(1, $generator->current());
            $generator->rewind();
            $generator->next();
            $this->assertEquals(2, $generator->current());
            try{
                $generator->rewind();
            } catch(Exception $e) {
            }
            $errorMessage = 'Cannot rewind a generator that was already run';
            $this->assertEquals($errorMessage, $e->getMessage());
        }
    }
}
