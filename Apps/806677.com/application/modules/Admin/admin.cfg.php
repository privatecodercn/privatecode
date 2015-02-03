<?php
return 
[
	'admin_menus' => [
		// 常用
		'main'		=> ['name' => '常用', 'class'=>'icon-flatscreen', 'block'=>[
			[
				'default'	=> true,
				'href'		=> '',
				'name'		=> '首页'
			],
			[
				'default'	=> false,
				'expand'	=> false,
				'href'		=> '#article',
				'name'		=> '文章',
				'sub_id'	=> 'article',
				'sub'		=> [
					['href'=>'/article/detail', 'name'=>'发表文章'],
					['href'=>'/article/index', 'name'=>'文章列表'],
				],
			],
			[
				'default'	=> false,
				'expand'	=> true,
				'href'		=> '#video',
				'name'		=> '视频管理',
				'sub_id'	=> 'video',
				'sub'		=> [
					['href'=>'/video/detail', 'name'=>'添加视频'],
					['href'=>'/video/index', 'name'=>'视频管理'],
					['href'=>'/album/detail', 'name'=>'添加专辑'],
					['href'=>'/album/index', 'name'=>'专辑管理'],
				],
			],
			[
				'default'	=> false,
				'expand'	=> true,
				'href'		=> '#author',
				'name'		=> '作者管理',
				'sub_id'	=> 'author',
				'sub'		=> [
					['href'=>'/author/detail', 'name'=>'添加作者'],
					['href'=>'/author/index', 'name'=>'作者列表'],
				],
			],
			[
				'default'	=> false,
				'expand'	=> true,
				'href'		=> '#events',
				'name'		=> '赛事管理',
				'sub_id'	=> 'events',
				'sub'		=> [
					['href'=>'/events/common', 'name'=>'总赛事管理'],
					['href'=>'/events/index', 'name'=>'赛事列表'],
					['href'=>'/events/detail', 'name'=>'添加赛事'],
				],
			],
			[
				'default'	=> false,
				'expand'	=> true,
				'href'		=> '#fragment',
				'name'		=> '碎片数据',
				'sub_id'	=> 'fragment',
				'sub'		=> [
					['href'=>'/fragment/oneKeyGenerate', 'name'=>'一键生成碎片'],
					['href'=>'/fragment/indexFocus', 'name'=>'首页焦点'],
					['href'=>'/fragment/indexNews', 'name'=>'首页新闻公告'],
					['href'=>'/fragment/index', 'name'=>'其他'],
				],
			],
		]],
		// 用户
		'user'		=> ['name' => '用户管理', 'class'=>'icon-users', 'block'=>[
			[
				'default'	=> false,
				'expand'	=> true,
				'href'		=> '#user',
				'name'		=> '用户',
				'sub_id'	=> 'user',
				'sub'		=> [
					['href'=>'/user/detail', 'name'=>'添加用户'],
					['href'=>'/user/index', 'name'=>'用户列表'],
					['href'=>'/user/changePwd', 'name'=>'修改密码'],
				],
			],
		]],
		// 统计
		'stat'		=> ['name' => '统计', 'class'=>'icon-chart', 'block'=>[
			[
				'default'	=> true,
				'expand'	=> true,
				'href'		=> '/user/newcount',
				'name'		=> '新用户统计'
			],
		]],
		// 设置
		'setting'	=> ['name' => '设置', 'class'=>'icon-setting', 'block'=>[
			[
				'default'	=> true,
				'expand'	=> true,
				'href'		=> '/config',
				'name'		=> '程序参数配置'
			],
		]],
	],
];