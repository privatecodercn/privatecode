<?php
class CaptchaController extends Yaf_Controller_Abstract
{
	public $invalidDo = [];
	
	public function indexAction($c='', $n=4, $m=5, $h=25)
	{
		$config = Yaf_Registry::get('config');
		Captcha::$cookiePath = $config->cookie->path;
		Captcha::$cookieDomain = $config->cookie->domain;
		if (empty($_GET['gif'])) {
			Captcha::generate($c, $n, $m, $h);
		} else {
			Captcha::generateGif($c, $n, $m, $h);
		}
		return false;
	}

	/**
	 * 检验一下验证码是否合法
	 * @param string $captcha
	 * @param string $cookieName
	 */
	public function validateCaptcha($captcha, $c='')
	{
		$this->json(Captcha::validate($captcha, $c));
	}
	
}