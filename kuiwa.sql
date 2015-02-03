/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50538
Source Host           : 127.0.0.1:3306
Source Database       : kuiwa

Target Server Type    : MYSQL
Target Server Version : 50538
File Encoding         : 65001

Date: 2014-12-24 18:28:20
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `is_copy` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否转载：0-原创,1-转载',
  `views` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '浏览数(点击数)',
  `comments` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `post_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间(后台创建)',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态:-1-已删除;0-待审核;1-正常;2-隐藏;3-特殊',
  `orderid` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序ID',
  `cover_image_id` int(11) NOT NULL DEFAULT '0' COMMENT '封面图ID',
  `cover_image` varchar(100) NOT NULL DEFAULT '' COMMENT '封面图',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
  `tag_ids` varchar(100) NOT NULL DEFAULT '' COMMENT '关键字标签对应ID列表(逗号分隔)',
  `tags` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字标签(逗号分隔)',
  `editor` varchar(45) NOT NULL DEFAULT '' COMMENT '编辑',
  `author` varchar(45) NOT NULL DEFAULT '' COMMENT '作者',
  `redirect` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转的URL',
  `source` varchar(30) NOT NULL DEFAULT '' COMMENT '来源',
  `source_url` varchar(100) NOT NULL DEFAULT '' COMMENT '来源URL',
  PRIMARY KEY (`id`),
  KEY `idx_cid` (`cid`),
  KEY `idx_post_time` (`post_time`),
  KEY `idx_orderid` (`orderid`)
) ENGINE=InnoDB AUTO_INCREMENT=100008 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO article VALUES ('100007', '0', '0', '52', '1', '1418198708', '1418199014', '1', '0', '0', '', 'TI4西雅图DOTA2 TI4外卡赛 MVP vs VP 第2场', '', '', 'admin', '', '', '', '');

-- ----------------------------
-- Table structure for `article_content`
-- ----------------------------
DROP TABLE IF EXISTS `article_content`;
CREATE TABLE `article_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100008 DEFAULT CHARSET=utf8 COMMENT='文章内容表';

-- ----------------------------
-- Records of article_content
-- ----------------------------
INSERT INTO article_content VALUES ('100007', '<p>stesafsdf</p>');

-- ----------------------------
-- Table structure for `bbs_board`
-- ----------------------------
DROP TABLE IF EXISTS `bbs_board`;
CREATE TABLE `bbs_board` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `lvl` tinyint(4) NOT NULL DEFAULT '0' COMMENT '版块层级',
  `pid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '上级版块',
  `topic_num` smallint(6) NOT NULL DEFAULT '0' COMMENT '主题数',
  `post_num` mediumint(9) NOT NULL DEFAULT '0' COMMENT '帖子数',
  `view_num` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '浏览数',
  `post_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发帖时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态:-1-已删除;0-隐藏;1-启用;',
  `orderid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序ID',
  `name` varchar(150) NOT NULL DEFAULT '' COMMENT '版块名称',
  `managers` varchar(255) NOT NULL DEFAULT '' COMMENT '版主列表，","分隔的UID列表',
  `paths` varchar(255) NOT NULL DEFAULT '' COMMENT '上级版块信息',
  PRIMARY KEY (`id`),
  KEY `idx_post_time` (`post_time`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='论坛版块';

-- ----------------------------
-- Records of bbs_board
-- ----------------------------
INSERT INTO bbs_board VALUES ('1', '1', '0', '0', '0', '0', '0', '0', '0', '孕婴', '{\"2\":\"葵娃\"}', '[]');
INSERT INTO bbs_board VALUES ('2', '2', '1', '0', '0', '0', '0', '0', '0', '准备怀孕', '', '[[1, \"孕婴\"]]');
INSERT INTO bbs_board VALUES ('3', '2', '1', '0', '0', '0', '0', '0', '0', '孕期交流', '', '[[1, \"孕婴\"]]');
INSERT INTO bbs_board VALUES ('4', '2', '1', '0', '0', '0', '0', '0', '0', '婴儿护理', '', '[[1, \"孕婴\"]]');
INSERT INTO bbs_board VALUES ('5', '2', '1', '0', '0', '0', '0', '0', '0', '宝宝健康', '', '[[1, \"孕婴\"]]');
INSERT INTO bbs_board VALUES ('6', '2', '1', '0', '0', '0', '0', '0', '0', '母婴食谱', '', '[[1, \"孕婴\"]]');
INSERT INTO bbs_board VALUES ('7', '1', '0', '0', '0', '0', '0', '0', '0', '教育', '', '[]');
INSERT INTO bbs_board VALUES ('8', '2', '7', '0', '0', '0', '0', '0', '0', '亲子阅读', '', '[[7, \"教育\"]]');
INSERT INTO bbs_board VALUES ('9', '2', '7', '0', '0', '0', '0', '0', '0', '幼儿教育', '', '[[7, \"教育\"]]');
INSERT INTO bbs_board VALUES ('10', '2', '7', '0', '0', '0', '0', '0', '0', '资源分享', '', '[[7, \"教育\"]]');
INSERT INTO bbs_board VALUES ('11', '1', '0', '0', '0', '0', '0', '0', '0', '健康养生', '', '[]');
INSERT INTO bbs_board VALUES ('12', '2', '11', '0', '0', '0', '0', '0', '0', '女性健康', '', '[[11, \"健康养生\"]]');
INSERT INTO bbs_board VALUES ('13', '2', '11', '0', '0', '0', '0', '0', '0', '养生美食', '', '[[11, \"健康养生\"]]');
INSERT INTO bbs_board VALUES ('14', '2', '11', '0', '0', '0', '0', '0', '0', '养生保健', '', '[[11, \"健康养生\"]]');
INSERT INTO bbs_board VALUES ('15', '1', '0', '0', '0', '0', '0', '0', '0', '公共交流', '', '[]');
INSERT INTO bbs_board VALUES ('16', '2', '15', '0', '0', '0', '0', '0', '0', '家有乐宝', '', '[[15, \"公共交流\"]]');
INSERT INTO bbs_board VALUES ('17', '2', '15', '0', '0', '0', '0', '0', '0', '闲聊茶馆', '', '[[15, \"公共交流\"]]');
INSERT INTO bbs_board VALUES ('18', '2', '15', '0', '0', '0', '0', '0', '0', '美图分享', '', '[[15, \"公共交流\"]]');
INSERT INTO bbs_board VALUES ('19', '2', '15', '0', '0', '0', '0', '0', '0', '母婴闲置', '', '[[15, \"公共交流\"]]');
INSERT INTO bbs_board VALUES ('20', '1', '0', '0', '0', '0', '0', '0', '0', '站务', '', '[]');
INSERT INTO bbs_board VALUES ('21', '2', '20', '0', '0', '0', '0', '0', '0', '公告区', '', '[[20, \"站务\"]]');
INSERT INTO bbs_board VALUES ('22', '2', '20', '0', '0', '0', '0', '0', '0', '建议、反馈', '', '[[20, \"站务\"]]');
INSERT INTO bbs_board VALUES ('23', '2', '20', '0', '0', '0', '0', '0', '0', '举报、投诉', '', '[[20, \"站务\"]]');
INSERT INTO bbs_board VALUES ('24', '2', '20', '0', '0', '0', '0', '0', '0', '版主专区', '', '[[20, \"站务\"]]');

-- ----------------------------
-- Table structure for `bbs_board_date_data`
-- ----------------------------
DROP TABLE IF EXISTS `bbs_board_date_data`;
CREATE TABLE `bbs_board_date_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `board_id` mediumint(9) NOT NULL DEFAULT '0' COMMENT '版块ID',
  `date` int(11) NOT NULL DEFAULT '0' COMMENT '日期:20140414',
  `topic_num` smallint(6) NOT NULL DEFAULT '0' COMMENT '主题数',
  `post_num` smallint(6) NOT NULL DEFAULT '0' COMMENT '帖子数',
  `view_num` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '浏览数',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_board_id_date` (`board_id`,`date`),
  KEY `idx_topic_num` (`topic_num`),
  KEY `idx_post_num` (`post_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='论坛版块日期数据';

-- ----------------------------
-- Records of bbs_board_date_data
-- ----------------------------

-- ----------------------------
-- Table structure for `bbs_posts`
-- ----------------------------
DROP TABLE IF EXISTS `bbs_posts`;
CREATE TABLE `bbs_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `board_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '版块ID',
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '主题帖ID',
  `views` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '浏览数(点击数)',
  `posts` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '回帖数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发帖时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态:-1-已删除;0-待审核;1-正常;',
  `position` smallint(6) NOT NULL DEFAULT '0' COMMENT '帖子位置',
  PRIMARY KEY (`id`),
  KEY `idx_topic_id` (`topic_id`),
  KEY `idx_position` (`position`),
  KEY `idx_create_time` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='论坛帖子';

-- ----------------------------
-- Records of bbs_posts
-- ----------------------------

-- ----------------------------
-- Table structure for `bbs_post_content`
-- ----------------------------
DROP TABLE IF EXISTS `bbs_post_content`;
CREATE TABLE `bbs_post_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` mediumtext NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='论坛帖子内容';

-- ----------------------------
-- Records of bbs_post_content
-- ----------------------------

-- ----------------------------
-- Table structure for `bbs_topic`
-- ----------------------------
DROP TABLE IF EXISTS `bbs_topic`;
CREATE TABLE `bbs_topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `board_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '版块ID',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '发帖会员ID',
  `is_copy` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否转载：0-原创,1-转载',
  `view_num` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '浏览数',
  `post_num` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '回帖数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发帖时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态:-1-已删除;0-待审核;1-正常;',
  `last_post_time` tinyint(4) NOT NULL DEFAULT '0' COMMENT '最后发表时间',
  `last_post_uid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '最后发表UID',
  `last_post_user` tinyint(4) NOT NULL DEFAULT '0' COMMENT '最后发表用户昵称',
  `title` varchar(120) NOT NULL DEFAULT '' COMMENT '标题',
  `nickname` varchar(16) NOT NULL DEFAULT '' COMMENT '发帖会员昵称',
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`),
  KEY `idx_board_id` (`board_id`),
  KEY `idx_create_time` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='论坛主题帖';

-- ----------------------------
-- Records of bbs_topic
-- ----------------------------

-- ----------------------------
-- Table structure for `category`
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '分类层级',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型:1-文章,2-帖子',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '名称',
  `path` varchar(100) NOT NULL DEFAULT '' COMMENT '分类层级路径信息',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO category VALUES ('1', '0', '1', '1', '公告', '/1');
INSERT INTO category VALUES ('2', '0', '1', '1', 'FAQ', '/2');
INSERT INTO category VALUES ('3', '0', '1', '1', '备孕期', '/3');
INSERT INTO category VALUES ('4', '0', '1', '1', '孕产期', '/4');
INSERT INTO category VALUES ('5', '0', '1', '1', '分娩期', '/5');
INSERT INTO category VALUES ('6', '0', '1', '1', '婴儿期', '/6');
INSERT INTO category VALUES ('7', '0', '1', '1', '幼儿期', '/7');
INSERT INTO category VALUES ('8', '0', '1', '1', '母婴食谱', '/8');
INSERT INTO category VALUES ('9', '0', '1', '1', '养生美食', '/9');
INSERT INTO category VALUES ('10', '0', '1', '1', '亲子教育', '/10');
INSERT INTO category VALUES ('11', '0', '1', '1', '故事堂', '/11');
INSERT INTO category VALUES ('101', '0', '1', '2', '经验', '/101');
INSERT INTO category VALUES ('102', '0', '1', '2', '求助', '/102');
INSERT INTO category VALUES ('103', '0', '1', '2', '讨论', '/103');

-- ----------------------------
-- Table structure for `files`
-- ----------------------------
DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '文件类型：1-图片',
  `path` varchar(200) NOT NULL DEFAULT '' COMMENT '图片地址',
  `md5` varchar(32) NOT NULL DEFAULT '' COMMENT '图片MD5',
  `size` varchar(32) NOT NULL DEFAULT '' COMMENT '图片文件大小',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文件表';

-- ----------------------------
-- Records of files
-- ----------------------------
INSERT INTO files VALUES ('1', '1', 'images/2014/1224/5469549a94b7858c1932.jpg', '1137dc58ac9972a931693de3dccd107d', '80652');

-- ----------------------------
-- Table structure for `fragment_data`
-- ----------------------------
DROP TABLE IF EXISTS `fragment_data`;
CREATE TABLE `fragment_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sign` varchar(60) NOT NULL DEFAULT '' COMMENT '配置项标志',
  `content` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_sign` (`sign`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='片段数据';

-- ----------------------------
-- Records of fragment_data
-- ----------------------------
INSERT INTO fragment_data VALUES ('1', 'carousel', '');
INSERT INTO fragment_data VALUES ('2', 'aboutus', '<p>本站提供基于互联网技术的服务。主要范围：微信接口功能定制开发、中高端网站功能定制开发、特殊应用系统开发。如：淘宝刷单系统定制、行业网站开发等</p>');
INSERT INTO fragment_data VALUES ('3', 'links', '[{\"title\":\"閑逸寒舍\",\"url\":\"http://59c.net\"},{\"title\":\"YAF\",\"url\":\"http://php.net/manual/en/book.yaf.php\"}]');
INSERT INTO fragment_data VALUES ('4', 'indexNews', '[]');

-- ----------------------------
-- Table structure for `medal`
-- ----------------------------
DROP TABLE IF EXISTS `medal`;
CREATE TABLE `medal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL DEFAULT '' COMMENT '勋章名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='勋章列表';

-- ----------------------------
-- Records of medal
-- ----------------------------

-- ----------------------------
-- Table structure for `tags`
-- ----------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT 'TAG名称',
  `num` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '使用该TAG的内容数',
  `hot` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否热门标签',
  PRIMARY KEY (`id`),
  KEY `idx_hot_num` (`hot`,`num`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TAG标签表';

-- ----------------------------
-- Records of tags
-- ----------------------------

-- ----------------------------
-- Table structure for `tag_data`
-- ----------------------------
DROP TABLE IF EXISTS `tag_data`;
CREATE TABLE `tag_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `target_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '标签对应内容类型:1-文章,2-BBS',
  `target_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '标签对应内容ID',
  `tagid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '标签ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_target_type_targetid_tagid` (`target_type`,`target_id`,`tagid`),
  KEY `idx_target_id` (`target_id`),
  KEY `idx_tagid` (`tagid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TAG标签表';

-- ----------------------------
-- Records of tag_data
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(10) NOT NULL COMMENT '用户名',
  `regip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '注册IP',
  `regtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `from_channel_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户来源渠道(广告渠道)ID',
  `nickname` varchar(16) NOT NULL DEFAULT '' COMMENT '昵称',
  `realname` varchar(16) NOT NULL DEFAULT '' COMMENT '用户真实姓名',
  `idcard` varchar(18) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `qq` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '联系QQ',
  `email` varchar(45) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机',
  `exp` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '经验值',
  `point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `coin` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '虚拟币',
  `gold` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '金币',
  `emails_tatus` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '电子邮件绑定状态',
  `mobile_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '手机绑定状态',
  `secure_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '安全密保状态',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '账号类型：1-系统管理员, 2-系统编辑, 10-版主, 11-普通会员',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '账号状态:-1-逻辑删除,0-未激活,1-正常,2-冻结(网站管理员操作),3-锁定(玩家自己操作)',
  `gender` tinyint(3) unsigned NOT NULL DEFAULT '2' COMMENT '性别',
  `birth_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '出生日期时间戳',
  `province` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '省级行政区号',
  `city` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '市',
  `county` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '县/区',
  `town` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '乡镇',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '详细的联系地址',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`),
  KEY `regip` (`regip`),
  KEY `regtime` (`regtime`),
  KEY `from_channel_id` (`from_channel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO user VALUES ('1', 'admin', '167772674', '1393490730', '1', '管理员', '管理员', '350101198001011212', '0', 'admin@kuiwa.cn', '15312345678', '10000', '10000', '10000', '10000', '1', '1', '1', '1', '1', '2', '315504000', '350000', '350100', '350102', '16777215', '');

-- ----------------------------
-- Table structure for `user_from_channel`
-- ----------------------------
DROP TABLE IF EXISTS `user_from_channel`;
CREATE TABLE `user_from_channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL DEFAULT '' COMMENT '渠道名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8 COMMENT='用户来源渠道';

-- ----------------------------
-- Records of user_from_channel
-- ----------------------------
INSERT INTO user_from_channel VALUES ('1', '直接用户');
INSERT INTO user_from_channel VALUES ('2', 'QQ群');
INSERT INTO user_from_channel VALUES ('3', '推广链接');
INSERT INTO user_from_channel VALUES ('4', '其他社区');
INSERT INTO user_from_channel VALUES ('5', '其他网站链接');
INSERT INTO user_from_channel VALUES ('11', '百度');
INSERT INTO user_from_channel VALUES ('12', 'Google');
INSERT INTO user_from_channel VALUES ('13', '360');
INSERT INTO user_from_channel VALUES ('14', '搜搜');
INSERT INTO user_from_channel VALUES ('15', '搜狗');
INSERT INTO user_from_channel VALUES ('101', '内部账号');
INSERT INTO user_from_channel VALUES ('102', '营销账号');

-- ----------------------------
-- Table structure for `user_login`
-- ----------------------------
DROP TABLE IF EXISTS `user_login`;
CREATE TABLE `user_login` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `last_login_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `username` varchar(10) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` varchar(8) NOT NULL DEFAULT '' COMMENT '私钥',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户登录表';

-- ----------------------------
-- Records of user_login
-- ----------------------------
INSERT INTO user_login VALUES ('1', '100', '1417687237', 'admin', '3589cb482592b7894bf4e6976a941647', '65kCMpyS');

-- ----------------------------
-- Table structure for `user_medal`
-- ----------------------------
DROP TABLE IF EXISTS `user_medal`;
CREATE TABLE `user_medal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '勋章ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_uid_mid` (`uid`,`mid`),
  KEY `idx_mid` (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户勋章列表';

-- ----------------------------
-- Records of user_medal
-- ----------------------------

-- ----------------------------
-- Table structure for `xzqh`
-- ----------------------------
DROP TABLE IF EXISTS `xzqh`;
CREATE TABLE `xzqh` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '行政区划代码',
  `higher_code` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '上一级行政区划代码',
  `lvl` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '级别：1-省级，2-地市级，3-县区级，4-镇/街道，5-村/居委会',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '城乡分类代码：1-省级，2-地市级，3-县区级，4-镇/街道，5-村/居委会',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '行政区名',
  PRIMARY KEY (`id`),
  KEY `idx_code` (`code`),
  KEY `idx_higher_code` (`higher_code`),
  KEY `idx_lvl` (`lvl`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='行政区划表';

-- ----------------------------
-- Records of xzqh
-- ----------------------------
