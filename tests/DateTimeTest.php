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

    public function test_0000ー00ー00_00：00：00はdate_parseでエラーにならない(){
        $date1 = new DateTime('0000-00-00'); #コンストラクタはdate_parse()と同じ
        $date2 = new DateTime('0000-00-00 00:00:00');

        $this->assertEquals('-0001-11-30 00:00:00', $date1->format('Y-m-d H:i:s'));
        $this->assertEquals('-0001-11-30 00:00:00', $date2->format('Y-m-d H:i:s'));
    }

    public function test_空文字列、null、falseは引数無しと同様に現時刻(){
        $today = new DateTime();
        $today = $today->format('Y-m-d H:i');

        $date1 = new DateTime('');
        $date2 = new DateTime(null);
        $date3 = new DateTime(false);

        $this->assertEquals($today, $date1->format('Y-m-d H:i'));
        $this->assertEquals($today, $date2->format('Y-m-d H:i'));
        $this->assertEquals($today, $date3->format('Y-m-d H:i'));
    }

    public function test_trueはdate_parseで例外(){
        try{
            $date1 = new DateTime(true);
        } catch(Exception $e){
            $message = $e->getMessage();
        }
        $expected = 'DateTime::__construct(): Failed to parse time string (1) at position 0 (1): Unexpected character';
        $this->assertEquals($expected, $message);
    }
}
