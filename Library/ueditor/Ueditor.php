<?php
/**
 * 公共控制器
 * Created        : 2013-05-30
 * Modified        : 2013-05-30
 * @link        : http://www.59c.net
 * @copyright    : (C) 2012 - 2014 59C.NET
 * @version        : 1.0.0
 * @author        : Joseph Chen (chenliq@gmail.com)
 */
class UeditorController extends Controller
{
    /**
     * 上传的文件域字段名
     * @var string
     */
    public $filedName = 'upfile';
    /**
     * 图片保存路径
     * @var unknown
     */
    public $imgSavePath = '';
    /**
     * 文件保存路径
     * @var string
     */
    public $fileSavePath = '';
    /**
     * 上传文件的MD5值
     * @var string
     */
    private $fileMd5;
    /**
     * 上传文件的大小
     * @var string
     */
    private $fileSize;
    /**
     * 上传成功后保存的目标文件路径
     * @var string
     */
    private $destFile = '';
    /**
     * 图片保存URL前缀
     * @var string
     */
    public $saveUrl = '/attachment/';
    public $actionMaxFileSize = [
        'uploadimage'  => 2048000,
        'uploadscrawl' => 2048000,
        'uploadvideo'  => 102400000,
        'uploadfile'   => 51200000
    ];
    /**
     * 不同上传操作对应的文件类型值
     * @var string
     */
    public $actionType = [
        'uploadimage'  => 1,
        'uploadscrawl' => 1,
        'uploadvideo'  => 2,
        'uploadfile'   => 3
    ];
    /**
     * 不同上传操作对应的保存子目录
     * @var string
     */
    public $actionDir = [
        'uploadimage'  => 'images/',
        'uploadscrawl' => 'images/',
        'uploadvideo'  => 'videos/',
        'uploadfile'   => 'files/'
    ];
    /**
     * 允许的文件名后缀
     * @var unknown
     */
    public $allowFiles = [
        'uploadimage'  => ['gif', 'jpg', 'jpeg', 'png'],
        'uploadscrawl' => ['png'],
        'uploadvideo'  => [
                'flv', 'mkv', 'avi', 'rm', 'rmvb', 'mpeg', 'mpg',
                'ogg', 'ogv', 'mov', 'wmv', 'mp4', 'webm',
                'asf', 'asx'
        ],
        'uploadfile'   => [
                'rar', 'zip', 
                'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx',
                'txt', 'pdf', 'chm',
                'swf'
        ],
    ];
    /**
     * 错误信息
     * @var string
     */
    private $error = '';
    
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
        $ueditorDir = __DIR__.'/';
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
                $result = $this->fileUpload($action);
                break;
        
                /* 列出图片 */
            case 'listimage':
                $result = include($ueditorDir.'action_list.php');
                break;
                /* 列出文件 */
            case 'listfile':
                $result = include($ueditorDir.'action_list.php');
                break;
        
                /* 抓取远程文件 */
            case 'catchimage':
                $result = include($ueditorDir.'action_crawler.php');
                break;
        
            default:
                $result = json_encode(array(
                    'state'=> '请求地址出错'
                ));
                break;
        }

        /* 输出结果 */
        if (isset($_GET['callback'])) {
            if (preg_match('/^[\w_]+$/', $_GET['callback'])) {
                echo htmlspecialchars($_GET['callback']) . '(' . $result . ')';
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
     * 附件上传
     */
    public function fileUpload($action)
    {
        if ('uploadscrawl' == $action)
        {
            $result = $this->uploadScrawl($action);
        } else {
            $result = $this->uploadCommon($action);
        }
        
        // 上传错误提示错误信息
        if(!$result)
        {
            $arr = [
                'state' => $this->error
            ];
            $this->json($arr);
        } else {// 上传成功 获取上传文件信息
            $destFile = $this->destFile;
        }
        $file = $this->actionDir[$action].$destFile;
        
        if ('uploadscrawl' != $action)
        {
            $db = Db::table('files');
            $db->type  = $this->actionType[$action];
            $db->path  = $file;
            $db->md5   = $this->fileMd5;
            $db->size  = $this->fileSize;
            $db->save();
        }
        
        $arr = array (
            'url'      => $this->saveUrl.$file,
            'fileType' => Fso::getExt($file),
            'title'    => '',
            'original' => '',
            'state'    => 'SUCCESS',
            'size'     => $this->fileSize
        );
        
        $this->json($arr);
    }
    
    /**
     * 上传图片、视频、文件
     * @param string $action
     * @return Ambigous <boolean, string, multitype:string number unknown >
     */
    public function uploadCommon($action)
    {
        if ('uploadimage' == $action) {
            $isImage = true;
        } else {
            $isImage = false;
        }
        $fileInfo = $_FILES[$this->filedName];
        $this->fileSize = filesize($fileInfo['tmp_name']);
        $this->fileMd5 = md5_file($fileInfo['tmp_name']);
        $fmodel = Db::table('files')->where('size', $this->fileSize)->where('md5', $this->fileMd5)->findOne();
        if ($fmodel)
        {
            $fileUrl = $this->saveUrl . $fmodel->path;
            unlink($fileInfo['tmp_name']);
            $arr = array (
                'url'      => $fileUrl,
                'fileType' => Fso::getExt($fmodel->path),
                'title'    => '',
                'original' => '',
                'state'    => 'SUCCESS',
                'size'     => $this->fileSize
            );
            $this->json($arr);
        }
        
        $dir = $this->actionDir[$action];
        
        $options = array(
            'image'     => $isImage,
            'max_size'  => $this->actionMaxFileSize[$action],
            'save_path' => Yaf_Registry::get('config')->application->attachment.$dir,
            'save_rule' => '##Y/md/',
        );
        $up = new Uploader($options);
        $up->allowExts = $this->allowFiles[$action];
        $result = $up->upload();
        if ($result)
        {
            $this->destFile = $up->fileList[$this->filedName];
        } else {
            $this->error = $up->error();
        }
        return $result;
    }
    
    /**
     * 上传涂鸦
     * @param string $action
     * @return Ambigous <boolean, string, multitype:string number unknown >
     */
    public function uploadScrawl($action)
    {
        $dir = $this->actionDir[$action];
        $options = [
            'image'     => true,
            'max_size'  => $this->actionMaxFileSize[$action],
            'save_path' => Yaf_Registry::get('config')->application->attachment.$dir,
            'save_rule' => '##Y/md/',
            'oriName'   => 'scrawl.png',
        ];
        $up = new Uploader($options);
        $up->allowExts = $this->allowFiles[$action];
        $up->base64Data = $_POST[$this->filedName];
        $up->baseExtType = '.jpg';
        $this->fileSize = strlen($up->base64Data);
        
        $result = $up->upload(true);
        if ($result)
        {
            $this->destFile = $result;
        } else {
            $this->error = $up->error();
        }
        return $result;
    }

    /**
     * 图片在线管理
     */
    public function imageManager()
    {
        $paths = array('');
        $action = htmlspecialchars($_POST['action']);
        if ($action == 'get')
        {
            $files = array();
            foreach ($paths as $path)
            {
                $tmp = $this->getfiles(substr($this->imgSavePath.$path,0,-1));
                if($tmp)
                {
                    $files = array_merge($files,$tmp);
                }
            }
            if ( !count($files) ) return;
            rsort($files,SORT_STRING);
            $str = '';
            foreach ( $files as $file ) {
                $str .= str_replace(IMG_PATH, '', $file) . 'ue_separate_ue';
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
    private function getfiles($path, &$files = array())
    {
        if ( !is_dir( $path ) ) return null;
        $handle = opendir( $path );
        while (false !== ($file = readdir($handle)))
        {
            if ( $file != '.' && $file != '..' )
            {
                $path2 = $path . '/' . $file;
                if (is_dir($path2))
                {
                    $this->getfiles( $path2 , $files );
                } else {
                    if (preg_match( '/\.(gif|jpeg|jpg|png|bmp)$/i' , $file ) ) {
                        $files[] = $path2;
                    }
                }
            }
        }
        return $files;
    }
    
}