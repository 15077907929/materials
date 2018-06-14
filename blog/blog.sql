/*
Navicat MySQL Data Transfer

Source Server         : virtual_linux
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-06-14 10:51:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_vietnamese_ci NOT NULL DEFAULT '' COMMENT '//文章标题',
  `tag` varchar(100) COLLATE utf8_vietnamese_ci NOT NULL DEFAULT '' COMMENT '//关键词',
  `description` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL DEFAULT '' COMMENT '//描述',
  `thumb` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL DEFAULT '' COMMENT '//缩略图',
  `content` text COLLATE utf8_vietnamese_ci NOT NULL COMMENT '//内容',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '//发布时间',
  `editor` varchar(50) COLLATE utf8_vietnamese_ci NOT NULL DEFAULT '' COMMENT '//文章作者',
  `view` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '//查看次数',
  `cate_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类',
  `no_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '//排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '//审核状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('1', '房地产楼市最新信息', '', '', '', '<p>房地产楼市最新信息</p>', '1520541764', '许多', '1', '31', '1', '0');
INSERT INTO `article` VALUES ('2', '啊啊', '', '', '', '<p>不不不<br/></p>', '1520541847', '', '1', '29', '2', '0');
INSERT INTO `article` VALUES ('3', '啊啊啊', '', '', '', '<p>不不不<br/></p>', '1520541877', '', '1', '30', '3', '0');
INSERT INTO `article` VALUES ('4', '啊啊', '', '', '', '<p>对对对<br/></p>', '1520542044', '', '2', '31', '4', '0');
INSERT INTO `article` VALUES ('5', '啊啊啊', '', '', '', '<p>啊啊啊<br/></p>', '1520542147', '', '3', '31', '5', '0');
INSERT INTO `article` VALUES ('6', '啊啊啊', '', '', '', '<p>啊啊啊<br/></p>', '1520542202', '许多', '4', '30', '6', '1');
INSERT INTO `article` VALUES ('7', '房地产楼市最新信息', '房地产楼市最新信息', '房地产楼市最新信息', '/uploads/thumb/20180308/205324403.jpg', '<p>房地产楼市最新信息</p>', '1520542494', '许多', '4', '2', '7', '0');
INSERT INTO `article` VALUES ('8', '房地产楼市最新信息', '房地产楼市最新信息', '房地产楼市最新信息', '/uploads/thumb/20180308/205517490.png', '<p>房地产楼市最新信息</p>', '1520542522', '许佳', '8', '31', '8', '0');
INSERT INTO `article` VALUES ('9', '火车站志愿者活动', '火车站志愿者活动', '火车站志愿者活动', '/uploads/thumb/20180308/205703886.jpg', '<p>火车站志愿者活动</p>', '1520542625', '许多', '2', '34', '9', '0');
INSERT INTO `article` VALUES ('10', '火车站志愿者活动2222', '火车站志愿者活动', '火车站志愿者活动', '/uploads/thumb/20180319/192652110.jpg', '<p>火车站志愿者活动</p><table><tbody><tr class=\"firstRow\"><td style=\"word-break: break-all;\" valign=\"top\" width=\"148\">afdf<br/></td><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td></tr><tr><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td></tr><tr><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td></tr><tr><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td></tr><tr><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td><td valign=\"top\" width=\"148\"><br/></td></tr></tbody></table><p><br/></p>', '1521021895', '许多', '2', '32', '10', '0');
INSERT INTO `article` VALUES ('11', '测试标题三十五', '房地产楼市最新信息', '格式', '/uploads/thumb/20180314/154042676.jpg', '<p>归属感<br/></p>', '1521042049', '许多', '2', '30', '0', '0');
INSERT INTO `article` VALUES ('12', '测试标题三十八', '火车站志愿者活动', '发蛋糕', '/uploads/thumb/20180314/154104199.jpg', '<p>规范刚发<br/></p>', '1521042071', '许佳', '2', '30', '0', '0');
INSERT INTO `article` VALUES ('13', '阿法第三方', '阿范德萨', '佛挡杀佛', '/uploads/thumb/20180315/011403441.jpg', '<p>防守打法<br/></p>', '1521076448', '许多', '3', '39', '0', '0');
INSERT INTO `article` VALUES ('14', '献血公益活动', '献血', '献血', '/uploads/thumb/20180319/134242450.jpg', '<p>打发第三方<br/></p>', '1521466972', '许多', '2', '35', '0', '0');
INSERT INTO `article` VALUES ('15', '娱乐圈花边新闻', '电子游戏机', '电子游戏机，文章的简要描述。。。。', '/uploads/thumb/20180319/181552801.jpg', '<p>娱乐圈花边新闻娱乐圈花边新闻娱乐圈花边新闻娱乐圈花边新闻娱乐圈花边新闻娱乐圈花边新闻娱乐圈花边新闻娱乐圈花边新闻娱乐圈花边新闻娱乐圈花边新<span style=\"color: rgb(198, 217, 240);\">闻娱乐圈花边新闻娱乐圈花边新闻娱乐圈花边新闻娱乐圈花边新闻娱乐圈花边新闻娱乐圈花边新闻娱乐圈花边新闻娱乐圈花</span>边新闻娱乐圈花边新闻娱乐圈花边新闻娱乐圈花边新闻娱乐圈花边新闻娱乐圈花边新闻</p>', '1521483405', '许多', '2', '31', '0', '0');
INSERT INTO `article` VALUES ('16', '西部山区贫困助学项目启动', '西部山区贫困助学项目启动', '西部山区贫困助学项目启动', '/uploads/thumb/20180319/194605493.jpg', '<p>西部山<span style=\"color: rgb(255, 0, 0);\"><strong>区贫困助学</strong></span>项目启动<img src=\"/uploads/ueditor/php/upload/image/20180320/1521488732392107.jpg\" title=\"1521488732392107.jpg\" alt=\"y.jpg\"/></p>', '1521488744', '许多', '2', '37', '0', '0');
INSERT INTO `article` VALUES ('17', '义务献血日', '义务献血日', '义务献血日', '/uploads/thumb/20180320/111441670.jpg', '<p>义务献血日</p>', '1521542443', '许多', '1', '35', '0', '0');
INSERT INTO `article` VALUES ('22', '东方闪电', '', '', '', '<p>发生的发生<br/></p>', '1521572532', '', '1', '2', '0', '0');
INSERT INTO `article` VALUES ('23', '发的方法', '', '', '', '<p>胜多负少<br/></p>', '1521572540', '', '2', '31', '0', '0');
INSERT INTO `article` VALUES ('24', '发', '', '', '', '<p>发送<br/></p>', '1521572551', '', '3', '39', '0', '0');
INSERT INTO `article` VALUES ('25', '给对方', '', '', '', '<p>不是大法官<br/></p>', '1521572567', '小李', '1', '2', '0', '0');
INSERT INTO `article` VALUES ('26', 'Aliquam lorem ante dapibus', 'Aliquam lorem ante dapibus', 'Clean Blog is a Free HTML-CSS Template provided by templatemo.com for everyone. Donec enim enim, imperdiet quis, mollis a, elementum a, diam. Lorem ipsum  dolor sit amet, consectetur adipiscing elit. Nulla et nunc commodo ante ornare imperdiet.', '/uploads/thumb/20180331/201943387.jpg', '<p>Clean Blog is a <a href=\"http://blog.hd/?id=1\" target=\"_parent\">Free HTML-CSS Template</a> provided by \r\n					<a href=\"http://blog.hd/?id=1#\">templatemo.com</a> \r\n					for everyone. Donec enim enim, imperdiet quis, mollis a, elementum a, diam. Lorem ipsum &nbsp;dolor sit amet, \r\n					consectetur adipiscing elit. Nulla et nunc commodo ante ornare imperdiet.</p>', '1522527210', 'Mike', '11', '41', '0', '0');
INSERT INTO `article` VALUES ('27', 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet', 'Credits go to Smashing Magazine for icons, Free photos for photos, and Serie3 for the slider. Ut nec vestibulum odio. Vivamus vitae nibh eu sem malesuada rutrum et sit amet magna. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridi', '/uploads/thumb/20180331/202256426.jpg', '<p>Credits go to <a href=\"http://blog.hd/?id=1\" target=\"_blank\">Smashing Magazine</a> for icons, \r\n					<a href=\"http://blog.hd/?id=1\" target=\"_blank\">Free photos</a> for photos, and <a href=\"http://blog.hd/?id=1\" target=\"_blank\">Serie3</a> for the slider. \r\n					Ut nec vestibulum odio. Vivamus vitae nibh eu sem malesuada rutrum et sit amet magna. \r\n					Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>', '1522527686', 'Jack', '46', '42', '0', '0');

-- ----------------------------
-- Table structure for `category`
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_vietnamese_ci NOT NULL DEFAULT '',
  `title` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL DEFAULT '',
  `keywords` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL DEFAULT '',
  `thumb` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `no_order` int(10) unsigned NOT NULL DEFAULT '0',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', '娱乐', '娱乐标题，发展娱乐', '娱乐关键词', '娱乐', '', '243', '1', '0', '0', '1');
INSERT INTO `category` VALUES ('2', '新闻', '新闻标题', '', '', '', '54', '2', '0', '0', '1');
INSERT INTO `category` VALUES ('29', '娱乐风向标', '娱乐风向标标题', '娱乐风向标关键字', '娱乐风向标描述', '/uploads/thumb/20180402/042925735.jpg', '0', '1', '1', '1520383194', '1');
INSERT INTO `category` VALUES ('30', '军事新闻', '军事新闻标题', '军事新闻关键字', '军事新闻描述', '/uploads/thumb/20180402/043010710.jpg', '0', '1', '2', '1520384035', '1');
INSERT INTO `category` VALUES ('31', '娱乐新闻', '娱乐新闻标题', '娱乐新闻关键字', '娱乐新闻描述\r\n', '/uploads/thumb/20180402/043018896.jpg', '0', '2', '2', '1520384060', '1');
INSERT INTO `category` VALUES ('32', '户外', '户外运动', '', '', '', '0', '3', '0', '1520426764', '1');
INSERT INTO `category` VALUES ('33', '爬山', '爬山，体验大自然', '', '', '/uploads/thumb/20180402/043029298.jpg', '0', '1', '32', '1520426794', '1');
INSERT INTO `category` VALUES ('34', '公益', '公益活动', '', '', '', '0', '4', '0', '1520426819', '1');
INSERT INTO `category` VALUES ('35', '献血', '献血，帮助他人', '', '', '/uploads/thumb/20180402/043448691.jpg', '0', '1', '34', '1520426851', '1');
INSERT INTO `category` VALUES ('36', '助残', '帮助残疾人', '', '', '/uploads/thumb/20180402/043506972.jpg', '0', '2', '34', '1520426867', '1');
INSERT INTO `category` VALUES ('37', '助学', '帮助贫困山区孩子，读书', '', '', '/uploads/thumb/20180402/043441469.jpg', '0', '3', '34', '1520426895', '1');
INSERT INTO `category` VALUES ('38', '敬老', '关爱老人', '关爱老人', '关爱老人', '/uploads/thumb/20180402/043435724.jpg', '0', '4', '34', '1520462926', '1');
INSERT INTO `category` VALUES ('39', '电子游戏', '电子游戏机', '电子游戏机', '电子游戏机', '/uploads/thumb/20180402/042951482.jpg', '0', '4', '1', '1521024224', '1');
INSERT INTO `category` VALUES ('40', '防守打法', '撒地方', '发的', '萨德', '/uploads/thumb/20180402/043002946.jpg', '0', '0', '2', '1521732664', '1');
INSERT INTO `category` VALUES ('41', 'Freebies', 'Freebies', 'Freebies', 'Freebies', '', '0', '5', '0', '1522527086', '1');
INSERT INTO `category` VALUES ('42', 'Web Design', 'Web Design', 'Web Design', 'Web Design', '', '0', '6', '0', '1522527106', '1');

-- ----------------------------
-- Table structure for `config`
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_vietnamese_ci DEFAULT '' COMMENT '//标题',
  `name` varchar(50) COLLATE utf8_vietnamese_ci DEFAULT '' COMMENT '//变量名',
  `content` text COLLATE utf8_vietnamese_ci COMMENT '//变量值',
  `no_order` int(10) unsigned DEFAULT '0' COMMENT '//排序',
  `tips` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT '' COMMENT '//描述',
  `field_type` varchar(50) COLLATE utf8_vietnamese_ci DEFAULT '' COMMENT '//字段类型',
  `field_value` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT '' COMMENT '//字段值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- ----------------------------
-- Records of config
-- ----------------------------
INSERT INTO `config` VALUES ('1', '网站标题', 'web_title', '后盾Blog系统', '1', '网站的标题', '1', '');
INSERT INTO `config` VALUES ('2', '统计代码', 'web_code', 'abcdefddd对对对dfdgffdf', '2', '网站的统计代码\r\n', '2', '');
INSERT INTO `config` VALUES ('3', '博客状态', 'web_status', '1', '3', '关闭/开启', '3', '0,1');
INSERT INTO `config` VALUES ('7', '版权', 'web_copyright', '版权所有', '4', '网站的版权\r\n', '2', '');
INSERT INTO `config` VALUES ('8', '辅助标题', 'seo_title', '后盾网 人人做后盾', '0', '对网站名称的说明\r\n', '1', '');
INSERT INTO `config` VALUES ('9', '关键词', 'keywords', '关键词', '0', '关键词', '1', '');
INSERT INTO `config` VALUES ('10', '描述', 'description', '描述', '0', '描述', '2', '');
INSERT INTO `config` VALUES ('11', '版权信息', 'copyright', 'Copyright © 2018 Your Company Name | Designed by xuduo | Validate XHTML & CSS', '0', '', '2', '');

-- ----------------------------
-- Table structure for `links`
-- ----------------------------
DROP TABLE IF EXISTS `links`;
CREATE TABLE `links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT '//名称',
  `title` varchar(100) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT '//标题',
  `url` varchar(200) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT '//链接',
  `no_order` int(10) unsigned DEFAULT '0' COMMENT '//排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- ----------------------------
-- Records of links
-- ----------------------------
INSERT INTO `links` VALUES ('1', '后盾网', '国内最大的,口碑最好的PHP培训机构', 'http://houdun.com', '1');
INSERT INTO `links` VALUES ('2', '后盾论坛', '人人做后盾', 'http://bbs.houdun.com', '2');
INSERT INTO `links` VALUES ('3', '测试连接名称', '测试连接标题', 'http://test.com', '3');

-- ----------------------------
-- Table structure for `navs`
-- ----------------------------
DROP TABLE IF EXISTS `navs`;
CREATE TABLE `navs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT '//名称',
  `title` varchar(100) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT '//标题',
  `url` varchar(200) COLLATE utf8_vietnamese_ci DEFAULT NULL COMMENT '//链接',
  `no_order` int(10) unsigned DEFAULT '0' COMMENT '//排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- ----------------------------
-- Records of navs
-- ----------------------------
INSERT INTO `navs` VALUES ('1', '首页', '国内最大的,口碑最好的PHP培训机构', '/?id=1', '1');
INSERT INTO `navs` VALUES ('2', '关于我', '人人做后盾', '/?id=2', '2');
INSERT INTO `navs` VALUES ('3', '慢生活', '测试连接标题1', '/?id=3', '3');
INSERT INTO `navs` VALUES ('8', '碎言碎语', '士大夫', '/cate?id=8', '4');
INSERT INTO `navs` VALUES ('9', '模板分享', '发蛋糕', '/art?id=9', '5');
INSERT INTO `navs` VALUES ('10', '联系我', '', '/conc?id=10', '6');
INSERT INTO `navs` VALUES ('11', '留言板', '', '/?id=11', '7');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) COLLATE utf8_vietnamese_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'xuduo3', 'eyJpdiI6IlplemF0ZHBzOUpxNXVhNlFJcVJORHc9PSIsInZhbHVlIjoiSThYOWtaTGd6a2w0V0Zvc0Z3aExudz09IiwibWFjIjoiMGM0ZDQ5YzE0MGM3ODE1NDM4ZjIwMzBmNzQxYzc2YzUzNjRjMTg0NjFlZjAyNzZhMTk2Yzc0ZjkwYjc2ODZiNCJ9', '0');
