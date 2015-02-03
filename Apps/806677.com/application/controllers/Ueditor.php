<?php
/**
 * 公共控制器
 * Created		: 2013-05-30
 * Modified		: 2013-05-30
 * @link		: http://www.59c.net
 * @copyright	: (C) 2012 - 2014 59C.NET
 * @version		: 1.0.0
 * @author		: Joseph Chen (chenliq@gmail.com)
 */
class UeditorController extends Controller
{
	
	public $imgSavePath = '';
	public $fileSavePath = '';
	
	/**
	 * 初始化操作
	 */
	public function init()
	{
		// 验证是否后台登录用户
		$user = new UserModel();
		if (!$user->isAdminLogined())
		{
			header('Location:/admin/login');
			exit;
		}
		$this->imgSavePath = Yaf_Registry::get('config')->application->attachment.'images/';
		$this->fileSavePath = Yaf_Registry::get('config')->application->attachment.'files/';
	}

	/**
	 * (non-PHPdoc)
	 * @see Controller::index()
	 */
	public function indexAction()
	{
		$action = $_GET['action'];
		$ueditorDir = ROOT_PATH.'Library/ueditor/';
		$configJson = file_get_contents($ueditorDir.'config.json');
		$CONFIG = json_decode(preg_replace('#\/\*[\s\S]+?\*\/#', '', $configJson), true);
		switch ($action)
		{
			case 'config':
				$result = json_encode($CONFIG);
				break;
		
				/* 上传图片 */
			case 'uploadimage':
				/* 上传涂鸦 */
			case 'uploadscrawl':
				/* 上传视频 */
			case 'uploadvideo':
				/* 上传文件 */
			case 'uploadfile':
				$result = include("{$ueditorDir}action_upload.php");
				break;
		
				/* 列出图片 */
			case 'listimage':
				$result = include("{$ueditorDir}action_list.php");
				break;
				/* 列出文件 */
			case 'listfile':
				$result = include("{$ueditorDir}action_list.php");
				break;
		
				/* 抓取远程文件 */
			case 'catchimage':
				$result = include("{$ueditorDir}action_crawler.php");
				break;
		
			default:
				$result = json_encode(array(
					'state'=> '请求地址出错'
				));
				break;
		}

		/* 输出结果 */
		if (isset($_GET["callback"])) {
			if (preg_match('/^[\w_]+$/', $_GET["callback"])) {
				echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
			} else {
				echo json_encode(array(
					'state'=> 'callback参数不合法'
				));
			}
		} else {
			echo $result;
		}
		return false;
	}
	
	/**
	 * 获取远程图片
	 */
	public function getRemoteImage()
	{
		set_time_limit( 0 );

		$config = array(
			"savePath" => $this->imgSavePath.date('Ymd/'),
			"allowFiles" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" ) , //文件允许格式
			"maxSize" => 3000					//文件大小限制，单位KB
		);

		$uri = htmlspecialchars( $_POST[ 'upfile' ] );
		$uri = str_replace( "&amp;" , "&" , $uri );
		
		//忽略抓取时间限制
		//ue_separate_ue  ue用于传递数据分割符号
		$imgUrls = explode( "ue_separate_ue" , $uri );
		$tmpNames = array();
		foreach ( $imgUrls as $imgUrl )
		{
			//http开头验证
			if(strpos($imgUrl,"http")!==0)
			{
				array_push( $tmpNames , "error" );
				continue;
			}
			//获取请求头
			$heads = get_headers($imgUrl , true);
			//死链检测
			if ( !( stristr( $heads[ 0 ] , "200" ) && stristr( $heads[ 0 ] , "OK" ) ) ) {
				array_push( $tmpNames , "error" );
				continue;
			}

			//格式验证(扩展名验证和Content-Type验证)
			$fileType = strtolower( strrchr( $imgUrl , '.' ) );
			if ( !in_array( $fileType , $config[ 'allowFiles' ] ) || !stristr( $heads[ 'Content-Type' ] , "image" ) ) {
				array_push( $tmpNames , "error" );
				continue;
			}

			//打开输出缓冲区并获取远程图片
			ob_start();
			$context = stream_context_create(
				array (
					'http' => array (
						'follow_location' => false // don't follow redirects
					)
				)
			);
			//请确保php.ini中的fopen wrappers已经激活
			readfile( $imgUrl,false,$context);
			$img = ob_get_contents();
			ob_end_clean();

			//大小验证
			$uriSize = strlen( $img ); //得到图片大小
			$allowSize = 1024 * $config[ 'maxSize' ];
			if ( $uriSize > $allowSize ) {
				array_push( $tmpNames , "error" );
				continue;
			}
			//创建保存位置
			$savePath = $config[ 'savePath' ];
			if ( !file_exists( $savePath ) ) {
				mkdir( "$savePath" , 0777, true );
			}
			//写入文件
			$tmpName = $savePath . rand( 1 , 10000 ) . time() . strrchr( $imgUrl , '.' );
			try {
				$fp2 = @fopen( $tmpName , "a" );
				fwrite( $fp2 , $img );
				fclose( $fp2 );
				array_push( $tmpNames ,  str_replace(IMG_PATH, '', $tmpName) );
			} catch ( Exception $e ) {
				array_push( $tmpNames ,  str_replace(IMG_PATH, '', $tmpName) );
//				 array_push( $tmpNames , "error" );
			}
		}
		/**
		 * 返回数据格式
		 * {
		 *   'url'   : '新地址一ue_separate_ue新地址二ue_separate_ue新地址三',
		 *   'srcUrl': '原始地址一ue_separate_ue原始地址二ue_separate_ue原始地址三'，
		 *   'tip'   : '状态提示'
		 * }
		 */
		$arr = array(
			'url'		=> implode('ue_separate_ue', $tmpNames),
			'tip'		=> '远程图片抓取成功！',
			'srcUrl'	=> $uri,
		);
		$this->json($arr);
	}
	
	/**
	 * 图片上传
	 */
	public function imageUp()
	{
	    $config = array(
	        "savePath" => $this->imgSavePath,
	        "maxSize" => 1024, //单位KB
	        "allowFiles" => array(".gif", ".png", ".jpg", ".jpeg", ".bmp")
	    );
		$up = new UeditorUploader("upfile", $config);
		$info = $up->getFileInfo();
		$arr = array (
			'title'		=> '',
			'url'		=> str_replace(WEB_PATH, '', $info["url"]),
			'original'	=> $info["originalName"],
			'state'		=> $info["state"],
		);
		$this->json($arr);
	}
	
	/**
	 * 附件上传
	 */
	public function fileUp()
	{
		//上传配置
		$config = array(
				"savePath" => $this->fileSavePath, //保存路径
				"maxSize" =>  1024,//文件大小限制，单位KB
				"allowFiles" => array( ".rar" , ".doc" , ".docx" , ".zip" , ".pdf" , ".txt" , ".swf" , ".wmv" ) //文件允许格式
		);
		$up = new UeditorUploader("upfile", $config);
		$info = $up->getFileInfo();
		$arr = array (
			'url'		=> str_replace($this->fileSavePath, '', $info["url"]),
			'fileType'	=> $info['type'],
			'original'	=> $info["originalName"],
			'state'		=> $info["state"],
		);
		$this->json($arr);
	}

	/**
	 * 图片在线管理
	 */
	public function imageManager()
	{
		$paths = array('');
		$action = htmlspecialchars( $_POST[ "action" ] );
		if ($action == "get")
		{
			$files = array();
			foreach ( $paths as $path)
			{
				$tmp = $this->getfiles( substr($this->imgSavePath.$path,0,-1) );
				if($tmp){
					$files = array_merge($files,$tmp);
				}
			}
			if ( !count($files) ) return;
			rsort($files,SORT_STRING);
			$str = "";
			foreach ( $files as $file ) {
				$str .= str_replace(IMG_PATH, '', $file) . "ue_separate_ue";
			}
			echo $str;
		}
		return false;
	}
	
	/**
	 * 遍历获取目录下的指定类型的文件
	 * @param $path
	 * @param array $files
	 * @return array
	 */
	private function getfiles( $path , &$files = array() )
	{
		if ( !is_dir( $path ) ) return null;
		$handle = opendir( $path );
		while ( false !== ( $file = readdir( $handle ) ) )
		{
			if ( $file != '.' && $file != '..' )
			{
				$path2 = $path . '/' . $file;
				if ( is_dir( $path2 ) )
				{
					$this->getfiles( $path2 , $files );
				} else {
					if ( preg_match( "/\.(gif|jpeg|jpg|png|bmp)$/i" , $file ) ) {
						$files[] = $path2;
					}
				}
			}
		}
		return $files;
	}
	
}