<?php
class AutoCompleteController extends  Controller
{
	public function authorAction()
	{
		$word = $this->getRequest()->getQuery('term', '');
		$rows = Db::table('user')
					->selectColumns('uid', 'nickname')
					->whereIn('type', [21, 22])
					->whereLike('nickname', $word.'%')
					->findAll();
		$datas = [];
		foreach ($rows as $row)
		{
			$datas[] = array(
				'value'	=> $row->uid,
				'label'	=> $row->nickname,
				'name'	=> $row->nickname
			);
		}
		$this->json($datas);
	}
	
	public function eventsAction()
	{
		$word = $this->getRequest()->getQuery('term', '');
		$rows = Db::table('events')
					->selectColumns('id', 'name', 'short_name')
					->whereLike('name', $word.'%')
					->whereLike('nickname', $word.'%')
					->findAll();
		$datas = [];
		foreach ($rows as $row)
		{
			$datas[] = array(
				'value'	=> $row->id,
				'label'	=> $row->nickname,
				'name'	=> $row->nickname
			);
		}
		$this->json($datas);
	}
	
	public function albumAction()
	{
		$word = $this->getRequest()->getQuery('term', '');
		$rows = Db::table('album')
					->selectColumns('id', 'title')
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