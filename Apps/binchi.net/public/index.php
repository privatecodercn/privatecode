<?php
ini_set('display_errors', 1);
error_reporting(2047);
define('ROOT_PATH', '/d/web/yaf/');
define('BASE_PATH', dirname(__DIR__).'/');
define('APP_PATH', BASE_PATH.'application/');
define('WEB_PATH', BASE_PATH.'public/');
$app  = new Yaf_Application(BASE_PATH . 'conf/application.ini');
$app->bootstrap()->run();

