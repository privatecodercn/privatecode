<?php
class ToolsController extends Yaf_Controller_Abstract
{
	public function index()
	{
		$str = String::idCrypt(100005);
		echo $str;
		echo "\n";
		echo String::idDeCrypt($str);
		exit;
	}

	public function resetAdminUserPwdAction()
	{
	    // 	    $user = new UserModel();
	    // 	    $return = $user->resetPassword('admin');
	    // 	    var_export($return);
	    // 	    echo PHP_EOL;
	    // 	    echo $return['password'];
	    // 	    return false;
	}

}