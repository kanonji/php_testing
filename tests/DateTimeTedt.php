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

	public function test_DateTime：：diffのDateIntervalは少し特殊(){
		ini_set('date.timezone', 'Asia/Tokyo');
		$base = new DateTime('2013-01-15 22:00:00');
		$comparative = new DateTime('2013-01-16 01:00:00');
		$diffInterval = $base->diff($comparative);
		$interval = new DateInterval('P1DT1H');
		$this->assertNotEquals($interval, $diffInterval);
		$this->assertEquals(-99999, $interval->days); # I saw false on var_dump($interval);
		$this->assertEquals(0, $diffInterval->days);
	}

	public function test_DateTime：：diffのDateIntervalのformatのdとa(){
		ini_set('date.timezone', 'Asia/Tokyo');
		$base = new DateTime('2013-01-15 01:00:00');
		$comparative = new DateTime('2013-02-16 02:00:00');
		$diffInterval = $base->diff($comparative);
		$interval = new DateInterval('P1M1DT1H');
		$this->assertEquals(32, $diffInterval->days);
		$this->assertEquals('d: 1, a: 32', $diffInterval->format('d: %d, a: %a') );
		$this->assertEquals('d: 1, a: (unknown)', $interval->format('d: %d, a: %a') );
	}

	public function test_DateIntervalで24H未満は1日と扱われない(){
		ini_set('date.timezone', 'Asia/Tokyo');
		$base = new DateTime('2013-01-15 22:00:00');
		$comparative = new DateTime('2013-01-16 01:00:00');
		$interval = $base->diff($comparative);
		$this->assertEquals('0 days', $interval->format('%d days'));
		$comparative = new DateTime('2013-01-16 22:00:00');
		$interval = $base->diff($comparative);
		$this->assertEquals('1 days', $interval->format('%d days'));
	}
}
