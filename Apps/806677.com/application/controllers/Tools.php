<?php
class ToolsController extends Yaf_Controller_Abstract
{
	public function indexAction()
	{
		$str = String::idCrypt(100005);
		echo $str;
		echo "\n";
		echo String::idDeCrypt($str);
		exit;
	}
	
	public function deleteHtmlAction($page='index')
	{
		if (false !== strpos($page, '../') || 0 === strpos($page, '/'))
		{
			$this->json(false, 'Failure');
		}
		$filename = WEB_PATH.$page.'.html';
		if (is_file($filename))
		{
			unlink($filename);
		}
	}
	
	public function testAction()
	{
        $db = Db::table('user')->setPkColumn('uid');
        $data = ['exp'=>'exp+3', 'coin'=>'coin+2'];
// 	    $rows = $db->whereIn('uid', [1,12586])->update($data);
        $rows = $db->whereLike('username', 'ad%')->findAll(null, true);
	    var_export($rows);
// 	    $config = Yaf_Registry::get('config');
// 		Db::isThrowError(false);
// 		$db = Db::table('user', 'u')->setPkColumn('uid');
// 		$row = $db
//     	          ->limit(2)
//     	          ->selectColumns('u.username')
//     	          ->findColumn('username', 1);
//     	          ->findOne(1,true);
//                 ->findAll('uid in (1, 12586)', true);
// 		echo 'last query:';
// 		echo $db->getLastQuery();
// 		echo PHP_EOL;
// 		var_export($row);
// 		echo PHP_EOL;
//         var_export($row);
//         $row->delete();
// 		$db->username = 'test';
// 		$success = $db->save();
// 		var_dump($success);
// 		var_export($row);
		exit;
	}
	

}