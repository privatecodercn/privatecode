<?php
/**
 * 主题帖
 * Created		: 2014-05-29
 * Modified		: 2014-07-09
 * @link		: http://www.kuiwa.cn
 * @copyright	: (C) 2014 KUIWA.CN
 */
class BoardController extends Controller
{
	/**
	 * 版块列表
	 */
	public function indexAction()
	{
		$board = new Bbs\BoardModel();
		$boardList = $board->getAllListFromDb();
		
		$this->getView()->assign('boardList', $boardList);
	}
	
	/**
	 * 版块批量修改
	 */
	public function doBatchSaveAction()
	{
		$table = 'bbs_board';
		// 修改
		$db = Db::table($table);
		foreach ($_POST['name'] as $id=>$name)
		{
			$data = [
				'name'		=> $name,
				'orderid'	=> $_POST['order'][$id]
			];
			$db->update($data, $id);
		}
		// 新增
		$newName = isset($_POST['newname']) ? $_POST['newname'] : [];
		$pInfos = [];
		foreach ($newName as $k=>$name)
		{
			$pid = $_POST['newpid'][$k];
			if (!$pid)
			{
				$pInfos[$pid] = 0;
			} else if (!isset($pInfos[$pid])) {
				$pInfos[$pid] = Db::table($table)->selectColumns('lvl')->findColumn($pid);
			}
			if (isset($_POST['managers']))
			{
			    $managers = json_encode($_POST['managers']);
			} else {
			    $managers = '{}';
			}
			$data = [
				'name'		=> $name,
				'orderid'	=> $_POST['neworder'][$k],
				'lvl'		=> $pInfos[$pid] + 1,
				'pid'		=> $pid,
				'status'	=> 1,
				'managers'  => $managers,
				'paths'     => $path,
			];
			$db->insert($data);
		}
		$board = new Bbs\BoardModel();
		$board->getAllList(true);
		
		$this->json(true);
	}
	
	/**
	 * 单个版块修改
	 */
	public function doSaveAction()
	{
		
	}
	
	/**
	 * 删除版块
	 * @param int $id
	 */
	public function deleteAction($id)
	{
		if (!String::isDigit($id))
		{
			$this->json(false, ['id'=>$id]);
		}
		
		/**
		 * 版块下有帖子无法进行删除
		 */
		if (Db::table('bbs_posts')->findOne())
		{
		    $this->json(false, '有帖子数据的版块不能进行删除！');
		}
		
		Db::table('bbs_board')->delete($id);
		
		$board = new BbsBoardModel();
		$board->getAllList(true);
		
		$this->json(true, ['id'=>$id]);
	}
}