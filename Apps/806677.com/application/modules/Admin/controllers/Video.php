<?php
class VideoController extends Controller
{
	public $_menu_block = 'main';
	public $status = [-1=>'删除', '待审核', '正常'];

	public function init()
	{
		$videoSite = Db::table('video_site')->findAll(true);
		$vars = [
			'_menu_block' => $this->_menu_block,
			'admin_now_menu' => 'video',
			'status' => $this->status,
			'from' => Arr::simple($videoSite),
		];
		$this->getView()->assign($vars);
	}
	
	/**
	 * 视频列表
	 */
	public function indexAction()
	{
		// 获取列表
		$limit = 20;
		$orm = Db::table('video')
				->orderBy('id', 'desc');
		$rows = $orm->count();
		
		Page::init($limit, $rows);
		$list = Db::table('video')
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
			$detail = Db::table('video');
		} else {
			$detailType = 'edit';
			$detail = Db::table('video')->findOne($id);
		}
		if ($detail->id)
		{
			$detail->create_time = date('Y-m-d H:i:s', $detail->create_time);
		} else {
			$detail->from = 2;
			$detail->views = rand(1, 99);
			$detail->score = 60;
			$detail->status = 1;
			$detail->play_style = 1;
			$detail->type = 2;
			$detail->definition = 4;
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
		$id = $this->getRequest()->getPost('id', '0');
		if (empty($id) || !ctype_digit($id))
		{
			$video = Db::table('video');
		} else {
			$video = Db::table('video')->findOne($id);
			if (!$video->id)
			{
				$this->json(false, ['id'=>$id]);
			}
		}

		$cover_image_id = (int)$this->getRequest()->getPost('cover_image_id', 0);
		$video->from = (int)$this->getRequest()->getPost('from', 0);
		$video->title = $this->getRequest()->getPost('title', '');
		$video->cover_image_id = $cover_image_id;
		$video->cover_image = $this->getRequest()->getPost('cover_image', '');
		$video->score = (int)$this->getRequest()->getPost('score', 0);
		$video->views = (int)$this->getRequest()->getPost('views', 0);
		$video->status = (int)$this->getRequest()->getPost('status', 0);
		$video->definition = (int)$this->getRequest()->getPost('definition', 1);
		$video->play_style = (int)$this->getRequest()->getPost('play_style', 1);
		$video->type = (int)$this->getRequest()->getPost('type', 2);
		$video->create_time = time();
		$video->author_uid = $this->getRequest()->getPost('author_uid', '0');
		$video->author = $this->getRequest()->getPost('author', '');
		$video->url = $this->getRequest()->getPost('url', '');
		$video->code = $this->getRequest()->getPost('code', '');
		$video->brief = $this->getRequest()->getPost('brief', '');
		
		if ($video->is_new)
		{
			$video->save();
		}
		
		/**
		 * 保存tag信息
		*/
		$tags = $this->getRequest()->getPost('tags', 0);
		$tag = new TagModel();
		$tagData = array(
			'tags'		=> $tags,
			'target_id'	=> $video->id,
			'type'		=> 3,
		);
		$tag->save($tagData);
		
		$video->tags = $tag->updateData['tags'];
		$video->tag_ids = $tag->updateData['tag_ids'];
		$video->save();
		
		/**
		 * 保存图片关联信息
		*/
		$sql = 'update pics set tid='.$video->id.' where id='.$cover_image_id;
		Db::table('pics')->execute($sql);
		
		/**
		 * 添加专辑关联
		 */
		$album_id = (int)$this->getRequest()->getPost('album_id', 0);
		if ($album_id)
		{
			$av = Db::table('album_videos')
					->where('a_id', $album_id)
					->where('v_id', $video->id)
					->findOne();
			if (!$av)
			{
				$av = Db::table('album_videos');
				$av->a_id = $album_id;
				$av->v_id = $video->id;
				$av->save();
			}
		}
		
		// 请求首页重新生成静态页
		file_get_contents(Yaf_Registry::get('config')->site->url.'/index.php');
		
		$this->json(true, ['id'=>$video->id]);
	}
	
	/**
	 * 删除操作
	 * @param int $id
	 */
	public function deleteAction($id)
	{
		if (empty($id) || !ctype_digit($id))
		{
			$this->json(false, 'ID非法');
		} else {
			$author = Db::table('video')->findOne($id);
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
	 * 根据视频源播放页地址,自动获取视频详细信息
	 * @param string $url
	 */
    public function autoVideoDetailAction($url)
    {
        $url = urldecode($url);
        $arr = parse_url($url);
        
        switch ($arr['host']) {
            case 'v.youku.com':
                parse_str($arr['query'], $query);
                $id = substr($arr['path'], 11, -5);
                $fid = $query['f'];
                
                $curl = new ICurl();
                $content = $curl->get($url);
                preg_match('~<span id="subtitle">(.+?)</span>~is', $content, $m);

                $data = [
		            'code' => 'http://player.youku.com/player.php/Type/Folder/Fid/'.$fid.'/Ob/1/sid/'.$id.'/v.swf',
                    'title' => $m[1]
                ];
                break;
            
            default:
                ;
                break;
        }
        
        $this->json(true, $data);
    }
	
}