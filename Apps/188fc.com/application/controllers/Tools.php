<?php
class ToolsController extends Controller
{
	public function index()
	{
		$str = String::idCrypt(100005);
		echo $str;
		echo "\n";
		echo String::idDeCrypt($str);
		exit;
	}
	
	public function setcookie()
	{
		setcookie('char', '123', time()+3600, '/', '.xzwu.x');
		exit;
	}
	
	public function getcookie()
	{
		var_export($_COOKIE);
		exit;
	}

}