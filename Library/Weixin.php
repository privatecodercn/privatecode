<?php
class Weixin
{
    const ACCESS_TOKEN_PRE = 'wx:access_token:';
    const JSAPI_TICKET_PRE = 'wx:jsapi_ticket:';
    
    /**
     * 当前微信公众号对应的应用名称
     * @var string
     */
    private $appName;
    
    /**
     * 对应的微信相关配置数组
     * @var array
     */
    private $cfg;
    
    /**
     * 错误信息
     * @var object|data
     */
    public $error;
    
    public function __construct($appName) 
    {
        $this->appName = $appName;
        $this->cfg = Local_Cfg::getWeixinConfig($appName);
    }
    
    /**
     * 获取AccessToken
     * @param string $appName
     * @return string|boolean
     */
    public function getAccessToken()
    {
        if ($token=URedis::getInstance()->get(self::ACCESS_TOKEN_PRE.$this->appName))
        {
            return $token;
        }
        $url = sprintf(
                   'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s',
                   $this->cfg['appid'], $this->cfg['secret']
               );
        $curl = new ICurl();
        $json = $curl->get($url);
        $data = json_decode($json);
        if (isset($data->access_token))
        {
            $this->cacheAccessToken($data->access_token, $data->expires_in-10);
            return $data->access_token;
        } else {
            return false;
        }
    }
    
    /**
     * 缓存access_token
     * @param string $token
     * @param int $expire
     */
    private function cacheAccessToken($token, $expire)
    {
        URedis::getInstance()->setex(self::ACCESS_TOKEN_PRE.$this->appName, $expire, $token);
    }
    
    /**
     * 获取微信JS接口的临时票据
     * @return string|boolean
     */
    public function getJsapiTicket()
    {
        if ($ticket=URedis::getInstance()->get(self::JSAPI_TICKET_PRE.$this->appName))
        {
            return $ticket;
        }
        $url = sprintf(
                   'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi',
                   $this->getAccessToken()
               );
        $curl = new ICurl();
        $json = $curl->get($url);
        $data = json_decode($json);
        if (isset($data->ticket))
        {
            $this->cacheJsapiTicket($data->ticket, $data->expires_in-10);
            return $data->ticket;
        } else {
            return false;
        }
    }
    
    /**
     * 缓存微信JS接口的临时票据
     * @param string $ticket
     * @param int $expire
     */
    private function cacheJsapiTicket($ticket, $expire)
    {
        URedis::getInstance()->setex(self::JSAPI_TICKET_PRE.$this->appName, $expire, $ticket);
    }
    
    /**
     * 公众号菜单查询
     */
    public function getMenu($returnJson=false)
    {
        $apiUrl = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$this->getAccessToken();
        $curl = new ICurl();
        $json = $curl->get($apiUrl);
        $result = json_decode($json);
        
        if (isset($result->errcode))
        {
            return false;
        } else {
            return $returnJson ? $json : $result->menu->button;
        }
    }
    
    /**
     * 发布菜单
     * @param array|string $data
     * @return boolean
     */
    public function releaseMenu($data)
    {
        if (is_array($data))
        {
            $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        $apiUrl = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->getAccessToken();
        $curl = new ICurl($apiUrl);
        $json = $curl->post($data);
        $result = json_decode($json);
        if ($result->errcode==0)
        {
            return true;
        } else {
            $this->error = $result;
            return false;
        }
    }
    
}




