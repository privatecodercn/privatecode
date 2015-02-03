<?php
/**
 * 站点主控制器
 * Created		: 2014-06-30
 * Modified		: 2014-07-10
 * @link		: http://www.kuiwa.cn
 * @copyright	: (C) 2014 KUIWA.CN
 */
class IndexController extends Yaf_Controller_Abstract
{
	public function indexAction()
	{
	    echo '<a href="weixin://profile/gh_e9bc4322071f">点击关注</a><br/>';
	    echo '<a href="weixin://qr/xkzfx_bEM7tMraKk9xnU">点击关注</a>';
	    exit;
		$view = $this->getView();
		
// 		$view->assign('', );
		
	}
	
	public function testAction()
	{
		
	}
}