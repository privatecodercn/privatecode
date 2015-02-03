<?php
class Local_Cfg
{
	
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
	
}