<?php
/**
 * 定时重新生成微信access_token
 * Created		: 2014-07-10
 * Modified		: 2014-07-10
 * @link		: http://www.binchi.net
 * @copyright	: (C) 2014 BINCHI.NET
 * @example		: /d/web/yaf/command binchi.net Init/createNewUser $username
 */
class InitCmd
{
    
    public function createNewUser($username, $password=null, $type=null)
    {
        $data = [
            'username' => $username
        ];
        if ($password)
        {
            $data['password'] = $password;
        }
        if ($type)
        {
            $data['type'] = $type;
        }
        $user = new UserModel();
        $user->addUser($data);
        if ($user->error)
        {
            echo $user->error;
            echo "\n";
        } else {
            var_export($user->returnData);
        }
    }
    
    public function resetPassword($username, $password=null)
    {
        $user = new UserModel();
        $result = $user->resetPassword($username, $password);
        if ($result)
        {
            var_export($result);
        } else {
            echo "\n";
            echo $user->error;
        }
    }
    
    public function getWxAccessToken($appName='binchi')
    {
        echo (new Weixin($appName))->getAccessToken();
    }

    public function randStr($len=8, $type=7)
    {
        echo uniqid('');
        echo "\n";
        echo String::rand($len, $type);
        echo "\n";
    }
}