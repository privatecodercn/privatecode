<?php
class UserController extends Controller
{

    public function loginAction()
    {
	    $config = Local_Cfg::getWeixinConfig(Yaf_Registry::get('app_name'));
        String::$_id_crypt_key = $config['EncodingAESKey'];
        $o = String::idDecode64($_GET['o']);
        $timestamp = substr($o, 0, 10);
        $openID    = substr($o, 10);
        $now = time();
        // 判断参数是否过期
        if ($now > ($timestamp+900))
        {
            echo '非法请求';
            exit;
        }
        
        $db = Db::table('user', '', $config['db_connection_name']);
        $user = $db->where('wx_openid', $openID)->findOne();
        if ($user)
        {
            ;
        } else {
            $userM = new UserModel($config['db_connection_name']);
            $data = [
                'username'  => uniqid(substr($openID, -3)),
                'wx_openid' => $openID,
                'from_channel_id' => '2',
            ];
            $userM->addUser($data);
            $user = $db->setPkColumn('uid')->findOne($userM->returnData['uid']);
        }
        
        Cookie::set('uid', $user->uid);
        
        $view = $this->getView();
        $vars = [
            'message' => '已经登录成功了!',
        ];
        $view->assign($vars);
        $view->display('message.html.php');
        return false;
    }
    
}

