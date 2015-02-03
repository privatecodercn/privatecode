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
				'expand'	=> true,
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
				'href'		=> '#bbs',
				'name'		=> '论坛管理',
				'sub_id'	=> 'bbs',
				'sub'		=> [
					['href'=>'/board/index', 'name'=>'版块管理'],
					['href'=>'/topic/index', 'name'=>'主题帖管理'],
					['href'=>'/post/index', 'name'=>'帖子管理'],
				],
			],
			[
				'default'	=> false,
				'expand'	=> false,
				'href'		=> '#category',
				'name'		=> '分类管理',
				'sub_id'	=> 'category',
				'sub'		=> [
					['href'=>'/category/detail', 'name'=>'添加分类'],
					['href'=>'/category/index', 'name'=>'分类列表'],
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
				],
			],
		]],
		// 统计
		'stat'		=> ['name' => '统计', 'class'=>'icon-chart', 'block'=>[
			[
				'default'	=> true,
				'href'		=> '/user/newcount',
				'name'		=> '新用户统计'
			],
		]],
		// 设置
		'setting'	=> ['name' => '设置', 'class'=>'icon-setting', 'block'=>[
			[
				'default'	=> true,
				'href'		=> '/index/config',
				'name'		=> '程序参数配置'
			],
		]],
	],
];