<?php
class IndexController extends Controller
{
	public function indexAction()
	{
	    $latestNews = Db::table('article')
	                    ->selectColumns('id, title, post_time')
	                    ->orderBy('id desc')
	                    ->limit(12)
	                    ->findAll();
	    
	    $vars = [
            'latestNews' => $latestNews,
	    ];
	    
		$this->getView()->assign($vars);
	}
	
}