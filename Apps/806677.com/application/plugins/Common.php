<?php
/**
 * 公用的插件
 * Created		: 2014-06-30
 * Modified		: 2014-07-09
 * @link		: http://www.59c.net
 * @copyright	: (C) 2014 59C.NET
 *
 */
class CommonPlugin extends Yaf_Plugin_Abstract
{
	/**
	 * (non-PHPdoc)
	 * 路由之前的操作
	 * @see Yaf_Plugin_Abstract::routerStartup()
	 */
	public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
	{
		if (strtolower($request->getRequestUri())=='/admin')
		{
			$request->setRequestUri('/admin/index/index');
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * 路由结束后的操作
	 * @see Yaf_Plugin_Abstract::routerShutdown()
	 */
	public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
	{
		
		// Admin后台初始化验证等操作
		if ($request->getModuleName()=='Admin')
		{
			$this->initAdmin($request, $response);
		}

		$config = Yaf_Registry::get("config");
		$tplDir = $config->application->viewPath;
		$view = Yaf_Dispatcher::getInstance()->initView($tplDir);
		$view->assign([
			'site' => $config->site,
		]);
	}
	
	/**
	 * Admin后台验证与初始化
	 * @param Yaf_Request_Abstract $request
	 * @param Yaf_Response_Abstract $response
	 */
	protected function initAdmin(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
	{
		$config = Yaf_Registry::get("config");
		$ignoreAction = $config->admin->ignoreVerifyAction->toArray();
		$user = new UserModel();
		if ( !in_array($request->getActionName(), $ignoreAction) && !$user->isAdminLogined())
		{
			if ($request->getControllerName() == 'index' && $request->getActionName() == 'index')
			{
				$response->setRedirect('/admin/login?url='.$request->getRequestUri());
			} else {
				$response->setRedirect('/admin/login');
			}
			$response->setRedirect('/admin/login');
		} else {
			$adminCfg = include APP_PATH.'modules/Admin/admin.cfg.php';
			Yaf_Registry::set("adminCfg", $adminCfg);
			Cookie::$expire = $config->admin->cookieExpire;
			Cookie::set('admin_uid', Cookie::get('admin_uid'));
			Cookie::set('admin_sid', Cookie::get('admin_sid'));
			$userInfo = $user->read(Cookie::get('admin_uid'));
			Yaf_Registry::set("adminUserInfo", $userInfo);
			$tplDir = $config->application->directory.'/modules/Admin/views';
			$view = Yaf_Dispatcher::getInstance()->initView($tplDir);
			$view->assign([
				'uid' => Cookie::get('admin_uid'),
				'admin_user' => $userInfo,
				'_menu_block' => 'main',
				'admin_now_menu' => '',
				'cfg' => $adminCfg,
				'site' => $config->site,
			]);
		}
	}
}