<?php
class EventsController extends Controller
{
	public $_menu_block = 'main';
	
	public function init()
	{
		Lang::load('events');
		$this->getView()->assign("_menu_block", $this->_menu_block);
		$this->getView()->assign("admin_now_menu", 'events');
	}
	
	/**
	 * 总赛事列表页
	 */
	public function commonAction()
	{
		// 获取文章列表
		$limit = 20;
		$orm = Db::table('events_common')
					->orderBy('id', 'desc');
		$rows = $orm->count();
		
		Page::init($limit, $rows);
		$list = Db::table('events_common')
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
	 * 删除一条总赛事
	 */
	public function deleteCommonAction($id)
	{
		if (empty($id) || !ctype_digit($id))
		{
			$this->json(false, 'ID非法');
		} else {
			$return = Db::table('events_common')->where('id', $id)->delete();
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
	public function saveCommonAction()
	{
		$id = $this->getRequest()->getPost('id', '0');
		if (!empty($id) && !ctype_digit($id))
		{
			$this->failure(Lang::get('invalid_request'));
		}
	
		if ($_POST['editType']=='edit')
		{
			$model = Db::table('events_common')->findOne($id);
		} else {
			$model = Db::table('events_common');
		}
		if ($id)
		{
			$model->id = $id;
		}
		$model->name = $this->getRequest()->getPost('name', '');
		$model->short_name = $this->getRequest()->getPost('short_name', '');
		$model->brief = $this->getRequest()->getPost('brief', '');
		if ($model->save())
		{
			$this->json(true);
		} else {
			if ($mo->msg)
			{
				$msg = $mo->msg;
			} else {
				$msg = Lang::get('save_events_common_data_fail');
			}
			$this->json(false, $msg);
		}
	}
	
	/**
	 * 赛事列表页
	 */
	public function indexAction()
	{
		// 获取文章列表
		$limit = 20;
		$orm = Db::table('events_common')
					->orderBy('id', 'desc');
		$rows = $orm->count();
		
		Page::init($limit, $rows);
		$list = Db::table('events_common')
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
			$detail = Db::table('events');
		} else {
			$detailType = 'edit';
			$detail = Db::table('events')->findOne($id);
		}
		if ($detail->id)
		{
			$detail->start_time = date('Y-m-d', $detail->start_time);
			$detail->end_time = date('Y-m-d', $detail->end_time);
		} else {
			$detail->id = 0;
			$detail->start_time = date('Y-m-d');
			$detail->end_time = date('Y-m-d');
			$detail->name = '';
			$detail->short_name = '';
			$detail->brief = '';
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
			$return = Db::table('events')->where('id', $id)->delete();
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
		$id = $this->getRequest()->getPost('id', '0');
		if (!empty($id) && !ctype_digit($id))
		{
			$this->failure(Lang::get('invalid_request'));
		}
	
		$start_time = strtotime($this->getRequest()->getPost('start_time', ''));
		$end_time = strtotime($this->getRequest()->getPost('end_time', ''));
	
		if ($_POST['editType']=='edit')
		{
			$model = Db::table('events')->findOne($id);
		} else {
			$model = Db::table('events');
		}
		if ($id)
		{
			$model->id = $id;
		}
		$model->name = $this->getRequest()->getPost('name', '');
		$model->short_name = $this->getRequest()->getPost('short_name', '');
		$model->brief = $this->getRequest()->getPost('brief', '');
		if ($model->save())
		{
			$this->json(true);
		} else {
			if ($mo->msg)
			{
				$msg = $mo->msg;
			} else {
				$msg = Lang::get('save_events_data_fail');
			}
			$this->json(false, $msg);
		}
	}
	
	
	
	
}
