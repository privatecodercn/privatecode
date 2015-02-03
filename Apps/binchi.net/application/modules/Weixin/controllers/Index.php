<?php
/**
 * 微信接口
 * Created        : 2014-09-16
 * Modified        : 2014-09-16
 * @link        : http://binchi.net
 * @copyright    : (C) 2014 binchi.net
 */
class IndexController extends Yaf_Controller_Abstract
{
    /**
     * 默认的微信公众号配置名
     * @var string
     */
    const APP_NAME = 'binchi';
    /**
     * 当前的微信公众号配置名
     * @var string
     */
    private $appName;
    
    public function init()
    {
//         $GLOBALS['HTTP_RAW_POST_DATA'] = file_get_contents(__DIR__.'/P.txt');
        $appName = $this->getRequest()->getParam('app_name');
        if (!$appName)
        {
            $appName = self::APP_NAME;
        }
        $this->appName = $appName;
        $appToken = $cfg = Local_Cfg::getWeixinConfig($appName)['token'];
        file_put_contents(__DIR__.'/t.txt', var_export($_SERVER, true));
        if (!$this->checkSignature($appToken))
        {
			echo 'error';
            exit;
        }
        if (isset($_GET['echostr']))
        {
			echo $_GET['echostr'];
            exit;
        }
        if (isset($GLOBALS['HTTP_RAW_POST_DATA']))
        {
            file_put_contents(__DIR__.'/POST.txt', $GLOBALS['HTTP_RAW_POST_DATA']);
//             $wx = new Weixin($appName);
//             $token = $wx->getAccessToken();
        } else {
            exit;
        }
    }
    
    public function indexAction()
    {
        $wxm = new WeixinModel($this->appName);
        $wxm->handle();
    }
    
    /**
     * 验证消息真实性,即消息是否来自于微信平台
     * @param string $token
     * @return boolean
     */
    private function checkSignature($token)
    {
        $timestamp = $_GET['timestamp'];
        // 判断时间是否过期
//         if ($timestamp < (time()-1800))
//         {
//             return false;
//         }
        $signature = $_GET['signature'];
        $nonce = $_GET['nonce'];
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($signature == $tmpStr)
        {
            return true;
        } else {
            return false;
        }
    }
}