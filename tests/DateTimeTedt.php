<?php
class DateTimeTest extends PHPUnit_Framework_TestCase{
	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage DateTime::__construct(): It is not safe to rely on the system's timezone settings. 
	 */
	public function test_Expect_Exception_with_no_timezone_set(){
		$this->assertTrue(false !== ini_set('date.timezone', null));
		new DateTime();
	}
}
