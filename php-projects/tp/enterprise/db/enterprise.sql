/*
Navicat MySQL Data Transfer

Source Server         : virtual_linux
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : enterprise

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-07-24 11:49:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `sex` tinyint(4) NOT NULL DEFAULT '1',
  `tel` varchar(20) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `qq` varchar(12) NOT NULL,
  `msn` varchar(40) NOT NULL,
  `taobao` varchar(40) NOT NULL,
  `introduction` text NOT NULL,
  `login` int(10) unsigned NOT NULL DEFAULT '0',
  `modify_ip` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  `register_date` int(11) NOT NULL,
  `approval_date` int(11) NOT NULL,
  `ok` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员信息表';

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', '1', 'xuduo3', '9fc39503b4e93142ae120a250dd3f982', '1', '', '', '', '', '', '', '', '13', '173017253', '1557583148', '0', '0', '0');

-- ----------------------------
-- Table structure for `column`
-- ----------------------------
DROP TABLE IF EXISTS `column`;
CREATE TABLE `column` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` char(100) DEFAULT NULL,
  `e_name` char(100) DEFAULT NULL,
  `foldername` char(50) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `bigclass` int(11) DEFAULT '0',
  `module` int(11) DEFAULT NULL,
  `no_order` int(11) DEFAULT NULL,
  `if_in` char(1) NOT NULL DEFAULT '1',
  `nav` char(1) DEFAULT '0',
  `c_keywords` varchar(200) DEFAULT NULL,
  `e_keywords` varchar(200) DEFAULT NULL,
  `c_content` text,
  `e_content` text,
  `c_description` text,
  `e_description` text,
  `c_out_url` char(200) DEFAULT NULL,
  `list_order` int(11) DEFAULT '0',
  `new_windows` char(50) DEFAULT NULL,
  `classtype` int(11) DEFAULT '1',
  `e_out_url` char(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of column
-- ----------------------------
INSERT INTO `column` VALUES ('1', '关于我们', null, 'About', null, '0', '1', '1', '0', '1', '中文关关键词', 'english keywords', '<p>中文内容</p>', '<p>English content</p>', '中文简短描述', 'English description', null, '0', null, '1', null);
INSERT INTO `column` VALUES ('2', '新闻中心', null, 'News', 'news', '0', '2', '2', '0', '1', null, null, null, null, null, null, null, '0', null, '1', null);
INSERT INTO `column` VALUES ('3', '产品中心', null, 'Product', null, '0', '3', null, '0', '1', null, null, null, null, null, null, null, '0', null, '1', null);
INSERT INTO `column` VALUES ('4', '下载中心', null, 'Download', null, '0', '4', null, '0', '3', null, null, null, null, null, null, null, '0', null, '1', null);
INSERT INTO `column` VALUES ('5', '图片中心', null, 'Img', null, '0', '5', null, '0', '1', null, null, null, null, null, null, null, '0', null, '1', null);
INSERT INTO `column` VALUES ('6', '常见问答', null, 'Question', 'question', '0', '2', null, '1', '3', null, null, null, null, null, null, null, '0', null, '1', null);
INSERT INTO `column` VALUES ('7', '招聘中心', null, 'Job', null, '0', '6', null, '0', '3', null, null, null, null, null, null, null, '0', null, '1', null);
INSERT INTO `column` VALUES ('8', '在线留言', null, 'Message', null, '0', '7', null, '0', '2', null, null, null, null, null, null, null, '0', null, '1', null);
INSERT INTO `column` VALUES ('9', '在线反馈', null, null, null, '0', '0', null, '1', '3', null, null, null, null, null, null, 'index.php?m=Home&c=Feedback&a=feedback', '0', null, '1', null);
INSERT INTO `column` VALUES ('10', '网站管理', null, null, null, '0', '0', null, '1', '2', null, null, null, null, null, null, 'index.php?m=Admin&c=Index&a=index', '0', null, '1', null);
INSERT INTO `column` VALUES ('11', '企业新闻', null, null, null, '2', '2', null, '1', '0', null, null, null, null, null, null, null, '0', null, '2', null);
INSERT INTO `column` VALUES ('12', '行业新闻', null, null, null, '2', '2', null, '1', '0', null, null, null, null, null, null, null, '0', null, '2', null);
INSERT INTO `column` VALUES ('13', '企业新闻三级栏目', null, null, null, '11', '2', null, '1', '0', null, null, null, null, null, null, null, '0', null, '3', null);
INSERT INTO `column` VALUES ('14', '家用电器', null, null, null, '3', '3', null, '1', '0', null, null, null, null, null, null, null, '0', null, '2', null);
INSERT INTO `column` VALUES ('15', '办公电脑', null, null, null, '3', '3', null, '1', '0', null, null, null, null, null, null, null, '0', null, '2', null);
INSERT INTO `column` VALUES ('16', '数码通讯', null, null, null, '3', '3', null, '1', '0', null, null, null, null, null, null, null, '0', null, '2', null);
INSERT INTO `column` VALUES ('17', '电视机', null, null, null, '14', '3', null, '1', '0', null, null, null, null, null, null, null, '0', null, '3', null);
INSERT INTO `column` VALUES ('18', '洗衣机', null, null, null, '14', '3', null, '1', '0', null, null, null, null, null, null, null, '0', null, '3', null);

-- ----------------------------
-- Table structure for `download`
-- ----------------------------
DROP TABLE IF EXISTS `download`;
CREATE TABLE `download` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `c_title` varchar(200) DEFAULT NULL,
  `e_title` varchar(200) DEFAULT NULL,
  `c_keywords` varchar(200) DEFAULT NULL,
  `e_keywords` varchar(200) DEFAULT NULL,
  `c_description` text,
  `e_description` text,
  `c_content` text,
  `e_content` text,
  `class1` int(11) DEFAULT '0',
  `class2` int(11) DEFAULT '0',
  `class3` int(11) DEFAULT '0',
  `new_ok` tinyint(4) DEFAULT NULL,
  `downloadurl` varchar(255) DEFAULT NULL,
  `filesize` varchar(255) DEFAULT NULL,
  `com_ok` tinyint(4) DEFAULT '0',
  `hits` int(11) DEFAULT '0',
  `updatetime` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `c_para1` varchar(200) DEFAULT NULL,
  `c_para2` varchar(200) DEFAULT NULL,
  `c_para3` varchar(200) DEFAULT NULL,
  `c_para4` varchar(200) DEFAULT NULL,
  `c_para5` varchar(200) DEFAULT NULL,
  `c_para6` varchar(200) DEFAULT NULL,
  `c_para7` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='下载信息表';

-- ----------------------------
-- Records of download
-- ----------------------------
INSERT INTO `download` VALUES ('1', '发士大夫撒旦', '', '', '', '', '', '', '', '0', '0', '0', '0', null, '', '0', '0', '2019', '2019', '', '', null, null, null, null, null);
INSERT INTO `download` VALUES ('2', '发生的发生', '', '', '', '发士大夫撒旦', '发顺丰撒', '', '', '0', '0', '0', '0', null, '6111.51', '0', '0', '2019', '2019', '', '', null, null, null, null, null);
INSERT INTO `download` VALUES ('3', '发生的发生', '', '', '', '沙发斯蒂芬', '方式发送到', '<p>发顺丰撒</p>', '<p>撒的发生大发</p>', '0', '0', '0', '0', '1557545985.rar', '6111.51', '0', '0', '2019', '2019', '', '', null, null, null, null, null);

-- ----------------------------
-- Table structure for `fdparameter`
-- ----------------------------
DROP TABLE IF EXISTS `fdparameter`;
CREATE TABLE `fdparameter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `c_name` varchar(100) NOT NULL,
  `e_name` varchar(100) NOT NULL,
  `no_order` int(10) unsigned NOT NULL DEFAULT '0',
  `use_ok` tinyint(4) NOT NULL DEFAULT '0',
  `wr_ok` tinyint(4) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='反馈信息表';

-- ----------------------------
-- Records of fdparameter
-- ----------------------------
INSERT INTO `fdparameter` VALUES ('1', '反馈主题', '', '0', '0', '0', '1');
INSERT INTO `fdparameter` VALUES ('2', '姓名', '', '0', '0', '0', '1');
INSERT INTO `fdparameter` VALUES ('3', '职务', '', '0', '0', '0', '1');
INSERT INTO `fdparameter` VALUES ('4', 'Email', '', '0', '0', '0', '1');
INSERT INTO `fdparameter` VALUES ('5', '电话', '', '0', '0', '0', '1');
INSERT INTO `fdparameter` VALUES ('6', '手机', '', '0', '0', '0', '1');
INSERT INTO `fdparameter` VALUES ('7', '传真', '', '0', '0', '0', '1');
INSERT INTO `fdparameter` VALUES ('8', '单位名称', '', '0', '0', '0', '1');
INSERT INTO `fdparameter` VALUES ('9', '详细地址', '', '0', '0', '0', '1');
INSERT INTO `fdparameter` VALUES ('10', '邮政编码', '', '0', '0', '0', '1');
INSERT INTO `fdparameter` VALUES ('11', '省份', '', '0', '0', '0', '2');
INSERT INTO `fdparameter` VALUES ('12', '反馈类型', '', '0', '0', '0', '2');
INSERT INTO `fdparameter` VALUES ('13', '信息描述', '', '0', '0', '0', '3');

-- ----------------------------
-- Table structure for `feedback`
-- ----------------------------
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `para1` varchar(255) DEFAULT NULL,
  `para2` varchar(255) DEFAULT NULL,
  `para3` varchar(255) DEFAULT NULL,
  `para4` varchar(255) DEFAULT NULL,
  `para5` varchar(255) DEFAULT NULL,
  `para6` varchar(255) DEFAULT NULL,
  `para7` varchar(255) DEFAULT NULL,
  `para8` varchar(255) DEFAULT NULL,
  `para9` varchar(255) DEFAULT NULL,
  `para10` varchar(255) DEFAULT NULL,
  `para11` varchar(255) DEFAULT NULL,
  `para12` varchar(255) DEFAULT NULL,
  `para13` varchar(255) DEFAULT NULL,
  `para14` varchar(255) DEFAULT NULL,
  `para15` varchar(255) DEFAULT NULL,
  `para16` text,
  `para17` text,
  `para18` text,
  `para19` text,
  `para20` text,
  `fdtitle` varchar(255) DEFAULT NULL,
  `fromurl` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `readok` int(11) DEFAULT '0',
  `useinfo` text,
  `en` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of feedback
-- ----------------------------
INSERT INTO `feedback` VALUES ('1', '111', '12121', '', 'metinfo@qq.com', '', '', '', '', '', '', '湖南', '索取资料', '', '', '', 'ddddd', '', '', '', '', '关键是变成串的形式以后还能够转化回来--反馈邮件', 'http://localhost/met/feedback/index.php?title=', '127.0.0.1', '2009-03-16 13:29:00', '0', null, '');

-- ----------------------------
-- Table structure for `imgs`
-- ----------------------------
DROP TABLE IF EXISTS `imgs`;
CREATE TABLE `imgs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `c_title` varchar(200) DEFAULT NULL,
  `e_title` varchar(200) DEFAULT NULL,
  `c_keywords` varchar(200) DEFAULT NULL,
  `e_keywords` varchar(200) DEFAULT NULL,
  `c_description` text,
  `e_description` text,
  `c_content` text,
  `e_content` text,
  `class1` int(11) DEFAULT '0',
  `class2` int(11) DEFAULT '0',
  `class3` int(11) DEFAULT '0',
  `new_ok` tinyint(4) DEFAULT NULL,
  `imgurl` varchar(255) DEFAULT NULL,
  `imgurls` varchar(255) DEFAULT NULL,
  `com_ok` tinyint(4) DEFAULT '0',
  `hits` int(11) DEFAULT '0',
  `updatetime` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `c_para1` varchar(200) DEFAULT NULL,
  `c_para2` varchar(200) DEFAULT NULL,
  `c_para3` varchar(200) DEFAULT NULL,
  `c_para4` varchar(200) DEFAULT NULL,
  `c_para5` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='图片信息表';

-- ----------------------------
-- Records of imgs
-- ----------------------------
INSERT INTO `imgs` VALUES ('1', '法萨芬撒放', '', '防守打法', '', '胜多负少的', '', '<p>撒旦飞洒</p>', '<p>防守打法</p>', '0', '0', '0', '0', null, null, '0', '0', '2019', '2019', null, null, null, null, null);
INSERT INTO `imgs` VALUES ('2', '防守打法', '', '', '', '范德萨发', '发的发', '', '', '0', '0', '0', '0', '201905/watermark/1557552998.jpg', '201905/thumb/1557552998.jpg', '0', '0', '2019', '2019', null, null, null, null, null);
INSERT INTO `imgs` VALUES ('3', '发士大夫撒旦', '', '', '', '', '', '', '', '0', '0', '0', '0', '', '', '0', '0', '2019', '2019', null, null, null, null, null);
INSERT INTO `imgs` VALUES ('4', '啊啊啊', '', '', '', '', '', '', '', '0', '0', '0', '0', '', '', '0', '0', '2019', '2019', null, null, null, null, null);
INSERT INTO `imgs` VALUES ('5', '发士大夫撒啊啊啊', '', '', '', '', '', '', '', '5', '0', '0', '0', '', '', '0', '0', '2019', '2019', null, null, null, null, null);

-- ----------------------------
-- Table structure for `job`
-- ----------------------------
DROP TABLE IF EXISTS `job`;
CREATE TABLE `job` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `c_position` varchar(100) DEFAULT NULL,
  `e_position` varchar(100) DEFAULT NULL,
  `count` int(11) DEFAULT '0',
  `c_place` varchar(100) DEFAULT NULL,
  `e_place` varchar(100) DEFAULT NULL,
  `c_deal` varchar(100) DEFAULT NULL,
  `e_deal` varchar(100) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `useful_life` int(11) DEFAULT NULL,
  `c_content` text,
  `e_content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='招聘信息表';

-- ----------------------------
-- Records of job
-- ----------------------------
INSERT INTO `job` VALUES ('1', '放散阀', '', '0', '', '', '', '', '2019', '0', '<p>阿士大夫</p>', '<p>阿士大夫</p>');
INSERT INTO `job` VALUES ('2', '防守打法', '', '0', '', '', '', '', '2019', '0', '<p>撒旦飞洒</p>', '<p>阿斯顿发</p>');

-- ----------------------------
-- Table structure for `link`
-- ----------------------------
DROP TABLE IF EXISTS `link`;
CREATE TABLE `link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `c_webname` varchar(100) DEFAULT NULL,
  `e_webname` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '0',
  `c_info` varchar(255) DEFAULT NULL,
  `e_info` varchar(255) DEFAULT NULL,
  `contact` varchar(200) DEFAULT NULL,
  `no_order` int(10) unsigned DEFAULT '0',
  `com_ok` tinyint(4) DEFAULT '0',
  `show_ok` tinyint(4) DEFAULT '0',
  `addtime` int(11) DEFAULT NULL,
  `link_lang` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='友情链接';

-- ----------------------------
-- Records of link
-- ----------------------------
INSERT INTO `link` VALUES ('1', '防守打法', null, null, null, '0', null, null, null, '0', '0', '0', null, null);

-- ----------------------------
-- Table structure for `message`
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `info` text,
  `ip` varchar(255) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `readok` int(11) DEFAULT '0',
  `useinfo` varchar(255) DEFAULT NULL,
  `en` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of message
-- ----------------------------
INSERT INTO `message` VALUES ('1', '胡总', '12345678', 'metinfo@qq.com', '426507856', '用于企业、单位形象展示、网络宣传、产品发布、产品展示、新闻发布、公告发布、在线交流等，包含企业简介、产品中心、新闻中心、客户服务、联系我们等基本栏目。', '127.0.0.1', '2009-03-07 11:19:06', '1', '用于企业、单位形象展示、网络宣传、产品发布、产品展示、新闻发布、公告发布、在线交流等，包含企业简介、产品中心、新闻中心、客户服务、联系我们等基本栏目。', '');
INSERT INTO `message` VALUES ('2', 'Hu zong', '12345678', 'metinfo@qq.com', '426507856', 'test ok', '127.222.168.111', '2009-03-07 11:25:27', '0', '审核通过', 'en');
INSERT INTO `message` VALUES ('3', '欧小姐', '131888888888', 'metinfo@metinfo.com.cn', '426507856', '用于企业、单位形象展示、网络宣传、产品发布、产品展示、新闻发布、公告发布、在线交流等，包含企业简介、产品中心、新闻中心、客户服务、联系我们等基本栏目。', '127.0.0.1', '2009-03-07 18:56:44', '0', ' ', '');

-- ----------------------------
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `c_title` varchar(200) NOT NULL,
  `e_title` varchar(200) NOT NULL,
  `c_keywords` varchar(200) NOT NULL,
  `e_keywords` varchar(200) NOT NULL,
  `c_description` text NOT NULL,
  `e_description` text NOT NULL,
  `c_content` text NOT NULL,
  `e_content` text NOT NULL,
  `class1` int(11) NOT NULL DEFAULT '0',
  `class2` int(11) NOT NULL DEFAULT '0',
  `class3` int(11) NOT NULL DEFAULT '0',
  `img_ok` tinyint(4) NOT NULL DEFAULT '0',
  `imgurl` varchar(255) NOT NULL,
  `imgurls` varchar(255) NOT NULL,
  `com_ok` tinyint(4) NOT NULL DEFAULT '0',
  `issue` varchar(100) NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  `updatetime` int(11) NOT NULL,
  `addtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='新闻信息表';

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES ('1', '防守打法', '', '', '', '', '', '', '', '0', '0', '0', '0', '', '', '0', 'xuduo3', '0', '2019', '2019');
INSERT INTO `news` VALUES ('2', '防守打法', '', '', '', '', '', '', '', '0', '0', '0', '0', '', '', '0', 'xuduo3', '0', '2019', '2019');
INSERT INTO `news` VALUES ('3', '测试新闻', '范德萨范德萨', '测试新闻关键词', '发士大夫撒旦', '第三方', '佛挡杀佛', '<p>是分散</p>', '<p>发发生大</p>', '0', '0', '0', '1', '201905/watermark/1557481061.jpg', '201905/thumb/1557481061.jpg', '0', 'xuduo3', '0', '2019', '2019');
INSERT INTO `news` VALUES ('4', '发顺丰撒', '', '', '', '', '', '', '', '0', '0', '0', '0', '', '', '0', 'xuduo3', '0', '2019', '2019');

-- ----------------------------
-- Table structure for `parameter`
-- ----------------------------
DROP TABLE IF EXISTS `parameter`;
CREATE TABLE `parameter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) DEFAULT NULL,
  `c_mark` char(200) DEFAULT NULL,
  `e_mark` char(200) DEFAULT NULL,
  `use_ok` int(1) DEFAULT '0',
  `no_order` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  `maxsize` char(200) NOT NULL DEFAULT '200',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of parameter
-- ----------------------------
INSERT INTO `parameter` VALUES ('1', 'para1', '编号', 'Number', '0', '1', '3', '200');
INSERT INTO `parameter` VALUES ('2', 'para2', '品牌', 'Brand', '1', '2', '3', '200');
INSERT INTO `parameter` VALUES ('3', 'para3', '单位', 'Unit', '1', '3', '3', '200');
INSERT INTO `parameter` VALUES ('4', 'para4', '价格', 'Price', '1', '4', '3', '200');
INSERT INTO `parameter` VALUES ('5', 'para5', '', '', '0', '5', '3', '200');
INSERT INTO `parameter` VALUES ('6', 'para6', '', '', '0', '6', '3', '200');
INSERT INTO `parameter` VALUES ('7', 'para7', '', '', '0', '7', '3', '200');
INSERT INTO `parameter` VALUES ('8', 'para8', '', '', '0', '8', '3', '200');
INSERT INTO `parameter` VALUES ('9', 'para9', '', '', '0', '9', '3', '不限');
INSERT INTO `parameter` VALUES ('10', 'para10', '', '', '0', '10', '3', '不限');
INSERT INTO `parameter` VALUES ('11', 'para1', '文件类型', 'File Type', '1', '1', '4', '200');
INSERT INTO `parameter` VALUES ('12', 'para2', '文件版本', 'Version', '1', '2', '4', '200');
INSERT INTO `parameter` VALUES ('13', 'para3', '', '', '0', '3', '4', '200');
INSERT INTO `parameter` VALUES ('14', 'para4', '', '', '0', '4', '4', '200');
INSERT INTO `parameter` VALUES ('15', 'para5', '', '', '0', '5', '4', '200');
INSERT INTO `parameter` VALUES ('16', 'para6', '', '', '0', '6', '4', '200');
INSERT INTO `parameter` VALUES ('17', 'para7', '', '', '0', '7', '4', '200');
INSERT INTO `parameter` VALUES ('18', 'para8', '', '', '0', '8', '4', '200');
INSERT INTO `parameter` VALUES ('19', 'para9', '', '', '0', '9', '4', '不限');
INSERT INTO `parameter` VALUES ('20', 'para10', '', '', '0', '10', '4', '不限');
INSERT INTO `parameter` VALUES ('21', 'para1', '', '', '0', '1', '5', '200');
INSERT INTO `parameter` VALUES ('22', 'para2', '', '', '0', '2', '5', '200');
INSERT INTO `parameter` VALUES ('23', 'para3', '', '', '0', '3', '5', '200');
INSERT INTO `parameter` VALUES ('24', 'para4', '', '', '0', '4', '5', '200');
INSERT INTO `parameter` VALUES ('25', 'para5', '', '', '0', '5', '5', '200');
INSERT INTO `parameter` VALUES ('26', 'para6', '', '', '0', '6', '5', '200');
INSERT INTO `parameter` VALUES ('27', 'para7', '', '', '0', '7', '5', '200');
INSERT INTO `parameter` VALUES ('28', 'para8', '', '', '0', '8', '5', '200');
INSERT INTO `parameter` VALUES ('29', 'para9', '', '', '0', '9', '5', '不限');
INSERT INTO `parameter` VALUES ('30', 'para10', '', '', '0', '10', '5', '不限');

-- ----------------------------
-- Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `c_title` varchar(200) DEFAULT NULL,
  `e_title` varchar(200) DEFAULT NULL,
  `c_keywords` varchar(200) DEFAULT NULL,
  `e_keywords` varchar(200) DEFAULT NULL,
  `c_description` text,
  `e_description` text,
  `c_content` longtext,
  `e_content` longtext,
  `class1` int(11) DEFAULT '0',
  `class2` int(11) DEFAULT '0',
  `class3` int(11) DEFAULT '0',
  `new_ok` int(1) DEFAULT '0',
  `imgurl` varchar(300) DEFAULT NULL,
  `imgurls` varchar(300) DEFAULT NULL,
  `com_ok` int(1) DEFAULT '0',
  `hits` int(11) DEFAULT '0',
  `updatetime` datetime DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `c_para1` varchar(200) DEFAULT NULL,
  `c_para2` varchar(200) DEFAULT NULL,
  `c_para3` varchar(200) DEFAULT NULL,
  `c_para4` varchar(200) DEFAULT NULL,
  `c_para5` varchar(200) DEFAULT NULL,
  `c_para6` varchar(200) DEFAULT NULL,
  `c_para7` varchar(200) DEFAULT NULL,
  `c_para8` varchar(200) DEFAULT NULL,
  `c_para9` text,
  `c_para10` text,
  `e_para1` varchar(200) DEFAULT NULL,
  `e_para2` varchar(200) DEFAULT NULL,
  `e_para3` varchar(200) DEFAULT NULL,
  `e_para4` varchar(200) DEFAULT NULL,
  `e_para5` varchar(200) DEFAULT NULL,
  `e_para6` varchar(200) DEFAULT NULL,
  `e_para7` varchar(200) DEFAULT NULL,
  `e_para8` varchar(200) DEFAULT NULL,
  `e_para9` text,
  `e_para10` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('12', '范德萨发生大', '第三方', '第三方', '水电费第三方', '大师傅', 'ffsdf', '<p>水电费水电费</p>', '<p>水电费水电费</p>', '0', '14', '17', '1', '201905/watermark/1557532985.jpg', '201905/thumb/1557532985.jpg', '1', '0', '2019-05-11 07:58:48', '2019-05-11 07:58:48', null, '佛挡杀佛', '的放散阀', '辅导费', null, null, null, null, null, null, null, '地方', '似懂非懂是', '撒地方', null, null, null, null, null, null);
INSERT INTO `product` VALUES ('13', '防守打法', '范德萨', '撒旦飞洒', '撒地方', '沙发上的', '安抚', '<p>阿士大夫</p>', '<p>撒的发生大发</p>', '0', '0', '0', '1', null, null, '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '发生', '发', null, null, null, null, null, null, null, null, '撒地方', '撒地方', null, null, null, null, null, null, null, null);
INSERT INTO `product` VALUES ('14', 'FSDF ', 'FDSFDS', 'DSFDSF', 'DSFDS', 'DFDS', 'FDSFDSF', '<p>FDFDSFDS</p>', '<p>FSDFSDFSD</p>', '0', '0', '0', null, null, null, null, '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'FDSF', '', null, null, null, null, null, null, null, null, 'FDSF', 'DSF', null, null, null, null, null, null, null, null);
INSERT INTO `product` VALUES ('15', 'FDSFSD', '', 'FDSFSD', 'FDSF', 'FSDF', 'DSFDS', '', '<p>FSDFSDFS</p>', '0', '0', '0', null, null, null, null, '0', '2019-05-11 11:24:50', '2019-05-11 11:24:50', 'FDSFSD', 'FDSF', null, null, null, null, null, null, null, null, 'FDSFSD', '', null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `skin`
-- ----------------------------
DROP TABLE IF EXISTS `skin`;
CREATE TABLE `skin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skin_name` char(200) DEFAULT NULL,
  `skin_file` char(20) DEFAULT NULL,
  `skin_info` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of skin
-- ----------------------------
INSERT INTO `skin` VALUES ('1', '红色双语', 'red', '默认模板');
INSERT INTO `skin` VALUES ('2', '蓝色中文', 'metinfo', '米特官方模板');
