<?php
class FragmentController extends Controller
{
	public $_menu_block = 'main';
	
	public function init()
	{
		$this->getView()->assign([
            '_menu_block' => $this->_menu_block,
            'admin_now_menu' => 'fragment',
		]);
	}
	
	public function indexAction()
	{
		$aboutUs = Db::table('fragment_data')
					->where('sign', 'aboutus')
					->findOne();
		if ($aboutUs)
		{
			$aboutUs = $aboutUs->content;
		} else {
			$aboutUs = '';
		}
		$links = Db::table('fragment_data')
					->where('sign', 'links')
					->findOne();
		if ($links)
		{
			$links = $links->content;
		} else {
			$links = '';
		}
		
		$vars = [
			'aboutUs' => $aboutUs,
			'links' => $links,
		];
		$this->getView()->assign($vars);
	}

	public function oneKeyGenerateAction()
	{
	
	}

	public function indexFocusAction ()
	{
		$focus = Local_Fragment::getIndexFocus();
		
		$vars = [
			'focus' => $focus,
		];
		$this->getView()->assign($vars);
	}
	
	public function saveFocusAction()
	{
		$focusIndex = (int)$this->getRequest()->getPost('focusIndex', 0);
		$title = $this->getRequest()->getPost('title', '');
		if (!$title || !is_string($title))
		{
			$this->json(false, '标题不能为空！');
		}
		$url = $this->getRequest()->getPost('url', '');
		if (!$url || !is_string($url))
		{
			$this->json(false, '链接不能为空！');
		}
		$cover_image_id = (int)$this->getRequest()->getPost('cover_image_id', 0);
		$cover_image = $this->getRequest()->getPost('cover_image', '');
		$create_time = (int)strtotime($this->getRequest()->getPost('create_time', 0));
		$brief = $this->getRequest()->getPost('brief', '');
		
		$row = Db::table('fragment_data')
					->where('sign', 'indexFocus')
					->findOne();
		if ($row)
		{
			$focusContent = $row->content ? : '[]';
		} else {
			$focusContent = '[]';
			$row = Db::table('fragment_data');
			$row->sign = 'indexFocus';
		}
		$focus = json_decode($focusContent);
		$focus[$focusIndex] = new stdClass();
		$focus[$focusIndex]->title = $title;
		$focus[$focusIndex]->url = $url;
		$focus[$focusIndex]->cover_image_id = $cover_image_id;
		$focus[$focusIndex]->cover_image = $cover_image;
		$focus[$focusIndex]->create_time = $create_time;
		if ($focusIndex == 0)
		{
			$focus[$focusIndex]->brief = $brief;
		}
		
		$focusContent = json_encode($focus, JSON_UNESCAPED_UNICODE);
		$row->content = $focusContent;
		$row->save();
		$this->json(true);
	}
	
	public function indexNewsAction()
	{
		$list = Local_Fragment::getIndexNews();
		if (!$list)
		{
			$item = new stdClass();
			$item->title = '';
			$item->url = '';
			$list = [$item];
		}
		
		$vars = [
			'list' => $list
		];
		$this->getView()->assign($vars);
	}

	public function saveIndexNewsAction()
	{
		$titles = $this->getRequest()->getPost('titles', []);
		$urls = $this->getRequest()->getPost('urls', []);
		$list = [];
		foreach ($titles as $k => $title) 
		{
			$item = new stdClass();
			$item->title = $title;
			$item->url = $urls[$k];
			$list[] = $item;
		}
		$content = json_encode($list, JSON_UNESCAPED_UNICODE);

		$row = Db::table('fragment_data')
					->where('sign', 'indexNews')
					->findOne();
		if (!$row)
		{
			$row = Db::table('fragment_data');
			$row->sign = 'indexNews';
		}
		$row->content = $content;
		$row->save();
		
		$this->json(true);
	}
	
	public function saveAction($sign, $saveDb=true)
	{
		if ($saveDb)
		{
			$row = Db::table('fragment_data')
						->where('sign', $sign)
						->findOne();
			if ($row)
			{
				$row->content = $_POST['content'];
				$row->save();
			} else {
				$row = Db::table('fragment_data');
				$row->sign = $sign;
				$row->content = $_POST['content'];
				$row->save();
			}
		}
	
		$fragmentDir = APP_PATH.'data/fragment/';
		if (!is_dir($fragmentDir))
		{
			mkdir($fragmentDir, 0755, true);
		}
		$type = 'html';
		$isShtml = false;
		$shtmlFile = WEB_PATH.'inc/';
		switch ($sign)
		{
			case 'aboutus':
				$content = $row->content;
				$isShtml = true;
				$shtmlFile .= 'aboutus.shtml';
				break;
					
			case 'links':
				$content = '';
				$arr = json_decode($row->content);
				foreach ($arr as $item)
				{
					$content .= '<li><a href="'.$item->url.'" target="_blank">'.$item->title.'</a></li>';
				}
				$isShtml = true;
				$shtmlFile .= 'links.shtml';
				break;
					
			case 'hotVideo':
				$fields = 'id,title,score,create_time,cover_image';
				$rows = Db::table('video')
							->select_many_expr($fields)
							->where('status', '1')
							->where('play_style', '1')
							->orderBy('score', 'desc')
							->orderBy('id', 'desc')
							->limit(5)
							->findAll(null, true);
				$content = '<?php return '.var_export($rows, true).';';
				$type = 'php';
				$tpl = APP_PATH.'views/hotVideo.html.php';
				$html = $this->getView()->render($tpl, ['hotVideoList'=>$rows]);
				$filename = WEB_PATH.'inc/hotVideo.shtml';
				file_put_contents($filename, $html);
				break;
					
			case 'viewsRankVideo':
				$fields = 'id,title,views,create_time,cover_image';
				$rows = Db::table('video')
							->select_many_expr($fields)
							->where('status', '1')
							->where('play_style', '1')
							->orderBy('views', 'desc')
							->orderBy('id', 'desc')
							->limit(5)
							->findAll(null, true);
				$content = '<?php return '.var_export($rows, true).';';
				$type = 'php';
				$tpl = APP_PATH.'views/viewsRankVideo.html.php';
				$html = $this->getView()->render($tpl, ['viewsRankVideoList'=>$rows]);
				$filename = WEB_PATH.'inc/viewsRankVideo.shtml';
				file_put_contents($filename, $html);
				break;
					
			default:
				;
				break;
		}
	
		if ($type == 'php')
		{
			file_put_contents($fragmentDir.$sign.'.php', $content);
		} else {
			file_put_contents($fragmentDir.$sign.'.html', $content);
		}
		if ($isShtml)
		{
			file_put_contents($shtmlFile, $content);
		}
		
		// 请求首页重新生成静态页
		file_get_contents(Yaf_Registry::get('config')->site->url.'/index.php');
	
		$this->json(true);
	}
}