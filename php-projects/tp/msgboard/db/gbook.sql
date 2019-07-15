/*
Navicat MySQL Data Transfer

Source Server         : virtual_linux
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : gbook

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-07-15 16:41:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pwd` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理员信息表';

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'xuduo3', 'e10adc3949ba59abbe56e057f20f883e');

-- ----------------------------
-- Table structure for `guestbook`
-- ----------------------------
DROP TABLE IF EXISTS `guestbook`;
CREATE TABLE `guestbook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reply` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `ip` int(11) NOT NULL,
  `settop` tinyint(4) NOT NULL DEFAULT '0',
  `ifshow` tinyint(4) NOT NULL DEFAULT '0',
  `ifqqh` tinyint(4) NOT NULL DEFAULT '0',
  `systime` int(11) NOT NULL,
  `replytime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='留言信息表';

-- ----------------------------
-- Records of guestbook
-- ----------------------------
INSERT INTO `guestbook` VALUES ('1', 'xuduo3', '今天天气不错，可使我还要在公司加班，', '哈哈哈', '421312268@qq.com', '173017253', '0', '1', '1', '1557347208', '1557373000');
INSERT INTO `guestbook` VALUES ('4', 'jack', '晚上文峰哥哥请我们几个吃饭，聚一聚，好长时间没聚了，上一次还是一年前', '', 'xfksei38lb35@163.com', '173017253', '0', '0', '0', '1557357877', '1557373083');
INSERT INTO `guestbook` VALUES ('5', 'mike', '今天做了一个股票的小php程序，有canvas图，感觉做的还不错，收藏了', '好的不错，继续努力啊', '', '173017253', '1', '1', '0', '1557357877', '1557373032');
INSERT INTO `guestbook` VALUES ('15', '防守打法范德萨', '撒地方范德萨发', '', '', '173017253', '0', '0', '1', '1557376857', '0');
