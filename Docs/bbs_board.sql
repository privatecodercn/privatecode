/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50535
Source Host           : 127.0.0.1:3306
Source Database       : kuiwa

Target Server Type    : MYSQL
Target Server Version : 50535
File Encoding         : 65001

Date: 2014-07-09 14:20:49
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `bbs_board`
-- ----------------------------
DROP TABLE IF EXISTS `bbs_board`;
CREATE TABLE `bbs_board` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lvl` tinyint(4) NOT NULL DEFAULT '0' COMMENT '版块层级',
  `pid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '上级版块',
  `topic_num` smallint(6) NOT NULL DEFAULT '0' COMMENT '主题数',
  `post_num` mediumint(9) NOT NULL DEFAULT '0' COMMENT '帖子数',
  `view_num` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '浏览数',
  `post_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发帖时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态:-1-已删除;0-未启用;1-启用;',
  `orderid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序ID',
  `name` varchar(150) NOT NULL DEFAULT '' COMMENT '版块名称',
  `managers` varchar(255) NOT NULL DEFAULT '' COMMENT '版主列表，","分隔的UID列表',
  PRIMARY KEY (`id`),
  KEY `idx_post_time` (`post_time`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='论坛版块';

-- ----------------------------
-- Records of bbs_board
-- ----------------------------
INSERT INTO bbs_board VALUES ('1', '1', '0', '0', '0', '0', '0', '1', '0', '孕婴', '{\"2\":\"葵娃\"}');
INSERT INTO bbs_board VALUES ('2', '2', '1', '0', '0', '0', '0', '1', '0', '准备怀孕', '');
INSERT INTO bbs_board VALUES ('3', '2', '1', '0', '0', '0', '0', '1', '0', '孕期交流', '');
INSERT INTO bbs_board VALUES ('4', '2', '1', '0', '0', '0', '0', '1', '0', '婴儿护理', '');
INSERT INTO bbs_board VALUES ('5', '1', '0', '0', '0', '0', '0', '1', '0', '教育', '');
INSERT INTO bbs_board VALUES ('6', '2', '5', '0', '0', '0', '0', '1', '0', '亲子阅读', '');
INSERT INTO bbs_board VALUES ('7', '2', '5', '0', '0', '0', '0', '1', '0', '幼儿教育', '');
INSERT INTO bbs_board VALUES ('8', '2', '1', '0', '0', '0', '0', '1', '0', '母婴食谱', '');
INSERT INTO bbs_board VALUES ('9', '2', '5', '0', '0', '0', '0', '1', '0', '资源分享', '');
INSERT INTO bbs_board VALUES ('10', '1', '0', '0', '0', '0', '0', '1', '0', '健康养生', '');
INSERT INTO bbs_board VALUES ('11', '1', '0', '0', '0', '0', '0', '1', '0', '公共交流', '');
INSERT INTO bbs_board VALUES ('12', '2', '1', '0', '0', '0', '0', '1', '0', '宝宝健康', '');
INSERT INTO bbs_board VALUES ('13', '2', '10', '0', '0', '0', '0', '1', '0', '女性健康', '');
INSERT INTO bbs_board VALUES ('14', '2', '10', '0', '0', '0', '0', '1', '0', '养生美食', '');
INSERT INTO bbs_board VALUES ('15', '2', '10', '0', '0', '0', '0', '1', '0', '养生保健', '');
INSERT INTO bbs_board VALUES ('16', '2', '11', '0', '0', '0', '0', '1', '0', '家有乐宝', '');
INSERT INTO bbs_board VALUES ('17', '2', '11', '0', '0', '0', '0', '1', '0', '闲聊茶馆', '');
INSERT INTO bbs_board VALUES ('18', '2', '11', '0', '0', '0', '0', '1', '0', '美图分享', '');
INSERT INTO bbs_board VALUES ('19', '2', '11', '0', '0', '0', '0', '1', '0', '母婴闲置', '');
INSERT INTO bbs_board VALUES ('20', '1', '0', '0', '0', '0', '0', '1', '0', '站务', '');
INSERT INTO bbs_board VALUES ('21', '2', '20', '0', '0', '0', '0', '1', '0', '公告区', '');
INSERT INTO bbs_board VALUES ('22', '2', '20', '0', '0', '0', '0', '1', '0', '建议、反馈', '');
INSERT INTO bbs_board VALUES ('23', '2', '20', '0', '0', '0', '0', '1', '0', '举报、投诉', '');
INSERT INTO bbs_board VALUES ('24', '2', '20', '0', '0', '0', '0', '1', '0', '版主专区', '');
