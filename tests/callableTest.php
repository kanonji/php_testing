<?php
class callableTest extends PHPUnit_Framework_TestCase{

    public function test_callableからspl_object_hashでハッシュIdを生成出来る() {
        $callable = function(){ return true; };
        $objectHashId = spl_object_hash((object)$callable);

        $this->assertEquals(true, is_string($objectHashId));
        $this->assertEquals(true, $objectHashId === spl_object_hash((object)$callable));
    }

    public function test定義の異なるcallableから得たハッシュIdは異なる() {
        $callableA = function(){ return true; };
        $callableB = function(){ return false; };
        $objectHashIdA = spl_object_hash((object)$callableA);
        $objectHashIdB = spl_object_hash((object)$callableB);

        $this->assertEquals(false, $objectHashIdA === $objectHashIdB);
    }

    public function test同じ定義のcallableでも生成が別ならハッシュIdは異なる() {
        $callableA = function(){ return true; };
        $callableAA = function(){ return true; };
        $objectHashIdA = spl_object_hash((object)$callableA);
        $objectHashIdAA = spl_object_hash((object)$callableAA);

        $this->assertEquals(false, $objectHashIdA === $objectHashIdAA);
    }
}
