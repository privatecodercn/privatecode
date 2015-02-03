<?php
/**
 * 核心语言文件
 *
 * Create     : 2013-11-22
 * Modified   : 2014-05-23
 * @link      : http://www.59c.net
 * @copyright : (C) 2013 - 2014 59C.NET
 * @version   : 1.0.0
 * @author    : Joseph Chen <chenliq@gmail.com>
 */
return 
[
	
	/**
	 * 公共数组配置
	 */
	'monthCn' => array(1=>'一月',2=>'二月',3=>'三月',4=>'四月',5=>'五月',6=>'六月',
			7=>'七月',8=>'八月',9=>'九月',10=>'十月',11=>'十一月',12=>'十二月'),
	'monthEncn' => array('Jan'=>'一月','Feb'=>'二月','Mar'=>'三月','Apr'=>'四月',
			'May'=>'五月','Jun'=>'六月','Jul'=>'七月','Aug'=>'八月',
			'Sep'=>'九月','Oct'=>'十月','Nov'=>'十一月','Dec'=>'十二月'),
	/**
	 * 星座
	 * @var array
	 */
	'gender' => array('女', '男', '保密'),
	/**
	 * 星座
	 * @var array
	 */
	'star' => array('未知', '白羊座', '金牛座', '双子座', '巨蟹座', '狮子座', '室女座',
			'天秤座', '天蝎座', '人马座', '摩羯座', '宝瓶座', '双鱼座'),
	'starDetail' => array('未知', '白羊座，牡羊座', '金牛座', '双子座', '巨蟹座', '狮子座',
			'室女座，处女座', '天秤座', '天蝎座', '人马座，射手座', '摩羯座，山羊座',
			'宝瓶座，水瓶座', '双鱼座'),
	/**
	 * 时间单位
	 * @var array
	 */
	'datetimeUnitName' => array('', '天', '周', '月', '年', '时', '分', '秒'),

	'handle_success'	=> '操作成功。',
	'handle_failed'		=> '操作失败。',
	
	'Success'		=> '操作成功。',
	'Failure'		=> '操作失败。',

	'incorrect_config' 				=> '系统配置出错。',
	'invalid_request' 				=> '您的请求无效。',
	'incorrect_verification_code'	=> '验证码不正确。',

	'controller_not_exist'					=> '请求的控制器 "{controller}" 不存在。',
	'controller_method_not_exist'			=> '请求的控制器方法 "{method}" 不存在。',
	'controller_method_arguments_invalid'	=> '请求的控制器方法参数有错。',
	'The template file opened fail.'		=> '模板文件无法打开。',
	'template_file_not_exist'				=> '模板文件 "{template_file}" 不存在。',

	'data_must_be_array_or_object'	=> '给定的数据必须是一个数组或一个对象。',
	'ipdata_library_need_update'	=> '有最新的IP库需要更新。',

	/**
	 * model
*/
	'field_is_required'			=> '字段{field}必须填写。',
	'field_invalid'				=> '字段{field}数据"{value}"非法。',

	/**
	 * upload
*/
	'upload_file_extension_not_allowed'
		=> '文件 "{file}" 无法被上传. 只有后缀名如下的文件是被允许的: {extensions}。',
	'upload_file_too_large'
		=> '文件 "{file}" 太大. 文件大小不能超过 {limit} 字节。',
	'upload_file_too_small'
		=> '文件 "{file}" 太小. 文件大小不能少于 {limit} 字节。',
	'upload_file_extension_not_match_mime_type'
		=> '文件"{file}"的后缀名与文件类型"{mime-type}"不匹配。',
	'upload_file_extension_not_match_mime_type'
		=> '文件"{file}"的后缀名与文件类型"{mime-type}"不匹配。',
	'upload_file_failed_to_write_to_disk'
		=> '无法将已上传的文件 "{file}" 写入硬盘。',
	'upload_file_stopped_by_extension' => '文件上传被 extension 所停止。',
	'upload_path_invalid' => '上传文件保存路径 "{path}" 不是一个有效的目录。',

	/**
	 * IP库
	 */

	/**
	 * 用户相关
	 */
	'login_success'					=> '登录成功。',
	'signup_success'				=> '注册成功。',
	'handle_failed_without_logined'	=> '未登录状态不允许操作。',
	'username_already_exist'        => '用户名已存在。',
	'username_not_exist'			=> '用户名不存在。',
	'password_incorrect'			=> '密码错误。',
	'username_cannot_only_digit'	=> '用户名不能为纯数字。',
	'username_character_invalid'	=> '用户名只能由以下字符组成：汉字、英文字母、数字、下划线。',
	'username_length_out_of_bound'	=> '用户名长度只能是{minlen}~{maxlen}个字符。',
	'username_is_required'			=> '用户名不能为空。',
	'password_is_required'			=> '密码不能为空。',
	'password_length_out_of_bound'	=> '密码长度只能是{minlen}~{maxlen}个字符。',
];