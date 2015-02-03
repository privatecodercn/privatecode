<?php
class MemberController extends Controller
{
	
	public function doLogin()
	{
		$config = Yaf_Registry::get('config');
		Captcha::$cookiePath = $config->cookie->path;
		Captcha::$cookieDomain = $config->cookie->domain;
		// 验证码不正确
// 		if (!Captcha::validate($this->getRequest()->getPost('captcha'), 'captcha'))
// 		{
// 			Captcha::setCookie(false, 1, 'admin_captcha');
// 			$this->json(false, Lang::get('incorrect_verification_code'));
// 		}
		$user = User::getInstance();
		// 账号密码验证
		if ($user->auth($_POST['username'], $_POST['password']))
		{
			$now = time();
			$ulogin = $user->user;
			$ulogin->use_id_column('uid');
			$ulogin->last_login_ip = $_SERVER['REMOTE_ADDR'];
			$ulogin->last_login_time = $now;
			$ulogin->save();
			Cookie::$expire = $config->admin->cookieExpire;
			Cookie::set('admin_uid', $userInfo->uid);
			$ssalt = String::rand(6);
			Cookie::set('admin_ss', $ssalt);
			Cookie::set('admin_sid', $user->cryptSid($ulogin->uid, $ssalt, $ulogin->salt));
		} else {
			$this->json(false, $user->msg);
		}
		Captcha::setCookie(false, 1, 'admin_captcha');
		
		// 成功输出默认数据
		$this->json(true);
	}
	
	
}
