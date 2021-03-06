<?php
class AttachmentController extends Controller
{

	/**
	 * 下载或显示文件
	 */
	public function indexAction()
	{
		$imgTypes = ['jpg', 'gif', 'png'];
		$allowFiles = ['jpg', 'gif', 'png', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'zip', 'rar', 'gz', 'bz2'];
		$path = $_SERVER['QUERY_STRING'];
		$extension = pathinfo($path, PATHINFO_EXTENSION);
		if (!in_array($extension, $allowFiles))
		{
			$this->header404();
		}
		$config = Yaf_Registry::get('config');
		$file = Yaf_Registry::get('config')->attachment->path.$path;
		if (!is_file($file) || false !== strpos($path, '../'))
		{
			$this->header404();
		}
		
		$finfo = new finfo();
		$contentType = $finfo->file($file, FILEINFO_MIME_TYPE);
		if (!in_array($extension, $imgTypes))
		{
			header("Content-Type: $contentType;");
			header('Content-Disposition: attachment; filename="' . basename($file) . '"');
		} else {
			header("Content-Type: $contentType");
		}
		header('X-Accel-Redirect:/attachment/' . $path);
		exit;
	}
	
}