<?php
class ArticleController extends Controller
{
	public function detailAction($id, $page=1)
	{
		if (ctype_digit($id))
		{
			$idStr = String::idCrypt($id);
			$this->getResponse()->setHeader($this->getRequest()->getServer('SERVER_PROTOCOL'), '301 Moved Permanently');
			$this->getResponse()->setRedirect('/article/'.$idStr.'_'.$page.'.html');
		} else {
			$idStr = $id;
			$id = String::idDeCrypt($idStr);
		}
		if (empty($id) || (!is_int($id) && !ctype_digit($id)))
		{
			$this->header404();
		} else {
			$detail = ORM::for_table('article')->table_alias('a1')
						->join('article_content', ['a1.id', '=', 'a2.id'], 'a2')
						->find_one($id);
			if (!$detail) 
			{
				$this->header404();
			}
		}
		$pageBreakTag = '_ueditor_page_break_tag_';
		if (strpos($detail->content, $pageBreakTag))
		{
			$contents = explode($pageBreakTag, $detail->content);
			$pageTotal = count($contents);
			if ($page>$pageTotal)
			{
				$page = $pageTotal;
			} else if ($page<1) {
				$page = 1;
			}
			$detail->content = $contents[$page-1];
		} else {
			$pageTotal = 1;
		}
		
		$vars = [
			'detail' => $detail,
			'id' => $id,
			'page' => $page,
			'pageTotal' => $pageTotal
		];

		$this->getView()->assign($vars);
	}
	
}