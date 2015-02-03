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
	
	public $user = null;
	
	public function __construct()
	{
		$this->user = Db::table('user')->setPkColumn('uid');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Model::read()
	 */
	public function read($uid, $fields='*')
	{
		return Db::table('user')->setPkColumn('uid')
					->selectColumns($fields)
				    ->join('user_login', 'user.uid=user_login.uid')
				    ->where('user.uid', $uid)
				    ->findOne();
	}
	
	public function create()
	{
		return $this->user;
	}

	public function save($detail, $newPwd=false, $password=null)
	{
		if (isset($detail->uid) && $detail->uid)
		{
			$userLogin = Db::table('user_login')->findOne($detail->uid);
			if (!$userLogin)
			{
				$userLogin = Db::table('user_login');
			}
		} else {
			$userLogin = Db::table('user_login');
		}
		$regIp = isset($detail->regip) ? $detail->regip : Ip::getIntIp('127.0.0.1');
		$regTime = isset($detail->regtime) ? $detail->regtime : time();
		
		$isNew = $userLogin->is_new();
		
		if ($isNew)
		{
			$userLogin->last_login_ip = $regIp;
			$userLogin->last_login_time = $regTime;
		}
		$userLogin->username = $detail->username;
		if ($isNew || $newPwd)
		{
			$salt = String::rand(8);
			$userLogin->salt = $salt;
			$password = empty($password) ? String::rand(12) : $password;
			$userLogin->password = $this->cryptPassword($detail->username, $password, $salt);
		}
		if ($userLogin->save())
		{
			$user = $detail;
			if ($user->save())
			{
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * 用户账号密码验证
	 * @param string $username
	 * @param string $password
	 */
	public function auth($username, $password)
	{
		$user = Db::table('user_login')
					->where('username', $username)
					->findOne();
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
		$user = Db::table('user_login')->findOne($uid);
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
		$user = $this->read($uid, ['user.uid','user_login.last_login_time', 'user_login.salt', 'user.type']);
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