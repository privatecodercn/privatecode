<?php
/**
 * URL操作
 *
 * Create     : 2013-11-22
 * Modified   : 2013-11-22
 * @link      : http://www.59c.net
 * @copyright : (C) 2013 59C.NET
 * @version   : 1.0.0
 * @author    : Joseph Chen <chenliq@gmail.com>
 */
class Url
{
	/**
	 * 获取新浪微博短链接
	 * @param string $url
	 */
	public static function getWeiboShortUrl($url)
	{
		$apiUrl='http://api.t.sina.com.cn/short_url/shorten.json?source=209678993&url_long='.urlencode($url);
		$icurl = new ICurl();
		$json = $icurl->get($apiUrl);
		$result = json_decode($json);
		return $result[0]->url_short;
	}
	
	/**
	 * 短网址生成
	 * @param string $url
	 */
	public static function shorturl($url)
	{
		$url = crc32($url);
		$result = sprintf("%u", $url);
		return self::code62($result);
	}

	/**
	 * 短网址生成编码
	 * @param string $x
	 */
	public static function code62($x)
	{
		$show = '';
		while($x > 0) {
			$s = $x % 62;
			if ($s > 35) {
				$s = chr($s+61);
			} elseif ($s > 9 && $s <=35) {
				$s = chr($s + 55);
			}
			$show .= $s;
			$x = floor($x/62);
		}
		return $show;
	}

	/**
	 * 调用google的api生成短网址
	 * @param string $long_url
	 */
	public static function shortenGoogleUrl($long_url)
	{
		$apiKey = 'AIzaSyA9nILUpH0bW0sy733CkslaWkP7xYT7q98';
		$postData = array('longUrl' => $long_url, 'key' => $apiKey);
		$jsonData = json_encode($postData);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
		$response = curl_exec($curl);
		curl_close($curl);
		$json = json_decode($response);
		return $json->id;
	}

	/**
	 * 调用google的api从短网址还原成原网址
	 * @param string $short_url
	 */
	public static function expandGoogleUrl($short_url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?shortUrl='.$short_url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($curl);
		curl_close($curl);
		$json = json_decode($response);
		var_export($json);
		return $json->longUrl;
	}

	/**
	 * 去除URL后缀
	 * @param string $pathInfo
	 * @param string $urlSuffix
	 * @return string
	 */
	public static function removeSuffix($pathInfo, $urlSuffix)
	{
		if($urlSuffix!=='' && substr($pathInfo,-strlen($urlSuffix))===$urlSuffix)
		{
			return substr($pathInfo, 0, -strlen($urlSuffix));
		}
		else
		{
			return $pathInfo;
		}
	}
	
}