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
class objectTest extends PHPUnit_Framework_TestCase{
	public function test_親クラスのメソッドを通じてオーバーライドしたメソッドを呼ぶ場合、privateなメソッドだけオーバーライド出来ない(){
		$bar = new Bar();
		$this->assertEquals('bar', $bar->getPublic());
		$this->assertEquals('bar', $bar->getProtected());
		$this->assertEquals('foo', $bar->getPrivate());
	}
}
