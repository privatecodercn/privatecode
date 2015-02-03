<?php
class TiController extends Controller
{
	
	public function indexAction()
	{
		$start = 2011;
		$year = date('Y');
		$maxSession = $year - ($start-1);
		
		$vars = [
			'startYear' => $start,
			'maxSession' => $maxSession,
			'seoTitle' => 'TI国际邀请赛-视频列表'
		];

		$this->getView()->assign($vars);
	}
	
	public function detailAction($session)
	{
		$detail = Db::table('album')->where('sign', 'ti'.$session)->findOne();
		if (!$detail)
		{
			$this->header404();
		}
		$detail->tags = explode(',', $detail->tags);
		
		$list = Db::table('album_videos')->where('a_id', $detail->id)->findAll();
		$idList = [];
		$orderList = [];
		foreach ($list as $v)
		{
			$idList[] = $v->v_id;
			$orderList[$v->v_id] = $v->order_id;
		}
		if ($idList)
		{
			$videoList = Db::table('video')->whereIn('id', $idList)->findAll();
		} else {
			$videoList = [];
		}
		
		$vars = [
			'detail' => $detail,
			'videoList' => $videoList,
			'orderList' => $orderList,
			'seoTitle' => $detail->title
		];

		$view = $this->getView();
		$view->assign($vars);
		$tpl = $view->getScriptPath().'/ti/detail-'.$session.'.html.php';
		if (!is_file($tpl))
		{
			$tpl = $view->getScriptPath().'/ti/detail.html.php';
		}
		$html = $view->render($tpl, $vars);
		if (PRODUCTION)
		{
			$filename = WEB_PATH.'ti'.$session.'.html';
			file_put_contents($filename, $html);
		}
	}
	
}
