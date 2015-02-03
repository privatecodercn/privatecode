<?php
class IndexController extends Controller
{
	public function indexAction()
	{
	    
		$user = ORM::for_table('xzqh_test')
				    ->where_equal('code', '110101')
				    ->find_one();
	
		
		$this->getView()->assign("environ", Yaf_ENVIRON);
		$this->getView()->assign("content", "Hello Admin.");
		
	}
	
	public function loginAction()
	{
	}
	
	public function dologinAction()
	{
		$config = Yaf_Registry::get('config');
		// 验证码不正确
		if (!Captcha::validate($this->getRequest()->getPost('captcha'), 'admin_captcha'))
		{
			Captcha::setCookie(false, 1, 'admin_captcha');
			$this->json(false, Lang::get('incorrect_verification_code'));
		}
		$user = new UserModel();
		// 账号密码验证
		if ($config->admin->user == $_POST['username'])
		{
			if ($config->admin->pass == $_POST['password'])
			{
				Cookie::set('admin_uid', 1);
				$userInfo = $user->read(1);
				Cookie::set('admin_sid', $user->cryptSid(1, $userInfo->last_login_time, $userInfo->salt));
			} else {
				$this->json(false, $_POST['password'].Lang::get('password_incorrect'));
			}
		} else if ($user->auth($_POST['username'], $_POST['password'])) {
			$now = time();
			$userInfo = ORM::for_table('user')->where('username', $_POST['username'])->find_one();
			if (!$userInfo)
			{
				$this->json(false, Lang::get('username_not_exist'));
			}
			$ulogin = ORM::for_table('user_login')->where('uid', $userInfo->uid)->find_one();
			$ulogin->use_id_column('uid');
			$ulogin->last_login_ip = $_SERVER['REMOTE_ADDR'];
			$ulogin->last_login_time = $now;
			$ulogin->save();
			Cookie::$expire = $config->admin->cookieExpire;
			Cookie::set('admin_uid', $userInfo->uid);
			Cookie::set('admin_sid', $user->cryptSid($userInfo->uid, $ulogin->last_login_time, $ulogin->salt));
		} else {
			$this->json(false, $user->msg);
		}
		Captcha::setCookie(false, 1, 'admin_captcha');
		
		// 成功输出默认数据
		$this->json(true);
	}
}