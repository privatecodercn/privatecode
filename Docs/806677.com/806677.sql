create database if not exists `806677` default charset utf8;
use `806677`;
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
	('2', 'aboutus', '<p>本站专注于DOTA2重大赛事比赛视频和各种精彩集锦。</p>'),
	('3', 'links', '[{"title":"閑逸寒舍","url":"http://59c.net"},{"title":"YAF","url":"http://php.net/manual/en/book.yaf.php"}]'),
	('4', 'indexFocus', '[{"title":"TI4比赛回顾","url":"\/ti4","cover_image_id":22,"cover_image":"\/attachment\/images\/2014\/0919\/2991541be2c6490aa767.jpg","create_time":1411315200,"brief":"DOTA2国际邀请赛，简称Ti，创立于2011年，是一个全球性的电子竞技赛事，ValveCorporation（V社）主办。\\r\\n 每年一次在美国西雅图（除Ti1在德国科隆）举行DOTA2最大规模和最高奖金额度的国际性高水准比赛。<br \/>\\r\\n截止TI4，DOTA2奖金额度已高达千万美元。"},{"title":"TI3","url":"\/ti3","cover_image_id":27,"cover_image":"\/attachment\/images\/2014\/0919\/6754541bf6b0a4e87134.jpg","create_time":1411315200},{"title":"TI2","url":"\/ti2","cover_image_id":22,"cover_image":"\/attachment\/images\/2014\/0919\/2991541be2c6490aa767.jpg","create_time":1411315200},{"title":"WCG2012","url":"wcg2012","cover_image_id":22,"cover_image":"\/attachment\/images\/2014\/0919\/2991541be2c6490aa767.jpg","create_time":1411315200},{"title":"TI1","url":"\/ti1","cover_image_id":22,"cover_image":"\/attachment\/images\/2014\/0919\/2991541be2c6490aa767.jpg","create_time":1411315200}]'),
	('5', 'indexNews', '[]');

-- ----------------------------
-- user_login
-- 用户登录表
-- V7ang1IA
-- ----------------------------
drop table if exists `user_login`;
create table `user_login` (
  `uid` int unsigned not null auto_increment,
  `last_login_ip` bigint unsigned not null default 0 comment '上次登录IP',
  `last_login_time` int unsigned not null default 0 comment '上次登录时间',
  `username` varchar(10) not null default '' comment '用户名',
  `password` varchar(32) not null default '' comment '密码',
  `salt` varchar(8) not null default '' comment '私钥',
  primary key (`uid`),
  unique key `username` (`username`) 
) engine=InnoDB default charset=utf8 auto_increment=12585 comment = '用户登录表';
insert into user_login values ('1', '100', '1392364872', 'admin', '43318bce9d9c58e77421b0e6272e6586', '7E3#g9,c');

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
  `mobile` varchar(11) not null default '' comment '手机',
  `exp` int unsigned not null default 0 comment '经验值',
  `point` int unsigned not null default 0 comment '积分',
  `coin` int unsigned not null default 0 comment '虚拟币',
  `gold` int unsigned not null default 0 comment '金币',
  `emails_tatus` tinyint unsigned not null default 0 comment '电子邮件绑定状态',
  `mobile_status` tinyint unsigned not null default 0 comment '手机绑定状态',
  `secure_status` tinyint unsigned not null default 0 comment '安全密保状态',
  `type` tinyint unsigned not null default 0 comment '账号类型：0-普通会员, 1-系统管理员, 2-系统编辑, 10-版主, 21-视频解说，22-视频作者',
  `status` tinyint unsigned not null default 0 comment '账号状态:-1-逻辑删除,0-未激活,1-正常,2-冻结(网站管理员操作),3-锁定(玩家自己操作)',
  `gender` tinyint unsigned not null default '2' comment '性别',
  `birth_date` int unsigned not null default 0 comment '出生日期时间戳',
  `province` mediumint unsigned not null default 0 comment '省级行政区号',
  `city` mediumint unsigned not null default 0 comment '市',
  `county` mediumint unsigned not null default 0 comment '县/区',
  `address` varchar(255) not null default '' comment '详细的联系地址',
  `brief` varchar(500) not null default '' comment '个人简介',
  primary key (`uid`),
  unique `username` (`username`),
  index `regip` (`regip`),
  index `regtime` (`regtime`),
  index `from_channel_id` (`from_channel_id`)
) engine = InnoDB default charset=utf8 comment = '用户表';
insert into user values (1, 'admin', 167772674, 1393490730, 1, '管理员', '管理员', '350101198001011212', 0, 'admin@806677.com', '15312345678', '10000', '10000', '10000', '10000', '1', '1', '1', '1', '1', '2', '315504000', '350000', '350100', '350102', '', '');


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
  `target_type` tinyint unsigned not null default 0 comment '标签对应内容类型:1-文章,2-专辑,3-视频',
  `target_id` int unsigned not null default 0 comment '标签对应内容ID',
  `tagid` mediumint unsigned not null default 0 comment '标签ID',
  primary key  (`id`),
  unique key `idx_target_type_targetid_tagid` (`target_type`, `target_id`, `tagid`),
  index `idx_target_id` (`target_id`),
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
-- events_common
-- 总赛事
-- -----------------------------------------------------
drop table if exists `events_common`;
create table `events_common` (
  `id` int unsigned not null auto_increment,
  `name` varchar(30) not null default '' comment '名称',
  `short_name` varchar(15) not null default '' comment '简称',
  `brief` varchar(5000) not null default '' comment '简介',
  primary key  (`id`)
) engine=innodb default charset=utf8 comment='总赛事';


-- -----------------------------------------------------
-- events
-- 赛事
-- -----------------------------------------------------
drop table if exists `events`;
create table `events` (
  `id` int unsigned not null auto_increment,
  `start_time` int unsigned not null default 0 comment '开始时间',
  `end_time` int unsigned not null default 0 comment '结束时间',
  `name` varchar(30) not null default '' comment '名称',
  `short_name` varchar(15) not null default '' comment '简称',
  `brief` varchar(5000) not null default '' comment '简介',
  primary key  (`id`)
) engine=innodb default charset=utf8 comment='赛事';


-- -----------------------------------------------------
-- events_video
-- 赛事的视频
-- -----------------------------------------------------
drop table if exists `events_video`;
create table `events_video` (
  `id` int unsigned not null auto_increment,
  `e_id` int unsigned not null default 0 comment '赛事ID',
  `v_id` int unsigned not null default 0 comment '视频ID',
  primary key  (`id`),
  unique key `e_id_v_id` (`e_id`, `v_id`) 
) engine=innodb default charset=utf8 comment='赛事的视频';


-- -----------------------------------------------------
-- teams
-- 战队
-- -----------------------------------------------------
drop table if exists `teams`;
create table `teams` (
  `id` int unsigned not null auto_increment,
  `name` varchar(100) not null default '' comment '战队名称',
  primary key  (`id`)
) engine=innodb default charset=utf8 comment='战队';


-- -----------------------------------------------------
-- player
-- 选手
-- -----------------------------------------------------
drop table if exists `player`;
create table `player` (
  `id` int unsigned not null auto_increment,
  `play_id` varchar(100) not null default '' comment '游戏ID',
  `realname` varchar(100) not null default '' comment '真实姓名',
  primary key  (`id`)
) engine=innodb default charset=utf8 comment='选手';


-- -----------------------------------------------------
-- video_site
-- 视频站
-- -----------------------------------------------------
drop table if exists `video_site`;
create table `video_site` (
  `id` int unsigned not null auto_increment,
  `name` varchar(100) not null default '' comment '视频站名称',
  `domain` varchar(100) not null default '' comment '网站域名',
  primary key  (`id`)
) engine=innodb default charset=utf8 comment='视频站';
insert into `video_site`(`id`, `name`, `domain`) values
  (1, '网络', ''),
  (2, '优酷', 'www.youku.com'),
  (3, '土豆', 'www.tudou.com'),
  (4, '搜狐视频', 'tv.sohu.com'),
  (5, '腾讯视频', 'v.qq.com'),
  (6, '56', 'www.56.com'),
  (7, '爱奇艺', 'www.iqiyi.com '),
  (8, '新浪视频', 'v.sina.com.cn'),
  (9, '酷6网', 'www.ku6.com'),
  (10, '6间房', 'www.6.cn'),
  (11, '17173', 'v.17173.com'),
  (12, '乐视', 'www.letv.com')
  ;


-- -----------------------------------------------------
-- video
-- 视频
-- -----------------------------------------------------
drop table if exists `video`;
create table `video` (
  `id` int unsigned not null auto_increment,
  `from` smallint unsigned not null default 1 comment '来源视频站对应ID',
  `views` int unsigned not null default 0 comment '视频浏览量',
  `score` int not null default 0 comment '视频评分',
  `status` tinyint not null default 0 comment '状态:-1-已删除;0-待审核;1-正常',
  `definition` smallint not null default 1 comment '视频清晰度：2-标清，4-高清，8-超清',
  `play_style` tinyint unsigned not null default 1 comment '播放方式:1嵌入代码，2-跳转到播放页',
  `type` tinyint not null default 1 comment '视频类型：1-集锦视频，2-比赛视频，3-解说视频',
  `create_time` int unsigned not null default 0 comment '创建时间',
  `author_uid` int unsigned not null default 0 comment '作者ID',
  `title` varchar(100) not null default '' comment '视频标题',
  `author` varchar(30) not null default 0 comment '作者',
  `tag_ids` varchar(100) not null default '' comment '关键字标签对应ID列表(逗号分隔)',
  `tags` varchar(255) not null default '' comment '关键字标签(逗号分隔)',
  `cover_image_id` int not null default 0 comment '视频封面图ID',
  `cover_image` varchar(200) not null default '' comment '视频封面图',
  `url` varchar(100) not null default '' comment '视频源播放页地址，跳转到页面时使用',
  `code` varchar(300) not null default '' comment '视频播放器代码',
  `brief` varchar(255) not null default '' comment '视频摘要',
  primary key (`id`),
  index `idx_create_time` (`create_time`),
  index `idx_views` (`views`),
  index `idx_score` (`score`),
  index `idx_type` (`type`),
  index `idx_author_uid` (`author_uid`)
) engine=innodb default charset=utf8 comment='视频';


-- -----------------------------------------------------
-- album
-- 专辑
-- -----------------------------------------------------
drop table if exists `album`;
create table `album` (
  `id` int unsigned not null auto_increment,
  `score` int not null default 0 comment '视频评分',
  `views` int unsigned not null default 0 comment '查看数(专题所有视频被查看数)',
  `status` tinyint unsigned not null default 0 comment '状态:-1-已删除;0-待审核;1-正常',
  `create_time` int unsigned not null default 0 comment '创建时间',
  `author_uid` int unsigned not null default 0 comment '作者ID',
  `title` varchar(255) not null default '' comment '专辑标题',
  `author` varchar(30) not null default 0 comment '作者',
  `cover_image_id` int not null default 0 comment '视频封面图ID',
  `cover_image` varchar(100) not null default '' comment '视频封面图',
  `tag_ids` varchar(100) not null default '' comment '关键字标签对应ID列表(逗号分隔)',
  `tags` varchar(255) not null default '' comment '关键字标签(逗号分隔)',
  `sign` varchar(50) not null default 0 comment '专辑标志符,用于生成缓存目录等',
  `content` varchar(255) not null default '' comment '专辑简介',
  primary key  (`id`)
) engine=innodb default charset=utf8 comment='专辑';


-- -----------------------------------------------------
-- album_videos
-- 专辑包含的视频
-- -----------------------------------------------------
drop table if exists `album_videos`;
create table `album_videos` (
  `id` int unsigned not null auto_increment,
  `a_id` int unsigned not null default 0 comment '专辑ID',
  `v_id` int unsigned not null default 0 comment '视频ID',
  `order_id` smallint unsigned not null default 0 comment '视频在专辑中的顺序ID',
  primary key  (`id`),
  unique key `a_id_v_id` (`a_id`, `v_id`) 
) engine=innodb default charset=utf8 comment='专辑包含的视频';


-- -----------------------------------------------------
-- author
-- 作者
-- -----------------------------------------------------
drop table if exists `author`;
create table `author` (
  `id` int unsigned not null auto_increment comment 'UID,对应user表的uid',
  `create_time` int unsigned not null default 0 comment '创建时间',
  `join_time` int unsigned not null default 0 comment '加入时间',
  `status` tinyint not null default 0 comment '状态:-1-已删除;0-待审核;1-正常',
  `nickname` varchar(20) not null default '' comment '昵称',
  `realname` varchar(10) not null default '' comment '真实姓名',
  `brief` varchar(500) not null default '' comment '简介',
  primary key  (`id`)
) engine=innodb default charset=utf8 comment='作者';


-- -----------------------------------------------------
-- pics
-- 图片
-- -----------------------------------------------------
drop table if exists `pics`;
create table `pics` (
  `id` int unsigned not null auto_increment,
  `source_id` int(11) not null default 0 comment '原id',
  `type` int(11) not null default 0 comment '目标内容类型:1-文章,2-专辑,3-视频',
  `tid` int(11) not null default 0 comment '目标内容id',
  `path` varchar(200) not null default '' comment '图片地址',
  `md5` varchar(32) not null default '' comment '图片MD5',
  `size` varchar(32) not null default '' comment '图片文件大小',
  primary key (`id`),
  key `type` (`type`),
  key `tid` (`tid`)
) engine=innodb default charset=utf8 comment='图片表';


