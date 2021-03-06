create database if not exists `binchi` default charset utf8;
use `binchi`;
set names utf8;
set foreign_key_checks=0;


-- -----------------------------------------------------
-- fragment_data
-- 片段数据
-- -----------------------------------------------------
drop table if exists `fragment_data` ;
create table if not exists `fragment_data` (
  `id` int unsigned not null auto_increment,
  `sign` varchar(60) not null default '' comment '配置项标志',
  `content` text not null comment '内容',
  primary key (`id`),
  unique index `idx_sign` (`sign`)
) engine = innodb default charset=utf8 comment = '片段数据';
insert into fragment_data values 
	('1', 'carousel', ''),
	('2', 'aboutus', '<p>本站提供基于互联网技术的服务。主要范围：微信接口功能定制开发、中高端网站功能定制开发、特殊应用系统开发。如：淘宝刷单系统定制、行业网站开发等</p>'),
	('3', 'links', '[{"title":"閑逸寒舍","url":"http://59c.net"},{"title":"YAF","url":"http://php.net/manual/en/book.yaf.php"}]'),
	('4', 'indexNews', '[]');

-- ----------------------------
-- user_login
-- 用户登录表
-- ----------------------------
drop table if exists `user_login`;
create table `user_login` (
  `uid` int unsigned not null auto_increment,
  `type` tinyint unsigned not null default 0 comment '账号类型：1-系统管理员, 2-系统编辑, 10-版主, 11-普通会员',
  `last_login_ip` bigint unsigned not null default 0 comment '上次登录IP',
  `last_login_time` int unsigned not null default 0 comment '上次登录时间',
  `username` varchar(30) not null default '' comment '用户名',
  `password` varchar(32) not null default '' comment '密码',
  `salt` varchar(8) not null default '' comment '私钥',
  primary key (`uid`),
  unique key `username` (`username`) 
) engine=InnoDB default charset=utf8 comment = '用户登录表';

-- ----------------------------
-- user
-- 用户表
-- ----------------------------
drop table if exists `user`;
create table `user` (
  `uid` int unsigned not null auto_increment,
  `username` varchar(30) not null comment '用户名',
  `regip` bigint unsigned not null default 0 comment '注册IP',
  `regtime` int unsigned not null default 0 comment '注册时间',
  `from_channel_id` int unsigned not null default 0 comment '用户来源渠道(广告渠道)ID',
  `wx_openid` varchar(16) not null default '' comment '微信公众平台OpenID',
  `wx_unionid` varchar(16) not null default '' comment '微信开放平台UnionID',
  `wx_unsubscribe` tinyint unsigned not null default 0 comment '微信取消关注',
  `nickname` varchar(16) not null default '' comment '昵称',
  `realname` varchar(16) not null default '' comment '用户真实姓名',
  `idcard` varchar(18) not null default '' comment '身份证号码',
  `qq` bigint unsigned not null default 0 comment '联系QQ',
  `email` varchar(45) not null default '' comment '电子邮箱',
  `mobile` bigint unsigned not null default 0 comment '手机',
  `exp` int unsigned not null default 0 comment '经验值',
  `point` int unsigned not null default 0 comment '积分',
  `coin` int unsigned not null default 0 comment '虚拟币',
  `gold` int unsigned not null default 0 comment '金币',
  `emails_tatus` tinyint unsigned not null default 0 comment '电子邮件绑定状态',
  `mobile_status` tinyint unsigned not null default 0 comment '手机绑定状态',
  `secure_status` tinyint unsigned not null default 0 comment '安全密保状态',
  `type` tinyint unsigned not null default 0 comment '账号类型：1-系统管理员, 2-系统编辑, 10-版主, 11-普通会员',
  `status` tinyint unsigned not null default 0 comment '账号状态:-1-逻辑删除,0-未激活,1-正常,2-冻结(网站管理员操作),3-锁定(玩家自己操作)',
  `gender` tinyint unsigned not null default '2' comment '性别',
  `birth_date` int unsigned not null default 0 comment '出生日期时间戳',
  `province` mediumint unsigned not null default 0 comment '省级行政区号',
  `city` mediumint unsigned not null default 0 comment '市',
  `county` mediumint unsigned not null default 0 comment '县/区',
  `town` mediumint unsigned not null default 0 comment '乡镇',
  `address` varchar(255) not null default '' comment '详细的联系地址',
  primary key (`uid`),
  unique `username` (`username`),
  index `regip` (`regip`),
  index `regtime` (`regtime`),
  index `from_channel_id` (`from_channel_id`)
) engine = InnoDB default charset=utf8 comment = '用户表';


-- ----------------------------
-- user_from_channel
-- 用户来源渠道
-- ----------------------------
drop table if exists `user_from_channel`;
create table `user_from_channel` (
  `id` int unsigned not null auto_increment,
  `name` varchar(16) not null default '' comment '渠道名',
  primary key (`id`)
) engine=InnoDB default charset=utf8 comment = '用户来源渠道';
insert into user_from_channel values 
  (1, '直接用户'),
  (2, '微信关注'),
  (3, 'QQ群'),
  (4, '推广链接'),
  (5, '其他社区'),
  (6, '其他网站链接'),
  (11, '百度'),
  (12, 'Google'),
  (13, '360'),
  (14, '搜搜'),
  (15, '搜狗'),
  (99, '后台添加'),
  (101, '内部账号'),
  (102, '营销账号');

-- ----------------------------
-- user_medal
-- 用户勋章列表
-- ----------------------------
drop table if exists `user_medal`;
create table `user_medal` (
  `id` int unsigned not null auto_increment,
  `uid` int unsigned not null default 0 comment '用户ID',
  `mid` int unsigned not null default 0 comment '勋章ID',
  primary key (`id`),
  unique key `idx_uid_mid` (`uid`, `mid`),
  key `idx_mid` (`mid`)
) engine=InnoDB default charset=utf8 comment = '用户勋章列表';

-- ----------------------------
-- medal
-- 勋章列表
-- ----------------------------
drop table if exists `medal`;
create table `medal` (
  `id` int unsigned not null auto_increment,
  `name` varchar(16) not null default '' comment '勋章名',
  primary key (`id`)
) engine=InnoDB default charset=utf8 comment = '勋章列表';


-- -----------------------------------------------------
-- article
-- 文章表
-- -----------------------------------------------------
drop table if exists `article`;
create table if not exists `article` (
  `id` int unsigned not null auto_increment,
  `views` mediumint unsigned not null default 0 comment '浏览数(点击数)',
  `comments`  mediumint(8) unsigned not null default 0 comment '评论数',
  `post_time` int unsigned not null default 0 comment '发布时间',
  `create_time` int unsigned not null default 0 comment '创建时间(后台创建)',
  `status` tinyint not null default 0 comment '状态:-1-已删除;0-待审核;1-正常;2-隐藏;3-特殊',
  `orderid` smallint not null default '0' comment '排序ID',
  `cover_image_id` int not null default 0 comment '封面图ID',
  `cover_image` varchar(100) not null default '' comment '封面图',
  `title` varchar(150) not null default '' comment '标题',
  `tag_ids` varchar(100) not null default '' comment '关键字标签对应ID列表(逗号分隔)',
  `tags` varchar(255) not null default '' comment '关键字标签(逗号分隔)',
  `editor` varchar(45) not null default '' comment '编辑',
  `author` varchar(45) not null default '' comment '作者',
  `redirect` varchar(255) not null default '' comment '跳转的URL',
  primary key (`id`),
  index `idx_post_time` (`post_time`),
  index `idx_orderid` (`orderid`),
  index `idx_views` (`views`),
  index `idx_comments` (`comments`)
) engine = innodb default charset=utf8 AUTO_INCREMENT=100001 comment = '文章表';

-- -----------------------------------------------------
-- `article_content`
-- -----------------------------------------------------
drop table if exists `article_content`;
create table if not exists `article_content` (
  `id` int unsigned not null auto_increment,
  `content` text not null comment '内容',
  primary key (`id`)
) engine=innodb default charset=utf8 comment = '文章内容表';

-- -----------------------------------------------------
-- tags
-- TAG标签表
-- -----------------------------------------------------
drop table if exists `tags`;
create table `tags` (
  `id` mediumint unsigned not null auto_increment,
  `name` varchar(32) not null default '' comment 'TAG名称',
  `num` mediumint unsigned not null default 0 comment '使用该TAG的内容数',
  `hot` tinyint unsigned not null default 0 comment '是否热门标签',
  primary key  (`id`),
  key `idx_hot_num` (`hot`,`num`),
  key `idx_name` (`name`)
) engine=innodb default charset=utf8 comment = 'TAG标签表';

-- -----------------------------------------------------
-- tag_data
-- TAG标签数据
-- -----------------------------------------------------
drop table if exists `tag_data`;
create table `tag_data` (
  `id` int unsigned not null auto_increment,
  `target_type` tinyint unsigned not null default 0 comment '标签对应内容类型:1-视频,2-专辑,3-文章',
  `target_id` int unsigned not null default 0 comment '标签对应内容ID',
  `tagid` mediumint unsigned not null default 0 comment '标签ID',
  primary key  (`id`),
  unique key `idx_target_type_targetid_tagid` (`target_type`, `target_id`, `tagid`),
  index `idx_target_type` (`target_type`),
  index `idx_tagid` (`tagid`)
) engine=innodb default charset=utf8 comment = 'TAG标签表';


-- ----------------------------
-- Table structure for `xzqh`
-- ----------------------------
drop table if exists `xzqh`;
create table `xzqh` (
`id` int unsigned not null auto_increment,
`code` bigint unsigned not null default '0' comment '行政区划代码',
`higher_code` bigint(10) unsigned not null default '0' comment '上一级行政区划代码',
`lvl` tinyint unsigned not null default '0' comment '级别：1-省级，2-地市级，3-县区级，4-镇/街道，5-村/居委会',
`type` tinyint unsigned not null default '0' comment '城乡分类代码：1-省级，2-地市级，3-县区级，4-镇/街道，5-村/居委会',
`name` varchar(50) not null default '' comment '行政区名',
primary key (`id`),
index `idx_code` (`code`),
index `idx_higher_code` (`higher_code`),
index `idx_lvl` (`lvl`),
index `idx_name` (`name`)
) engine=innodb default charset=utf8 comment = '行政区划表';


-- -----------------------------------------------------
-- files
-- 文件表
-- -----------------------------------------------------
drop table if exists `files`;
create table `files` (
  `id` int unsigned not null auto_increment,
  `type` int(11) not null default 0 comment '文件类型：1-图片',
  `path` varchar(200) not null default '' comment '图片路径',
  `md5` varchar(32) not null default '' comment '图片MD5',
  `size` varchar(32) not null default '' comment '图片文件大小',
  `outside_link` varchar(255) not null default '' comment '对应外链地址,如:图床、网盘等',
  primary key (`id`),
  key `type` (`type`)
) engine=innodb default charset=utf8 comment='文件表';
