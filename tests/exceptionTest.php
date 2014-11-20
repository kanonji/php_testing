<?php
class ExceptionTest extends PHPUnit_Framework_TestCase{

    public function test_catchのスコープを区切っていない(){
        $one = 1;
        $result;
        try{
            throw new Exception();
        } catch(Exception $e){
            $result = $one;
        }
        $this->assertEquals(1, $result);
    }
}
