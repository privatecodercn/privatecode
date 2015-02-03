<?php
class KeditorController extends Controller
{
	public $extArr = 
	[
		'image' => ['gif', 'jpg', 'png'],
		'file' => ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'zip', 'rar', 'gz', 'bz2'],
	];
	public function index()
	{
		$this->json(['error'=>1, 'message'=>'test']);
	}
	
	/**
	 * 浏览远程图片的服务器端程序
	 */
	public function fileManager()
	{
		$rootPath = Core::$cfg->protectedFilePath;
		$currentUrl = '/index/file?path=';
		//检查目录名
		$dirName = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
		if (empty($this->extArr[$dirName]))
		{
			$this->json($arr);
		}
		if (!is_dir($rootPath) || false !== strpos($_GET['path'], './'))
		{
			$this->header404();
		}
		$rootPath .= $dirName.'/';
		$currentUrl .= $dirName.'/';
		if (!is_dir($rootPath))
		{
			mkdir($rootPath, 0777, true);
		}
		
		//根据path参数，设置各路径和URL
		if (empty($_GET['path'])) {
			$currentDirPath = '';
			$moveupDirPath = '';
			$currentPath = $rootPath;
			$currentUrl = $currentUrl;
		} else {
			$currentDirPath = $_GET['path'];
			$moveupDirPath = preg_replace('/(.*?)[^\/]+\/$/', '$1', $currentDirPath);
			$currentPath = $rootPath . $_GET['path'];
			$currentUrl = $currentUrl . $_GET['path'];
		}
		$arr = [
			'moveup_dir_path'	=> $moveupDirPath,
			'current_dir_path'	=> $currentDirPath,
			'current_url'		=> $currentUrl,
			'total_count'		=> 0,
			'file_list'			=> array()
		];
		$order = empty($_GET['order']) ? 'name' : strtolower($_GET['order']);
		
		//遍历目录取得文件信息
		$fileList = array();
		$orderArr = array();
		if ($handle = opendir($currentPath))
		{
			$i = 0;
			while (false !== ($filename = readdir($handle))) {
				if ($filename{0} == '.') continue;
				$file = $currentPath . $filename;
				if (is_dir($file)) {
					$fileList[$i]['is_dir'] = true; //是否文件夹
					$fileList[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
					$fileList[$i]['filesize'] = 0; //文件大小
					$fileList[$i]['is_photo'] = false; //是否图片
					$fileList[$i]['filetype'] = ''; //文件类别，用扩展名判断
				} else {
					$fileList[$i]['is_dir'] = false;
					$fileList[$i]['has_file'] = false;
					$fileList[$i]['filesize'] = filesize($file);
					$fileList[$i]['dir_path'] = '';
					$fileExt = strtolower(pathinfo($file, PATHINFO_EXTENSION));
					$fileList[$i]['is_photo'] = in_array($fileExt, $this->extArr['image']);
					$fileList[$i]['filetype'] = $fileExt;
				}
				$fileList[$i]['filename'] = $filename; //文件名，包含扩展名
				$fileList[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
				// 排序
				if ($order=='name')
				{
					$orderArr[$i] = $filename;
				} else if ($order=='size') {
					$orderArr[$i] = $fileList[$i]['filesize'];
				} else {
					$orderArr[$i] = $fileList[$i]['filetype'];
				}
				$i++;
			}
			closedir($handle);
		}
		array_multisort($orderArr, SORT_ASC, $fileList);
		$arr['total_count'] = count($fileList);
		$arr['file_list'] = $fileList;
		
		$this->json($arr);
	}
	
	/**
	 * 上传文件的服务器端程序
	 */
	public function uploadFile()
	{
		//最大文件大小
		$maxSize = 20971520;
		
		$savePath = Config::$protectedFilePath;
		$saveUrl  = '/attachment?';
		$this->contentType = 'text/html';
		
		//PHP上传失败
		if (!empty($_FILES['filename']['error']))
		{
			switch($_FILES['filename']['error'])
			{
				case '1':
					$error = '超过php.ini允许的大小。';
					break;
				case '2':
					$error = '超过表单允许的大小。';
					break;
				case '3':
					$error = '图片只有部分被上传。';
					break;
				case '4':
					$error = '请选择图片。';
					break;
				case '6':
					$error = '找不到临时目录。';
					break;
				case '7':
					$error = '写文件到硬盘出错。';
					break;
				case '8':
					$error = 'File upload stopped by extension。';
					break;
				case '999':
				default:
					$error = '未知错误。';
			}
			$this->json(['error'=>1, 'message'=>$error]);
		}
		
		//有上传文件时
		if (empty($_FILES) === false)
		{
			//原文件名
			$fileName = $_FILES['filename']['name'];
			//服务器上临时文件名
			$tmpName = $_FILES['filename']['tmp_name'];
			//文件大小
			$fileSize = $_FILES['filename']['size'];
			//检查文件名
			if (!$fileName)
			{
				$this->json(['error'=>1, 'message'=>'请选择文件。']);
			}
			//检查目录
			if (@is_dir($savePath) === false)
			{
				$this->json(['error'=>1, 'message'=>'上传目录不存在。']);
			}
			//检查目录写权限
			if (@is_writable($savePath) === false)
			{
				$this->json(['error'=>1, 'message'=>'上传目录没有写权限。']);
			}
			//检查是否已上传
			if (@is_uploaded_file($tmpName) === false)
			{
				$this->json(['error'=>1, 'message'=>'上传失败。']);
			}
			//检查文件大小
			if ($fileSize > $maxSize)
			{
				$this->json(['error'=>1, 'message'=>'上传文件大小超过限制。']);
			}
			//检查目录名
			$dirName = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
			if (empty($this->extArr[$dirName]))
			{
				$this->json(['error'=>1, 'message'=>'目录名不正确。']);
			}
			
			//获得文件扩展名
			$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
			//检查扩展名
			if (in_array($fileExt, $this->extArr[$dirName]) === false)
			{
				$this->json(['error'=>1, 'message'=>'上传文件扩展名是不允许的扩展名。\n只允许' . implode(',', $this->extArr[$dirName]) . '格式。']);
			}
			//创建文件夹
			if ($dirName !== '')
			{
				$dirName .= '/'.date('Y/md/');
				$savePath .= $dirName;
			}
			
			if (!is_dir($savePath))
			{
				mkdir($savePath, 0755, true);
			}
			//新文件名
			$newFileName = Fso::randFileName('', '');
			//移动文件
			$fileExt = '.'.$fileExt;
			$filePath = $savePath . $newFileName . $fileExt;
			$oriFilePath = $filePath . '.ori';
			if (move_uploaded_file($tmpName, $oriFilePath) === false)
			{
				$this->json(['error'=>1, 'message'=>'上传失败']);
			}

			$orm = Db::table('pics');
			$size = filesize($oriFilePath);
			$md5 = md5_file($oriFilePath);
			$pic = $orm->where('ori_size', $size)->where('ori_md5', $md5)->findOne();
			if ($pic)
			{
				$fileUrl = $saveUrl . $pic->path;
				unlink($oriFilePath);
				$this->json(['error'=>0, 'url'=>$fileUrl, 'path'=>$pic->path]);
			}
			
			$saveUrl .= $dirName;

			$text =
			[
				['text' => '财富房产', 'color'=>[255, 255, 255], 'font'=>'simsun.ttc', 'font_size'=>12],
				['text' => '188FC.COM', 'color'=>[255, 255, 255], 'font'=>'cambriab.ttf', 'font_size'=>12],
			];
			$wm = new WaterMark($oriFilePath, $text);
			$wm->position = 8;
			$wm->alpha = 127;
			$wm->outputFile = $filePath;
			$wm->mark();
			
			$fileUrl = $saveUrl . $newFileName . $fileExt;
			$data = 
			[
				'ori_size'	=> filesize($oriFilePath),
				'ori_md5'	=> md5_file($oriFilePath),
				'size'		=> filesize($filePath),
				'md5'		=> md5_file($filePath),
				'path'		=> $dirName . $newFileName . $fileExt,
			];
			$meedoo = new Medoo(Core::getMedooCfg());
			$meedoo->insert('pics', $data);
			
			$this->json(['error'=>0, 'url'=>$fileUrl, 'path'=>$dirName.$newFileName.$fileExt]);
		} else {
			$this->json(['error'=>1, 'message'=>'上传失败']);
		}
	}
}