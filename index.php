<?php
/**
 * 命令行请求入口
*
 * Created		: 2014-07-02
 * Modified		: 2014-07-22
 * @link		: http://www.kuiwa.cn
 * @copyright	: (C) 2014 KUIWA.CN
 */
define('APPLICATION_PATH', dirname(__FILE__));

if (!extension_loaded("yaf"))
{
	include(APPLICATION_PATH . '/framework/loader.php');
}
$application = new Yaf_Application(APPLICATION_PATH . "/conf/application.ini");
$application->bootstrap()->run();