<?php
/**
 * 公用的插件
 * @author Administrator
 *
 */
class CommonPlugin extends Yaf_Plugin_Abstract
{
	protected $config;
	
	// 路由结束后的操作
	public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
	{
		$this->config = Yaf_Registry::get('config');
		
		// Admin后台初始化验证等操作
		if ($request->getControllerName() == 'Admin')
		{
		    $request->setModuleName('Admin');
		    $request->setControllerName(ucfirst($request->getActionName()));
		} elseif ($request->getControllerName() == 'Weixin'){
		    $request->setModuleName('Weixin');
		    $request->setControllerName(ucfirst($request->getActionName()));
		    $request->setActionName('index');
		}
		
		// Admin后台初始化验证等操作
		if ($request->getModuleName()=='Admin')
		{
			$this->initAdmin($request, $response);
		} else {
// 			$this->initUser($request, $response);
		}

		$tplDir = $this->config->application->viewPath;
		$view = Yaf_Dispatcher::getInstance()->initView($tplDir);
		$view->assign([
			'site' => $this->config->site,
		]);
	}
	
	/**
	 * Admin后台验证与初始化
	 * @param Yaf_Request_Abstract $request
	 * @param Yaf_Response_Abstract $response
	 */
	protected function initAdmin(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
	{
		$ignoreAction = $this->config->admin->ignoreVerifyAction->toArray();
		$user = new UserModel();
		if ( !in_array($request->getActionName(), $ignoreAction) && !$user->isAdminLogined())
		{
			if ($request->getControllerName() == 'index' && $request->getActionName() == 'index')
			{
				$response->setRedirect('/admin/login?url='.$request->getRequestUri());
			} else {
				$response->setRedirect('/admin/login');
			}
		} else {
			$adminCfg = include APP_PATH.'modules/Admin/admin.cfg.php';
			Yaf_Registry::set('adminCfg', $adminCfg);
			
			Cookie::$expire = $this->config->admin->cookieExpire;
			Cookie::set('admin_uid', Cookie::get('admin_uid'));
			Cookie::set('admin_sid', Cookie::get('admin_sid'));
			$userInfo = $user->read(Cookie::get('admin_uid'));
			
			Yaf_Registry::set("adminUserInfo", $userInfo);
			
			$tplDir = APP_PATH.'modules/Admin/views';
			$view = Yaf_Dispatcher::getInstance()->initView($tplDir);
			$view->assign([
				'uid' => Cookie::get('admin_uid'),
				'adminUserInfo' => $userInfo,
				'_menu_block' => 'main',
				'admin_now_menu' => '',
				'cfg' => $adminCfg,
				'site' => $this->config->site,
			]);
		}
	}
}