/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50538
Source Host           : 127.0.0.1:3306
Source Database       : binchi

Target Server Type    : MYSQL
Target Server Version : 50538
File Encoding         : 65001

Date: 2015-01-14 14:28:42
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`),
  KEY `idx_post_time` (`post_time`),
  KEY `idx_orderid` (`orderid`),
  KEY `idx_views` (`views`),
  KEY `idx_comments` (`comments`)
) ENGINE=InnoDB AUTO_INCREMENT=100001 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of article
-- ----------------------------

-- ----------------------------
-- Table structure for `article_content`
-- ----------------------------
DROP TABLE IF EXISTS `article_content`;
CREATE TABLE `article_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章内容表';

-- ----------------------------
-- Records of article_content
-- ----------------------------

-- ----------------------------
-- Table structure for `files`
-- ----------------------------
DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '文件类型：1-图片',
  `path` varchar(200) NOT NULL DEFAULT '' COMMENT '图片路径',
  `md5` varchar(32) NOT NULL DEFAULT '' COMMENT '图片MD5',
  `size` varchar(32) NOT NULL DEFAULT '' COMMENT '图片文件大小',
  `outside_link` varchar(255) NOT NULL DEFAULT '' COMMENT '对应外链地址,如:图床、网盘等',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文件表';

-- ----------------------------
-- Records of files
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='片段数据';

-- ----------------------------
-- Records of fragment_data
-- ----------------------------
INSERT INTO fragment_data VALUES ('1', 'carousel', '');
INSERT INTO fragment_data VALUES ('2', 'aboutus', '<p>本站提供基于互联网技术的服务。主要范围：微信接口功能定制开发、中高端网站功能定制开发、特殊应用系统开发。如：淘宝刷单系统定制、行业网站开发等</p>');
INSERT INTO fragment_data VALUES ('3', 'links', '[{\"title\":\"閑逸寒舍\",\"url\":\"http://59c.net\"},{\"title\":\"YAF\",\"url\":\"http://php.net/manual/en/book.yaf.php\"}]');
INSERT INTO fragment_data VALUES ('4', 'indexNews', '[]');
INSERT INTO fragment_data VALUES ('5', 'binchi_winxin_menu', '{\r\n    \"button\": [\r\n        {\r\n            \"name\": \"了解我们\",\r\n            \"sub_button\": [\r\n                {\r\n                    \"type\": \"view\",\r\n                    \"name\": \"产品中心\",\r\n                    \"url\": \"http://binchi.net\",\r\n                    \"sub_button\": []\r\n                },\r\n                {\r\n                    \"type\": \"view\",\r\n                    \"name\": \"成功案例\",\r\n                    \"url\": \"http://binchi.net\",\r\n                    \"sub_button\": []\r\n                },\r\n                {\r\n                    \"type\": \"view\",\r\n                    \"name\": \"关于我们\",\r\n                    \"url\": \"http://binchi.net\",\r\n                    \"sub_button\": []\r\n                }\r\n            ]\r\n        },\r\n        {\r\n            \"name\": \"客服中心\",\r\n            \"sub_button\": [\r\n                {\r\n                    \"type\": \"view\",\r\n                    \"name\": \"联系我们\",\r\n                    \"url\": \"http://binchi.net\",\r\n                    \"sub_button\": []\r\n                },\r\n                {\r\n                    \"type\": \"view\",\r\n                    \"name\": \"定制开发\",\r\n                    \"url\": \"http://binchi.net\",\r\n                    \"sub_button\": []\r\n                }\r\n            ]\r\n        }\r\n    ]\r\n}');
INSERT INTO fragment_data VALUES ('6', 'fc188_com_winxin_menu', '{\r\n    \"button\": [\r\n        {\r\n            \"name\": \"房源中心\",\r\n            \"sub_button\": [\r\n                {\r\n                    \"type\": \"view\",\r\n                    \"name\": \"二手房\",\r\n                    \"url\": \"http://188fc.binchi.net/weixin/esf\",\r\n                    \"sub_button\": []\r\n                },\r\n                {\r\n                    \"type\": \"view\",\r\n                    \"name\": \"出租房\",\r\n                    \"url\": \"http://188fc.binchi.net/weixin/rent\",\r\n                    \"sub_button\": []\r\n                },\r\n                {\r\n                    \"type\": \"view\",\r\n                    \"name\": \"中介合作\",\r\n                    \"url\": \"http://188fc.binchi.net/weixin/agentCooperation\",\r\n                    \"sub_button\": []\r\n                }\r\n            ]\r\n        },\r\n        {\r\n            \"name\": \"客服中心\",\r\n            \"sub_button\": [\r\n                {\r\n                    \"type\": \"view\",\r\n                    \"name\": \"我要买房\",\r\n                    \"url\": \"http://188fc.binchi.net/weixin/buy\",\r\n                    \"sub_button\": []\r\n                },\r\n                {\r\n                    \"type\": \"view\",\r\n                    \"name\": \"我要租房\",\r\n                    \"url\": \"http://188fc.binchi.net/weixin/qz\",\r\n                    \"sub_button\": []\r\n                },\r\n                {\r\n                    \"type\": \"view\",\r\n                    \"name\": \"留言\",\r\n                    \"url\": \"http://188fc.binchi.net/weixin/leavemessage\",\r\n                    \"sub_button\": []\r\n                }\r\n            ]\r\n        }\r\n    ]\r\n}');

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
  `target_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '标签对应内容类型:1-视频,2-专辑,3-文章',
  `target_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '标签对应内容ID',
  `tagid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '标签ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_target_type_targetid_tagid` (`target_type`,`target_id`,`tagid`),
  KEY `idx_target_type` (`target_type`),
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
  `mobile` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '手机',
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
INSERT INTO user VALUES ('1', 'admin', '2130706433', '1421117041', '99', 'admin', 'admin', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '0', '0', '');

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
INSERT INTO user_from_channel VALUES ('99', '后台添加');
INSERT INTO user_from_channel VALUES ('101', '内部账号');
INSERT INTO user_from_channel VALUES ('102', '营销账号');

-- ----------------------------
-- Table structure for `user_login`
-- ----------------------------
DROP TABLE IF EXISTS `user_login`;
CREATE TABLE `user_login` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '账号类型：1-系统管理员, 2-系统编辑, 10-版主, 11-普通会员',
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
INSERT INTO user_login VALUES ('1', '1', '100', '1421117199', 'admin', '6c9e4964bdd7fa68d2f0ee88a7aa89dd', 'tU4q3SV8');

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
  `higher_code` bigint(10) unsigned NOT NULL DEFAULT '0' COMMENT '上一级行政区划代码',
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
