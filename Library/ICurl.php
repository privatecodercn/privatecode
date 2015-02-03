<?php
/**
 * CURL功能
 *
 * Created		: 2013-04-28
 * Modified		: 2013-04-28
 * @link		: http://www.59c.net
 * @copyright 	: (C) 2012 - 2014 59C.NET
 * @version		: 0.1.0
 * @author		: Joseph Chen (chenliq@gmail.com)
 */
class ICurl
{
	/**
	 * cURL句柄
	 * @var resource
	 */
	private $_ch;
	/**
	 * 当前请求的URL地址
	 * @var string
	 */
	private $_url;
	/**
	 * 当前CURL 配置
	 * @var unknown
	 */
	public $options;
	/**
	 * 请求的USER-AGENT用PHP标志
	 */
	private $phpAgent = 'PHP/%s (Linux;) PHP/20130830 PHP/%s';
	/**
	 * 默认配置
	 * @var array
	 */
	private $_config = array(
		CURLOPT_RETURNTRANSFER	=> true,
// 		CURLOPT_FOLLOWLOCATION	=> true,
		CURLOPT_AUTOREFERER		=> true,
		CURLOPT_CONNECTTIMEOUT	=> 30,
		CURLOPT_TIMEOUT			=> 30,
		CURLOPT_SSL_VERIFYPEER	=> false,
		CURLOPT_HEADER			=> false,
		CURLOPT_USERAGENT		=> 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.31'
	);

	/**
	 * 构造函数
	 * @throws CException
	 */
	public function __construct($url=null)
	{
		try {
			if (!ini_get('open_basedir') && !ini_get('safe_mode'))
			{
				$this->_config[CURLOPT_FOLLOWLOCATION] = true;
			}
			if (strtoupper($this->_config[CURLOPT_USERAGENT]) == 'PHP')
			{
				$this->phpAgent = sprintf($this->phpAgent, PHP_VERSION);
				$this->_config[CURLOPT_USERAGENT] = $this->phpAgent;
			}
			$this->_ch = curl_init($url);
			$options = is_array($this->options) ? ($this->options + $this->_config) : $this->_config;
			$this->setOptions($options);
		
			$ch = $this->_ch;
	
		} catch (Exception $e) {
			throw new CException('Curl not installed');
		}
	}

	/**
	 * GET请求一个页面
	 * @param string $url 请求的URL
	 * @param array $params 请求的附加URL参数
	 * @return mixed
	 */
	public function get($url='', $params = array())
	{
		return $this->_exec($this->buildUrl($url, $params));
	}

	/**
	 * 请求多个URL页面
	 * @param array $urls URL数组
	 */
	public function gets($urls, $usleep=0)
	{
		foreach ($urls as $url)
		{
			$this->get($url);
			if ($usleep)
			{
				usleep($usleep);
			}
		}	
	}
	
	/**
	 * POST提交到一个页面
	 * @param string $url 请求的URL
	 * @param array $data POST提交的数据
	 * @return mixed
	 */
	public function post($data = array())
	{
		$this->setOption(CURLOPT_POST, true);
		$this->setOption(CURLOPT_POSTFIELDS, $data);
		return $this->_exec();
	}

	/**
	 * PUT方式提交数据
	 * @param string $url 请求的URL
	 * @param array $data 提交的数据
	 * @param array $params 请求的附加URL参数
	 * @return mixed
	 */
	public function put($url, $data, $params = array())
	{
		// write to memory/temp
		$f = fopen('php://temp', 'rw+');
		fwrite($f, $data);
		rewind($f);

		$this->setOption(CURLOPT_PUT, true);
		$this->setOption(CURLOPT_INFILE, $f);
		$this->setOption(CURLOPT_INFILESIZE, strlen($data));

		return $this->_exec($this->buildUrl($url, $params));
	}

	/**
	 * 根据参数创建一个新的URL
	 * @param string $url 请求的URL
	 * @param array $data 提交的数据
	 * @return string
	 */
	public function buildUrl($url, $data = array())
	{
		if (!$url) return null;
		$parsed = parse_url($url);
		isset($parsed['query']) ? parse_str($parsed['query'], $parsed['query']) : $parsed['query'] = array();
		$params = isset($parsed['query']) ? array_merge($parsed['query'], $data) : $data;
		$parsed['query'] = ($params) ? '?' . http_build_query($params) : '';
		if (!isset($parsed['path']))
		{
			$parsed['path'] = '/';
		}
		$port = '';
		if (isset($parsed['port']))
		{
			$port = ':' . $parsed['port'];
		}
		
		return $parsed['scheme'] . '://' . $parsed['host'] .$port. $parsed['path'] . $parsed['query'];
	}

	/**
	 * 设置一个或多个CURL设置选项
	 * @param array $options
	 * @return Curl
	 */
	public function setOptions($options = array())
	{
		curl_setopt_array($this->_ch, $options);
		return $this;
	}


	/**
	 * 设置CURL传输选项
	 * @param string $options
	 * @return Curl
	 */
	public function setOption($option, $value)
	{
		curl_setopt($this->_ch, $option, $value);
		return $this;
	}

	/**
	 * 执行操作
	 * @param string $url
	 * @throws CException
	 * @return mixed
	 */
	private function _exec($url=null)
	{
		if ($url)
		{
			$this->setOption(CURLOPT_URL, $url);
		}
		$c = curl_exec($this->_ch);
		if (!curl_errno($this->_ch))
		{
    	    curl_close($this->_ch);
			return $c;
		} else {
// 			throw new Exception(curl_error($this->_ch));
    	    curl_close($this->_ch);
    	    return false;
		}
	}
}
