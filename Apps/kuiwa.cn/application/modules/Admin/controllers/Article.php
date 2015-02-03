<?php
class ArticleController extends Controller
{
	public $_menu_block = 'main';
	public $isCopy = ['原创', '转载'];
	public $status = [-1=>'删除', '待审核', '正常'];

	public function init()
	{
		Lang::load('article');
		$this->getView()->assign([
            '_menu_block' => $this->_menu_block,
            'isCopy' => $this->isCopy,
            'status' => $this->status,
            'admin_now_menu' => 'article',
		]);
	}
	
	/**
	 * 文章列表首页
	 * @see Controller::index()
	 */
	public function indexAction()
	{
		// 获取文章列表
		$limit = 20;
		$Db = Db::table('article')
					->orderBy('id', 'desc');
		$rows = $Db->count();
		
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
			$detail = Db::table('article', 'a1')
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
		if (empty($id) || !String::isDigit($id))
		{
			$this->json(false, 'ID非法');
		} else {
			$article = Db::table('article')->findOne($_GET['id']);
			$article->status = -1;
			$return = $article->save();
			if ($return)
			{
				$this->json(true, '删除成功');
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
		$_POST['title'] = $_POST['title'];

		$mo = new ArticleModel();
		if ($mo->save($_POST))
		{
			$this->json(true);
		} else {
			if ($mo->msg)
			{
				$msg = $mo->msg;
			} else {
				$msg = Lang::get('save_article_data_fail');
			}
			$this->json(false, $msg);
		}
	}
	
}