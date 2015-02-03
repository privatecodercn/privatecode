<?php
class IndexController extends Yaf_Controller_Abstract
{
	public function indexAction()
	{
		$this->getView()->assign("content", "Hello World");
		echo microtime(1) - $_SERVER['REQUEST_TIME_FLOAT'];
	}
}