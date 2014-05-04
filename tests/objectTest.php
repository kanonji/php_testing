<?php
class Foo{
    public function getPublic(){
        return $this->publicAnswer();
    }
    public function getProtected(){
        return $this->protectedAnswer();
    }
    public function getPrivate(){
        return $this->privateAnswer();
    }
    public function publicAnswer(){
        return 'foo';
    }
    protected function protectedAnswer(){
        return 'foo';
    }
    private function privateAnswer(){
        return 'foo';
    }
}
class Bar extends Foo{
    public function publicAnswer(){
        return 'bar';
    }
    protected function protectedAnswer(){
        return 'bar';
    }
    private function privateAnswer(){
        return 'bar';
    }
}
class Baz extends Foo{
    public function publicAnswer(){
        return 'baz';
    }
    public function protectedAnswer(){
        return 'baz';
    }
    public function privateAnswer(){
        return 'baz';
    }
}

class ConstFoo{
    const FOO = 'foo';
}
class ConstBar{
    const BAR = ConstFoo::FOO;
}

class objectTest extends PHPUnit_Framework_TestCase{
    public function test_親クラスのメソッドを通じてオーバーライドしたメソッドを呼ぶ場合、privateなメソッドだけオーバーライド出来ない(){
        $bar = new Bar();
        $this->assertEquals('bar', $bar->getPublic());
        $this->assertEquals('bar', $bar->getProtected());
        $this->assertEquals('foo', $bar->getPrivate());
    }

    public function test_privateメソッドをpublicでオーバーライドは出来ないが、オーバーロードっぽい事は出来る(){
        $baz = new Baz();
        $this->assertEquals('baz', $baz->getPublic());
        $this->assertEquals('baz', $baz->getProtected());
        $this->assertEquals('foo', $baz->getPrivate());
        $this->assertEquals('baz', $baz->privateAnswer());
    }

    public function test_コンストの値に他のコンストを使える(){
        $this->assertEquals('foo', ConstBar::BAR);
    }
}
