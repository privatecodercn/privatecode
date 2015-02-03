<?php
class Local_Cfg
{
    
    public static $bbsCategoryKey = 'bbs-cat';
	
	public static function getDefinition()
	{
		return 
		[
			1 => '标清',
			2 => '高清',
			4 => '超清'
		];
	}
	
	public static function getVideoType()
	{
		return 
		[
			1 => '集锦视频',
			2 => '比赛视频',
			3 => '解说视频',
		];
	}
	
	public static function getBbsCategory()
	{
	    $arr = URedis::getInstance()->hGetAll(self::$bbsCategoryKey);
	    if (!$arr)
	    {
	        $rows = Db::table('category')->where('type', 2)->findArray();
	        $arr = Arr::simple($rows);
	        URedis::getInstance()->hMset(self::$bbsCategoryKey, $arr);
	    }
	    return $arr;
	}
	
}