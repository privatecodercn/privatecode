<?php
/**
 * Cookie
 *
 * Created		: 2011-06-05
 * Modified		: 2013-10-22
 * @link    	: http://www.59c.net
 * @copyright 	: (C) 2013 - 2014 59C.NET
 * @version		: 1.0.0
 * @author    	: Joseph Chen <chenliq@gmail.com>
 */
class Cookie
{
	public static $expire = 3600;
	public static $path = '/';
	public static $domain = null;
	
	/**
	 * 设置COOKIE
	 * @param string $key
	 * @param string $value
	 * @return boolean
	 */
	public static function set($key, $value)
	{
		return setcookie($key, $value, time()+self::$expire, self::$path, self::$domain);
	}
	
	/**
	 * 获取cookie值
	 * @param string $key
	 * @return Ambigous <NULL, unknown>
	 */
	public static function get($key)
	{
		return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
	}

}