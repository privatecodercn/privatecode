<?php
/**
 * 主题帖
 * Created        : 2014-07-02
 * Modified        : 2014-07-10
 * @link        : http://www.kuiwa.cn
 * @copyright    : (C) 2014 KUIWA.CN
 */
namespace Bbs;
use \Db,\Fso;

class BoardModel extends \Model
{
    /**
     * 读取一个版块的信息
     * @param int $id
     * @return \Db
     */
    public function read($id) 
    {
        return Db::table('bbs_board')->findOne($id);
    }
    
    /**
     * 从数据库获取所有版块列表
     * @param number $id
     * @return array
     */
    public function getAllListFromDb($id=0)
    {
        $db = Db::table('bbs_board')
                        ->orderBy('lvl')
                        ->orderBy('orderid');
        if ($id)
        {
            $db->whereOr([['pid', '=', $id], ['id', '=', $id]]);
        }
        $boardArr = $db->findArray();
                
        $boardList = [];
        $boardPList = [];
        
        foreach ($boardArr as $item)
        {
            $item['managers'] = json_decode($item['managers'], true);
            $item['sub'] = [];
            $boardPList[$item['id']] = $item;
            if ($item['lvl']==1)
            {
                $boardList[$item['id']] = &$boardPList[$item['id']];
            } else {
                $boardPList[$item['pid']]['sub'][$item['id']] = &$boardPList[$item['id']];
            }
        }
        return $boardList;
    }
    
    /**
     * 获取所有版块列表
     * @param string $recache
     * @return array
     */
    public function getAllList($recache=false)
    {
        $file = APP_PATH.'data/bbsboard/list.php';
        if ($recache || !is_file($file) || true)
        {
            $list = $this->getAllListFromDb();
            $this->recacheList($list);
        } else {
            $list = include $file;
        }
        return $list;
    }
    
    /**
     * 获取指定版块及其子版块的列表信息
     * @param int $id
     * @return array
     */
    public function getSubList($id) 
    {
        $list = $this->getAllListFromDb($id);
        return $list;
    }
    
    /**
     * 缓存列表信息
     * @param array $list
     * @return boolean
     */
    private function recacheList($list)
    {
        $file = APP_PATH.'data/bbsboard/list.php';
        $content = var_export($list, true);
        Fso::write($file, $content, 'php', true);
        return true;
    }
    
    /**
     * 获取版块的当天数据
     * @return multitype:unknown
     */
    public function getTodayData()
    {
        $fields = ['board_id', 'date', 'topic_num', 'post_num'];
        $list = Db::table('bbs_board_date_data')
                    ->selectColumns($fields)
                    ->where('date', date('Ymd'))
                    ->findArray();
        $list = $list ?: [];
        $datas = [];
        foreach ($list as $row) 
        {
            $datas[$row['board_id'].':'.$row['date']] = $row;
        }
        return $datas;
    }
    
    /**
     * 设置一个版块的面包屑信息
     * @param \Db $boardOne
     */
    public static function setBoardBreadcrumbs($boardOne)
    {
        $paths = json_decode($boardOne->paths);
    	$paths[] = [$boardOne->id, $boardOne->name];
    	foreach ($paths as $v)
    	{
        	$GLOBALS['breadcrumbs'][] = [
    	    	'url' => '/bbs/board-'.$v[0].'.html',
    	    	'title' => $v[1]
        	];
    	}
    }
    
}