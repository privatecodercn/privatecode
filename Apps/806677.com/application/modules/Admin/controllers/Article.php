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
	 * 添加/修改页面
	 */
	public function detailAction($id=0)
	{
		if (empty($id) || !ctype_digit($id))
		{
			$detailType = 'new';
			$detail = Db::table('article');
		} else {
			$detailType = 'edit';
			$detail = Db::table('article')->table_alias('a1')
						->join('article_content', 'a1.id=a2.id', 'a2')
						->findOne($id);
		}
		if ($detail->id)
		{
			$detail->post_time = date('Y-m-d H:i:s', $detail->post_time);
		} else {
			$userInfo = Yaf_Registry::get("adminUserInfo");
			$detail->id = 0;
			$detail->views = rand(1, 99);
			$detail->status = 1;
			$detail->editor = $userInfo->username;
			$detail->post_time = date('Y-m-d H:i:s');
		}
		$vars = [
			'detail' => $detail,
			'detailType' => $detailType,
		];
		
		$this->getView()->assign($vars);
	}

	/**
	 * 删除一条信息
	 */
	public function deleteAction($id)
	{
		if (empty($id) || !ctype_digit($id))
		{
			$this->json(false, 'ID非法');
		} else {
			$author = Db::table('article')->findOne($id);
			$author->status = -1;
			$return = $author->save();
			if ($return)
			{
				$this->json(false, '删除成功');
			} else {
				$this->json(false, '删除失败');
			}
		}
	}

	/**
	 * 添加/修改文章处理
	 */
	public function saveAction()
	{
		if (!empty($_POST['id']) && !ctype_digit($_POST['id']))
		{
			$this->failure(Lang::get('invalid_request'));
		}

		$_POST['post_time'] = strtotime($_POST['post_time']);

		$mo = new ArticleModel();
		if ($mo->save($_POST))
		{
			if ($this->isAjax())
			{
				$this->json(true);
			} else {
				$this->success(Lang::get('handle_success'));
			}
		} else {
			if ($mo->msg)
			{
				$msg = $mo->msg;
			} else {
				$msg = Lang::get('save_article_data_fail');
			}
			if ($this->isAjax())
			{
				$this->json(false, $msg);
			} else {
				$this->failure($msg);
			}
		}
	}
}