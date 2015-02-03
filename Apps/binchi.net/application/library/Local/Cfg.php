<?php
class Local_Cfg
{
    
    public static function getWeixinConfig($appName)
    {
        $cfg = include APP_PATH.'data/conf/weixin.php';
        return $cfg[$appName];
    }
    
    public static function getWeixinToken($appName)
    {
        $cfg = include APP_PATH.'data/conf/weixin.php';
        return $cfg[$appName]['token'];
    }
}
