create database if not exists `kuiwa` default charset utf8;
use `kuiwa`;
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
	('2', 'aboutus', ''),
	('3', 'links', '[{"title":"","url":"http://fz12345.taobao.com"}]'),
	('4', 'indexNews', '[]');

-- ----------------------------
-- user_login
-- 用户登录表
-- wrFKX4wJ
-- ----------------------------
drop table if exists `user_login`;
create table `user_login` (
  `uid` int unsigned not null auto_increment,
  `type` tinyint unsigned not null default 0 comment '账号类型：1-系统管理员, 2-系统编辑, 10-版主, 11-普通会员',
  `last_login_ip` bigint unsigned not null default 0 comment '上次登录IP',
  `last_login_time` int unsigned not null default 0 comment '上次登录时间',
  `username` varchar(10) not null default '' comment '用户名',
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
  `username` varchar(10) not null comment '用户名',
  `regip` bigint unsigned not null default 0 comment '注册IP',
  `regtime` int unsigned not null default 0 comment '注册时间',
  `from_channel_id` int unsigned not null default 0 comment '用户来源渠道(广告渠道)ID',
  `nickname` varchar(16) not null default '' comment '昵称',
  `realname` varchar(16) not null default '' comment '用户真实姓名',
  `idcard` varchar(18) not null default '' comment '身份证号码',
  `qq` bigint unsigned not null default 0 comment '联系QQ',
  `email` varchar(45) not null default '' comment '电子邮箱',
  `mobile` bigint unsigned not null default 0 comment '手机',
  `exp` int unsigned not null default 0 comment '经验值',
  `point` int unsigned not null default 0 comment '积分',
  `honor` int unsigned not null default 0 comment '荣誉币',
  `coin` int unsigned not null default 0 comment '硬币(葵花籽)',
  `gold` int unsigned not null default 0 comment '金币',
  `diamond` int unsigned not null default 0 comment '钻石',
  `emails_tatus` tinyint unsigned not null default 0 comment '电子邮件绑定状态',
  `mobile_status` tinyint unsigned not null default 0 comment '手机绑定状态',
  `secure_status` tinyint unsigned not null default 0 comment '安全密保状态',
  `type` tinyint unsigned not null default 0 comment '账号类型：1-系统管理员, 2-系统编辑, 10-版主, 11-普通会员',
  `status` tinyint unsigned not null default 0 comment '账号状态:-1-逻辑删除,0-未激活,1-正常,2-冻结(网站管理员操作),3-锁定(玩家自己操作)',
  `gender` tinyint unsigned not null default 2 comment '性别',
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
) engine = InnoDB default charset=utf8 auto_increment=889900 comment = '用户表';


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
  (2, 'QQ群'),
  (3, '推广链接'),
  (4, '其他社区'),
  (5, '其他网站链接'),
  (11, '百度'),
  (12, 'Google'),
  (13, '360'),
  (14, '搜搜'),
  (15, '搜狗'),
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
  `target_type` tinyint unsigned not null default 0 comment '标签对应内容类型:1-文章,2-BBS',
  `target_id` int unsigned not null default 0 comment '标签对应内容ID',
  `tagid` mediumint unsigned not null default 0 comment '标签ID',
  primary key  (`id`),
  unique key `idx_target_type_targetid_tagid` (`target_type`, `target_id`,`tagid`),
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
`higher_code` bigint unsigned not null default '0' comment '上一级行政区划代码',
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
-- category
-- 分类表
-- -----------------------------------------------------
drop table if exists `category`;
create table `category` (
  `id` smallint unsigned not null auto_increment,
  `pid` int not null default 0 comment '上级分类ID',
  `level` tinyint not null default 1 comment '分类层级',
  `type` tinyint not null default 0 comment '类型:1-文章,2-帖子',
  `name` varchar(200) not null default '' comment '名称',
  `path` varchar(100) not null default '' comment '分类层级路径信息',
  primary key (`id`),
  key `type` (`type`)
) engine=innodb default charset=utf8 comment='分类表';
insert into `category` (`id`, `type`, `name`, `path`) values
  (1, 1, '公告', '/1'),
  (2, 1, 'FAQ', '/2'),
  (3, 1, '备孕期', '/3'),
  (4, 1, '孕产期', '/4'),
  (5, 1, '分娩期', '/5'),
  (6, 1, '婴儿期', '/6'),
  (7, 1, '幼儿期', '/7'),
  (8, 1, '母婴食谱', '/8'),
  (9, 1, '养生美食', '/9'),
  (10, 1, '亲子教育', '/10'),
  (11, 1, '故事堂', '/11'),
  (101, 2, '经验', '/101'),
  (102, 2, '求助', '/102'),
  (103, 2, '讨论', '/103');


-- -----------------------------------------------------
-- article
-- 文章表
-- -----------------------------------------------------
drop table if exists `article`;
create table if not exists `article` (
  `id` int unsigned not null auto_increment,
  `cid` int unsigned not null default 0 comment '分类ID',
  `is_copy` tinyint unsigned not null default 0 comment '是否转载：0-原创,1-转载',
  `views` mediumint unsigned not null default 0 comment '浏览数(点击数)',
  `comments`  mediumint unsigned not null default 0 comment '评论数',
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
  `source` varchar(30) not null default '' comment '来源',
  `source_url` varchar(100) not null default '' comment '来源URL',
  primary key (`id`),
  index `idx_cid` (`cid`),
  index `idx_post_time` (`post_time`),
  index `idx_orderid` (`orderid`)
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
-- article_plugin
-- 文章扩展插件内容
-- -----------------------------------------------------
drop table if exists `article_plugin`;
create table `article_plugin` (
  `id` int unsigned not null auto_increment,
  `aid` int unsigned not null default 0 comment '文章ID',
  `target_id` int unsigned not null default 0 comment '对应插件ID',
  primary key  (`id`),
  unique key `idx_target_type_targetid_tagid` (`aid`, `target_id`),
  index `idx_target_id` (`target_id`)
) engine=innodb default charset=utf8 comment = '文章扩展插件内容表';


-- -----------------------------------------------------
-- bbs_board
-- 论坛版块
-- -----------------------------------------------------
drop table if exists `bbs_board`;
create table if not exists `bbs_board` (
  `id` mediumint unsigned not null auto_increment,
  `lvl` tinyint not null default 0 comment '版块层级',
  `pid` tinyint not null default 0 comment '上级版块',
  `topic_num` smallint not null default '0' comment '主题数',
  `post_num` mediumint not null default '0' comment '帖子数',
  `view_num` mediumint unsigned not null default 0 comment '浏览数',
  `post_time` int unsigned not null default 0 comment '发帖时间',
  `status` tinyint not null default 0 comment '状态:-1-已删除;0-隐藏;1-启用;',
  `orderid` tinyint not null default 0 comment '排序ID',
  `name` varchar(150) not null default '' comment '版块名称',
  `managers` varchar(255) not null default '' comment '版主列表，","分隔的UID列表',
  `paths` varchar(255) not null default '' comment '上级版块信息',
  primary key (`id`),
  index `idx_post_time` (`post_time`)
) engine = innodb default charset=utf8 comment = '论坛版块';
insert into `bbs_board` (`id`, `lvl`, `pid`, `status`, `name`, `managers`, `paths`) values
  ('1', '1', '0', '0', '孕婴', '{"2":"葵娃"}', '[]'),
  ('2', '2', '1', '0', '准备怀孕', '', '[[1, "孕婴"]]'),
  ('3', '2', '1', '0', '孕期交流', '', '[[1, "孕婴"]]'),
  ('4', '2', '1', '0', '婴儿护理', '', '[[1, "孕婴"]]'),
  ('5', '2', '1', '0', '宝宝健康', '', '[[1, "孕婴"]]'),
  ('6', '2', '1', '0', '母婴食谱', '', '[[1, "孕婴"]]'),
  ('7', '1', '0', '0', '教育', '', '[]'),
  ('8', '2', '7', '0', '亲子阅读', '', '[[7, "教育"]]'),
  ('9', '2', '7', '0', '幼儿教育', '', '[[7, "教育"]]'),
  ('10', '2', '7', '0', '资源分享', '', '[[7, "教育"]]'),
  ('11', '1', '0', '0', '健康养生', '', '[]'),
  ('12', '2', '11', '0', '女性健康', '', '[[11, "健康养生"]]'),
  ('13', '2', '11', '0', '养生美食', '', '[[11, "健康养生"]]'),
  ('14', '2', '11', '0', '养生保健', '', '[[11, "健康养生"]]'),
  ('15', '1', '0', '0', '公共交流', '', '[]'),
  ('16', '2', '15', '0', '家有乐宝', '', '[[15, "公共交流"]]'),
  ('17', '2', '15', '0', '闲聊茶馆', '', '[[15, "公共交流"]]'),
  ('18', '2', '15', '0', '美图分享', '', '[[15, "公共交流"]]'),
  ('19', '2', '15', '0', '母婴闲置', '', '[[15, "公共交流"]]'),
  ('20', '1', '0', '0', '站务', '', '[]'),
  ('21', '2', '20', '0', '公告区', '', '[[20, "站务"]]'),
  ('22', '2', '20', '0', '建议、反馈', '', '[[20, "站务"]]'),
  ('23', '2', '20', '0', '举报、投诉', '', '[[20, "站务"]]'),
  ('24', '2', '20', '0', '版主专区', '', '[[20, "站务"]]');
    
-- -----------------------------------------------------
-- bbs_board
-- 论坛版块日期数据
-- -----------------------------------------------------
drop table if exists `bbs_board_date_data`;
create table if not exists `bbs_board_date_data` (
  `id` int unsigned not null auto_increment,
  `board_id` mediumint not null default 0 comment '版块ID',
  `date` int not null default 0 comment '日期:20140414',
  `topic_num` smallint not null default '0' comment '主题数',
  `post_num` smallint not null default '0' comment '帖子数',
  `view_num` mediumint unsigned not null default 0 comment '浏览数',
  primary key (`id`),
  unique index `idx_board_id_date` (`board_id`, `date`),
  index `idx_topic_num` (`topic_num`),
  index `idx_post_num` (`post_num`)
) engine = innodb default charset=utf8 comment = '论坛版块日期数据';
    
-- -----------------------------------------------------
-- bbs_topic
-- 论坛主题帖
-- -----------------------------------------------------
drop table if exists `bbs_topic`;
create table if not exists `bbs_topic` (
  `id` int unsigned not null auto_increment,
  `board_id` mediumint unsigned not null default 0 comment '版块ID',
  `uid`  int unsigned not null default 0 comment '发帖会员ID',
  `aid`  int unsigned not null default 0 comment '帖子主题直接关联文章内容',
  `is_copy` tinyint unsigned not null default 0 comment '是否转载：0-原创,1-转载',
  `view_num` mediumint unsigned not null default 0 comment '浏览数',
  `post_num`  mediumint unsigned not null default 0 comment '回帖数',
  `post_time` int unsigned not null default 0 comment '发帖时间',
  `status` tinyint not null default 0 comment '状态:-1-已删除;0-待审核;1-正常;',
  `only_owner_view` tinyint not null default 0 comment '回复仅帖主可见',
  `last_post_time` tinyint not null default 0 comment '最后发表时间',
  `last_post_uid` tinyint not null default 0 comment '最后发表UID',
  `last_post_user` tinyint not null default 0 comment '最后发表用户昵称',
  `title` varchar(120) not null default '' comment '标题',
  `nickname` varchar(16) not null default '' comment '发帖会员昵称',
  primary key (`id`),
  index `idx_uid` (`uid`),
  index `idx_board_id` (`board_id`),
  index `idx_create_time` (`create_time`)
) engine = innodb default charset=utf8 AUTO_INCREMENT=10001 comment = '论坛主题帖';
    
-- -----------------------------------------------------
-- bbs_posts
-- 论坛帖子
-- -----------------------------------------------------
drop table if exists `bbs_posts`;
create table if not exists `bbs_posts` (
  `id` int unsigned not null auto_increment,
  `board_id` mediumint unsigned not null default 0 comment '版块ID',
  `topic_id` int unsigned not null default 0 comment '主题帖ID',
  `post_time` int unsigned not null default 0 comment '发帖时间',
  `status` tinyint not null default 0 comment '状态:-1-已删除;0-待审核;1-正常;',
  `position` smallint not null default '0' comment '帖子位置',
  `content` mediumtext not null comment '内容',
  primary key (`id`),
  index `idx_topic_id` (`topic_id`),
  index `idx_position` (`position`),
  index `idx_create_time` (`create_time`)
) engine = innodb default charset=utf8 AUTO_INCREMENT=10001 comment = '论坛帖子';

    
    
    
    