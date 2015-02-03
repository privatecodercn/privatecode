<?php
/**
 * 核心方法类
 * Created		: 2014-07-09
 * Modified		: 2014-07-09
 * @link		: http://www.kuiwa.cn
 * @copyright	: (C) 2014 KUIWA.CN
 */
class Core
{
	/**
	 * 是否搜索引擎请求
	 * @return boolean
	 */
	public static function isRobot()
	{
		return preg_match("/(Bot|Crawl|Spider|slurp|sohu-search|lycos|robozilla)/i", $_SERVER['HTTP_USER_AGENT'])>0;
	}
	
	/**
	 * 是否恶意的机器人请求
	 * @return boolean
	 */
	public static function isBalefulRobot()
	{
		
		return false;
// 		return preg_match("/(Bot)/i", $_SERVER['HTTP_USER_AGENT'])>0;
	}
}