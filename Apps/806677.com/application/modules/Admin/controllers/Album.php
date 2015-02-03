<?php
class AlbumController extends Controller
{
	public $_menu_block = 'main';
	public $status = [-1=>'删除', '待审核', '正常'];

	public function init()
	{
		$this->getView()->assign("_menu_block", $this->_menu_block);
		$this->getView()->assign("admin_now_menu", 'video');
		$this->getView()->assign("status", $this->status);
	}
	/**
	 * 列表
	 */
	public function indexAction()
	{
		// 获取列表
		$limit = 20;
		$orm = Db::table('album')
				->orderBy('id', 'desc');
		$rows = $orm->count();
		
		Page::init($limit, $rows);
		$list = Db::table('album')
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
	 * 添加/编辑
	 */
	public function detailAction($id=0)
	{
		if (empty($id) || !ctype_digit($id))
		{
			$detailType = 'new';
			$detail = Db::table('album');
		} else {
			$detailType = 'edit';
			$detail = Db::table('album')->findOne($id);
		}
		if ($detail->id)
		{
			$detail->create_time = date('Y-m-d H:i:s', $detail->create_time);
		} else {
			$detail->from = 0;
			$detail->views = rand(1, 99);
			$detail->score = 60;
			$detail->status = 1;
			$detail->create_time = date('Y-m-d H:i:s');
		}
		if ($detail->id)
		{
			$videoList = Db::table('video')
							->join('album_videos', 'video.id=album_videos.v_id')
							->where('album_videos.a_id', $id)
							->findAll();
		} else {
			$videoList = [];
		}
		$vars = [
			'detail' => $detail,
			'detailType' => $detailType,
			'videoList' => $videoList
		];
		
		$this->getView()->assign($vars);
	}
	
	/**
	 * 保存专辑信息
	 */
	public function saveAction()
	{
		$id = $this->getRequest()->getPost('id', '0');
		if (empty($id) || !ctype_digit($id))
		{
			$album = Db::table('album');
		} else {
			$album = Db::table('album')->findOne($id);
			if (!$album->id)
			{
				$this->json(false, ['id'=>$id]);
			}
		}

		$cover_image_id = (int)$this->getRequest()->getPost('cover_image_id', 0);
		$album->sign = $this->getRequest()->getPost('sign', '');
		$album->title = $this->getRequest()->getPost('title', '');
		$album->cover_image_id = $cover_image_id;
		$album->cover_image = $this->getRequest()->getPost('cover_image', '');
		$album->score = (int)$this->getRequest()->getPost('score', 0);
		$album->views = (int)$this->getRequest()->getPost('views', 0);
		$album->status = (int)$this->getRequest()->getPost('status', 0);
		$album->create_time = time();
		$album->author_uid = $this->getRequest()->getPost('author_uid', '0');
		$album->author = $this->getRequest()->getPost('author', '');
		$album->content = $this->getRequest()->getPost('content', '');
	
		if ($album->is_new)
		{
			$album->save();
		}

		/**
		 * 保存tag信息
		 */
		$tags = $this->getRequest()->getPost('tags', 0);
		$tag = new TagModel();
		$tagData = array(
			'tags'		=> $tags,
			'target_id'	=> $album->id,
			'type'		=> 2,
		);
		$tag->save($tagData);
		
		$album->tags = $tag->updateData['tags'];
		$album->tag_ids = $tag->updateData['tag_ids'];
		$album->save();
		
		/**
		 * 保存图片关联信息
		 */
		$sql = 'update pics set tid='.$album->id.' where id='.$cover_image_id;
		Db::table('pics')->execute($sql);
		
		$this->json(true, ['id'=>$album->id]);
	}
	
	/**
	 * 删除专辑
	 * @param number $id
	 */
	public function deleteAction($id=0)
	{
		$id = (int)$id;
		if (!$id)
		{
			$this->json(false, 'ID非法');
		}
		Db::table('album')->where('id', $id)->delete();
		
		Db::table('tag_data')
				->where('target_type', 2)
				->where('target_id', $id)
				->delete();
				
		Db::table('pics')
				->where('type', 2)
				->where('tid', $id)
				->delete();
		
		$this->json(true, ['id'=>$id]);
	}

	/**
	 * 专辑自动完成
	 */
	public function autoGetAlbumAction()
	{
		$word = $this->getRequest()->getQuery('term', '');
		$rows = Db::table('album')
					->selectColumn('id,title')
					->whereLike('title', $word.'%')
					->findAll();
		$datas = [];
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
	
	
}
