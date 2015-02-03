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
		} else {
    		$item = new stdClass();
    		$item->title = '';
    		$item->url = '';
    		$item->cover_image_id = '';
    		$item->cover_image = '';
    		$item->brief = '';
    		$item->create_time = time();
			$focus = [$item,$item];
		}
		return $focus;
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