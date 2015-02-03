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
    private $secret = 'FJkay6TbP3vmHBnHX4vJjjy8V33nNzZynhRR2B';

    public function __construct($appName, $eventKey)
    {
        $this->appName = $appName;
        $this->eventKey = $eventKey;
    }
    
    public function contactUs($wxm)
    {
        $text = <<<TEXT
手机：18060502900！
您也可以在菜单：
“客服中心->留言”
提交您的信息或者微信中切换到键盘输入文字，我们均会收到您的留言并在收到消息后尽快安排时间与您联系。    
TEXT;
        return [
            'type' => 'text',
            'text' => $text
        ];
    }
    
    public function LOGIN_BIND($wxm)
    {
        String::$_id_crypt_key = Local_Cfg::getWeixinConfig($this->appName)['EncodingAESKey'];
        $time = time();
        $openID = String::idEncode64($time.$wxm->openID);
        $text = <<<TEXT
<a href="http://binchi.net/fc/user/login?o={$openID}">点击这里，立即登录</a>
TEXT;
        return [
            'type' => 'text',
            'text' => $text
        ];
    }
}
