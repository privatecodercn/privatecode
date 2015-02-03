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
    
    public $error = '';
    
    public $returnData = [];
	
	public $user = null;
	public $user_login = null;
	
	private $dbConnectionName;
	
	public function __construct($dbConnectionName=Db::DEFAULT_CONNECTION)
	{
		$this->user = Db::table('user', '', $dbConnectionName)->setPkColumn('uid');
		$this->user_login = Db::table('user_login', '', $dbConnectionName)->setPkColumn('uid');
		$this->dbConnectionName = $dbConnectionName;
	}
	
	private function uModel()
	{
	    return Db::table('user', '', $this->dbConnectionName)->setPkColumn('uid');
	}
	
	private function ulModel()
	{
	    return Db::table('user_login', '', $this->dbConnectionName)->setPkColumn('uid');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Model::read()
	 */
	public function read($uid, $fields='*')
	{
		return $this->user
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
			$userLogin = $this->ulModel()->findOne($detail->uid);
			if (!$userLogin)
			{
				$userLogin = $this->ulModel();
			}
		} else {
			$userLogin = $this->ulModel();
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
		$user = $this->ulModel()
					->where('username', $username)
					->findOne(false);
		if (!$user)
		{
			$this->error = true;
			$this->msg   = Lang::get('username_not_exist');
			return false;
		}
		if ($this->cryptPassword($username, $password, $user->salt) == $user->password)
		{
			$this->user = $user;
			return true;
		} else {
			$this->error = true;
			$this->msg   = Lang::get('password_incorrect');
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
		$user = $this->ulModel()->findOne($uid, false);
		if ($user->uid && $this->cryptSid($user->uid, $user->last_login_time, $user->salt)==$sid)
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
		$user = $this->user_login->findOne($uid, false);
		$cryptSid = $this->cryptSid($uid, $user->last_login_time, $user->salt);
		if ($user && ($user->type==1 || $user->type==2) && $cryptSid==$sid)
		{
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 重置用户密码
	 * @param string $username
	 * @param string $password
	 */
	public function resetPassword($username, $password=null)
	{
	    $password = $password ? : String::rand(8);
	    $salt = String::rand(8);
	    $userLogin = $this->user_login->findOne(['username', $username]);
	    if (!$userLogin)
	    {
	        $this->error = Lang::get('username_not_exist');
	        return false;
	    }
	    $userLogin->password = $this->cryptPassword($username, $password, $salt);
	    $userLogin->salt = $salt;
	    $result = $userLogin->save();
	    return ['reslut'=>$result, 'password'=>$password];
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

	/**
	 * 添加一条会员信息
	 * @param array $data
	 */
	public function addUser($data=[])
	{
	    if (!isset($data['username']))
	    {
	        $this->error = Lang::get('username_is_required');
	        return false;
	    }
	    $userLogin = $this->user_login;
	    $row = $userLogin->findOneArray(['username', $data['username']]);
	    if ($row)
	    {
	        $this->error = Lang::get('username_already_exist');
	        return false;
	    }
	    $userLogin->type = isset($data['type']) ? $data['type'] : 11;
	    $userLogin->last_login_ip = 0;
	    $userLogin->last_login_time = 0;
	    $userLogin->username = $data['username'];
	    $salt = String::rand(8);
	    $userLogin->salt = $salt;
	    if (isset($data['password']))
	    {
	        $password = $data['password'];
	    } else {
	        $password = String::rand(8);
	    }
	    $userLogin->password = $this->cryptPassword($data['username'], $password, $salt);
	    $userLogin->save();
	    $uid = $userLogin->getLastInsertId();
	    
	    $user = $this->user;
	    $user->uid = $uid;
	    $user->username = $data['username'];
	    $user->regip = isset($data['regip']) ? $data['regip'] : Ip::getIntIp('127.0.0.1');
	    $user->regtime = isset($data['regtime']) ? $data['regtime'] : time();
	    $user->from_channel_id = isset($data['from_channel_id']) ? $data['from_channel_id'] : 99;
	    $user->wx_openid = isset($data['wx_openid']) ? $data['wx_openid'] : '';
	    $user->wx_unionid = isset($data['wx_unionid']) ? $data['wx_unionid'] : '';
	    $user->wx_unsubscribe = isset($data['wx_unsubscribe']) ? $data['wx_unsubscribe'] : 0;
	    $user->nickname = isset($data['nickname']) ? $data['nickname'] : $data['username'];
	    $user->realname = isset($data['realname']) ? $data['realname'] : $data['username'];
	    $user->idcard = isset($data['idcard']) ? $data['idcard'] : 0;
	    $user->qq = isset($data['qq']) ? $data['qq'] : 0;
	    $user->email = isset($data['email']) ? $data['email'] : '';
	    $user->mobile = isset($data['mobile']) ? $data['mobile'] : 0;
	    $user->exp = isset($data['exp']) ? $data['exp'] : 0;
	    $user->point = isset($data['point']) ? $data['point'] : 0;
	    $user->coin = isset($data['coin']) ? $data['coin'] : 0;
	    $user->gold = isset($data['gold']) ? $data['gold'] : 0;
	    $user->emails_tatus = isset($data['emails_tatus']) ? $data['emails_tatus '] : 0;
	    $user->mobile_status = isset($data['mobile_status']) ? $data['mobile_status'] : 0;
	    $user->secure_status = isset($data['secure_status']) ? $data['secure_status'] : 0;
	    $user->type = isset($data['type']) ? $data['type'] : 11;
	    $user->status = isset($data['status']) ? $data['status'] : 1;
	    $user->gender = isset($data['gender']) ? $data['gender'] : 0;
	    $user->birth_date = isset($data['birth_date']) ? $data['birth_date'] : 0;
	    $user->province = isset($data['province']) ? $data['province'] : 0;
	    $user->city = isset($data['city']) ? $data['city'] : 0;
	    $user->county = isset($data['county']) ? $data['county'] : 0;
	    $user->town = isset($data['town']) ? $data['town'] : 0;
	    $user->address = isset($data['address']) ? $data['address'] : '';
	    $user->save();
	    
	    $this->returnData = [
	        'uid' => $uid,
            'password' => $password
	    ];
	    return true;
	}

}