<?php
/**
 * 微信模型
 * Create     : 2014-09-16
 * Modified   : 2014-09-16
 * @link      : http://www.binchi.net
 * @copyright : (C) 2013 BINCHI.NET
 * @version   : 1.0.0
 * @author    : Joseph Chen <dev@59c.net>
 */
class WeixinClick4FCModel
{
    private $appName;
    private $eventKey;

    public function __construct($appName, $eventKey)
    {
        $this->appName = $appName;
        $this->eventKey = $eventKey;
    }
    
    /**
     * 处理点击事件
     */
    public function handle()
    {
        
    }
}
