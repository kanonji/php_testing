<?php
trait FooTrait{
    public function fooPublic(){
        return get_class_methods(__trait__);
    }
    protected function fooProtected(){}
    private function fooPrivate(){}
    public static function staticPublic(){}
    protected static function staticProtected(){}
    private static function staticPrivate(){}
}
class FooTraitClass{
    use FooTrait;
}

trait BarTrait{
    public function get__class__(){
        return __class__;
    }

    public function get__trait__(){
        return __trait__;
    }
}
class BarTraitClass{
    use BarTrait;
}

class FooBarTraitClass{
    use FooTrait;
    use BarTrait;
}

class TraitTest extends PHPUnit_Framework_TestCase{
    public function test_get_class_methods（__trait__）はpublicメソッドのみ(){
        $result = (new FooTraitClass)->fooPublic();
        $expected = ['fooPublic', 'staticPublic'];
        $this->assertEquals($expected, $result);
    }

    public function test_そして、他のtraitの影響は受けない(){
        $result = (new FooTraitClass)->fooPublic();
        $expected = ['fooPublic', 'staticPublic'];
        $this->assertEquals($expected, $result);
    }

    public function test_空のクラスとクロージャーでtraitのメソッドだけを全部取得できる(){
        $closure = function(){
            return get_class_methods($this);
        };
        $obj = new FooTraitClass;
        $closure = $closure->bindTo($obj, $obj);
        $expected = [
            'fooPublic',
            'fooProtected',
            'fooPrivate',
            'staticPublic',
            'staticProtected',
            'staticPrivate',
        ];
        $this->assertEquals($expected, $closure());
    }

    public function test_そして、他のtraitのメソッドも含まれてしまう(){
        $closure = function(){
            return get_class_methods($this);
        };
        $obj = new FooBarTraitClass;
        $closure = $closure->bindTo($obj, $obj);
        $expected = [
            'fooPublic',
            'fooProtected',
            'fooPrivate',
            'staticPublic',
            'staticProtected',
            'staticPrivate',
            'get__class__',
            'get__trait__',
        ];
        $this->assertEquals($expected, $closure());
    }

    public function test_定数__class__はtrait内に書いてもクラス名を返す(){
        $obj = new BarTraitClass;
        $this->assertEquals('BarTraitClass', $obj->get__class__());
        $this->assertEquals('BarTrait', $obj->get__trait__());
    }
}
