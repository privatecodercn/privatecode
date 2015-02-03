<?php
/**
 * 核心方法类
 * Created		: 2014-09-15
 * Modified		: 2014-12-15
 * @link		: http://www.binchi.net
 * @copyright	: (C) 2014 BINCHI.NET
 */
class Controller extends Yaf_Controller_Abstract
{
	
	/**
	 * 输出/返回JSON数据
	 * @param boolean $success 是否成功
	 * @param array|string|int $data 成功为返回的数据，失败则为返回的失败信息提示
	 * @param array $params 更多返回的参数
	 * @param boolean $output
	 */
	public function json($success, $data=null, $params=array())
	{
		header('content-type:text/html;charset=utf-8');
		if (!is_array($success) && $success)
		{
			$arr = array(
					'success'	=> 1,
			);
			if (!is_null($data) && is_array($data))
			{
				$arr['data'] = $data;
			} else {
				$arr['message'] = $data;
			}
		} else if (is_array($success) || is_object($success)) {
			echo json_encode($success, JSON_UNESCAPED_UNICODE);
			exit;
		} else {
			$arr = array(
				'success'	=> 0,
				'message'	=> $data
			);
		}
		if ($params)
		{
			$arr = array_merge($arr, $params);
		}
		$json = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $json;
		exit;
	}
	
	/**
	 * 判断当前请求是否AJAX方式
	 * HTTP_X_REQUESTED_WITH 只有客户端用JQuery框架ajax请求才有这个参数
	 */
	public function isAjax()
	{
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH']))
		{
			return true;
		}
		// 表单提交或URL有对应的AJAX请求参数标志
		if(!empty($_POST['IS_AJAX_REQUEST']) || !empty($_GET['IS_AJAX_REQUEST']))
		{
			return true;
		}
		return false;
	}

	/**
	 * 发送404 HEADER信息
	 */
	public function header404()
	{
		if (substr(PHP_SAPI, 0, 3) == 'cgi')
		{
			header('Status: 404 Not Found');
		} else {
			header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
		}
		exit;
	}
	
}