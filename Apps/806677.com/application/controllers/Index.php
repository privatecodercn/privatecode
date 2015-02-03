<?php
/**
 * 主题帖
 * Created		: 2014-06-30
 * Modified		: 2014-07-10
 * @link		: http://www.806677.com
 * @copyright	: (C) 2014 806677.COM
 */
class IndexController extends Yaf_Controller_Abstract
{
	public function indexAction()
	{
		$newsList = Local_Fragment::getIndexNews();
		if (!$newsList)
		{
			$newsList = [];
		}
		
		$focus = Local_Fragment::getIndexFocus();
		
		$fields = 'id,views,score,definition,play_style,create_time,title,cover_image,url';
		$newestVideoList = Db::table('video')
				->selectColumns($fields)
				->where('status', '1')
				->orderBy('id', 'desc')
				->limit(8)
				->findAll();

		$vars = [
			'newsList' => $newsList,
			'newestVideoList' => $newestVideoList,
			'focusBig' => $focus[0],
			'focusSmall' => $focus[1],
		];
		
		
		$view = $this->getView();
		$view->assign($vars);
		$tpl = $view->getScriptPath().'/index/index.html.php';
		$html = $view->render($tpl);
		file_put_contents(WEB_PATH.'index.html', $html);
	}
	
}