<?php
/**
 * 上传文件操作
 *
 * Create     : 2013-11-22
 * Modified   : 2013-11-22
 * @link      : http://www.59c.net
 * @copyright : (C) 2013 - 2014 59C.NET
 * @version   : 1.0.0
 * @author    : Joseph Chen <chenliq@gmail.com>
 */
class Uploader
{
	/**
	 * 最大上传文件大小(默认2M)
	 * @var int
	 */
	public $maxSize = 2097152;
	/**
	 * 允许上传文件的后缀类型
	 * @var array
	 */
	public $allowExts = [];
	/**
	 * 上传文件保存的路径
	 * @var string
	*/
	public $savePath = '';
	/**
	 * 上传文件名生成规则(任意不带参数的函数名/类的静态方法/字符串)
	 * 如果是默认的Fso::randFileName方法，可以带参数，规则为"#参数1#参数2"
	 * @var array|string
	 */
	public $saveRule = '##Ymd/';
	/**
	 * 上传后返回的文件信息只包含上传后路径
	 * @var boolean
	 */
	public $onlyReturnFilePath = true;
	/**
	 * 上传的文件列表
	 * @var array
	 */
	public $fileList = [];
	/**
	 * 要保存的文件信息
	 * @var array
	 * @example [tmp_name, save_path]
	 */
	public $saveList = [];
	/**
	 * 上传的文件数量
	 * @var int
	*/
	public $fileNum = 0;
	/**
	 * 原始上传文件名
	 * @var unknown
	 */
	public $oriName = '';
	/**
	 * 是否出错
	 * @var boolean
	 */
	public $error = false;
	/**
	 * 出错的字段
	 * @var string
	 */
	public $errorField = '';
	/**
	 * 出错的文件
	 * @var string
	 */
	public $errorFile = '';
	/**
	 * 出错的提示信息
	 * @var string
	 */
	public $errorMsg = '';
	/**
	 * 是否限制图片
	 * @var boolean
	 */
	public $isImage = false;
	/**
	 * 限制的图片类型
	 * @var boolean
	 */
	public $imageType = [IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_PNG];
	/**
	 * 上传的base字符串信息
	 * @var string
	 */
	public $base64Data = '';
	/**
	 * 上传的base64编码文件信息的后缀
	 * @var string
	 */
	public $baseExtType = '.jpg';
	
	/**
	 * 返回的状态信息
	 */
	private $stateMap = array(
        "SUCCESS", //上传成功标记，在UEditor中内不可改变，否则flash判断会出错
        "文件大小超出 upload_max_filesize 限制",
        "文件大小超出 MAX_FILE_SIZE 限制",
        "文件未被完整上传",
        "没有文件被上传",
        "上传文件为空",
        "ERROR_TMP_FILE" => "临时文件错误",
        "ERROR_TMP_FILE_NOT_FOUND" => "找不到临时文件",
        "ERROR_SIZE_EXCEED" => "文件大小超出网站限制",
        "ERROR_TYPE_NOT_ALLOWED" => "文件类型不允许",
        "ERROR_CREATE_DIR" => "目录创建失败",
        "ERROR_DIR_NOT_WRITEABLE" => "目录没有写权限",
        "ERROR_FILE_MOVE" => "文件保存时出错",
        "ERROR_FILE_NOT_FOUND" => "找不到上传文件",
        "ERROR_WRITE_CONTENT" => "写入文件内容错误",
        "ERROR_UNKNOWN" => "未知错误",
        "ERROR_DEAD_LINK" => "链接不可用",
        "ERROR_HTTP_LINK" => "链接不是http链接",
        "ERROR_HTTP_CONTENTTYPE" => "链接contentType不正确"
	);


	/**
	 * 构造函数
	 * @param string $savePath
	 * @param array $options
	 */
	public function __construct($options=null)
	{
		if (isset($options['max_size'])) {
			$this->maxSize = $options['max_size'];
		}
		if (isset($options['save_path'])) {
			$this->savePath = $options['save_path'];
		}
		if (isset($options['save_rule'])) {
			$this->saveRule = $options['save_rule'];
		}
		if (isset($options['oriName']))
		{
			$this->oriName = $options['oriName'];
		}
		if (isset($options['image']) && $options['image'])
		{
			$this->isImage = true;
			$this->allowExts = array('jpg', 'gif', 'png');
			if (isset($options['image_type']))
			{
			    $this->imageType = $options['image_type'];
			}
		}
	}

	/**
	 * 上传文件
	 */
	public function upload($isBase64=false)
	{
		if ($isBase64)
		{
			return $this->uploadBase64();
		}
		if ($this->error) {
			return false;
		}
		$saveList = [];
		/**
		 * 循环检测文件
		*/
		foreach ($_FILES as $field => $item) 
		{
			if (is_array($item['name']))
			{
				$this->fileList[$field] = [];
				foreach ($item['name'] as $k=>$filename)
				{
					$file = [
						'error'		=> $item['error'][$k],
						'name'		=> $filename,
						'tmp_name'	=> $item['tmp_name'][$k],
						'size'		=> $item['size'][$k],
						'type'		=> $item['type'][$k],
					];
					$result = $this->handleFile($field, $file);
					if (!$result)
					{
					    return false;
					}
				}
			} else {
				$result = $this->handleFile($field, $item);
				if (!$result)
				{
				    return false;
				}
			}
		}

		// 开始将所有上传的文件从临时目录迁移到保存的目录
		foreach ($this->saveList as $v)
		{
			$dir = dirname($v[1]);
			if (!is_dir($dir)) {
				mkdir($dir, 0775, true);
			}
			move_uploaded_file($v[0], $v[1]);
		}

		return true;
	}
	
	/**
	 * 处理一个上传的文件
	 * @param string $field
	 * @param string $file
	 * @return boolean
	 */
	public function handleFile($field, $file)
	{
		if (UPLOAD_ERR_NO_FILE == $file['error'])
		{
			continue;
		}
		$this->fileNum++;
		// 文件是否成功上传
		if (UPLOAD_ERR_OK != $file['error'])
		{
			$this->setUploadErrorMsg($file['error'], $file['name']);
			$this->error = true;
			return false;
		}
		// 判断图片类型
		if ($this->isImage && !in_array(exif_imagetype($file['tmp_name']), $this->imageType))
		{
			$this->setUploadErrorMsg('ERR IMAGE TYPE');
			$this->error = true;
			return false;
		}
		// 文件大小检测
		if (!$this->checkFileSize($file['name'], $file['size'], $field))
		{
			$this->setUploadErrorMsg('ERR FILE SIZE');
			$this->error = true;
			return false;
		}
		// 文件格式是否合法
		if (!$this->checkExt($field, $file['name'], $file['tmp_name']))
		{
			$this->setUploadErrorMsg('ERR FILE EXTENSION');
			$this->error = true;
			return false;
		}
		// 文件上传路径验证
		if (!($path=$this->getSavepath($field)))
		{
			$this->setUploadErrorMsg('ERR FILE SAVE PATH');
			$this->error = true;
			return false;
		}
		$file['savename'] = $this->generateSavename($field).'.'.Fso::getExt($file['name']);
		$this->saveList[] = array($file['tmp_name'], $path.$file['savename']);
		if ($this->onlyReturnFilePath)
		{
			$this->fileList[$field] = $file['savename'];
		} else {
			$this->fileList[$field] = $file;
		}
		return true;
	}
	
	/**
	 * 处理base64编码的文件上传
	 */

	public function uploadBase64() 
	{
        $stream = base64_decode($this->base64Data);
        $size = strlen($stream);
        
        if (!$this->oriName)
        {
        	$this->oriName = 'tmp'.$this->baseExtType;
        }

        // 文件大小检测
        if (!$this->checkFileSize('base64file', $size))
        {
        	$this->setUploadErrorMsg('ERR FILE SIZE');
        	$this->error = true;
        	return false;
        }
        
        $saveName = $this->generateSavename().$this->baseExtType;
        $saveFile = $this->getSavepath().$saveName;
        Fso::mkdir(dirname($saveFile));
        
        // 保存文件
        if (!file_put_contents($saveFile, $stream)) {
        	$this->error(Lang::get('upload_file_failed_to_write_to_disk'));
        	return false;
        }
        
        if ($this->onlyReturnFilePath)
        {
        	return $saveName;
        } else {
	        $file = [
	        	'name' => $this->oriName,
	        	'type' => '',
	        	'tmp_name' => '',
	        	'error' => 0,
	        	'size' => $size,
	        	'savename' => $saveName
	        ];
	        return $file;
        }
	}
	
	/**
	 * 检测上传文件的大小是否超出
	 * @param string $file 上传的文件名称
	 * @param string $size 上传的文件大小
	 * @param string $field 上传对应的表单元素名称
	 * @return bool
	 */
	public function checkFileSize($file, $size, $field=null)
	{
		if (is_array($this->maxSize))
		{
			// 没设置对应的大小限制，或限制值为0，表示不限制
			if (isset($this->maxSize[$field]) && $this->maxSize[$field] && $this->maxSize[$field] < $size)
			{
				$this->setFileSizeErrorMsg($file, $this->maxSize[$field]);
				$this->error = true;
				return false;
			} else {
				return true;
			}
		} else if ($this->maxSize && $this->maxSize < $size) {
			$this->setFileSizeErrorMsg($file, $this->maxSize);
			$this->error = true;
			return false;
		} else {
			return true;
		}
	}

	/**
	 * 获取一个上传字段的文件名
	 * @param string $field
	 */
	public function getSavepath($field=null)
	{
		if (is_array($this->savePath)) {
			if (isset($this->savePath[$field]) && $this->savePath[$field]) {
				return $this->savePath[$field];
			} else {
				$this->setSavePathErrorMsg();
				$this->error = true;
				return false;
			}
		} else if (!$this->savePath) {
			$this->setSavePathErrorMsg();
			$this->error = true;
			return false;
		} else {
			return $this->savePath;
		}
	}

	/**
	 * 获取一个上传字段的文件名
	 * @param string $field
	 */
	public function generateSavename($field=null)
	{
		if (is_array($this->saveRule)) {
			if (isset($this->saveRule[$field])) {
				return $this->getSavename($this->saveRule[$field]);
			} else {
				return Fso::randFileName();
			}
		} else if ($this->saveRule) {
			return $this->getSavename($this->saveRule);
		} else {
			return Fso::randFileName();
		}
	}

	/**
	 * 根据规则获取上传的文件名
	 * @param string $rule
	 * @return string
	 */
	private function getSavename($rule)
	{
		if (!$rule) {
			return Fso::randFileName();
		} else if (0 === strpos($rule, '#')) {
			$params = explode('#', $rule);
			return Fso::randFileName($params[1], $params[2]);
		} else if (function_exists($rule)) {
			return call_user_func($rule);
		} else {
			return $rule;
		}
	}

	/**
	 * 检测单个文件的后缀是否符合要求
	 * @param string $field 要检查的表单字段名
	 * @param string $filename 上传的本地文件名
	 * @param string $file 上传到临时目录下的文件路径
	 */
	public function checkExt($field, $filename, $file)
	{
		$ext = Fso::getExt($filename);
		if (!ctype_digit((string)$field) && isset($this->allowExts[$field])) {
			if (is_array($this->allowExts[$field]) && !in_array($ext, $this->allowExts[$field])) {
				$this->error = true;
				$this->errorField = $field;
				$this->errorFile = $filename;
				$this->setNotAllowExtsErrorMsg($filename, $this->$this->allowExts[$field]);
				return false;
			} else if ($ext != $this->allowExts[$field]) {
				$this->error = true;
				$this->errorField = $field;
				$this->errorFile = $filename;
				$this->setNotAllowExtsErrorMsg($filename, $this->$this->allowExts[$field]);
				return false;
			}
		} else if (!in_array($ext, $this->allowExts)) {
			$this->error = true;
			$this->errorField = $field;
			$this->errorFile = $filename;
			$this->setNotAllowExtsErrorMsg($filename, $this->allowExts);
			return false;
		} else {
			$ret = Fso::isExtMatchMime($ext, $file);
			if (!$ret) {
				$msg = Lang::get('upload_file_extension_not_match_mime_type');
				$replacement = array('{file}' => $filename, '{mime-type}'=>Fso::getMimeType($file));
				$this->error(strtr($msg, $replacement));
				$this->error = true;
				$this->errorField = $field;
				$this->errorFile = $filename;
			}
			return $ret;
		}
	}

	/**
	 * 设置文件大小超出限制提示
	 * @param string $file
	 * @param int $size
	 */
	private function setFileSizeErrorMsg($file, $size)
	{
		$replacement = array('{file}'=>$file, '{limit}'=>$size);
		$this->error(Lang::get('upload_file_too_large', $replacement));
	}

	/**
	 * 设置上传路径错误提示
	 * @param string $path
	 */
	private function setSavePathErrorMsg($path='')
	{
		$replacement = array('{path}' => $path);
		$this->error(Lang::get('upload_path_invalid', $replacement));
		return true;
	}

	/**
	 * 设置文件后缀不允许的错误提示
	 * @param string $filename
	 * @param array $exts
	 */
	private function setNotAllowExtsErrorMsg($filename, $exts)
	{
		$msg = 'upload_file_extension_not_allowed';
		$replacement = array('{file}' => $filename, '{extensions}'=>join(',', $exts));
		$this->error(Lang::get($msg, $replacement));
		return true;
	}

	/**
	 * 设置上传出错的提示
	 * @param int $type
	 * @param string $file
	 */
	private function setUploadErrorMsg($type, $file='')
	{
		if (UPLOAD_ERR_INI_SIZE == $type) {
			$this->setFileSizeErrorMsg($file, ini_get('upload_max_filesize'));
		} else if (UPLOAD_ERR_FORM_SIZE == $type) {
			$this->setFileSizeErrorMsg($file, $_POST['MAX_FILE_SIZE']);
		} else if (UPLOAD_ERR_CANT_WRITE == $type) {
			$this->error(Lang::get('upload_file_failed_to_write_to_disk', array('{file}' => $file)));
		} else if (UPLOAD_ERR_EXTENSION == $type) {
			$this->error(Lang::get('upload_file_stopped_by_extension'));
		} else {
			$this->error($type);
		}
	}

	/**
	 * 返回/设置出错信息
	 */
	public function error($errorMsg=null)
	{
		if (!is_null($errorMsg)) {
			$this->errorMsg = $errorMsg;
		}
		return $this->errorMsg;
	}

}