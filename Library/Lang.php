<?php
/**
 * 全局配置
 *
 * Create     : 2013-10-18
 * Modified   : 2014-05-233
 * @link      : http://www.59c.net
 * @copyright : (C) 2007 - 2014 59C.NET
 * @version   : 2.0.0
 * @author    : Joseph Chen <chenliq@gmail.com>
 */
class Lang
{
	public static $lang = [];
	
	public static $langName = '';
	
	public static function init()
	{
		self::$langName = Yaf_Registry::get('config')->lang;
		self::$lang = require ROOT_PATH.'Library/lang/'.self::$langName.'.php';
	}
	
	/**
	 * 加载项目的语言文件
	 * @param string $name
	 */
	public static function load($name)
	{
		if (isset(self::$lang[$name]))
		{
			return true;
		}
		$file = APP_PATH.'lang/'.self::$langName.'/'.$name.'.php';
		if (!is_file($file))
		{
			return false;
		}
		self::$lang[$name] = true;
		self::$lang = array_merge(self::$lang, include $file);
		return true;
	}

	/**
	 * 获取字符串描述对应的语言内容
	 * @param string $str
	 */
	public static function get($str, $replacement=[])
	{
		if (isset(self::$lang[$str]))
		{
			$msg = self::$lang[$str];
		} else {
			$msg = $str;
		}
		if (is_array($replacement)) {
			$msg = vsprintf($msg, $replacement);
		} elseif ($replacement) {
			$msg = strtr($msg, $replacement);
		}
		return $msg;
	}
	
	/**
	 * 动态配置
	 * @param string $property
	 * @param mixed $value
	 */
	public function __set($property, $value)
	{
		$this->$property = $value;
	}
	
	/**
	 * 获取不存在的配置
	 * @param string $property
	 * @return NULL
	 */
	public function __get($property)
	{
		return null;
	}
}