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
				'href'		=> '/fragment',
				'name'		=> '碎片数据'
			],
			[
				'default'	=> false,
				'href'		=> '#weixin',
				'name'		=> '微信管理',
				'sub_id'	=> 'weixin',
				'sub'		=> [
					['href'=>'/WeixinMenu/index', 'name'=>'菜单管理'],
					['href'=>'/WeixinMenu/index2', 'name'=>'简单菜单管理'],
					['href'=>'/WeixinMenu/detail', 'name'=>'创建菜单'],
				],
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
];