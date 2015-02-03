<?php
class WeixinMenuController extends Controller
{
	public $_menu_block = 'main';

	public function init()
	{
		$vars = [
			'_menu_block' => $this->_menu_block,
			'admin_now_menu' => 'video',
		];
		$this->getView()->assign($vars);
	}
	
	public function indexAction()
	{
	    
	}
	
	public function getMenuAction($appName='binchi')
	{
		$wx = new Weixin($appName);
		$menu = $wx->getMenu();
		if (!$menu)
		{
		    $menu = [];
		}

		$this->json(true, $menu);
	}
	
	/**
	 * 简单菜单管理
	 */
	public function index2Action()
	{
	    $jsonEncodeOptions = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
		$wx = new Weixin('binchi');
		$menu = $wx->getMenu(true);
		if ($menu)
		{
    		$binchiMenu = json_encode(json_decode($menu)->menu, $jsonEncodeOptions);
		} else {
		    $binchiMenu = '';
		}
		
		$wx = new Weixin('fc');
		$menu = $wx->getMenu(true);
		if ($menu)
		{
    		$fc188Menu = json_encode(json_decode($menu)->menu, $jsonEncodeOptions);
		} else {
		    $fc188Menu = '';
		}
		
		$vars = [
            'binchiMenu' => $binchiMenu,
            'fc188Menu'  => $fc188Menu,
		];
		$this->getView()->assign($vars);
	}
	
	/**
	 * 添加/编辑
	 */
	public function detailAction($id=0)
	{
		if (empty($id) || !ctype_digit($id))
		{
			$detailType = 'new';
			$detail = ORM::for_table('video')->create();
		} else {
			$detailType = 'edit';
			$detail = ORM::for_table('video')->find_one($id);
		}
		if ($detail->id)
		{
			$detail->create_time = date('Y-m-d H:i:s', $detail->create_time);
		} else {
			$detail->from = 0;
			$detail->views = rand(1, 99);
			$detail->score = 60;
			$detail->status = 1;
			$detail->play_style = 1;
			$detail->create_time = date('Y-m-d H:i:s');
		}
		$vars = [
			'detail' => $detail,
			'detailType' => $detailType,
		];
		
		$this->getView()->assign($vars);
	}

	/**
	 * 修改操作
	 */
	public function saveAction()
	{
		
		$this->json(true, ['id'=>$video->id]);
	}
	
	/**
	 * 发布菜单 
	 */
	public function releaseAction()
	{
// 		$data = [
//             'button' => 
//             [
//                 [
//                     'name' => '了解我们',
//                     'sub_button' =>
//                     [
//                         ['type'=>'view', 'name'=>'产品中心', 'url'=>'http://binchi.net'],
//                         ['type'=>'view', 'name'=>'成功案例', 'url'=>'http://binchi.net'],
//                         ['type'=>'view', 'name'=>'关于我们', 'url'=>'http://binchi.net'],
//                     ]
//     		    ],
//                 [
//                     'name' => '客服中心',
//                     'sub_button' => 
//                     [
//                         ['type'=>'view', 'name'=>'联系我们', 'url'=>'http://binchi.net'],
//                         ['type'=>'view', 'name'=>'定制开发', 'url'=>'http://binchi.net'],
//                     ]
//     		    ]
// 		    ]
// 		];

		
	    $wx = new Weixin($_POST['app_name']);
		$result = $wx->releaseMenu($_POST['content']);
	    
		if ($result)
		{
		    $db = Db::table('fragment_data');
		    $db->sign = $_POST['app_name'].'_winxin_menu';
		    $db->content = $_POST['content'];
		    $db->save();
		    $this->json(true);
		} else {
		    $this->json(false, $result->errmsg);
		}
	}
	
	/**
	 * 专辑自动完成
	 */
	public function getAlbumAction()
	{
		$word = $this->getRequest()->getQuery('term', '');
		$rows = ORM::for_table('album')->select_many('id', 'title')
					->where_like('title', $word.'%')
					->find_many();
		foreach ($rows as $row)
		{
			$datas[] = array(
				'value'	=> $row->id,
				'label'	=> $row->title,
				'name'	=> $row->title
			);
		}
		$this->json($datas);
	}
	
	/**
	 * 删除操作
	 * @param int $id
	 */
	public function deleteAction($id)
	{
		if (!String::isDigit($id))
		{
			$this->json(false, ['id'=>$id]);
		}
		$medoo = new Medoo();
		$medoo->delete('video', ['id'=>$id]);
		
		$this->json(true, ['id'=>$id]);
	}
}