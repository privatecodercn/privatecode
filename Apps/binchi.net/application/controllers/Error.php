<?php
class ErrorController extends Yaf_Controller_Abstract
{
	public function init()
	{
		Yaf_Dispatcher::getInstance()->autoRender(FALSE);
	}
	
	public function errorAction()
	{
		$exception = $this->getRequest()->getException();
		var_dump($exception);
		$this->_view->assign("title", 'Error');
		$this->_view->assign("message", $exception->getMessage());
	}
}
