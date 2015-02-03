<?php
class MyDate
{
	/**
	 * 获取本周起始时间戳
	 * @return number
	 */
	public static function getThisWeek()
	{
		return strtotime('this week 00:00:00');
	}
	
}