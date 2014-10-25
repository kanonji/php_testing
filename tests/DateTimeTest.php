<?php
class DateTimeTest extends PHPUnit_Framework_TestCase{

    public function test_DateTime：：diffのDateIntervalは少し特殊(){
        ini_set('date.timezone', 'Asia/Tokyo');
        $base = new DateTime('2013-01-15 22:00:00');
        $comparative = new DateTime('2013-01-16 01:00:00');
        $diffInterval = $base->diff($comparative);
        $interval = new DateInterval('P1DT1H');
        $this->assertNotEquals($interval, $diffInterval);
        if(
            version_compare(PHP_VERSION, '5.4.0', '<')
            || ( version_compare(PHP_VERSION, '5.4.0', '>=') && version_compare(PHP_VERSION, '5.4.29', '<=') )
            || ( version_compare(PHP_VERSION, '5.5.0', '>=') && version_compare(PHP_VERSION, '5.5.13', '<=') )
        ){
            $this->assertEquals(-99999, $interval->days); # I saw false on var_dump($interval);
        } else {
            $this->assertEquals(false, $interval->days); # I saw false on var_dump($interval);
        }
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

    public function test_date_parseは1文字の文字列でjを除くa〜zを渡してもエラーにならない(){
        $letters = array_merge(range('A','Z'), range('a','z'));
        foreach($letters as $ascii){
            $result = date_parse($ascii);
            if('j' === strtolower($ascii)){
                $this->assertEquals(1, $result['error_count']);
                $this->assertEquals(array('The timezone could not be found in the database'), $result['errors']);
                $this->assertEquals(0, $result['warning_count']);
                $this->assertEquals(array(), $result['warnings']);
            } else {
                $this->assertEquals(0, $result['error_count']);
                $this->assertEquals(array(), $result['errors']);
                $this->assertEquals(0, $result['warning_count']);
                $this->assertEquals(array(), $result['warnings']);
            }
        }
    }

    public function test_date_parseは3桁までの数字は全てエラーになる(){
        foreach(range(0, 999) as $num){
            $numbers[] = $num;
            $numbers[] = (string)$num;
        }
        foreach($numbers as $num){
            $result = date_parse($num);
            $count = strlen($num);
            $errorsExpected = array_fill(0, $count, 'Unexpected character');
            $this->assertEquals($count, $result['error_count']);
            $this->assertEquals($errorsExpected, $result['errors']);
            $this->assertEquals(0, $result['warning_count']);
            $this->assertEquals(array(), $result['warnings']);
        }
    }

    public function test_date_parseは4桁数字はほぼエラーにならない(){
        foreach(range(1000, 9999) as $num){
            $numbers[] = $num;
            $numbers[] = (string)$num;
        }
        foreach($numbers as $num){
            $result = date_parse($num);
            if (2400 <= $num && $num < 2460) {
                $this->assertEquals(0, $result['error_count']);
                $this->assertEquals(array(), $result['errors']);
                $this->assertEquals(1, $result['warning_count']);
                $this->assertEquals(array(5 => 'The parsed time was invalid'), $result['warnings']);
            } else {
                $this->assertEquals(0, $result['error_count']);
                $this->assertEquals(array(), $result['errors']);
                $this->assertEquals(0, $result['warning_count']);
                $this->assertEquals(array(), $result['warnings']);
            }
        }
    }
}
