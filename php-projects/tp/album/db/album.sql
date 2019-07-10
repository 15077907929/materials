/*
Navicat MySQL Data Transfer

Source Server         : virtual_linux
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : album

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-07-10 14:17:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `userpass` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户信息表';

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'xuduo3', '9fc39503b4e93142ae120a250dd3f982', '0');
INSERT INTO `admin` VALUES ('2', 'xujia', 'db238163390e1b10ae0b21848d692127', '1561778436');
INSERT INTO `admin` VALUES ('3', 'mama', 'eeafbf4d9b3957b139da7b7f2e7f2d4a', '1561778461');

-- ----------------------------
-- Table structure for `albums`
-- ----------------------------
DROP TABLE IF EXISTS `albums`;
CREATE TABLE `albums` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cover` int(11) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `private` tinyint(4) NOT NULL DEFAULT '0',
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='相册目录表';

-- ----------------------------
-- Records of albums
-- ----------------------------
INSERT INTO `albums` VALUES ('32', '水浒传', '129', '1561785104', '0', '');
INSERT INTO `albums` VALUES ('37', '旅游', '136', '1561794054', '0', '');
INSERT INTO `albums` VALUES ('38', '威海', '0', '1561799303', '1', '');
INSERT INTO `albums` VALUES ('39', '测试', '142', '1557227901', '1', '');

-- ----------------------------
-- Table structure for `imgs`
-- ----------------------------
DROP TABLE IF EXISTS `imgs`;
CREATE TABLE `imgs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `album` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dir` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `pickey` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ext` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `private` tinyint(4) NOT NULL DEFAULT '0',
  `private_pass` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `author` int(11) NOT NULL DEFAULT '0',
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图片信息表';

-- ----------------------------
-- Records of imgs
-- ----------------------------
INSERT INTO `imgs` VALUES ('121', '32', '2ZchCt.jpg', '201905', 'fe3e128891c2a0c21f7a9eced24e9db4', 'jpg', '1', '6', '1557231485', '0', '', '1', '');
