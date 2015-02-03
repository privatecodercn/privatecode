<?php
class ErrorController extends Yaf_Controller_Abstract
{
	public function errorAction()
	{
		$exception = $this->getRequest()->getException();
		$code = $exception->getCode();
		$forward = false;
		if (YAF_ENVIRON == 'product')
		{
		    $message = '访问出错了！';
		}
		switch ($code)
		{
			case '516':
				$code = 404;
				$this->detailAction($code);
				return false;
			case '42S22':
				$title = 'SQL Script Error!';
				if (!isset($message))
				{
				    $message = $exception->getMessage();
				}
				break;
			
			default:
			    $title = 'Error';
			    if (!isset($message))
			    {
			        $message = '['.$code.'] '.$exception->getMessage();
			    }
		}
		$this->getView()->assign([
			'title'   => $title,
			'message' => $message
		]);
	}
	
	public function detailAction($id)
	{
		$vars = [];
		switch ($id)
		{
			case 404:
				$vars['title'] = '页面找不到了！';
				$vars['message'] = '页面找不到了！';
			break;
			
			default:
				;
			break;
		}
		
		$view = $this->getView();
		$view->assign($vars);
		$tpl = $view->getScriptPath().'/error/'.$id.'.html.php';
		$view->display($tpl);
		return false;
	}
}
