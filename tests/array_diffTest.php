<?php
class array_diffTest extends PHPUnit_Framework_TestCase{
    public function test_indexed_完全に同じ(){
        $one = array('A', 'B', 'C');
        $two = array('A', 'B', 'C');
        $this->assertEquals(array(), array_diff($one, $two));
    }

    public function test_indexed_順番が違うだけならdiffは出ない(){
        $one = array('A', 'B', 'C');
        $two = array('A', 'C', 'B');
        $this->assertEquals(array(), array_diff($one, $two));
    }

    public function test_indexed_異なる(){
        $one = array('A', 'B', 'C');
        $two = array('B', 'B', 'B');
        $this->assertEquals(array(0 => 'A', 2 => 'C'), array_diff($one, $two));
    }

    public function test_indexed_第2引数にある余分なDは結果に含まれ無い(){
        $one = array('A', 'B', 'C');
        $two = array('A', 'B', 'C', 'D');
        $this->assertEquals(array(), array_diff($one, $two));
    }

    public function test_indexed_あくまで第1引数に有って、第2引数に無いものがdiffになる(){
        $one = array('A', 'B', 'C');
        $two = array('A', 'B', 'D');
        $this->assertEquals(array(2 => 'C'), array_diff($one, $two));
    }

    public function test_assoc_完全に同じ(){
        $one = array('A' => '_A', 'B' => '_B', 'C' => '_C');
        $two = array('A' => '_A', 'B' => '_B', 'C' => '_C');
        $this->assertEquals(array(), array_diff($one, $two));
    }

    public function test_assoc_順番が違うだけならdiffは出ない(){
        $one = array('A' => '_A', 'B' => '_B', 'C' => '_C');
        $two = array('A' => '_A', 'C' => '_C', 'B' => '_B');
        $this->assertEquals(array(), array_diff($one, $two));
    }
}
