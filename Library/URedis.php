<?php
/**
 * Redis操作
 *
 * Created		: 2014-08-26
 * Modified		: 2014-08-26
 * @link		: http://www.59c.net
 * @copyright	: (C) 2012 - 2014 59C.NET
 * @version		: 1.0.0
 * @author		: Joseph Chen (chenliq@gmail.com)
 */
class URedis
{

    /**
     * 默认连接
     * @var string
     */
    const DEFAULT_CONNECTION = 'default';
    
    /**
     * 当前实例使用的连接名
     * @var string
     */
    private $connectionName = 'default';
    
    /**
     * 实例集
     * @var array
     */
    private static $instance = [];
    
	/**
	 * 构造函数
	 * @param string $connectionName
	 * @return Redis
	 */
	public function __construct($connectionName=self::DEFAULT_CONNECTION)
	{
	    $config = Yaf_Registry::get('config')->redis->$connectionName;
		$redis = new Redis();
		$conn = $redis->connect($config->host, $config->port);
		if (!$conn)
		{
			throw new Exception('cannot connect to redis server.');
		}
		$auth = $redis->auth($config->auth);
		if (!$auth)
		{
			throw new Exception('Redis: invalid password.');
		}
		self::$instance[$connectionName] = $redis;
		return self::$instance[$connectionName];
	}

	/**
	 * 获取实例
	 * @return Redis
	 */
	public static function getInstance($connectionName=self::DEFAULT_CONNECTION)
	{
	    if (!isset(self::$instance[$connectionName]))
	    {
	        new self($connectionName);
	    }
	    return self::$instance[$connectionName];
	}
	
	
}
