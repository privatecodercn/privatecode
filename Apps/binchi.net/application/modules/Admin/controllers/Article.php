<?php
class ArticleController extends Controller
{
	public $_menu_block = 'main';
	public $isCopy = ['原创', '转载'];
	public $status = [-1=>'删除', '待审核', '正常'];

	public function init()
	{
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
		$orm = ORM::for_table('article')
					->order_by_desc('id');
		$rows = $orm->count();
		
		Page::init($limit, $rows);
		$list = ORM::for_table('article')
					->order_by_desc('id')
					->limit($limit)
					->offset(Page::$from)
					->find_many();

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
			$detail = ORM::for_table('article')->create();
		} else {
			$detailType = 'edit';
			$detail = ORM::for_table('article')->table_alias('a1')
						->join('article_content', ['a1.id', '=', 'a2.id'], 'a2')
						->find_one($id);
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
			$this->failure('ID非法');
		} else {
			$article = ORM::for_table('article')->find($_GET['id']);
			$article->status = -1;
			$return = $article->save();
			if ($return)
			{
				$this->success('删除成功');
			} else {
				$this->failure('删除失败');
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
	
	/**
	 * 上传图片
	 */
	public function uploadImgAction()
	{
		$dir = 'a/';
		// 如果有文件上传
		if (isset($_FILES['0']) && $_FILES['0']['error'] != UPLOAD_ERR_NO_FILE)
		{
			$options = array(
				'image'		=> true,
				'image_type'=> [IMAGETYPE_JPEG],
				'max_size'	=> 1024000,
				'save_path'	=> IMG_PATH.$dir,
			);
			$upload = new UploadFile($options);
			// 上传错误提示错误信息
			if(!$upload->upload())
			{
				$this->json(false, $upload->error());
			} else {// 上传成功 获取上传文件信息
				$destFile = $upload->fileList[0];
			}
			$this->json(true, [$dir.$destFile]);
		} else {
			$this->json(false, 'no file uploaded.');
		}
	}
}