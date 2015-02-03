<?php
/**
 * 用户操作
 *
 * Created		: 2014-08-26
 * Modified		: 2014-08-26
 * @link		: http://www.59c.net
 * @copyright	: (C) 2012 - 2014 59C.NET
 * @version		: 1.0.0
 * @author		: Joseph Chen (chenliq@gmail.com)
 */
class User
{
	/**
	 * 
	 * @var UserModel
	 */
	public static $user;
	
	public static $isLogined = false;
	
	/**
	 * @return UserModel
	 */
	public static function getInstance()
	{
		if (!is_object(self::$user))
		{
			self::$user = new UserModel();
		}
		return self::$user;
	}
	
	public static function isLogined()
	{
		return self::getInstance()->isLogined();
	}
	
}
