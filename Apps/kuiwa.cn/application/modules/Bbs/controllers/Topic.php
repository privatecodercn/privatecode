<?php
class TopicController extends Controller
{
    
	public function detailAction()
	{
		
		return false;
	}

	public function newAction($id=0)
	{
	    $board = new Bbs\BoardModel();
	    $boardOne = $board->read($id);
	    \Bbs\BoardModel::setBoardBreadcrumbs($boardOne);
	    $GLOBALS['breadcrumbs'][] = [
    	    'url' => null,
    	    'title' => '发表帖子'
	    ];
	    
	    $vars = [
			'board_id' => $id,
			'boardOne' => $boardOne,
		];
		$this->getView()->assign($vars);
	}
	
	public function saveNewAction()
	{
	    
	    $this->json(true, ['id'=>$id]);
	}
	
}