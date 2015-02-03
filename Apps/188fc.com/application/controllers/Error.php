<?php
class ErrorController extends Yaf_Controller_Abstract
{
	public function errorAction()
	{
		$exception = $this->getRequest()->getException();
		$this->_view->assign("title", 'Error');
		$this->_view->assign("message", $exception->getMessage());
	}
}
