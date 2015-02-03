<?php
/**
 * 水印操作
 *
 * Created		: 2013-06-06
 * Modified		: 2014-06-20
 * @link		: http://www.binchi.net
 * @copyright	: (C) 2013 - 2014
 * @version		: 1.0.0
 * @author		: Joseph Chen (me@clq.name)
 */
class WaterMark
{
	/**
	 * 水印内容与图片边距
	 * @var int
	 */
	public $padding = 5;
	
	/**
	 * 行间距
	 * @var unknown
	 */
	public $lineMargin = 5;
	
	/**
	 * 水印位置
	 * @var int:1-左上，2-中上，3-右上，4-左中，5-中间，6-右中，7-左下，8-中下，9-右下
	 */
	public $position = 3;
	
	/**
	 * 透明度
	 * @var int 0~127，0-完全不透明；127-完全透明
	 */
	public $alpha = 127;

	/**
	 * 使用的字体文件
	 * @var string
	 */
	public $fontFile = 'simsun.ttc';
	
	/**
	 * 水印的文本内容
	 * @var array $text 水印文本内容，如果多行用数组形式，每个元素表示一行
	 * @example 
	 */
	public $text = [];
	
	/**
	 * 水印的图片文件路径
	 * @var string $text 水印图片文件路径，将指定的图片做为水印内容
	 * @example 
	 */
	public $markImg = '';
	
	/**
	 * 水印添加类型
	 * @var string text-文本，image-图片
	 */
	public $markType = 'text';
	
	/**
	 * 要添加水印的图片路径
	 * @var string
	 */
	public $file = '';
	
	/**
	 * 输出添加水印后的图片路径
	 * @var string
	 */
	public $outputFile = '';
	
	/**
	 * 图片的宽度
	 * @var int
	 */
	private $width = 0;
	
	/**
	 * 图片的高度
	 * @var int
	 */
	private $height = 0;
	
	/**
	 * 是否出错
	 * @var boolean
	 */
	private $error = false;
	
	/**
	 * 信息提示
	 * @var string
	 */
	private $msg = '';
	
	/**
	 * 源图像文件
	 * @var resource
	 */
	private $srcImg = null;
	
	/**
	 * 源图片的格式:1-gif,2-jpg,3-png
	 * @var int
	 */
	private $srcImgType = 1;
	
	
	/**
	 * 构造函数
	 * @param string $imgFile 要添加水印的原始图片文件
	 */
	public function __construct($imgFile, $text=[])
	{
		if (!is_file($imgFile))
		{
			$this->error = true;
			return false;
		}
		$this->file = $imgFile;
		$imgInfo = getimagesize($this->file);
		$this->width = $imgInfo[0];
		$this->height = $imgInfo[1];
		$this->srcImgType = $imgInfo[2];
		switch ($this->srcImgType)
		{
			case 1:
				$this->srcImg = imagecreatefromgif($this->file);
				break;
			case 2:
				$this->srcImg = imagecreatefromjpeg($this->file);
				break;
			case 3:
				$this->srcImg = imagecreatefrompng($this->file);
				break;
			default:
				$this->error = true;
				$this->msg = '不支持的图片文件类型';
		}
		$this->text = $text;
	}
	
	/**
	 * 正式添加水印
	 */
	public function mark()
	{
		if ($this->error)
		{
			return false;
		}
		$dstImg = imagecreatetruecolor($this->width, $this->height);
		imagecopy($dstImg, $this->srcImg, 0, 0, 0, 0, $this->width, $this->height);
		
		$posInfo = [];
		
		if ($this->markType == 'text' && $this->text)
		{
			$maxSize = $this->getMaxSize($this->text);
			$markImg = imagecreate($maxSize[0], $maxSize[1]);
			$color = imagecolorallocatealpha($markImg, 255, 255, 255, $this->alpha);
			imagefilledrectangle($markImg, 0, 0, $maxSize[0], $maxSize[1], $color);
			$x = 3;
			$y = 3;
			foreach ($this->text as $item) 
			{
				$rgb = $item['color'];
				$color = imagecolorallocate($markImg, $rgb[0], $rgb[1], $rgb[2]);
				$y += $item['font_size'] + $this->lineMargin;
				$fontfile = ROOT_PATH.'assets/fonts/'.$item['font'];
				imagettftext($markImg, $item['font_size'], 0, $x, $y, $color, $fontfile, $item['text']);
			}
			$pos = $this->getPos($maxSize[0], $maxSize[1]);
// 			imagegif($markImg, $this->file.'.gif');
			imagecopy($dstImg, $markImg, $pos[0], $pos[1], 0, 0, $maxSize[0], $maxSize[1]);
		} else if ($this->markType == 'image' && $this->markImg) {
			$markImgInfo = $this->getMarkImg($this->markImg);
			$markImg = $markImgInfo['markImg'];
			$pos = $this->getPos($markImgInfo['width'], $markImgInfo['height']);
			imagecopy($dstImg, $markImg, $pos[0], $pos[1], 0, 0, $markImgInfo['width'], $markImgInfo['height']);
		} else {
			
		}

		switch ($this->srcImgType)
		{
			case 1:
				imagegif($dstImg, $this->outputFile);
				break;
				
			case 2:
				imagejpeg($dstImg, $this->outputFile);
				break;
				
			case 3:
				imagepng($dstImg, $this->outputFile);
				break;
		}
	}

	/**
	 * 获取所有文本占用的宽度和高度
	 * @param array $textInfo
	 */
	private function getMaxSize($textInfo)
	{
		$maxW = 0;
		$maxH = 0;
		foreach ($textInfo as $text) 
		{
			$fontfile = ROOT_PATH.'assets/fonts/'.$text['font'];
			$box = imagettfbbox($text['font_size'], 0, $fontfile, $text['text']);
			$maxW = max($maxW, $box[2], $box[4]) - min($box[0], $box[6]);
			$maxH += max($box[1], $box[3]) - min($box[5], $box[7]) + $this->lineMargin;
		}
		return [$maxW + 5, $maxH + 5];
	}
	
	/**
	 * 获取一行文本的位置信息
	 * @param int $markWidth 水印宽度
	 * @param int $markHeight 水印高度
	 */
	private function getPos($markWidth, $markHeight)
	{
		$x = $this->padding;
		$y = $this->padding;
		switch ($this->position)
		{
			case 1:
				return [$x, $y];
			break;
			
			case 2:
				return [($this->width - $x*2 - $markWidth)/2, $y];
			break;
			
			case 3:
				return [$this->width - $x*2 - $markWidth, $y];
			break;
			
			case 4:
				return [$x, ($this->height - $y*2 - $markHeight)/2];
			break;
			
			case 5:
				return [($this->width - $x*2 - $markWidth)/2, ($this->height - $y*2 - $markHeight)/2];
			break;
			
			case 6:
				return [$this->width - $x*2 - $markWidth, ($this->height - $y*2 - $markHeight)/2];
			break;
			
			case 7:
				return [$x, $this->height - $y*2 - $markHeight];
			break;
			
			case 8:
				return [($this->width - $x*2 - $markWidth)/2, $this->height - $y*2 - $markHeight];
			break;
			
			case 9:
				return [$this->width - $x*2 - $markWidth, $this->height - $y*2 - $markHeight];
			break;
			
			default:
				;
			break;
		}
	}
	
	private function getMarkImg($imgFile)
	{
		$imgInfo = getimagesize($imgFile);
		$imgType = $imgInfo[2];
		switch ($imgType)
		{
			case 1:
				$markImg = imagecreatefromgif($imgFile);
				break;
			case 2:
				$markImg = imagecreatefromjpeg($imgFile);
				break;
			case 3:
				$markImg = imagecreatefrompng($imgFile);
				break;
			default:
				$this->error = true;
				$this->msg = '不支持的图片文件类型';
		}
		return ['markImg'=>$markImg, 'width'=>$imgInfo[0], 'height'=>$imgInfo[1]];
	}
}







































