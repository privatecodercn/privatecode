<?php
/**
 * 主题帖
 * Created		: 2014-10-09
 * Modified		: 2014-10-09
 * @link		: http://www.806677.com
 * @copyright	: (C) 2014 806677.COM
 * @example		: /d/web/yaf/command 806677.com fragment/recacheHotVideo
 */
class FragmentCmd
{
	
	public function recacheHotVideo()
	{
		$fields = 'id,title,score,create_time,cover_image';
		$rows = Db::table('video')
					->selectColumns($fields)
					->where('status', '1')
					->where('play_style', '1')
					->orderBy('score', 'desc')
					->orderBy('id', 'desc')
					->limit(5)
					->findAll(null, true);
		$tpl = APP_PATH.'views/hotVideo.html.php';
		$html = $this->getView()->render($tpl, ['hotVideoList'=>$rows]);
		$filename = WEB_PATH.'inc/hotVideo.shtml';
		file_put_contents($filename, $html);
		echo "end.\n";
		return false;
	}
	
	public function recacheViewsRankVideo()
	{
		$fields = 'id,title,views,create_time,cover_image';
		$rows = Db::table('video')
					->selectColumns($fields)
					->where('status', '1')
					->where('play_style', '1')
					->orderBy('score', 'desc')
					->orderBy('id', 'desc')
					->limit(5)
					->findAll(null, true);
		$tpl = APP_PATH.'views/viewsRankVideo.html.php';
		$html = $this->getView()->render($tpl, ['viewsRankVideoList'=>$rows]);
		$filename = WEB_PATH.'inc/viewsRankVideo.shtml';
		file_put_contents($filename, $html);
		echo "end.\n";
		return false;
	}
	
	public function getView()
	{
		return new Yaf_View_Simple(APP_PATH.'views/');
	}
}