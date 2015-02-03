/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50538
Source Host           : localhost:3306
Source Database       : 806677

Target Server Type    : MYSQL
Target Server Version : 50538
File Encoding         : 65001

Date: 2014-09-23 00:11:51
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `album`
-- ----------------------------
DROP TABLE IF EXISTS `album`;
CREATE TABLE `album` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sign` varchar(50) NOT NULL DEFAULT '0' COMMENT '专辑标志符,用于生成缓存目录等',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '专辑标题',
  `cover_image_id` int(11) NOT NULL DEFAULT '0' COMMENT '视频封面图ID',
  `cover_image` varchar(100) NOT NULL DEFAULT '' COMMENT '视频封面图',
  `tag_ids` varchar(100) NOT NULL DEFAULT '' COMMENT '关键字标签对应ID列表(逗号分隔)',
  `tags` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字标签(逗号分隔)',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '视频评分',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '查看数(专题所有视频被查看数)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态:-1-已删除;0-待审核;1-正常',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '专辑简介',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='专辑';

-- ----------------------------
-- Records of album
-- ----------------------------
INSERT INTO album VALUES ('4', 'ti4', 'TI4', '4', '/attachment/images/2014/0917/95225418f55be87dd887.jpg', '2,1', 'ti4,dota2', '60', '98', '1', '1410922102', 'DOTA2国际邀请赛，简称Ti，创立于2011年，是一个全球性的电子竞技赛事，ValveCorporation（V社）主办。\r\n每年一次在美国西雅图（除Ti1在德国科隆）举行DOTA2最大规模和最高奖金额度的国际性高水准比赛。<br />\r\n截止TI4，DOTA2奖金额度已高达千万美元。');

-- ----------------------------
-- Table structure for `album_videos`
-- ----------------------------
DROP TABLE IF EXISTS `album_videos`;
CREATE TABLE `album_videos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `a_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '专辑ID',
  `v_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '视频ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `a_id_v_id` (`a_id`,`v_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='专辑包含的视频';

-- ----------------------------
-- Records of album_videos
-- ----------------------------
INSERT INTO album_videos VALUES ('1', '4', '2');
INSERT INTO album_videos VALUES ('3', '4', '3');
INSERT INTO album_videos VALUES ('4', '4', '4');
INSERT INTO album_videos VALUES ('5', '4', '5');
INSERT INTO album_videos VALUES ('6', '4', '6');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO article VALUES ('1', '0', '0', '0', '0', '0', '0', '0', '', '234sdfasdf', '', '', '', '', '');

-- ----------------------------
-- Table structure for `article_content`
-- ----------------------------
DROP TABLE IF EXISTS `article_content`;
CREATE TABLE `article_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章内容表';

-- ----------------------------
-- Records of article_content
-- ----------------------------
INSERT INTO article_content VALUES ('1', 'sdfasdfas');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='片段数据';

-- ----------------------------
-- Records of fragment_data
-- ----------------------------
INSERT INTO fragment_data VALUES ('1', 'carousel', '');
INSERT INTO fragment_data VALUES ('2', 'aboutus', '');
INSERT INTO fragment_data VALUES ('3', 'indexaboutus', '');
INSERT INTO fragment_data VALUES ('4', 'indexFocus', '[{\"title\":\"TI4比赛回顾\",\"url\":\"\\/ti4\",\"cover_image_id\":22,\"cover_image\":\"\\/attachment\\/images\\/2014\\/0919\\/2991541be2c6490aa767.jpg\",\"create_time\":1411315200,\"brief\":\"DOTA2国际邀请赛，简称Ti，创立于2011年，是一个全球性的电子竞技赛事，ValveCorporation（V社）主办。\\r\\n 每年一次在美国西雅图（除Ti1在德国科隆）举行DOTA2最大规模和最高奖金额度的国际性高水准比赛。<br \\/>\\r\\n截止TI4，DOTA2奖金额度已高达千万美元。\"},{\"title\":\"TI3\",\"url\":\"\\/ti3\",\"cover_image_id\":27,\"cover_image\":\"\\/attachment\\/images\\/2014\\/0919\\/6754541bf6b0a4e87134.jpg\",\"create_time\":1411315200},{\"title\":\"TI2\",\"url\":\"\\/ti2\",\"cover_image_id\":22,\"cover_image\":\"\\/attachment\\/images\\/2014\\/0919\\/2991541be2c6490aa767.jpg\",\"create_time\":1411315200},{\"title\":\"WCG2012\",\"url\":\"wcg2012\",\"cover_image_id\":22,\"cover_image\":\"\\/attachment\\/images\\/2014\\/0919\\/2991541be2c6490aa767.jpg\",\"create_time\":1411315200},{\"title\":\"TI1\",\"url\":\"\\/ti1\",\"cover_image_id\":22,\"cover_image\":\"\\/attachment\\/images\\/2014\\/0919\\/2991541be2c6490aa767.jpg\",\"create_time\":1411315200}]');
INSERT INTO fragment_data VALUES ('5', 'indexNews', '[{\"title\":\"老党DOTA2第一视角:刃甲战斗先知\",\"url\":\"http:\\/\\/dota2.uuu9.com\\/201409\\/477044.shtml\"},{\"title\":\"Ks单排冲分实录:火猫\\/人马\\/骷髅王\",\"url\":\"http:\\/\\/dota2.uuu9.com\\/201409\\/477283.shtml\"},{\"title\":\"凯文DO2第一视角:暴力输出者剑圣\",\"url\":\"http:\\/\\/dota2.uuu9.com\\/201409\\/476709.shtml\"}]');

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
-- Table structure for `pics`
-- ----------------------------
DROP TABLE IF EXISTS `pics`;
CREATE TABLE `pics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '目标内容类型:1-视频,2-专辑,3-文章',
  `tid` int(11) NOT NULL DEFAULT '0' COMMENT '目标内容id',
  `path` varchar(200) NOT NULL DEFAULT '' COMMENT '图片地址',
  `md5` varchar(32) NOT NULL DEFAULT '' COMMENT '图片MD5',
  `size` varchar(32) NOT NULL DEFAULT '' COMMENT '图片文件大小',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `tid` (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='图片表';

-- ----------------------------
-- Records of pics
-- ----------------------------
INSERT INTO pics VALUES ('3', '3', '2', '/attachment/images/2014/0917/80655418f005c4eb1556.jpg', '', '');
INSERT INTO pics VALUES ('4', '2', '4', '/attachment/images/2014/0917/95225418f55be87dd887.jpg', '', '');
INSERT INTO pics VALUES ('5', '3', '6', '/attachment/images/2014/0917/366554192c6d597d9564.jpg', '', '');
INSERT INTO pics VALUES ('6', '3', '0', '/attachment/images/2014/0918/2441541a3bfe3ba29698.jpg', '', '');
INSERT INTO pics VALUES ('7', '3', '0', '/attachment/images/2014/0918/1842541a3c1d2cff234.png', '', '');
INSERT INTO pics VALUES ('8', '3', '0', '/attachment/images/2014/0918/9955541a3c3ff310d329.png', '', '');
INSERT INTO pics VALUES ('9', '3', '0', '/attachment/images/2014/0918/0532541a3c4b0d031479.png', '', '');
INSERT INTO pics VALUES ('10', '3', '0', '/attachment/images/2014/0918/7011541a3c7dab2e3616.png', '', '');
INSERT INTO pics VALUES ('11', '3', '0', '/attachment/images/2014/0918/741541a3c80b4f12648.jpg', '', '');
INSERT INTO pics VALUES ('12', '3', '0', '/attachment/images/2014/0918/7977541a3c84c2c76467.jpg', '', '');
INSERT INTO pics VALUES ('13', '3', '0', '/attachment/images/2014/0918/5121541a3c887d0c9784.jpg', '', '');
INSERT INTO pics VALUES ('14', '3', '0', '/attachment/images/2014/0918/7486541a42ebb6c9b700.png', '', '');
INSERT INTO pics VALUES ('19', '3', '0', '/attachment/images/2014/0919/2546541bde593e30c668.jpg', '3c963d6d50189a4ee0e353fecc99611e', '142191');
INSERT INTO pics VALUES ('20', '3', '0', '/attachment/images/2014/0919/1412541bdeca227ef908.jpg', 'e2a50885df0a33905a292715a7c98844', '5911');
INSERT INTO pics VALUES ('21', '3', '0', '/attachment/images/2014/0919/6461541be17c9dc12482.jpg', 'a0688b1f0c1d5b43954d752bd516f304', '5911');
INSERT INTO pics VALUES ('22', '3', '0', '/attachment/images/2014/0919/2991541be2c6490aa767.jpg', 'fd0c9ecaa6c3f92653eefa55cafb5ece', '24991');
INSERT INTO pics VALUES ('26', '3', '0', '/attachment/images/2014/0919/3119541bf6344c289261.jpg', '64cf9ac99c8db28046e6f1d6b9e87844', '5911');
INSERT INTO pics VALUES ('27', '3', '0', '/attachment/images/2014/0919/6754541bf6b0a4e87134.jpg', 'b8eacaefffe58ce8a7452b3cee3467e6', '10840');

-- ----------------------------
-- Table structure for `player`
-- ----------------------------
DROP TABLE IF EXISTS `player`;
CREATE TABLE `player` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `play_id` varchar(100) NOT NULL DEFAULT '' COMMENT '游戏ID',
  `realname` varchar(100) NOT NULL DEFAULT '' COMMENT '真实姓名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='战队';

-- ----------------------------
-- Records of player
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='TAG标签表';

-- ----------------------------
-- Records of tags
-- ----------------------------
INSERT INTO tags VALUES ('1', 'ti4', '1', '0');
INSERT INTO tags VALUES ('2', 'dota2', '1', '0');

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
  KEY `idx_target_id` (`target_id`),
  KEY `idx_tagid` (`tagid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='TAG标签表';

-- ----------------------------
-- Records of tag_data
-- ----------------------------
INSERT INTO tag_data VALUES ('2', '3', '2', '1');
INSERT INTO tag_data VALUES ('1', '3', '2', '2');

-- ----------------------------
-- Table structure for `teams`
-- ----------------------------
DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '战队名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='战队';

-- ----------------------------
-- Records of teams
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
INSERT INTO user_login VALUES ('1', '100', '1392364872', 'admin', '0af7f3f3127efeefd9611bcf2c309b21', '7E3#g9,c');

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
-- Table structure for `video`
-- ----------------------------
DROP TABLE IF EXISTS `video`;
CREATE TABLE `video` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '来源视频站对应ID',
  `views` int(11) NOT NULL DEFAULT '0' COMMENT '视频浏览量',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '视频评分',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `definition` smallint(6) NOT NULL DEFAULT '1' COMMENT '视频清晰度：2-标清，4-高清，8-超清',
  `play_style` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '播放方式:1嵌入代码，2-跳转到播放页',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `author_uid` int(11) NOT NULL DEFAULT '0' COMMENT '视频作者UID',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '视频标题',
  `author` varchar(20) NOT NULL DEFAULT '' COMMENT '视频作者',
  `tag_ids` varchar(100) NOT NULL DEFAULT '' COMMENT '关键字标签对应ID列表(逗号分隔)',
  `tags` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字标签(逗号分隔)',
  `cover_image_id` int(11) NOT NULL DEFAULT '0' COMMENT '视频封面图ID',
  `cover_image` varchar(100) NOT NULL DEFAULT '' COMMENT '视频封面图',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '视频源播放页地址，跳转到页面时使用',
  `code` varchar(300) NOT NULL DEFAULT '' COMMENT '视频播放器代码',
  `summary` varchar(255) NOT NULL DEFAULT '' COMMENT '视频摘要',
  PRIMARY KEY (`id`),
  KEY `idx_create_time` (`create_time`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='视频';

-- ----------------------------
-- Records of video
-- ----------------------------
INSERT INTO video VALUES ('2', '1', '85', '60', '1', '8', '1', '1410723270', '0', 'Ti4开幕式', '', '2,1', 'ti4,dota2', '3', '/attachment/images/2014/0917/80655418f005c4eb1556.jpg', 'http://v.youku.com/v_show/id_XNzQyNzMzOTQ0.html?f=22513416', '<embed src=\"http://player.youku.com/player.php/Type/Folder/Fid/22513416/Ob/1/sid/XNzQyNzMzOTQ0/v.swf\" quality=\"high\" width=\"480\" height=\"400\" align=\"middle\" allowScriptAccess=\"always\" allowFullScreen=\"true\" mode=\"transparent\" type=\"application/x-shockwave-flash\"></embed>', '');
INSERT INTO video VALUES ('3', '1', '96', '60', '1', '8', '1', '1410835948', '0', 'dk vs vg', '', '2,1', 'ti4,dota2', '5', '/attachment/images/2014/0917/366554192c6d597d9564.jpg', 'http://v.youku.com/v_show/id_XNzQyNzMzOTQ0.html?f=22513416', '<embed src=\"http://player.youku.com/player.php/Type/Folder/Fid/22513416/Ob/1/sid/XNzQyNzMzOTQ0/v.swf\" quality=\"high\" width=\"480\" height=\"400\" align=\"middle\" allowScriptAccess=\"always\" allowFullScreen=\"true\" mode=\"transparent\" type=\"application/x-shockwave-flash\"></embed>', '');
INSERT INTO video VALUES ('4', '1', '96', '60', '1', '8', '1', '1410935254', '0', 'dk vs vg', '', '2,1', 'ti4,dota2', '5', '/attachment/images/2014/0917/366554192c6d597d9564.jpg', 'http://v.youku.com/v_show/id_XNzQyNzMzOTQ0.html?f=22513416', '<embed src=\"http://player.youku.com/player.php/Type/Folder/Fid/22513416/Ob/1/sid/XNzQyNzMzOTQ0/v.swf\" quality=\"high\" width=\"480\" height=\"400\" align=\"middle\" allowScriptAccess=\"always\" allowFullScreen=\"true\" mode=\"transparent\" type=\"application/x-shockwave-flash\"></embed>', '');
INSERT INTO video VALUES ('5', '1', '96', '60', '1', '8', '1', '1410935606', '0', 'dk vs vg', '', '2,1', 'ti4,dota2', '5', '/attachment/images/2014/0917/366554192c6d597d9564.jpg', 'http://v.youku.com/v_show/id_XNzQyNzMzOTQ0.html?f=22513416', '<embed src=\"http://player.youku.com/player.php/Type/Folder/Fid/22513416/Ob/1/sid/XNzQyNzMzOTQ0/v.swf\" quality=\"high\" width=\"480\" height=\"400\" align=\"middle\" allowScriptAccess=\"always\" allowFullScreen=\"true\" mode=\"transparent\" type=\"application/x-shockwave-flash\"></embed>', '');
INSERT INTO video VALUES ('6', '1', '96', '60', '1', '8', '1', '1410936020', '0', 'dk vs vg', '', '2,1', 'ti4,dota2', '5', '/attachment/images/2014/0917/366554192c6d597d9564.jpg', 'http://v.youku.com/v_show/id_XNzQyNzMzOTQ0.html?f=22513416', '<embed src=\"http://player.youku.com/player.php/Type/Folder/Fid/22513416/Ob/1/sid/XNzQyNzMzOTQ0/v.swf\" quality=\"high\" width=\"480\" height=\"400\" align=\"middle\" allowScriptAccess=\"always\" allowFullScreen=\"true\" mode=\"transparent\" type=\"application/x-shockwave-flash\"></embed>', '');

-- ----------------------------
-- Table structure for `video_site`
-- ----------------------------
DROP TABLE IF EXISTS `video_site`;
CREATE TABLE `video_site` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '视频站名称',
  `domain` varchar(100) NOT NULL DEFAULT '' COMMENT '网站域名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='视频站';

-- ----------------------------
-- Records of video_site
-- ----------------------------
INSERT INTO video_site VALUES ('1', '网络', '');
INSERT INTO video_site VALUES ('2', '优酷', 'www.youku.com');
INSERT INTO video_site VALUES ('3', '土豆', 'www.tudou.com');
INSERT INTO video_site VALUES ('4', '搜狐视频', 'tv.sohu.com');
INSERT INTO video_site VALUES ('5', '腾讯视频', 'v.qq.com');
INSERT INTO video_site VALUES ('6', '56', 'www.56.com');
INSERT INTO video_site VALUES ('7', '爱奇艺', 'www.iqiyi.com ');
INSERT INTO video_site VALUES ('8', '新浪视频', 'v.sina.com.cn');
INSERT INTO video_site VALUES ('9', '酷6网', 'www.ku6.com');
INSERT INTO video_site VALUES ('10', '6间房', 'www.6.cn');
INSERT INTO video_site VALUES ('11', '17173', 'v.17173.com');
INSERT INTO video_site VALUES ('12', '乐视', 'www.letv.com');

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
