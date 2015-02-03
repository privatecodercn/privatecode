<?php
/**iptables -t filter -D INPUT -s 218.106.151.194 -j DROP
 * 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf_Bootstrap_Abstract
{

	public function _initConfig()
	{
		$config = Yaf_Application::app()->getConfig();
		Yaf_Registry::set("config", $config);

		Yaf_Registry::set("MedooOptions", [
			'database_file'	=> '',
			'database_type'	=> 'mysql',
			'server'		=> $config->database->host,
			'database_name'	=> $config->database->dbname,
			'username'		=> $config->database->username,
			'password'		=> $config->database->password,
			'charset'		=> $config->database->charset,
		]);
	}

	public function _initDefault(Yaf_Dispatcher $dispatcher)
	{
		
		$config = Yaf_Registry::get('config');
		
		Lang::init();
		
		Cookie::$expire = $config->cookie->expire;
		Cookie::$path	= $config->cookie->path;
		Cookie::$domain = $config->cookie->domain;
		
		$dbCfg = $config->database;
		$connection = 'mysql:host='.$dbCfg->host.';dbname='.$dbCfg->dbname.';charset='.$dbCfg->charset;
		
		Db::$isProduction = (YAF_ENVIRON == 'product');
		Db::configure($connection);
		Db::configure('username', $dbCfg->username);
		Db::configure('password', $dbCfg->password);
		
		
		// 注册插件
		$comPlg = new CommonPlugin();
		$dispatcher->registerPlugin($comPlg);
		
		// 添加路由协议
		$router = Yaf_Dispatcher::getInstance()->getRouter();
	 	$router->addConfig($config->routes);
	 	
	 	Yaf_Loader::import('User.php');
	}
}