create database if not exists `188fc` default charset utf8;
use `188fc`;
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
  `username` varchar(16) not null default '' comment '用户名',
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
  `username` varchar(16) not null comment '用户名',
  `regip` bigint unsigned not null default 0 comment '注册IP',
  `regtime` int unsigned not null default 0 comment '注册时间',
  `from_channel_id` int unsigned not null default 0 comment '用户来源渠道(广告渠道)ID',
  `wx_openid` varchar(28) not null default '' comment '微信公众平台OpenID',
  `wx_unionid` varchar(50) not null default '' comment '微信开放平台UnionID',
  `wx_unsubscribe` tinyint unsigned not null default 0 comment '微信取消关注',
  `nickname` varchar(16) not null default '' comment '昵称',
  `realname` varchar(16) not null default '' comment '用户真实姓名',
  `idcard` varchar(18) not null default '' comment '身份证号码',
  `qq` bigint unsigned not null default 0 comment '联系QQ',
  `email` varchar(45) not null default '' comment '电子邮箱',
  `mobile` bigint unsigned not null default 0 comment '手机',
  `exp` int unsigned not null default 0 comment '经验值',
  `point` int unsigned not null default 0 comment '积分',
  `honor` int unsigned not null default 0 comment '荣誉币',
  `coin` int unsigned not null default 0 comment '虚拟币',
  `gold` int unsigned not null default 0 comment '金币',
  `diamond` int unsigned not null default 0 comment '钻石',
  `emails_tatus` tinyint unsigned not null default 0 comment '电子邮件绑定状态',
  `mobile_status` tinyint unsigned not null default 0 comment '手机绑定状态',
  `secure_status` tinyint unsigned not null default 0 comment '安全密保状态',
  `type` tinyint unsigned not null default 0 comment '账号类型：1-系统管理员, 2-系统编辑, 10-版主, 11-普通会员',
  `is_agency` tinyint unsigned not null default 0 comment '是否中介:0-个人，1-中介，2-未鉴定',
  `cert` tinyint unsigned not null default 0 comment '认证情况',
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
  unique `wx_openid` (`wx_openid`),
  unique `wx_unionid` (`wx_unionid`),
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


-- -----------------------------------------------------
-- feedback
-- 反馈留言
-- -----------------------------------------------------
drop table if exists `feedback`;
create table `feedback` (
  `id` int unsigned not null auto_increment,
  `uid` int unsigned not null default 0 comment '登录用户ID，未登录用户，值为0',
  `ip` int unsigned not null default 0 comment '留言IP',
  `create_time` int unsigned not null default 0 comment '时间',
  `location` varchar(60) not null default '' comment '地点',
  `nickname` varchar(20) not null default '' comment '昵称',
  `email` varchar(60) not null default '' comment '联系邮箱',
  `content` varchar(255) not null default '' comment '内容',
  primary key  (`id`),
  index `idx_create_time` (`create_time`)
) engine=innodb default charset=utf8 comment = '反馈留言';


-- -----------------------------------------------------
-- house_sale
-- 出售信息
-- -----------------------------------------------------
drop table if exists `house_sale`;
create table `house_sale` (
  `id` int unsigned not null auto_increment,
  `uid` int unsigned not null default 0 comment '发布人UID',
  `loupan_id` int unsigned not null default 0 comment '小区/楼盘ID',
  `region_id` int unsigned not null default 0 comment '区域ID',
  `cid` tinyint unsigned not null default 0 comment '分类别ID：二手房、写字楼、商铺、新楼盘',
  `type` tinyint unsigned not null default 0 comment '类型',
  `area` mediumint unsigned not null default 0 comment '面积',
  `price` int unsigned not null default 0 comment '售价',
  `room` tinyint unsigned not null default 0 comment '室',
  `hall` tinyint unsigned not null default 0 comment '厅',
  `washroom` tinyint unsigned not null default 0 comment '卫',
  `balcony` tinyint unsigned not null default 0 comment '阳台',
  `floor` tinyint unsigned not null default 0 comment '所在楼层',
  `total_floor` tinyint unsigned not null default 0 comment '总楼层',
  `fitment` tinyint unsigned not null default 0 comment '装修情况',
  `property_year` tinyint unsigned not null default 0 comment '产权年限',
  `mobile` bigint not null default 0 comment '联系手机',
  `is_agency` tinyint not null default 0 comment '是否中介',
  `allow_agency` tinyint not null default 0 comment '是否允许中介联系',
  `can_register_corp` tinyint unsigned not null default 0 comment '是否可注册公司',
  `views` mediumint unsigned not null default 0 comment '浏览次数',
  `create_time` int unsigned not null default 0 comment '创建时间',
  `update_time` int unsigned not null default 0 comment '更新时间',
  `agencyname` varchar(20) not null default '' comment '中介名称',
  `loupan` varchar(32) not null default '' comment '小区/楼盘',
  `title` varchar(200) not null default '' comment '标题',
  `region` varchar(100) not null default '' comment '区域',
  `location` varchar(100) not null default '' comment '路段',
  `description` varchar(255) not null default '' comment '描述',
  `linkman` varchar(255) not null default '' comment '联系人',
  primary key (`id`),
  key `type` (`type`)
) engine=innodb default charset=utf8 comment='出售信息';


-- -----------------------------------------------------
-- house_rent
-- 出售信息
-- -----------------------------------------------------
drop table if exists `house_rent`;
create table `house_rent` (
  `id` int unsigned not null auto_increment,
  `uid` int unsigned not null default 0 comment '发布人UID',
  `loupan_id` int unsigned not null default 0 comment '小区/楼盘ID',
  `cid` tinyint unsigned not null default 0 comment '分类别ID：二手房、写字楼、商铺',
  `type` tinyint unsigned not null default 0 comment '类型',
  `area` mediumint unsigned not null default 0 comment '面积',
  `price` int unsigned not null default 0 comment '租金',
  `price_unit` tinyint unsigned not null default 0 comment '价格单位：1-元/月，2-元/㎡/天',
  `room` tinyint unsigned not null default 0 comment '室',
  `hall` tinyint unsigned not null default 0 comment '厅',
  `washroom` tinyint unsigned not null default 0 comment '卫',
  `balcony` tinyint unsigned not null default 0 comment '阳台',
  `floor` tinyint unsigned not null default 0 comment '所在楼层',
  `total_floor` tinyint unsigned not null default 0 comment '总楼层',
  `fitment` tinyint unsigned not null default 0 comment '装修情况',
  `property_type` tinyint unsigned not null default 0 comment '产权类型',
  `mobile` bigint not null default 0 comment '联系手机',
  `is_agency` tinyint not null default 0 comment '是否中介',
  `allow_agency` tinyint not null default 0 comment '是否允许中介联系',
  `can_register_corp` tinyint unsigned not null default 0 comment '是否可注册公司',
  `views` mediumint unsigned not null default 0 comment '浏览次数',
  `create_time` int unsigned not null default 0 comment '创建时间',
  `update_time` int unsigned not null default 0 comment '更新时间',
  `agencyname` varchar(20) not null default '' comment '中介名称',
  `loupan` varchar(32) not null default '' comment '小区/楼盘',
  `title` varchar(200) not null default '' comment '标题',
  `region` varchar(100) not null default '' comment '区域',
  `location` varchar(100) not null default '' comment '路段',
  `description` varchar(255) not null default '' comment '描述',
  `linkman` varchar(255) not null default '' comment '联系人',
  primary key (`id`),
  key `type` (`type`)
) engine=innodb default charset=utf8 comment='出租信息';


-- -----------------------------------------------------
-- house_buy
-- 求购信息
-- -----------------------------------------------------
drop table if exists `house_buy`;
create table `house_buy` (
  `id` int unsigned not null auto_increment,
  `uid` int unsigned not null default 0 comment '发布人UID',
  `region_id` int unsigned not null default 0 comment '区域ID',
  `cid` tinyint unsigned not null default 0 comment '分类别ID：二手房、写字楼、商铺、新楼盘',
  `type` tinyint unsigned not null default 0 comment '类型',
  `min_area` mediumint unsigned not null default 0 comment '最小面积',
  `max_area` mediumint unsigned not null default 0 comment '最大面积',
  `price` int unsigned not null default 0 comment '价格',
  `room` tinyint unsigned not null default 0 comment '室',
  `hall` tinyint unsigned not null default 0 comment '厅',
  `washroom` tinyint unsigned not null default 0 comment '卫',
  `balcony` tinyint unsigned not null default 0 comment '阳台',
  `mobile` bigint not null default 0 comment '联系手机',
  `is_agency` tinyint not null default 0 comment '是否中介',
  `allow_agency` tinyint not null default 0 comment '是否允许中介联系',
  `can_register_corp` tinyint unsigned not null default 0 comment '是否可注册公司',
  `views` mediumint unsigned not null default 0 comment '浏览次数',
  `create_time` int unsigned not null default 0 comment '创建时间',
  `update_time` int unsigned not null default 0 comment '更新时间',
  `agencyname` varchar(20) not null default '' comment '中介名称',
  `loupan` varchar(32) not null default '' comment '小区/楼盘',
  `title` varchar(200) not null default '' comment '标题',
  `region` varchar(100) not null default '' comment '区域',
  `location` varchar(100) not null default '' comment '路段',
  `description` varchar(255) not null default '' comment '描述',
  `linkman` varchar(255) not null default '' comment '联系人',
  primary key (`id`),
  key `type` (`type`)
) engine=innodb default charset=utf8 comment='出售信息';


-- -----------------------------------------------------
-- house_qz
-- 求租信息
-- -----------------------------------------------------
drop table if exists `house_qz`;
create table `house_qz` (
  `id` int unsigned not null auto_increment,
  `uid` int unsigned not null default 0 comment '发布人UID',
  `region_id` int unsigned not null default 0 comment '区域ID',
  `cid` tinyint unsigned not null default 0 comment '分类别ID：二手房、写字楼、商铺、新楼盘',
  `type` tinyint unsigned not null default 0 comment '类型',
  `min_area` mediumint unsigned not null default 0 comment '最小面积',
  `max_area` mediumint unsigned not null default 0 comment '最大面积',
  `price` int unsigned not null default 0 comment '租金',
  `price_unit` tinyint unsigned not null default 0 comment '价格单位：1-元/月，2-元/㎡/天',
  `room` tinyint unsigned not null default 0 comment '室',
  `hall` tinyint unsigned not null default 0 comment '厅',
  `washroom` tinyint unsigned not null default 0 comment '卫',
  `balcony` tinyint unsigned not null default 0 comment '阳台',
  `mobile` bigint not null default 0 comment '联系手机',
  `is_agency` tinyint not null default 0 comment '是否中介',
  `allow_agency` tinyint not null default 0 comment '是否允许中介联系',
  `can_register_corp` tinyint unsigned not null default 0 comment '是否可注册公司',
  `views` mediumint unsigned not null default 0 comment '浏览次数',
  `create_time` int unsigned not null default 0 comment '创建时间',
  `update_time` int unsigned not null default 0 comment '更新时间',
  `agencyname` varchar(20) not null default '' comment '中介名称',
  `loupan` varchar(32) not null default '' comment '小区/楼盘',
  `title` varchar(200) not null default '' comment '标题',
  `region` varchar(100) not null default '' comment '区域',
  `location` varchar(100) not null default '' comment '路段',
  `description` varchar(255) not null default '' comment '描述',
  `linkman` varchar(255) not null default '' comment '联系人',
  primary key (`id`),
  key `type` (`type`)
) engine=innodb default charset=utf8 comment='出售信息';


