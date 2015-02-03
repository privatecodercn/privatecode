<?php
/**
 * 公用的插件
 * Created		: 2014-06-30
 * Modified		: 2014-07-09
 * @link		: http://www.kuiwa.cn
 * @copyright	: (C) 2014 KUIWA.CN
 *
 */
class CommonPlugin extends Yaf_Plugin_Abstract
{
	// 路由结束后的操作
	public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
	{
		$this->config = Yaf_Registry::get('config');

		if ($request->getControllerName() == 'Admin')
		{
		    $request->setModuleName('Admin');
		    $request->setControllerName(ucfirst($request->getActionName()));
		} elseif ($request->getControllerName() == 'Bbs'){
		    $request->setModuleName('Bbs');
		    $request->setControllerName(ucfirst($request->getActionName()));
		}
		
		// Admin后台初始化验证等操作
		if ($request->getModuleName()=='Admin')
		{
			$this->initAdmin($request, $response);
		} elseif ($request->getModuleName()=='Bbs') {
			$this->initBbs($request, $response);
		} else {
			$this->initUser($request, $response);
		}
	}

	/**
	 * 用户验证与初始化
	 * @param Yaf_Request_Abstract $request
	 * @param Yaf_Response_Abstract $response
	 */
	protected function initUser(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
	{
		$uid = Cookie::get('uid');
		$user = new UserModel();
		Cookie::set('uid', $uid);
		Cookie::set('sid', Cookie::get('sid'));
		$userInfo = $user->read($uid);
		
		Yaf_Registry::set("userInfo", $userInfo);
		return [
			'uid' => $uid,
			'userInfo' => $userInfo,
			'site' => $this->config->site,
		];
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
	
	/**
	 * bbs模块初始化
	 * @param Yaf_Request_Abstract $request
	 * @param Yaf_Response_Abstract $response
	 */
	protected function initBbs(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
	{
		$GLOBALS['breadcrumbs'][] = [
			'url' => '/bbs',
			'title' => '论坛'
		];
		$vars = $this->initUser($request, $response);
		$config = Yaf_Registry::get('config');
		$tplDir = APP_PATH.'modules/Bbs/views';
		$view = Yaf_Dispatcher::getInstance()->initView($tplDir);
		$view->assign(
				array_merge(
					$vars, 
					[
				        'site' => $this->config->site,
				        'navCurrent' => 'nav_bbs'
                    ]
				)
		);
	}
}