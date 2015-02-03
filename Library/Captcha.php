<?php
/**
 * 工具类模块
 * Created		: 2012-08-07
 * Modified		: 2014-05-23
 * @link		: http://www.59c.net
 * @copyright	: (C) 2012 - 2014 59C.NET
 * @version		: 0.0.1
 * @author		: Joseph Chen <chenliq@gmail.com>
 */
class Captcha
{
	public static $cookieName = 'captcha';
	public static $fontFile = 'consola.ttf';
	public static $fontSize = 14;
	public static $cookiePath = '';
	public static $cookieDomain = '';
	
	/**
	 * 检验一下验证码是否合法
	 * @param string $captcha
	 * @param string $cookieName
	 * @return boolean
	 */
	public static function validate($captcha, $cookieName='')
	{
		self::$cookieName = empty($cookieName) ? self::$cookieName : $cookieName;
		if (!isset($_COOKIE[$cookieName]) || !$captcha)
		{
			return false;
		}
		$cookie = $_COOKIE[$cookieName];
		if (self::hash($captcha) == $cookie)
		{
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 加密验证码
	 * @param string $str
	 */
	public static function hash($str)
	{
		return md5($_SERVER['SERVER_NAME'].strtolower($str));
	}

	/**
	 * 设置/删除验证码的COOKIE信息
	 * @param string $cookieValue cookie值 
	 * @param int $expire 过期分钟数
	 * @param string $cookieName cookie名称
	 */
	public static function setCookie($cookieValue, $expire=1, $cookieName='')
	{
		$cookieName = empty($cookieName) ? self::$cookieName : $cookieName;
		if ($cookieValue === false)
		{
			$time = time() - ($expire*60);
		} else {
			$time = time() + ($expire*60);
		}
		setcookie($cookieName, $cookieValue, $time, self::$cookiePath, self::$cookieDomain);
	}
	
	/**
	 * 输出验证码图片
	 * @param string $cookie cookie名称
	 * @param int $num 验证码显示位数
	 * @param int $cookieMinute cookie存活时间（单位：分）
	 * @param int $h 验证高度
	 * @param int $onlyDigit 是否只包含数字，否则将包含字母
	 */
	public static function generate($cookie='', $num=5, $cookieMinute=3, $h=20, $onlyDigit=false)
	{
		$params = self::getParams($cookie, $num, $cookieMinute, $h, $onlyDigit);

		$width	= $params['width'];
		$height	= $params['height'];
		$codeStr= $params['string'];
		$num	= $params['number'];

		//设置cookie,必须在输出图像之前设置
		$codeValue = self::hash($codeStr);
		self::setCookie($codeValue, $params['expire'], $params['ckname']);
		
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1970 00:00:00 GMT");
		header("Content-type: image/gif");

		$im = imagecreate($width, $height);
		$back = imagecolorallocate($im, 245,245,245);
		imagefill($im, 0, 0, $back); //背景

		// 将字符逐个画到图片上
		for ($i=0; $i<$num; $i++)
		{
			$fontSize = self::$fontSize;
			$x = 5 + $i*$fontSize;
			$y = round(($height)/2) +round($fontSize/2) ;
			$char = $codeStr[$i];
			$col = imagecolorallocate($im, rand(100,255),rand(0,100),rand(100,255));
			$angle = rand(-20,20);
			if (!is_file($fontfile = ROOT_PATH.'Assets/fonts/'.self::$fontFile))
			{
				$fontfile = __DIR__.'/'.self::$fontFile;
			}
			imagettftext($im, $fontSize, $angle, $x, $y, $col, $fontfile, $char);
		}
		//加入干扰像素(数量为图片像素的1/20)
		for($i=0;$i<round($width*$height/20);$i++)
		{
			$randcolor = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
			imagesetpixel($im, rand(1, $width), rand(1, $height), $randcolor);
		}

		//输出gif格式的图像
		imagegif($im);
		imagedestroy($im);
		exit;
	}

	/**
	 * 生成GIF动画格式验证码
	 * @param string $cookie cookie前缀
	 * @param int $num 验证码显示位数
	 * @param int $cookieMinute cookie存活时间（单位：分）
	 * @param int $h 验证高度
	 * @param int $onlyDigit 是否只包含数字，否则将包含字母
	 */
	public static function generateGif($cookie='', $num=5, $cookieMinute=3, $h=20, $onlyDigit=false)
	{
		$params = self::getParams($cookie, $num, $cookieMinute, $h, $onlyDigit);
		$codeStr= $params['string'];
		//设置cookie,必须在输出图像之前设置
		$codeValue = self::hash($codeStr);
		self::setCookie($codeValue, $params['expire'], $params['ckname']);
		$imagedata = array();
		$delay = array();
		// 最多帧数
		$maxFrame = 5;
		// 是否至少有一帧生成过验证码
		$had = false;
		// 生成一个多帧的GIF动画
		for($i=0; $i<$maxFrame; $i++)
		{
			$delay[] = 70;
			ob_start();
			$image = imagecreate($params['width'], $params['height']);
			imagecolorallocate($image, 0,0,0);
			// 设定文字颜色数组
			$colorList[] = ImageColorAllocate($image, 15,73,210);
			$colorList[] = ImageColorAllocate($image, 0,64,0);
			$colorList[] = ImageColorAllocate($image, 0,0,64);
			$colorList[] = ImageColorAllocate($image, 0,128,128);
			$colorList[] = ImageColorAllocate($image, 27,52,47);
			$colorList[] = ImageColorAllocate($image, 51,0,102);
			$colorList[] = ImageColorAllocate($image, 0,0,145);
			$colorList[] = ImageColorAllocate($image, 0,0,113);
			$colorList[] = ImageColorAllocate($image, 0,51,51);
			$colorList[] = ImageColorAllocate($image, 158,180,35);
			$colorList[] = ImageColorAllocate($image, 59,59,59);
			$colorList[] = ImageColorAllocate($image, 0,0,0);
			$colorList[] = ImageColorAllocate($image, 1,128,180);
			$colorList[] = ImageColorAllocate($image, 0,153,51);
			$colorList[] = ImageColorAllocate($image, 60,131,1);
			$colorList[] = ImageColorAllocate($image, 0,0,0);
			$fontcolor = ImageColorAllocate($image, 0,0,0);
			$gray = ImageColorAllocate($image, 245,245,245);

			$color = imagecolorallocate($image, 255,255,255);
			$color2 = imagecolorallocate($image, 255,0,0);

			imagefill($image, 0, 0, $gray);

			$space = 12;        // 字符间距
			//至少保证有一帧显示验证码
			if ($i == ($maxFrame-1) && !$had)
			{
				$rnd = 1;
			} else {
				$rnd = rand(0,1);
			}
			// 屏蔽第一帧,且后续随机不显示
			if($i > 0 && $rnd)
			{
				$len = strlen($codeStr);
				for ($k = 0; $k < $len; $k++)
				{
					$colorRandom = mt_rand(0,sizeof($colorList)-1);
					$float_top = rand(0,4);
					$float_left = rand(0,3);
					imagestring($image, 5, $space * $k + $float_left, $float_top, $codeStr[$k], $colorList[$colorRandom]);
				}
				$had++;
			}
				
			for ($k = 0; $k < 20; $k++)
			{
				$colorRandom = mt_rand(0,sizeof($colorList)-1);
				imagesetpixel($image, rand()%70 , rand()%15 , $colorList[$colorRandom]);
					
			}
			// 添加干扰线
			for($k = 0; $k < 3; $k++)
			{
				$colorRandom = mt_rand(0, sizeof($colorList)-1);
				// $todrawline = rand(0,1);
				$todrawline = 1;
				if($todrawline)
				{
					imageline($image, mt_rand(0, $params['width']), mt_rand(0,$params['height']), mt_rand(0,$params['width']), mt_rand(0,$params['height']), $colorList[$colorRandom]);
				}
				else
				{
					$w = mt_rand(0, $params['width']);
					$h = mt_rand(0, $params['width']);
					imagearc($image, $params['width'] - floor($w / 2) , floor($h / 2),
					$w, $h,  rand(90,180), rand(180,270), $colorList[$colorRandom]);
				}
			}
			imagegif($image);
			imagedestroy($image);
			$imagedata[] = ob_get_contents();
			ob_clean();
			++$i;
		}

		$gif = new GIFEncoder($imagedata, $delay, 0, 2, 0, 0, 0, 'bin');
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1970 00:00:00 GMT');
		header('Content-type:image/gif');
		echo $gif->GetAnimation();
	}

	private static function getParams($cookie='', $num=5, $cookieMinute=5, $h=20, $onlyDigit=false)
	{
		$maxLen = 8;// 验证码最多位数
		$minHeight = 20;// 验证码图片最小高度
		$maxHeight = 50;// 验证码图片最大高度
		$maxCookieMinute = 30;//Cookie最长存活时间(单位：分钟)
		if (preg_match('/[\w]+/', $cookie)) {
			$ckName = $cookie;
			self::$cookieName = $cookie;
		} else {
			$ckName = self::$cookieName;
		}
		// 验证码显示的字符数，最多8位，默认5位
		if (ctype_digit((string)$num) && $num > 0) {
			$num = $num>$maxLen ? $maxLen : $num;
		} else {
			$num = 5;
		}
		// 验证码cookie存活时间
		if (ctype_digit($cookieMinute) && $cookieMinute > 3) {
			$cookieMinute = $cookieMinute>$maxCookieMinute ? $maxCookieMinute : $cookieMinute;
		} else {
			$cookieMinute = 5;
		}

		$width = 10 + $num*self::$fontSize;
		// 验证码图片的高度，默认20像素，最多50像素
		if (ctype_digit($h) && $h > $minHeight) {
			$height = $h>$maxHeight ? $maxHeight : $h;
		} else {
			$height = 20;
		}
		// 是否只有数字
		if ($onlyDigit) {
			$randType = String::RAND_INT;
		} else {
			$randType = String::RAND_INT ^ String::RAND_UPPER;
		}
		//生成X位验证码
		$codeStr = String::rand($num, $randType);

		return array(
			'ckname'	=> $ckName,
			'number'	=> $num,
			'expire'	=> $cookieMinute,
			'width'		=> $width,
			'height'	=> $height,
			'string'	=> $codeStr,
		);
	}

	
}