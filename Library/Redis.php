<?php
/**
 * Redis操作类
 *
 * Created    : 2014-10-24
 * Modified   : 2014-10-31
 * @link      : http://www.binchi.net/
 * @copyright : © 2014 BINCHI.NET
 * @version   : 1.0.0
 * @author    : Joseph Chen <me@binchi.net>
 */
class Redis
{
    
    private static $instance;
    
    public function __construct()
    {
        
    }
    
    /**
     * 
     * @return Redis
     */
    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
