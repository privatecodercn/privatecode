<?php
class IndexController extends Controller
{
	public function indexAction()
	{
		
		$this->getView()->assign("environ", YAF_ENVIRON);
		
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
				$this->json(false, Lang::get('password_incorrect'));
			}
		} else if ($user->auth($_POST['username'], $_POST['password'])) {
			$now = time();
			$userInfo = Db::table('user')->where('username', $_POST['username'])->findOne();
			if (!$userInfo)
			{
				$this->json(false, Lang::get('username_not_exist'));
			}
			$ulogin = Db::table('user_login')->where('uid', $userInfo->uid)->findOne();
			$ulogin->setPkColumn('uid');
			$ulogin->last_login_ip = $_SERVER['REMOTE_ADDR'];
			$ulogin->last_login_time = $now;
			$ulogin->save();
			Cookie::$expire = $config->admin->cookieExpire;
			Cookie::set('admin_uid', $userInfo->uid);
			$sid = $user->cryptSid($userInfo->uid, $ulogin->last_login_time, $ulogin->salt);
			Cookie::set('admin_sid', $sid);
		} else {
			$this->json(false, $user->msg);
		}
		Captcha::setCookie(false, 1, 'admin_captcha');
		
		// 成功输出默认数据
		$this->json(true);
	}
	
	public function doLogoutAction()
	{
		Cookie::set('admin_uid', false);
		Cookie::set('admin_sid', false);
		$this->json(true);
	}
	
	public function doModifyPwdAction()
	{
		$uid = (int)Cookie::get('admin_uid');
		$user = new UserModel();
		$ulogin = Db::table('user_login')
						->setPkColumn('uid')
						->findOne($uid);
		if (!$user->auth($ulogin->username, $_POST['oldpassword']))
		{
			$this->json(false, '旧密码错误！');
		}
		if ($_POST['newpassword']!=$_POST['newpassword2'])
		{
			$this->json(false, '确认密码不一致！');
		}
		$ulogin->password = $user->cryptPassword($ulogin->username, $_POST['newpassword'], $ulogin->salt);
		$ulogin->save();
		$this->json(true);
	}
	
	public function uploadImgAction()
	{
		switch ($_POST['type'])
		{
			case 'article':
				$dir = 'images/';
				$imageType = [IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_PNG];
				$type = 1;
				break;
				
			case 'album':
				$dir = 'images/';
				$imageType = [IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_PNG];
				$type = 2;
				break;
				
			case 'video':
				$dir = 'images/';
				$imageType = [IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_PNG];
				$type = 4;
				break;
				
			case 'fragment':
				$dir = 'images/';
				$imageType = [IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_PNG];
				$type = 3;
				break;
				
			default:
				$this->json(false, '未知的图片上传类型！');
		}
		// 如果有文件上传
		if (isset($_FILES['0']) && $_FILES['0']['error'] != UPLOAD_ERR_NO_FILE)
		{
			// 已经上传过同样的文件
			$tmpFile = $_FILES['0']['tmp_name'];
			$md5 = md5_file($tmpFile);
			$size = filesize($tmpFile);
			$pic = Db::table('pics')
						->where('md5', $md5)
						->where('size', $size)
						->findOne();
			if ($pic)
			{
				$file = $pic->path;
			} else {
				$options = array(
					'image'		=> true,
					'image_type'=> $imageType,
					'max_size'	=> 1024000,
					'save_path'	=> Yaf_Registry::get('config')->application->attachment.$dir,
					'save_rule'	=> '##Y/md/',
				);
				$upload = new UploadFile($options);
				// 上传错误提示错误信息
				if(!$upload->upload())
				{
					$this->json(false, $upload->error());
				} else {// 上传成功 获取上传文件信息
					$destFile = $upload->fileList[0];
				}
				$file = '/attachment/'.$dir.$destFile;
				$pic = Db::table('pics');
				$pic->type = $type;
				$pic->tid = 0;
				$pic->path = $file;
				$pic->md5 = $md5;
				$pic->size = $size;
				$pic->save();
			}
			$index = $this->getRequest()->getPost('index', '');
			$this->json(true, ['path'=>$file, 'id'=>$pic->id, 'index'=>$index]);
		} else {
			$this->json(false, 'no file uploaded.');
		}
		$this->json(true);
	}
	
	public function clearCacheAction($type='js')
	{
		switch ($type) 
		{
			case 'js':
				$dir = APP_PATH.'data/js';
				Fso::clearDir($dir);
			break;
			
			case 'css':
				$dir = APP_PATH.'data/css';
				Fso::clearDir($dir);
			break;
			
			case 'ti':
				$start = 2011;
				$year = date('Y');
				$maxSession = $year - ($start-1);
				for ($i=1; $i<=$maxSession; $i++)
				{
					$filename = WEB_PATH.'ti'.$i.'.html';
					unlink($filename);
				}
			break;
			
			default:
				;
			break;
		}
		$this->json(true);
	}
	
}