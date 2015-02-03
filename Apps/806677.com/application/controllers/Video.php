<?php
class VideoController extends Controller
{
	
	public function detailAction($id=0, $page=1)
	{
		if (ctype_digit($id))
		{
			$idStr = String::idCrypt($id);
			$this->getResponse()->setHeader($this->getRequest()->getServer('SERVER_PROTOCOL'), '301 Moved Permanently');
			$url = ($page>1) 
							? '/video/'.$idStr.'_'.$page.'.html'
							: '/video/'.$idStr.'.html';
			$this->getResponse()->setRedirect($url);
		} else {
			$idStr = $id;
			$id = String::idDeCrypt($idStr);
		}
		if (empty($id) || (!is_int($id) && !ctype_digit($id)))
		{
			$this->header404();
		} else {
			$detail = Db::table('video')->findOne($id);
			if (!$detail) 
			{
				$this->header404();
			}
		}
		
		$detail->tags = explode(',', $detail->tags);
		
		$vars = [
			'detail' => $detail,
			'id' => $id,
			'idStr' => $idStr,
			'seoTitle' => $detail->title
		];

		$this->getView()->assign($vars);
	}
	
	/**
	 * 解说视频
	 */
	public function listAction($params)
	{
		$viewPath = $this->getViewpath();
		switch ($params)
		{
			/**
			 * 集锦视频
			 */
			case 'jijin':
				$where = '`type` & 1';
				$typeName = '集锦视频';
			break;
			
			/**
			 * 比赛视频
			 */
			case 'match':
				$where = '`type` & 2';
				$typeName = '比赛视频';
			break;
			
			/**
			 * 解说视频
			 */
			case 'commentator':
				$where = '`type` & 4';
				$typeName = '解说视频';
			break;
			
			default:
				$this->header404();
			break;
		}
		$seoTitle = $typeName;
		
		$videoList = Db::table('video')->whereRaw($where)->findAll();
		
		$vars = [
			'type' => $params,
			'typeName' => $typeName,
			'videoList' => $videoList,
			'seoTitle' => $seoTitle
		];
		
		$this->getView()->assign($vars);
	}
}