/*
Navicat MySQL Data Transfer

Source Server         : virtual_linux
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ddz

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-06-21 09:04:50
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用来保存整个系统的房间信息';

-- ----------------------------
-- Records of room_ddz
-- ----------------------------

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用来保存整个系统的用户信息';

-- ----------------------------
-- Records of user_ddz
-- ----------------------------
