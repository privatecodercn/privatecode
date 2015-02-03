<?php
class ArticleController extends Controller
{
	public $_menu_block = 'main';
	public $isCopy = ['原创', '转载'];
	public $status = [-1=>'删除', '待审核', '正常'];

	public function init()
	{
		Lang::load('article');
		$this->getView()->assign("_menu_block", $this->_menu_block);
		$this->getView()->assign("isCopy", $this->isCopy);
		$this->getView()->assign("status", $this->status);
		$this->getView()->assign("admin_now_menu", 'article');
	}
	
	/**
	 * 文章列表首页
	 * @see Controller::index()
	 */
	public function indexAction()
	{
		// 获取文章列表
		$limit = 20;
		$orm = Db::table('article')
					->orderBy('id', 'desc');
		$rows = $orm->count();
		
		Page::init($limit, $rows);
		$list = Db::table('article')
					->orderBy('id', 'desc')
					->limit($limit)
					->offset(Page::$from)
					->findAll();

		$vars = [
			'list' => $list,
		];
		$this->getView()->assign($vars);
	}

	/**
	 * 文章详细页
	 */
	public function detailAction($id=0)
	{
	    if (!$id)
	    {
	        $this->header404();
	    }
		$detail = Db::table('article', 'a1')
						->join('article_content', 'a1.id=a2.id', 'a2')
						->findOne($id);
		if (!$detail || $detail->status != 1)
		{
		    $this->header404();
		}
		$vars = [
			'detail' => $detail,
		];
		
		$this->getView()->assign($vars);
	}
	
	public function listAction($cid=0)
	{
	    var_dump($cid);
	    return false;
	}
	
	public function byAction() 
	{
	    $this->forward('list', ['cid'=>3]);
	    return false;
	}
	
	public function hyAction() 
	{
	    $this->forward('list', ['cid'=>2]);
	    return false;
	}
	
	public function newbornAction() 
	{
	    $this->forward('list', ['cid'=>4]);
	    return false;
	}
	
	public function babyAction() 
	{
	    $this->forward('list', ['cid'=>5]);
	    return false;
	}
}