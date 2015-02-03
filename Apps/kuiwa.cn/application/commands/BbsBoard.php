<?php
/**
 * 主题帖
 * Created		: 2014-07-10
 * Modified		: 2014-07-10
 * @link		: http://www.kuiwa.cn
 * @copyright	: (C) 2014 KUIWA.CN
 * @example		: /d/web/yaf/command kuiwa.cn bbsBoard/newDateData date=20140710
 */
class BbsBoardCmd
{
	public function index($params)
	{
// 		extract(func_get_arg(0), EXTR_PREFIX_INVALID, 'params');
// 		var_dump($date, $type, $params_1);
	}
	
	public function newDateData($params=[])
	{
		$boardList = ORM::for_table('bbs_board')->select('id')->find_many();
		
		$table = 'bbs_board_date_data';
		$date = $params['date'] ?: (new DateTime())->add(new DateInterval('P1D'))->format('Ymd');
		foreach ($boardList as $board) 
		{
			$record = ORM::for_table($table)
				->where('board_id', $board->id)
				->where('date', $date)
				->find_one();
			if (!$record)
			{
				$record = ORM::for_table($table)->create();
				$record->board_id = $board->id;
				$record->date = $date;
				$record->topic_num = 0;
				$record->post_num = 0;
				$record->view_num = 0;
				$record->save();
			}
		}
		echo 'end.';
		echo "\n";
	}
}