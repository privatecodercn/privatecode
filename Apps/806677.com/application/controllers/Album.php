<?php
class AlbumController extends Yaf_Controller_Abstract
{
	
	public function indexAction($id=0)
	{
		$list = Db::table('album')
					->orderBy('id', 'desc')
					->findAll();
		
		$vars = [
			'list' => $list,
			'seoTitle' => '专辑列表'
		];

		$this->getView()->assign($vars);
	}
	
}