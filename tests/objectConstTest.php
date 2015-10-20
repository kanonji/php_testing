<?php
class ConstParent{
    const FOO = 'parent';

    public function getBySelf(){
        return self::FOO;
    }
    public function getByStatic(){
        return static::FOO;
    }
    public static function staticGetBySelf(){
        return self::FOO;
    }
    public static function staticGetByStatic(){
        return static::FOO;
    }

    public function getByParent(){
        // return parent::FOO; // PHP Fatal error:  Cannot access parent:: when current class scope has no parent
    }
    public static function staticGetByParent(){
        // return parent::FOO; // PHP Fatal error:  Cannot access parent:: when current class scope has no parent
    }
}
class ConstChild extends ConstParent{
    const FOO = 'child';

    public function getBySelfChild(){
        return self::FOO;
    }
    public function getByStaticChild(){
        return static::FOO;
    }
    public static function staticGetBySelfChild(){
        return self::FOO;
    }
    public static function staticGetByStaticChild(){
        return static::FOO;
    }

    public function getByParentChild(){
        return parent::FOO;
    }
    public static function staticGetByParentChild(){
        return parent::FOO;
    }
}

class objectConstTest extends PHPUnit_Framework_TestCase{
    public function test_親クラスのインスタンスで親クラスに書いたselfとstaticは同じ動き(){
        $parent = new ConstParent;
        $this->assertEquals('parent', $parent->getBySelf());
        $this->assertEquals('parent', $parent->getByStatic());
        $this->assertEquals('parent', ConstParent::staticGetBySelf());
        $this->assertEquals('parent', ConstParent::staticGetByStatic());
    }

    /**
     * いわゆる遅延静的束縛
     * @see http://www.php.net/manual/ja/language.oop5.late-static-bindings.php
     */
    public function test_子クラスのインスタンスで親クラスに書いたstaticは子クラスを指す(){
        $child = new ConstChild;
        $this->assertEquals('parent', $child->getBySelf());
        $this->assertEquals('child', $child->getByStatic());
        $this->assertEquals('parent', ConstChild::staticGetBySelf());
        $this->assertEquals('child', ConstChild::staticGetByStatic());
    }

    public function test_子クラスのインスタンスで子クラスに書いたselfとstaticはどちらも子クラスを指す(){
        $child = new ConstChild;
        $this->assertEquals('child', $child->getBySelfChild());
        $this->assertEquals('child', $child->getByStaticChild());
        $this->assertEquals('child', ConstChild::staticGetBySelfChild());
        $this->assertEquals('child', ConstChild::staticGetByStaticChild());
    }

    public function test_parentなら必ず親クラスのコンストにアクセスできる(){
        $child = new ConstChild;
        $this->assertEquals('parent', $child->getByParentChild());
        $this->assertEquals('parent', ConstChild::staticGetByParentChild());
    }
}
