<?php
class Local_Fragment
{
	public static function getIndexFocus()
	{
		$row = Db::table('fragment_data')
					->where('sign', 'indexFocus')
					->findOne();
		if ($row)
		{
			$focus = json_decode($row->content);
			$item = new stdClass();
			$item->title = '';
			$item->url = '';
			$item->cover_image_id = '';
			$item->cover_image = '';
			$item->create_time = time();
			for ($i=0; $i<=4; $i++)
			{
				if (isset($focus[$i]))
				{
					continue;
				}
				$focus[$i] = $item;
			}
			$focusBig = $focus[0];
			unset($focus[0]);
			$focusSmall = $focus;
		} else {
			$item = new stdClass();
			$item->title = '';
			$item->url = '';
			$item->cover_image_id = '';
			$item->cover_image = '';
			$item->brief = '';
			$item->create_time = time();
			$focusBig = $item;
			$focusSmall = [];
			for ($i=1; $i<=4; $i++)
			{
				$focusSmall[$i] = $item;
			}
		}
		return [$focusBig, $focusSmall];
	}
	
	public static function getIndexNews()
	{
		$row = Db::table('fragment_data')
					->where('sign', 'indexNews')
					->findOne();
		$list = [];
		if ($row)
		{
			$list = json_decode($row->content);
		}
		return $list;
	}
	
	public static function getVideoList($sign)
	{
		$file = APP_PATH.'data/fragment/'.$sign.'.php';
		if (is_file($file))
		{
			return include $file;
		} else {
			return [];
		}
	}
	
}