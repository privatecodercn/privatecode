<?php
/**
 * 首页
 * Created		: 2014-06-30
 * Modified		: 2014-08-11
 * @link		: http://www.kuiwa.cn
 * @copyright	: (C) 2014 KUIWA.CN
 */
class IndexController extends Controller
{
	
	public function init()
	{
// 		var_dump($this->getRequest()->getActionName());
// 		exit;
	}
	
	public function indexAction($id=0)
	{
		// 版块列表
		$board = new Bbs\BoardModel();
		if ($id)
		{
		    $boardList = $board->getSubList($id);
		    $boardOne = $board->read($id);
		    $GLOBALS['breadcrumbs'][] = [
				'url' => '/bbs/board-'.$boardOne->id.'.html',
				'title' => $boardOne->name
			];
		} else {
    		$boardList = $board->getAllList();
		}
		
		// 版块数据
		$boardTodayData = $board->getTodayData();
		
		$vars = [
			'boardList' => $boardList,
			'boardTodayData' => $boardTodayData
		];
		$this->getView()->assign($vars);
		
	}
	
	public function __call($action, $args)
	{
		var_dump($action, $args);
		exit;
	}
}