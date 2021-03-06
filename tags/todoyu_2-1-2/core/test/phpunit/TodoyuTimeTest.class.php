<?php
/****************************************************************************
* todoyu is published under the BSD License:
* http://www.opensource.org/licenses/bsd-license.php
*
* Copyright (c) 2011, snowflake productions GmbH, Switzerland
* All rights reserved.
*
* This script is part of the todoyu project.
* The todoyu project is free software; you can redistribute it and/or modify
* it under the terms of the BSD License.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the BSD License
* for more details.
*
* This copyright notice MUST APPEAR in all copies of the script.
*****************************************************************************/

/**
 * Test for: TodoyuTime
 *
 * @package		Todoyu
 * @subpackage	Core
 */
class TodoyuTimeTest extends PHPUnit_Framework_TestCase {

	protected $timezone;



	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		$this->timezone = Todoyu::getTimezone();

		Todoyu::setTimezone('UTC');
	}



	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown() {
		Todoyu::setTimezone($this->timezone);
	}



	/**
	 * Test getStartOfDay
	 */
	public function testGetStartOfDay() {
		$timeAfternoon	= gmmktime(14, 0, 0, 1, 1, 2010);
		$timeDaystart	= gmmktime(0, 0, 0, 1, 1, 2010);

		$result1	= TodoyuTime::getStartOfDay($timeAfternoon);
		$result2	= TodoyuTime::getStartOfDay($timeDaystart);

		$this->assertEquals($timeDaystart, $result1);
		$this->assertEquals($result1, $result2);
	}



	/**
	 * Test getEndOfDay
	 */
	public function testGetEndOfDay() {
		$time		= gmmktime(14, 0, 0, 1, 1, 2010);
		$testDayend	= gmmktime(23, 59, 59, 1, 1, 2010);

		$timeEnd1	= TodoyuTime::getEndOfDay($time);
		$timeEnd2	= TodoyuTime::getEndOfDay($testDayend);

		$this->assertEquals($testDayend, $timeEnd1);
		$this->assertEquals($testDayend, $timeEnd2);
	}



	/**
	 * Test getDayRange
	 */
	public function testGetDayRange() {
		$time		= gmmktime(14, 33, 59, 8, 3, 2010);
		$testStart	= gmmktime(0, 0, 0, 8, 3, 2010);
		$testEnd	= gmmktime(23, 59, 59, 8, 3, 2010);
		$range		= TodoyuTime::getDayRange($time);

		$this->assertEquals($testStart, $range['start']);
		$this->assertEquals($testEnd, $range['end']);
	}



	/**
	 * Test getWeekRange
	 */
	public function testGetWeekRange() {
		$time		= gmmktime(14, 33, 59, 8, 3, 2010);
		$testStart	= gmmktime(0, 0, 0, 8, 2, 2010);
		$testEnd	= gmmktime(23, 59, 59, 8, 8, 2010);
		$range		= TodoyuTime::getWeekRange($time);

		$this->assertEquals($testStart, $range['start']);
		$this->assertEquals($testEnd, $range['end']);
	}



	/**
	 * Test getMonthRange
	 */
	public function testGetMonthRange() {
		$time		= gmmktime(14, 33, 59, 8, 3, 2010);
		$testStart	= gmmktime(0, 0, 0, 8, 1, 2010);
		$testEnd	= gmmktime(23, 59, 59, 8, 31, 2010);
		$range		= TodoyuTime::getMonthRange($time);

		$this->assertEquals($testStart, $range['start']);
		$this->assertEquals($testEnd, $range['end']);
	}



	/**
	 * Test getWeekStart
	 */
	public function testGetWeekStart() {
		$time		= gmmktime(14, 33, 59, 8, 3, 2010);
		$testStart	= gmmktime(0, 0, 0, 8, 2, 2010);
		$weekStart	= TodoyuTime::getWeekStart($time);

		$this->assertEquals($testStart, $weekStart);
	}



	/**
	 * Test getMonthStart
	 */
	public function testGetMonthStart() {
		$time		= gmmktime(14, 33, 59, 8, 3, 2010);
		$testStart	= gmmktime(0, 0, 0, 8, 1, 2010);
		$monthStart	= TodoyuTime::getMonthStart($time);

		$this->assertEquals($testStart, $monthStart);
	}



	/**
	 * Test getWeekday
	 */
	public function testGetWeekday() {
		$time		= gmmktime(14, 33, 59, 8, 3, 2010);
		$testWeekday= 1;
		$weekday	= TodoyuTime::getWeekday($time);

		$this->assertEquals($testWeekday, $weekday);
	}



	/**
	 * Test getTimeParts
	 */
	public function testGetTimeParts() {
		$time		= (14 * 3600) + (33 * 60) + (59); // 14:33:59
		$testHours	= 14;
		$testMinutes= 33;
		$testSeconds= 59;

		$timeParts	= TodoyuTime::getTimeParts($time);

		$this->assertEquals($testHours, $timeParts['hours']);
		$this->assertEquals($testMinutes, $timeParts['minutes']);
		$this->assertEquals($testSeconds, $timeParts['seconds']);
	}



	/**
	 * Test firstHourLeftOver
	 */
	public function testFirstHourLeftOver() {
		$testHours1	= 1.0;
		$testHours2	= 0.0;
		$testHours3	= 0.7;

		$hours1	= TodoyuTime::firstHourLeftOver(2.5);
		$hours2	= TodoyuTime::firstHourLeftOver(-0.5);
		$hours3	= TodoyuTime::firstHourLeftOver(0.7);

		$this->assertEquals($testHours1, $hours1);
		$this->assertEquals($testHours2, $hours2);
		$this->assertEquals($testHours3, $hours3);
	}



	/**
	 * Test sec2hour
	 */
	public function testSec2hour() {
		$seconds1	= (14 * 3600) + (33 * 60) + (29); // 14:33:29
		$seconds2	= (14 * 3600) + (33 * 60) + (31); // 14:33:31
		$testString1= '14:33';
		$testString2= '14:34';

		$timeString1	= TodoyuTime::sec2hour($seconds1);
		$timeString2	= TodoyuTime::sec2hour($seconds2);

		$this->assertEquals($testString1, $timeString1);
		$this->assertEquals($testString2, $timeString2);
	}



	/**
	 * Test formatTime
	 */
	public function testFormatTime() {
		$seconds	= 18 * 3600 + 24 * 60 + 35;
		$testString1= '18:24:35';
		$testString2= '18:25';
		$testString3= '18:24';

		$timeString1= TodoyuTime::formatTime($seconds, true);
		$timeString2= TodoyuTime::formatTime($seconds, false);
		$timeString3= TodoyuTime::formatTime($seconds, false, false);

		$this->assertEquals($testString1, $timeString1);
		$this->assertEquals($testString2, $timeString2);
		$this->assertEquals($testString3, $timeString3);
	}



	/**
	 * Test format
	 */
	public function testFormat() {
		$currentLocale	= Todoyu::getLocale();

		Todoyu::setLocale('en_GB');

		$time	= gmmktime(14, 36, 5, 3, 9, 1984);

		$formattedEN= TodoyuTime::format($time, 'datetime');
		$expectedEN	= '09/03/84 14:36';

		$this->assertEquals($expectedEN, $formattedEN);


		Todoyu::setLocale('de_DE');

		$formattedDE= TodoyuTime::format($time, 'datetime');
		$expectedDE	= '09.03.1984 14:36';

		$this->assertEquals($expectedDE, $formattedDE);

		Todoyu::setLocale($currentLocale);
	}



	/**
	 * Test getFormat
	 */
	public function testGetFormat() {
		$currentLocale	= Todoyu::getLocale();

			// Test with german locale
		Todoyu::setLocale('de_DE');

		$format		= TodoyuTime::getFormat('DshortD2MlongY4');
		$expected	= '%a, %d. %B %Y';

		$this->assertEquals($expected, $format);


		$result		= TodoyuTime::getFormat('notavailableformatstring');
		$expected	= 'core.dateformat.notavailableformatstring';
		$this->assertEquals($expected, $result);

			// Restore settings
		Todoyu::setLocale($currentLocale);
	}



	/**
	 * Test parseDateString
	 */
	public function testParseDateString() {
		$time	= gmmktime(13, 46, 0, 4, 19, 2016);
		$date1	= date('r', $time);
		$date2	= date('Y-m-d H:i:s', $time);
		$date3	= TodoyuTime::format($time, 'datetime');

		$time1	= TodoyuTime::parseDateString($date1);
		$time2	= TodoyuTime::parseDateString($date2);
		$time3	= TodoyuTime::parseDateString($date3);

		$this->assertEquals($time, $time1);
		$this->assertEquals($time, $time2);
		$this->assertEquals($time, $time3);
	}



	/**
	 * Test parseDate
	 */
	public function testParseDate() {
		$oldLocale		= TodoyuLabelManager::getLocale();
		$dateCompare	= strtotime('2010-03-22');

		TodoyuLabelManager::setLocale('en_US');
		$dateString1	= '3/22/2010';
		$dateTime1		= TodoyuTime::parseDate($dateString1);

		TodoyuLabelManager::setLocale('en_GB');
		$dateString2	= '22/3/2010';
		$dateTime2		= TodoyuTime::parseDate($dateString2);

		TodoyuLabelManager::setLocale('de_DE');
		$dateString3	= '22.3.2010';
		$dateTime3		= TodoyuTime::parseDate($dateString3);

		TodoyuLabelManager::setLocale('pt_BR');
		$dateString4	= '22.3.2010';
		$dateTime4		= TodoyuTime::parseDate($dateString4);


		$this->assertEquals($dateCompare, $dateTime1);
		$this->assertEquals($dateCompare, $dateTime2);
		$this->assertEquals($dateCompare, $dateTime3);
		$this->assertEquals($dateCompare, $dateTime4);

		TodoyuLabelManager::setLocale($oldLocale);
	}



	/**
	 * Test parseDateTime
	 */
	public function testParseDateTime() {
		$dateCompare	= strtotime('2010-03-22 14:36');

		$oldLocale		= TodoyuLabelManager::getLocale();

		Todoyu::setLocale('de_DE');
		$dateStringDE	= '22.03.2010 14:36';
		$timeDE			= TodoyuTime::parseDateTime($dateStringDE);

		$this->assertEquals($dateCompare, $timeDE);

		TodoyuLabelManager::setLocale($oldLocale);
	}



	/**
	 * Test parseTime
	 */
	public function testParseTime() {
		$time_1	= '23:59';
		$sec_1	= 86340;
		$time_2	= '23:59:30';
		$sec_2	= 86370;
		$time_3	= '0:00:01';
		$sec_3	= 1;

		$res_1	= TodoyuTime::parseTime($time_1);
		$res_2	= TodoyuTime::parseTime($time_2);
		$res_3	= TodoyuTime::parseTime($time_3);

		$this->assertEquals($sec_1, $res_1);
		$this->assertEquals($sec_2, $res_2);
		$this->assertEquals($sec_3, $res_3);
	}



	/**
	 * Test parseDuration
	 */
	public function testParseDuration() {
		$dur_1	= '3:00';
		$sec_1	= 10800;
		$dur_2	= '0:00';
		$sec_2	= 0;
		$dur_3	= '1:';
		$sec_3	= 3600;
		$dur_4	= '100:00';
		$sec_4	= 360000;
		$dur_5	= ':59';
		$sec_5	= 3540;
		$dur_6	= '0:67';
		$sec_6	= 4020; // 1:07

		$res_1	= TodoyuTime::parseDuration($dur_1);
		$res_2	= TodoyuTime::parseDuration($dur_2);
		$res_3	= TodoyuTime::parseDuration($dur_3);
		$res_4	= TodoyuTime::parseDuration($dur_4);
		$res_5	= TodoyuTime::parseDuration($dur_5);
		$res_6	= TodoyuTime::parseDuration($dur_6);

		$this->assertEquals($sec_1, $res_1);
		$this->assertEquals($sec_2, $res_2);
		$this->assertEquals($sec_3, $res_3);
		$this->assertEquals($sec_4, $res_4);
		$this->assertEquals($sec_5, $res_5);
		$this->assertEquals($sec_6, $res_6);
	}



	/**
	 * Test getRoundedTime
	 */
	public function testGetRoundedTime() {
		$time	= 10 * 3600 + 33 * 60 + 31; // 10:33:31
		$test1	= 10 * 3600 + 35 * 60 + 0; // 10:35:00
		$test2	= 10 * 3600 + 30 * 60 + 0; // 10:30:00
		$test3	= 10 * 3600 + 40 * 60 + 0; // 10:40:00
		$test4	= 11 * 3600 + 0 + 0; // 11:00:00
		$test5	= 10 * 3600 + 33 * 60 + 0; // 10:33:00

		$rounded1	= TodoyuTime::getRoundedTime($time);
		$rounded2	= TodoyuTime::getRoundedTime($time, 5);
		$rounded3	= TodoyuTime::getRoundedTime($time, 10);
		$rounded4	= TodoyuTime::getRoundedTime($time, 15);
		$rounded5	= TodoyuTime::getRoundedTime($time, 20);
		$rounded6	= TodoyuTime::getRoundedTime($time, 30);
		$rounded7	= TodoyuTime::getRoundedTime($time, 60);
		$rounded8	= TodoyuTime::getRoundedTime($time, 1);

		$this->assertEquals($test1, $rounded1);
		$this->assertEquals($test1, $rounded2);
		$this->assertEquals($test2, $rounded3);
		$this->assertEquals($test2, $rounded4);
		$this->assertEquals($test3, $rounded5);
		$this->assertEquals($test2, $rounded6);
		$this->assertEquals($test4, $rounded7);
		$this->assertEquals($test5, $rounded8);
	}



	/**
	 * Check week timestamps
	 * Force UTC to test
	 */
	public function testGetTimestampsForWeekdays() {
		$expectedTimestamps = array(
			gmmktime(0,0,0,6,7,2010),	// 07.06.2010 00:00
			gmmktime(0,0,0,6,8,2010),	// 08.06.2010 00:00
			gmmktime(0,0,0,6,9,2010),	// 09.06.2010 00:00
			gmmktime(0,0,0,6,10,2010),	// 10.06.2010 00:00
			gmmktime(0,0,0,6,11,2010),	// 11.06.2010 00:00
			gmmktime(0,0,0,6,12,2010),	// 12.06.2010 00:00
			gmmktime(0,0,0,6,13,2010)	// 13.06.2010 00:00
		);

		$timestamps	= TodoyuTime::getTimestampsForWeekdays($expectedTimestamps[2]);

		$this->assertEquals($expectedTimestamps, $timestamps);
	}



	/**
	 * Test getDaysInMonth
	 */
	public function testGetDaysInMonth() {
		$timeJune2010	= gmmktime(0, 0, 0, 6, 1, 2010);
		$timeFeb2010	= gmmktime(0, 0, 0, 2, 1, 2010);

		$resDaysJune2010	= TodoyuTime::getDaysInMonth($timeJune2010);
		$resDaysFeb2010		= TodoyuTime::getDaysInMonth($timeFeb2010);
		$resDaysJan2010		= TodoyuTime::getDaysInMonth($timeFeb2010, -1);
		$resDaysMarch2010	= TodoyuTime::getDaysInMonth($timeFeb2010, 1);
		$resDaysApril2010	= TodoyuTime::getDaysInMonth($timeFeb2010, 2);
		$resDaysFeb2012		= TodoyuTime::getDaysInMonth($timeFeb2010, 24);

		$this->assertEquals($resDaysJune2010, 30);
		$this->assertEquals($resDaysFeb2010, 28);
		$this->assertEquals($resDaysJan2010, 31);
		$this->assertEquals($resDaysMarch2010, 31);
		$this->assertEquals($resDaysApril2010, 30);
		$this->assertEquals($resDaysFeb2012, 29);
	}



	/**
	 * Test rangeOverlaps
	 */
	public function testRangeOverlaps() {
		$date1	= strtotime('2010-01-01 08:00:00');
		$date2	= strtotime('2010-01-01 10:00:00');
		$date3	= strtotime('2010-03-05 08:00:00');
		$date4	= strtotime('2010-05-25 02:00:00');
		$date5	= strtotime('2010-08-13 14:00:00');
		$date6	= strtotime('2011-01-01 12:00:00');

		$overlaps1	= TodoyuTime::rangeOverlaps($date1, $date2, $date3, $date4);
		$overlaps2	= TodoyuTime::rangeOverlaps($date1, $date3, $date2, $date4);
		$overlaps3	= TodoyuTime::rangeOverlaps($date1, $date6, $date3, $date4);
		$overlaps4	= TodoyuTime::rangeOverlaps($date1, $date6, $date5, $date6);
		$overlaps5	= TodoyuTime::rangeOverlaps($date1, $date3, $date3, $date6);

		$this->assertFalse($overlaps1);
		$this->assertTrue($overlaps2);
		$this->assertTrue($overlaps3);
		$this->assertTrue($overlaps4);
		$this->assertFalse($overlaps5);
	}



	/**
	 * Test getWeekend
	 */
	public function testGetWeekend() {
		$date1		= mktime(0, 0, 0, 3, 16, 2011);
		$weekend1	= mktime(23, 59, 59, 3, 20, 2011);
		$test1		= TodoyuTime::getWeekEnd($date1);

		$date2		= mktime(0, 0, 0, 2, 29, 2024);
		$weekend2	= mktime(23, 59, 59, 3, 3, 2024);
		$test2		= TodoyuTime::getWeekEnd($date2);

		$date3		= mktime(0, 0, 0, 12, 31, 1984);
		$weekend3	= mktime(23, 59, 59, 1, 6, 1985);
		$test3		= TodoyuTime::getWeekEnd($date3);

		$this->assertEquals($weekend1, $test1);
		$this->assertEquals($weekend2, $test2);
		$this->assertEquals($weekend3, $test3);
	}



	/**
	 * Test getMonthEnd
	 */
	public function testGetMonthEnd() {
		$test1	= mktime(0, 0, 0, 3, 1, 2011);
		$expect1= mktime(0, 0, 0, 4, 1, 2011)-1;
		$test2	= mktime(0, 0, 0, 2, 10, 2011);
		$expect2= mktime(0, 0, 0, 3, 1, 2011)-1;
		$test3	= mktime(23, 59, 59, 5, 31, 2011);
		$expect3= mktime(0, 0, 0, 6, 1, 2011)-1;

		$result1= TodoyuTime::getMonthEnd($test1);
		$result2= TodoyuTime::getMonthEnd($test2);
		$result3= TodoyuTime::getMonthEnd($test3);

		$this->assertEquals($expect1, $result1);
		$this->assertEquals($expect2, $result2);
		$this->assertEquals($expect3, $result3);
	}



	/**
	 * Test getLastDayNumberInMonth
	 */
	public function testGetLastDayNumberInMonth() {
		$test1	= mktime(0, 0, 0, 3, 10, 2011);
		$expect1= 31;
		$result1= TodoyuTime::getLastDayNumberInMonth($test1);
		$this->assertEquals($expect1, $result1);

		$test2	= mktime(0, 0, 0, 4, 10, 2011);
		$expect2= 30;
		$result2= TodoyuTime::getLastDayNumberInMonth($test2);
		$this->assertEquals($expect2, $result2);

		$test3	= mktime(0, 0, 0, 2, 10, 2011);
		$expect3= 28;
		$result3= TodoyuTime::getLastDayNumberInMonth($test3);
		$this->assertEquals($expect3, $result3);
	}



	/**
	 * Test addDays
	 */
	public function testAddDays() {
		$date		= mktime(0, 0, 0, 3, 18, 2011);
		$expect1	= mktime(0, 0, 0, 3, 19, 2011);
		$expect2	= mktime(0, 0, 0, 3, 20, 2011);
		$expect5	= mktime(0, 0, 0, 3, 23, 2011);
		$expect10	= mktime(0, 0, 0, 3, 28, 2011);
		$expect20	= mktime(0, 0, 0, 4, 7, 2011);

		$result1	= TodoyuTime::addDays($date, 1);
		$result2	= TodoyuTime::addDays($date, 2);
		$result5	= TodoyuTime::addDays($date, 5);
		$result10	= TodoyuTime::addDays($date, 10);
		$result20	= TodoyuTime::addDays($date, 20);

		$this->assertEquals($expect1, $result1);
		$this->assertEquals($expect2, $result2);
		$this->assertEquals($expect5, $result5);
		$this->assertEquals($expect10, $result10);
		$this->assertEquals($expect20, $result20);

			// Test with custom time set
		$date2		= mktime(20, 30, 30, 3, 1, 2011);
		$expectX1	= mktime(20, 30, 30, 3, 2, 2011);

		$resultX1	= TodoyuTime::addDays($date2, 1);

		$this->assertEquals($expectX1, $resultX1);
	}



	/**
	 * Test roundUpTime
	 */
	public function testRoundUpTime() {
		$time1	= 44 * 60;
		$round1	= 15;
		$expect1= 45 * 60;

		$result1= TodoyuTime::roundUpTime($time1, $round1);
		$this->assertEquals($expect1, $result1);


		$time2	= 20 * 60 + 5;
		$round2	= 10;
		$expect2= 30 * 60;

		$result2= TodoyuTime::roundUpTime($time2, $round2);
		$this->assertEquals($expect2, $result2);


		$time3	= 2 * 60 + 30;
		$round3	= 30;
		$expect3= 30 * 60;

		$result3= TodoyuTime::roundUpTime($time3, $round3);
		$this->assertEquals($expect3, $result3);
	}



	/**
	 * Test getIntersectingDayTimestamps
	 */
	public function testGetIntersectingDayTimestamps() {
		$dateStart1	= mktime(0, 0, 0, 3, 1, 2011);
		$dateEnd1	= mktime(0, 0, 0, 3, 15, 2011);
		$dateStart2	= mktime(0, 0, 0, 3, 10, 2011);
		$dateEnd2	= mktime(0, 0, 0, 3, 20, 2011);

		$intersection	= TodoyuTime::getIntersectingDayTimestamps($dateStart1, $dateEnd1, $dateStart2, $dateEnd2);

		$this->assertEquals(6, sizeof($intersection));
		$this->assertEquals($dateEnd1, $intersection[5]);
		$this->assertEquals($dateStart2, $intersection[0]);
	}



	/**
	 * Test getDayTimestampsInRange
	 */
	public function testGetDayTimestampsInRange() {
		$dateStart	= mktime(0, 0, 0, 3, 1, 2011);
		$dateEnd	= mktime(0, 0, 0, 3, 31, 2011);

		$days		= TodoyuTime::getDayTimestampsInRange($dateStart, $dateEnd);

		$this->assertEquals(31, sizeof($days));
		$this->assertEquals($dateStart, $days[0]);
		$this->assertEquals($dateEnd, $days[30]);
	}



	/**
	 * Test parsesqldate
	 */
	public function testparsesqldate() {
		$date	= '2010-01-01';
		$expect	= mktime(0, 0, 0, 1, 1, 2010);
		$result	= TodoyuTime::parseSqlDate($date);

		$this->assertEquals($expect, $result);
	}



	/**
	 * Test formatsqldate
	 */
	public function testformatsqldate() {
		Todoyu::setLocale('en_GB');

		$date	= '2010-01-01';
		$expect	= '01/01/2010';
		$result	= TodoyuTime::formatSqlDate($date);

		$this->assertEquals($expect, $result);
	}



	/**
	 * Test formatDuration
	 */
	public function testformatDuration() {
		Todoyu::setLocale('en_GB');

			// Check 1 second
		$duration60	= TodoyuTime::formatDuration(1);
		$expect60	= '1 Second';
		$this->assertEquals($expect60, $duration60);

			// Check 30 seconds
		$duration60	= TodoyuTime::formatDuration(30);
		$expect60	= '30 Seconds';
		$this->assertEquals($expect60, $duration60);

			// Check 1 minute
		$duration60	= TodoyuTime::formatDuration(60);
		$expect60	= '1 Minute';
		$this->assertEquals($expect60, $duration60);

			// Check 5 minutes
		$duration300	= TodoyuTime::formatDuration(300);
		$expect300	= '5 Minutes';
		$this->assertEquals($expect300, $duration300);

			// Check 1 hour
		$duration3600	= TodoyuTime::formatDuration(3600);
		$expect3600	= '1 Hour';
		$this->assertEquals($expect3600, $duration3600);

			// Check 5 hours
		$duration3600	= TodoyuTime::formatDuration(18000);
		$expect3600	= '5 Hours';
		$this->assertEquals($expect3600, $duration3600);

			// Check 1 day
		$duration172800	= TodoyuTime::formatDuration(86400);
		$expect172800	= '1 Day';
		$this->assertEquals($expect172800, $duration172800);

			// Check 2 days
		$duration172800	= TodoyuTime::formatDuration(172800);
		$expect172800	= '2 Days';
		$this->assertEquals($expect172800, $duration172800);
	}



	/**
	 * Test formattimespan
	 */
	public function testformattimespan() {
		Todoyu::setLocale('en_GB');

			// Check timespan within same day
		$startHours		= mktime(10, 0, 0, 1, 1, 2011);
		$endHours		= mktime(12, 0, 0, 1, 1, 2011);

		$expectHours	= 'Sat, Jan 01 11, 10:00 - 12:00';
		$resultHours	= TodoyuTime::formatTimespan($startHours, $endHours);

		$this->assertEquals($expectHours, $resultHours);

			// Check timespan within same day with duration
		$expectHours2	= 'Sat, Jan 01 11, 10:00 - 12:00 (2 Hours)';
		$resultHours2	= TodoyuTime::formatTimespan($startHours, $endHours, true);

		$this->assertEquals($expectHours2, $resultHours2);

			// Check timespan over multiple days
		$startDays		= mktime(10, 0, 0, 1, 1, 2011);
		$endDays		= mktime(10, 0, 0, 1, 2, 2011);
		$expectDays		= 'Sat, Jan 01 11 - Sun, Jan 02 11';
		$resultDays		= TodoyuTime::formatTimespan($startDays, $endDays);

		$this->assertEquals($expectDays, $resultDays);

			// Check timespan over multiple days with duration
		$expectDays2	= 'Sat, Jan 01 11 - Sun, Jan 02 11 (1 Day)';
		$resultDays2	= TodoyuTime::formatTimespan($startDays, $endDays, true);

		$this->assertEquals($expectDays2, $resultDays2);
	}



	/**
	 * Test gettimeofday
	 */
	public function testgettimeofday() {
		$time	= mktime(0, 0, 1, 1, 1, 2011);
		$expect	= 1;
		$result	= TodoyuTime::getTimeOfDay($time);

		$this->assertEquals($expect, $result);
	}



	/**
	 * Test isStandardDate
	 *
	 */
	public function testisstandarddate() {
		$this->assertTrue(TodoyuTime::isStandardDate('2011-08-05'));
		$this->assertTrue(TodoyuTime::isStandardDate('1999-01-01'));
		$this->assertFalse(TodoyuTime::isStandardDate('1999-1-01'));
	}

}

?>