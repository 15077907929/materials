/*
Navicat MySQL Data Transfer

Source Server         : virtual_linux
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ddz

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-06-26 14:41:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `room_ddz`
-- ----------------------------
DROP TABLE IF EXISTS `room_ddz`;
CREATE TABLE `room_ddz` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `player1_name` varchar(25) NOT NULL,
  `player2_name` varchar(25) NOT NULL,
  `lord` enum('player2','player1') NOT NULL,
  `flag` enum('player2','player1') NOT NULL,
  `player1_p` varchar(100) NOT NULL,
  `player2_p` varchar(100) NOT NULL,
  `lord_p` varchar(20) NOT NULL,
  `player1_time` int(11) NOT NULL DEFAULT '0',
  `player2_time` int(11) NOT NULL DEFAULT '0',
  `system_time` int(11) NOT NULL DEFAULT '0',
  `player1_show` varchar(100) NOT NULL,
  `player2_show` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='用来保存整个系统的房间信息';

-- ----------------------------
-- Records of room_ddz
-- ----------------------------
INSERT INTO `room_ddz` VALUES ('1', '房间一号', 'xuduo3', 'mike', 'player2', 'player2', 'T2,F5,T4,', 'F2,', '11,H6,T6,', '1555356863', '1555356863', '1555356863', 'T10,', 'F9,');
INSERT INTO `room_ddz` VALUES ('2', '房间二号', '', '', '', '', '', '', '', '1555335476', '0', '1555335476', '', '');
INSERT INTO `room_ddz` VALUES ('3', '房间三号', '', '', '', '', '', '', '', '1555329809', '0', '1555329809', '', '');
INSERT INTO `room_ddz` VALUES ('4', '房间四号', '', '', '', '', '', '', '', '1555330373', '0', '1555330373', '', '');
INSERT INTO `room_ddz` VALUES ('5', '房间五号', '', '', '', '', '', '', '', '0', '0', '0', '', '');
INSERT INTO `room_ddz` VALUES ('6', '房间六号', '', '', '', '', '', '', '', '0', '0', '0', '', '');
INSERT INTO `room_ddz` VALUES ('7', '房间七号', '', '', '', '', '', '', '', '1555330380', '0', '1555330380', '', '');
INSERT INTO `room_ddz` VALUES ('8', '房间八号', '', '', '', '', '', '', '', '0', '0', '0', '', '');
INSERT INTO `room_ddz` VALUES ('9', '房间九号', '', '', '', '', '', '', '', '0', '0', '0', '', '');

-- ----------------------------
-- Table structure for `user_ddz`
-- ----------------------------
DROP TABLE IF EXISTS `user_ddz`;
CREATE TABLE `user_ddz` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `face` int(11) NOT NULL DEFAULT '1',
  `win` int(11) NOT NULL DEFAULT '0',
  `lost` int(11) NOT NULL DEFAULT '0',
  `run` int(11) NOT NULL DEFAULT '0',
  `score` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `n` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='用来保存整个系统的用户信息';

-- ----------------------------
-- Records of user_ddz
-- ----------------------------
INSERT INTO `user_ddz` VALUES ('1', 'xuduo3', 'e10adc3949ba59abbe56e057f20f883e', '0', '1', '14', '18', '32', '0');
INSERT INTO `user_ddz` VALUES ('2', 'xujia', 'db238163390e1b10ae0b21848d692127', '0', '1', '0', '0', '0', '0');
INSERT INTO `user_ddz` VALUES ('3', 'mama', 'eeafbf4d9b3957b139da7b7f2e7f2d4a', '0', '1', '0', '0', '0', '0');
INSERT INTO `user_ddz` VALUES ('4', 'mike', '18126e7bd3f84b3f3e4df094def5b7de', '0', '1', '5', '1', '32', '0');
INSERT INTO `user_ddz` VALUES ('5', 'makes', '29d0b8d9daec06cdd0cda7269997b216', '0', '1', '0', '0', '0', '0');
