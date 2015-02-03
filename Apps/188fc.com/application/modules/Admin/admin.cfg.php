<?php
return 
[
	'admin_menus' => [
		// 常用
		'main'		=> ['name' => '常用', 'class'=>'icon-flatscreen', 'block'=>[
			[
				'default'	=> true,
				'href'		=> '/index',
				'name'		=> '首页'
			],
			[
				'default'	=> false,
				'href'		=> '#house',
				'name'		=> '房源管理',
				'sub_id'	=> 'house',
				'sub'		=> [
					['href'=>'/house/officeBuildingDetail', 'name'=>'发布写字楼'],
					['href'=>'/house/officeBuildingList', 'name'=>'写字楼列表'],
					['href'=>'/house/rentDetail', 'name'=>'发布租房'],
					['href'=>'/house/rentList', 'name'=>'出租列表'],
					['href'=>'/house/secondhandDetail', 'name'=>'发布二手房'],
					['href'=>'/house/secondhandList', 'name'=>'二手房列表'],
				],
			],
			[
				'default'	=> false,
				'href'		=> '#article',
				'name'		=> '文章',
				'sub_id'	=> 'article',
				'sub'		=> [
					['href'=>'/article/detail', 'name'=>'发表文章'],
					['href'=>'/article', 'name'=>'文章列表'],
				],
			],
			[
				'default'	=> false,
				'href'		=> '/fragment',
				'name'		=> '碎片数据'
			],
		]],
		// 统计
		'user'		=> ['name' => '用户管理', 'class'=>'icon-users', 'block'=>[
			[
				'default'	=> false,
				'href'		=> '#user',
				'name'		=> '用户',
				'sub_id'	=> 'user',
				'sub'		=> [
					['href'=>'/user/detail', 'name'=>'添加用户'],
					['href'=>'/user', 'name'=>'用户列表'],
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
				'href'		=> '/config',
				'name'		=> '程序参数配置'
			],
		]],
	],
	'admin_title'		=> '管理后台  - ',
	
	'cookie_expire'		=> 86400
];