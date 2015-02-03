<?php
/**
 * 用户模型
 * 
 * Create     : 2013-11-28
 * Modified   : 2014-05-23
 * @link      : http://www.59c.net
 * @copyright : (C) 2013 - 2014 59C.NET
 * @version   : 1.0.0
 * @author    : Joseph Chen <chenliq@gmail.com>
 */
class UserModel
{
	
	public function __construct()
	{
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Model::read()
	 */
	public function read($uid, $fields='*')
	{
		return ORM::for_table('user')->table_alias('u')
					->select_many_expr($fields)
				    ->join('user_login', [
				        'u.uid', '=', 'ul.uid'
				    ], 'ul')
				    ->where_equal('u.uid', $uid)
				    ->find_one();
	}

	/**
	 * 修改密码
	 * @param string $username
	 * @param int $uid
	 * @return array
	 */
	public function doChangePwd($username, $uid)
	{
		if (empty($_POST['oldpassword']))
		{
			return ['success'=>0, 'message'=>'旧密码不能为空！'];
		}
		if (empty($_POST['newpassword']) || empty($_POST['newpassword2']))
		{
			return ['success'=>0, 'message'=>'新密码或确认新密码不能为空！'];
		}
		if ($_POST['newpassword'] != $_POST['newpassword2'])
		{
			return ['success'=>0, 'message'=>'新密码必须确认新密码一致！'];
		}
		if (!$this->auth($username, $_POST['oldpassword']))
		{
			return ['success'=>0, 'message'=>'旧密码错误！'];
		}
		$_POST['password'] = $_POST['newpassword'];
		$result = $this->updateInfo($_POST, $uid, 1);
		if ($result)
		{
			return ['success'=>1, 'message'=>'操作成功！'];
		} else {
			return ['success'=>0, 'message'=>'更新失败！'];
		}
	}
	
	/**
	 * 用户账号密码验证
	 * @param string $username
	 * @param string $password
	 */
	public function auth($username, $password)
	{
		$user = ORM::for_table('user_login')
			->where_equal('username', $username)
			->find_one();
		if (!$user)
		{
			$this->error = true;
			$this->msg	 = Lang::get('username_not_exist');
			return false;
		}
		if ($this->cryptPassword($username, $password, $user['salt']) == $user['password'])
		{
			$this->user = $user;
			return true;
		} else {
			$this->error = true;
			$this->msg	 = Lang::get('password_incorrect');
			return false;
		}
	}

	/**
	 * 判断当前是否己登录
	 */
	public function isLogined()
	{
		$uid = Cookie::get('uid');
		$sid = Cookie::get('sid');
		$user = ORM::for_table('user_login')->find_one($uid);
		if ($user && $this->cryptSid($user['uid'], $user['last_login_time'], $user['salt'])==$sid)
		{
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 判断是否已登录管理员账号
	 */
	public function isAdminLogined()
	{
		$uid = Cookie::get('admin_uid');
		$sid = Cookie::get('admin_sid');
		$user = $this->read($uid, ['u.uid','ul.last_login_time', 'ul.salt', 'u.type']);
		$cryptSid = $this->cryptSid($uid, $user->last_login_time, $user->salt);
		if ($user && ($user->type==1 || $user->type==2) && $cryptSid==$sid)
		{
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 根据会员名和原始密码生成密码串
	 * @param string $username 用户名
	 * @param string $password 密码
	 * @param string $salt 加密盐值
	 */
	public function cryptPassword($username, $password, $salt)
	{
		return md5(md5($username).$salt.md5($password));
	}

	/**
	 * 根据会员ID生成SID
	 * @param string $uid 用户ID
	 * @param string $time 时间戳
	 * @param string $salt 加密盐值
	 */
	public function cryptSid($uid, $time, $salt)
	{
		return md5(md5($uid).md5($salt).md5($time));
	}
}