<?php
class CategoryController extends Controller
{
	public $_menu_block = 'main';
	public $type = ['请选择', '文章', '帖子'];

	public function init()
	{
		$this->getView()->assign([
            '_menu_block' => $this->_menu_block,
            'type' => $this->type,
            'admin_now_menu' => 'category',
		]);
	}
	
	/**
	 * 分类列表首页
	 * @see Controller::index()
	 */
	public function indexAction()
	{
		// 获取分类列表
		$limit = 50;
		$db = Db::table('category');
		$rows = $db->count();
		
		Page::init($limit, $rows);
		$list = $db->orderBy('id', 'asc')
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
			$detail = Db::table('category');
		} else {
			$detailType = 'edit';
			$detail = Db::table('category')->findOne($id);
		}
		if ($detail->id)
		{
			$detail->post_time = date('Y-m-d H:i:s', $detail->post_time);
		} else {
			$detail->id = 0;
			$detail->pid = 0;
			$detail->level = 1;
			$detail->type = 1;
			$detail->name = '';
			$detail->path = '';
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
			$return = Db::table('category')->delete($id);
			if ($return)
			{
				$this->json(true, '删除成功');
			} else {
				$this->json(false, '删除失败');
			}
		}
	}

	/**
	 * 添加/修改分类处理
	 */
	public function saveAction()
	{
		if (!ctype_digit($_POST['id']))
		{
			$this->failure(Lang::get('invalid_request'));
		}
		if (empty($_POST['id']))
		{
			$category = Db::table('category');
		} else {
			$category = Db::table('category')->findOne($_POST['id']);
		}
		$category->pid = 0;
		$category->level = 1;
		$category->type = (int)$_POST['type'];
		$category->name = $_POST['name'];
		$category->path = '';
		$result = $category->save();
		if ($result)
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
				$msg = Lang::get('save_category_data_fail');
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