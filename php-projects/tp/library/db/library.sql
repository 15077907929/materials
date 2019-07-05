/*
Navicat MySQL Data Transfer

Source Server         : virtual_linux
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : library

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-07-03 14:02:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `bookcase`
-- ----------------------------
DROP TABLE IF EXISTS `bookcase`;
CREATE TABLE `bookcase` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='书架信息表';

-- ----------------------------
-- Records of bookcase
-- ----------------------------
INSERT INTO `bookcase` VALUES ('1', '书架123');
INSERT INTO `bookcase` VALUES ('2', '书架2');
INSERT INTO `bookcase` VALUES ('3', '书架3');

-- ----------------------------
-- Table structure for `bookinfo`
-- ----------------------------
DROP TABLE IF EXISTS `bookinfo`;
CREATE TABLE `bookinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `barcode` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `typeid` int(10) unsigned NOT NULL DEFAULT '0',
  `author` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `translator` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `pubid` int(11) NOT NULL,
  `price` float(8,2) NOT NULL COMMENT '//float(8,2)',
  `page` int(10) unsigned NOT NULL DEFAULT '0',
  `bookcase` int(11) NOT NULL,
  `storage` int(10) unsigned NOT NULL DEFAULT '0',
  `inTime` date NOT NULL DEFAULT '0000-00-00',
  `operator` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `del` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图书信息表';

-- ----------------------------
-- Records of bookinfo
-- ----------------------------
INSERT INTO `bookinfo` VALUES ('2', '9787544527095', '史记', '3', '司马迁', '', '1', '25.00', '0', '3', '0', '2019-06-28', 'admin', '0');
INSERT INTO `bookinfo` VALUES ('3', '123456789', '西游记', '4', '吴承恩', '', '3', '32.00', '0', '2', '0', '2019-06-28', 'admin', '0');
INSERT INTO `bookinfo` VALUES ('8', '34242', '水浒传', '1', '施耐庵', '', '2', '99.00', '0', '1', '0', '2019-06-28', 'admin', '0');
INSERT INTO `bookinfo` VALUES ('9', '53452334', 'php入门', '1', '', '', '2', '56.00', '0', '1', '0', '2019-06-28', 'admin', '0');
INSERT INTO `bookinfo` VALUES ('10', '474654524', 'java入门', '1', '', '', '1', '55.00', '0', '2', '0', '2019-06-28', 'admin', '0');
INSERT INTO `bookinfo` VALUES ('11', '454565724', 'c语言入门', '1', '', '', '3', '65.00', '0', '1', '0', '2019-06-28', 'admin', '0');
INSERT INTO `bookinfo` VALUES ('12', '45452485745', 'java语言入门', '4', '', '', '2', '65.00', '0', '3', '0', '2019-06-28', 'admin', '0');
INSERT INTO `bookinfo` VALUES ('13', '4545245467456', 'javascript入门', '3', '', '', '1', '65.00', '0', '1', '0', '2019-06-28', 'admin', '0');
INSERT INTO `bookinfo` VALUES ('14', '454524324', 'linux入门', '3', '', '', '1', '65.00', '0', '3', '0', '2019-06-28', 'admin', '0');
INSERT INTO `bookinfo` VALUES ('15', '63256345564', '资治通鉴', '3', '司马光', '', '1', '56.00', '0', '3', '0', '2019-06-28', 'admin', '0');
INSERT INTO `bookinfo` VALUES ('16', '6325634554364', '三国演义', '3', '罗贯中', '', '2', '88.00', '0', '2', '0', '2019-06-28', 'admin', '0');

-- ----------------------------
-- Table structure for `booktype`
-- ----------------------------
DROP TABLE IF EXISTS `booktype`;
CREATE TABLE `booktype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图书分类信息表';

-- ----------------------------
-- Records of booktype
-- ----------------------------
INSERT INTO `booktype` VALUES ('1', '计算机');
INSERT INTO `booktype` VALUES ('2', '医学');
INSERT INTO `booktype` VALUES ('3', '小说');
INSERT INTO `booktype` VALUES ('4', '摄影');
INSERT INTO `booktype` VALUES ('5', '建筑');

-- ----------------------------
-- Table structure for `borrow`
-- ----------------------------
DROP TABLE IF EXISTS `borrow`;
CREATE TABLE `borrow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `readerid` int(10) unsigned NOT NULL,
  `bookid` int(11) NOT NULL,
  `borrowTime` date NOT NULL,
  `backTime` date NOT NULL,
  `operator` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ifback` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图书借阅信息表';

-- ----------------------------
-- Records of borrow
-- ----------------------------
INSERT INTO `borrow` VALUES ('1', '1', '3', '2019-06-28', '2019-06-28', 'admin', '1');
INSERT INTO `borrow` VALUES ('2', '1', '8', '2019-06-28', '2019-06-28', 'admin', '1');
INSERT INTO `borrow` VALUES ('3', '1', '2', '2019-06-28', '2019-07-28', 'admin', '0');
INSERT INTO `borrow` VALUES ('4', '1', '9', '2019-06-28', '2019-06-28', 'admin', '1');
INSERT INTO `borrow` VALUES ('5', '1', '10', '2019-06-28', '2019-07-28', 'admin', '0');
INSERT INTO `borrow` VALUES ('6', '1', '13', '2019-06-28', '2019-07-28', 'admin', '0');
INSERT INTO `borrow` VALUES ('7', '1', '11', '2019-06-28', '2019-07-28', 'admin', '0');
INSERT INTO `borrow` VALUES ('8', '1', '12', '2019-06-28', '2019-06-28', 'admin', '1');
INSERT INTO `borrow` VALUES ('9', '1', '14', '2019-06-28', '2019-06-28', 'admin', '1');
INSERT INTO `borrow` VALUES ('10', '1', '15', '2019-06-28', '2019-06-28', 'admin', '1');
INSERT INTO `borrow` VALUES ('11', '8', '8', '2019-05-01', '2019-06-06', 'admin', '0');
INSERT INTO `borrow` VALUES ('12', '8', '15', '2019-06-28', '2019-07-28', 'admin', '0');
INSERT INTO `borrow` VALUES ('13', '8', '16', '2019-06-28', '2019-07-28', 'admin', '0');
INSERT INTO `borrow` VALUES ('14', '2', '13', '2019-06-28', '2019-08-27', 'admin', '0');
INSERT INTO `borrow` VALUES ('15', '2', '15', '2019-06-28', '2019-07-28', 'admin', '0');
INSERT INTO `borrow` VALUES ('16', '2', '3', '2019-06-28', '2019-07-28', 'admin', '0');
INSERT INTO `borrow` VALUES ('17', '1', '15', '2019-05-31', '2019-06-28', 'admin', '1');
INSERT INTO `borrow` VALUES ('18', '8', '9', '2019-06-28', '2019-07-28', 'admin', '0');

-- ----------------------------
-- Table structure for `library`
-- ----------------------------
DROP TABLE IF EXISTS `library`;
CREATE TABLE `library` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `curator` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createDate` date NOT NULL,
  `introduce` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图书馆信息表';

-- ----------------------------
-- Records of library
-- ----------------------------
INSERT INTO `library` VALUES ('1', '测试图书馆123', '许多456', '15077907929', '安徽省合肥市兴旺华府骏苑', '421312268@qq.com***---', 'www.test.com', '2019-07-03', '这个是测试用的789');

-- ----------------------------
-- Table structure for `manager`
-- ----------------------------
DROP TABLE IF EXISTS `manager`;
CREATE TABLE `manager` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `pwd` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `n` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图书馆管理员信息表';

-- ----------------------------
-- Records of manager
-- ----------------------------
INSERT INTO `manager` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3');
INSERT INTO `manager` VALUES ('2', 'xuduo3', '9fc39503b4e93142ae120a250dd3f982');
INSERT INTO `manager` VALUES ('3', 'jiajia', 'cd611a31ea969b908932d44d126d195b');
INSERT INTO `manager` VALUES ('4', 'mama', 'eeafbf4d9b3957b139da7b7f2e7f2d4a');
INSERT INTO `manager` VALUES ('8', 'xxx', 'f561aaf6ef0bf14d4208bb46a4ccb3ad');
INSERT INTO `manager` VALUES ('9', '测试', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `manager` VALUES ('10', 'aaa', 'e1faffb3e614e6c2fba74296962386b7');
INSERT INTO `manager` VALUES ('11', 'xyz', 'd16fb36f0911f878998c136191af705e');

-- ----------------------------
-- Table structure for `parameter`
-- ----------------------------
DROP TABLE IF EXISTS `parameter`;
CREATE TABLE `parameter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cost` int(10) unsigned NOT NULL,
  `validity` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='参数设置表';

-- ----------------------------
-- Records of parameter
-- ----------------------------
INSERT INTO `parameter` VALUES ('1', '15', '24');

-- ----------------------------
-- Table structure for `publishing`
-- ----------------------------
DROP TABLE IF EXISTS `publishing`;
CREATE TABLE `publishing` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ISBN` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='出版社信息表';

-- ----------------------------
-- Records of publishing
-- ----------------------------
INSERT INTO `publishing` VALUES ('1', '123456789', '新华出版社123');
INSERT INTO `publishing` VALUES ('2', '1244', '教育出版社');
INSERT INTO `publishing` VALUES ('3', '5345', '测试出版社');

-- ----------------------------
-- Table structure for `purview`
-- ----------------------------
DROP TABLE IF EXISTS `purview`;
CREATE TABLE `purview` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL,
  `sysset` tinyint(4) NOT NULL DEFAULT '0',
  `readerset` tinyint(4) NOT NULL DEFAULT '0',
  `bookset` tinyint(4) NOT NULL DEFAULT '0',
  `borrowback` tinyint(4) NOT NULL DEFAULT '0',
  `sysquery` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理员权限信息表';

-- ----------------------------
-- Records of purview
-- ----------------------------
INSERT INTO `purview` VALUES ('1', '2', '1', '1', '1', '1', '1');
INSERT INTO `purview` VALUES ('2', '1', '1', '1', '1', '1', '1');
INSERT INTO `purview` VALUES ('3', '3', '1', '1', '0', '1', '1');
INSERT INTO `purview` VALUES ('4', '4', '1', '1', '1', '1', '1');
INSERT INTO `purview` VALUES ('6', '8', '1', '0', '0', '1', '1');

-- ----------------------------
-- Table structure for `reader`
-- ----------------------------
DROP TABLE IF EXISTS `reader`;
CREATE TABLE `reader` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sex` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '//1男，0女',
  `barcode` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `vocation` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `paperType` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `paperNO` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createDate` date NOT NULL,
  `operator` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `remark` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `typeid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='读者信息表';

-- ----------------------------
-- Records of reader
-- ----------------------------
INSERT INTO `reader` VALUES ('1', '许多', '1', '123456789', '', '0000-00-00', '身份证', '345543', '', '', '2019-06-27', 'admin', '', '3');
INSERT INTO `reader` VALUES ('2', '许佳', '1', '12345678911', '', '0000-00-00', '身份证', '123', '', '', '2019-06-27', 'admin', '', '1');
INSERT INTO `reader` VALUES ('5', '许多555', '0', '123456789', '', '0000-00-00', '军官证', '342657199807011869', '', '', '2019-06-27', 'admin', '', '3');
INSERT INTO `reader` VALUES ('8', 'mama', '0', '1569875632', '', '0000-00-00', '工作证', '123243', '', '', '2019-06-27', 'admin', '', '2');
INSERT INTO `reader` VALUES ('9', '戴宗', '1', '12434324', '', '0000-00-00', '工作证', '5342342', '', '', '2019-06-27', 'admin', '', '7');
INSERT INTO `reader` VALUES ('10', '宋江', '1', '13213', '', '0000-00-00', '军官证', '23432', '', '', '2019-06-27', 'admin', '', '1');
INSERT INTO `reader` VALUES ('11', '李四', '0', '234324', '', '0000-00-00', '工作证', '324432', '', '', '2019-06-27', 'admin', '', '2');
INSERT INTO `reader` VALUES ('12', '撒地方', '1', '24234', '', '0000-00-00', '军官证', '54535', '', '', '2019-06-28', 'admin', '', '3');

-- ----------------------------
-- Table structure for `readertype`
-- ----------------------------
DROP TABLE IF EXISTS `readertype`;
CREATE TABLE `readertype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='读者分类信息表';

-- ----------------------------
-- Records of readertype
-- ----------------------------
INSERT INTO `readertype` VALUES ('1', '学生', '6');
INSERT INTO `readertype` VALUES ('2', '教师', '8');
INSERT INTO `readertype` VALUES ('3', '测试类型', '10');
INSERT INTO `readertype` VALUES ('7', '社会人员', '4');
