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
class WeixinModel
{
    public $appName;
    public $openID;
    public $fromUserName;
    public $msgId;
    public $encrypt;
    public $content;
    public $msgType;
    
    public function __construct($appName='binchi') 
    {
        $this->appName = $appName;
    }
    
    /**
     * 处理用户发送的消息
     */
    public function handle()
    {
        $sxe = simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA'], 'SimpleXMLElement', LIBXML_NOCDATA);
        $this->openID = trim($sxe->FromUserName);
        $this->fromUserName = trim($sxe->ToUserName);
        $this->msgId = trim($sxe->MsgId);
        if (isset($sxe->Encrypt))
        {
            $this->encrypt = trim($sxe->Encrypt);
        }
        $this->content = trim($sxe->Content);
        if (!isset($sxe->MsgType))
        {
        }
        $this->msgType = trim($sxe->MsgType);
        switch ($this->msgType)
        {
            case 'text':
                $this->handleText();
                break;
            case 'event':
                $this->handleEvent(trim($sxe->Event), trim($sxe->EventKey));
                break;
        }
    }
    
    /**
     * 处理文本
     */
	public function handleText()
	{
	    

	}
	
	/**
	 * 
	 * @param string $event
	 * @param string $eventKey
	 */
	public function handleEvent($event, $eventKey)
	{
	    switch (strtolower($event))
	    {
	        // 关注
	        case 'subscribe':
	            $config = Local_Cfg::getWeixinConfig($this->appName);
	            $weixinName = $config['name'];
	            $text = <<<TEXT
/::) 恭喜您成为{$weixinName}微信粉丝。
TEXT;
	            $data = [
                    'username'  => uniqid(substr($this->openID, -5)),
                    'wx_openid' => $this->openID,
	            ];
	            $user = new UserModel($config['db_connection_name']);
	            $user->addUser($data);
	            $this->replyText($text);
	            break;
	        // 取消关注
	        case 'unsubscribe':
	            
	            break;
	        // 其他事件
	        case 'click':
	            $clickModel = Local_Cfg::getWeixinConfig($this->appName)['clickModel'];
	            $wxc = new $clickModel($this->appName, $eventKey);
	            $result = $wxc->$eventKey($this);
	            if ($result['type'] == 'text')
	            {
	                $this->replyText($result['text']);
	            } else {
	                
	            }
	            break;
	    }
	    
	}
	
	
	private function replyText($text)
	{
	    $createTime = time();
	    $data = <<<EOT
<xml>
<ToUserName><![CDATA[{$this->openID}]]></ToUserName>
<FromUserName><![CDATA[{$this->fromUserName}]]></FromUserName>
<CreateTime>$createTime</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[$text]]></Content>
</xml>
EOT;
	    echo $data;
	}
}
