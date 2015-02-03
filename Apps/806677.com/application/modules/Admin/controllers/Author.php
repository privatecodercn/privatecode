<?php
class AuthorController extends Controller
{
	public $_menu_block = 'main';
	public $status = [-1=>'删除', '待审核', '正常'];
	public $user = null;

	public function init()
	{
		$this->getView()->assign("_menu_block", $this->_menu_block);
		$this->getView()->assign("status", $this->status);
		$this->getView()->assign("admin_now_menu", 'author');
		$this->user = Db::table('user')->setPkColumn('uid');
	}
	
	/**
	 * 列表
	 */
	public function indexAction()
	{
		$limit = 20;
		$orm = $this->user->whereIn('type', [21, 22])
					->orderBy('uid', 'desc');
		$rows = $orm->count();
		
		Page::init($limit, $rows);
		$list = $this->user
					->orderBy('uid', 'desc')
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
	public function detailAction($uid=0)
	{
		if (empty($uid) || !ctype_digit($uid))
		{
			$detailType = 'new';
			$detail = $this->user;
		} else {
			$detailType = 'edit';
			$detail = $this->user->findOne($uid);
		}
		if ($detail->uid)
		{
			$detail->regtime = date('Y-m-d H:i:s', $detail->regtime);
		} else {
			$detail->uid = 0;
			$detail->status = 1;
			$detail->regtime = date('Y-m-d H:i:s');
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
	public function deleteAction($uid)
	{
		if (empty($uid) || !ctype_digit($uid))
		{
			$this->json(false, 'ID非法');
		} else {
			$author = $this->user->findOne($uid);
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
	 * 添加/修改处理
	 */
	public function saveAction()
	{
		$uid = $this->getRequest()->getPost('uid', '0');
		$editType = $this->getRequest()->getPost('editType', 'add');
		if (!empty($uid) && !ctype_digit($uid))
		{
			$this->failure(Lang::get('invalid_request'));
		}
	
		$regtime = strtotime($this->getRequest()->getPost('regtime', time()));
	
		$user = new UserModel();
		if ($editType=='new')
		{
			$author = $user;
		} else {
			$author = $user->read($uid);
		}
		if ($uid)
		{
			$author->uid = $uid;
		}
		$author->username = $this->getRequest()->getPost('nickname', '');
		$author->nickname = $this->getRequest()->getPost('nickname', '');
		$author->realname = $this->getRequest()->getPost('realname', '');
		$author->regtime = $regtime;
		$author->status = $this->getRequest()->getPost('status', '0');
		$author->brief = $this->getRequest()->getPost('brief', '');
		$author->type = 22;
		
		if ($user->save($author))
		{
			$this->json(true);
		} else {
			if ($mo->msg)
			{
				$msg = $mo->msg;
			} else {
				$msg = Lang::get('save_author_data_fail');
			}
			$this->json(false, $msg);
		}
	}
	
}
