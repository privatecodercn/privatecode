<?php
ini_set('default_socket_timeout', -1);

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->auth('2012+abc!=2010');
$channelname = 'foo';
try
{
	$redis->subscribe(array($channelname, 'test'), 'f');
}catch(Exception $e)
{
	echo $e->getMessage();
}

function f($redis, $channel, $msg)
{
	var_export(func_get_args());
// 	var_dump($msg);
}
