<?php
/**
 * 命令行代码入口
 * Created		: 2014-07-02
 * Modified		: 2014-07-11
 * @link		: http://www.kuiwa.cn
 * @copyright	: (C) 2014 KUIWA.CN
 */
set_time_limit(0);
define("ROOT_PATH", '/d/web/yaf/');

if ($_SERVER['argc'] < 3)
{
	echo 'arguments error.';
	echo "\n";
	exit;
}


// 判断项目对应目录是否存在
$appName = $_SERVER['argv'][1];
define('BASE_PATH', __DIR__.'/Apps/'.$appName.'/');
if (!is_dir(BASE_PATH))
{
	echo BASE_PATH;
	echo ' ['.$appName.'] is not exist.';
	echo "\n";
	exit;
}
define("WEB_PATH", BASE_PATH.'public/');
define('APP_PATH', BASE_PATH.'application/');

$ca = explode('/', $_SERVER['argv'][2]);


// 判断控制器文件是否存在
$cmdName = ucfirst($ca[0]);
$cmdFile = APP_PATH.'/commands/'.$cmdName.'.php';
if (!is_file($cmdFile))
{
	echo $cmdFile;
	echo ' module not exist.';
	echo "\n";
	exit;
}
require $cmdFile;
$cmdName = $cmdName.'Cmd';
$cmd = new $cmdName;

// 调用方法
if (isset($ca[1]))
{
	$action = $ca[1];
} else {
	$action = 'index';
}

// 判断方法是否存在
if (!method_exists($cmd, $action))
{
	echo 'method not exist.';
	echo "\n";
	exit;
}

$params = array_slice($_SERVER['argv'], 3);
$tmp = [];
foreach ($params as $k=>$v) 
{
	if (strpos($v, '='))
	{
		unset($params[$k]);
		$p = explode('=', $v, 2);
		$tmp[$p[0]] = $p[1];
	}
}
foreach ($params as $v)
{
	array_push($tmp, $v);
}
$params = $tmp;


if (method_exists($cmd, 'init'))
{
	$cmd->init();
}

$app  = new Yaf_Application(BASE_PATH . "conf/application.ini");
$app->bootstrap();
call_user_func_array([$app, 'execute'], array_merge([[$cmd, $action]], $params));
// $app->bootstrap()->execute([$cmd, $action], $params);

