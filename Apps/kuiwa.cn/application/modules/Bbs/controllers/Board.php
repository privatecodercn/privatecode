<?php
class BoardController extends Controller
{
    /**
     * 版块帖子列表或子版块列表
     * @param int $id
     * @return boolean
     */
    public function detailAction($id)
    {
    	$board = new Bbs\BoardModel();
    	$boardOne = $board->read($id);
    	if ($boardOne->lvl == 1)
    	{
	        $this->forward('index', 'index', [$id]);
	        return false;
    	}
    	
    	\Bbs\BoardModel::setBoardBreadcrumbs($boardOne);
    	
    	$vars = [
    	   'boardOne' => $boardOne,
    	];
    	 
    	$this->getView()->assign($vars);
    }
    
    
}