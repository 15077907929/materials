/*
Navicat MySQL Data Transfer

Source Server         : virtual_linux
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : online

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-07-12 14:14:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pwd` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='//管理员信息表';

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'xuduo3', 'bd9399a5376b3509f81aecbe081e3e1f');

-- ----------------------------
-- Table structure for `question`
-- ----------------------------
DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` tinyint(3) unsigned NOT NULL COMMENT '//考题类别',
  `cate` tinyint(3) unsigned NOT NULL COMMENT '//考题类型',
  `score` tinyint(3) unsigned NOT NULL,
  `content` varchar(2000) COLLATE utf8_unicode_ci NOT NULL COMMENT '//考题内容',
  `answer` varchar(2000) COLLATE utf8_unicode_ci NOT NULL COMMENT '//考题答案',
  `correct_answer` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `small_cate` tinyint(3) unsigned NOT NULL COMMENT '//考题所属套题',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='//考题信息表';

-- ----------------------------
-- Records of question
-- ----------------------------
INSERT INTO `question` VALUES ('1', '1', '1', '3', 'The financial problem with the USPS is caused partly by_____.啊啊啊', 'A．its unbalanced budget.*B．its rigid management.*C．the cost for technical upgrading.*D．the withdrawal of bank support.', 'A', '1');
INSERT INTO `question` VALUES ('2', '1', '1', '2', 'According to Paragraph 2, the USPS fails to modernize itself due to_____.', 'A．the interference from interest groups.*B．the inadequate funding from Congress.*C．the shrinking demand for postal service.*D．the incompetence of postal unions.', 'B', '2');
INSERT INTO `question` VALUES ('3', '1', '1', '2', 'The long-standing complaint by the USPS and its unions can be addressed by_____.', 'A．removing its burden of retiree health care.*B．making more investment in new vehicles.*C．adopting a new rate-increase mechanism.*D．attracting more first-class mail users.', 'C', '3');
INSERT INTO `question` VALUES ('4', '1', '1', '2', 'In the last paragraph, the author seems to view legislators with_____.', 'A．respect.*B．tolerance.*C．discontent.*D．gratitude.', 'D', '3');
INSERT INTO `question` VALUES ('5', '1', '1', '2', 'Which of the following would be the best title for the text?', 'A．The USPS Starts to Miss Its Good Old Days*B．The Postal Service: Keep Away from My Cheese*C．The USPS: Chronic Illness Requires a Quick Cure*D．The Postal Service Needs More than a Band-Aid', 'B', '1');
INSERT INTO `question` VALUES ('6', '1', '2', '3', 'According to the Paragraphs 1 and 2, many young Americans cast doubts on _____. ', 'A．the justification of the news-filtering practice.*B．people\'s preference for social media platforms.*C．the administrations ability to handle information.*D．social media was a reliable source of news.', 'AB', '1');
INSERT INTO `question` VALUES ('7', '1', '2', '3', 'The phrase “beer up”(Line 2, Para.2) is closest in meaning to _____. ', 'A．sharpen*B．define*C．boast*D．share', 'CD', '2');
INSERT INTO `question` VALUES ('8', '1', '2', '3', 'According to the knight foundation survey, young people _____. ', 'A．tend to voice their opinions in cyberspace.*B．verify news by referring to diverse resources.*C．have s strong sense of responsibility.*D．like to exchange views on “distributed trust”', 'AC', '3');
INSERT INTO `question` VALUES ('9', '1', '2', '3', 'The Barna survey found that a main cause for the fake news problem is _____. ', 'A．readers outdated values.*B．journalists\' biased reporting*C．readers\' misinterpretation*D．journalists\' made-up stories.', 'BD', '4');
INSERT INTO `question` VALUES ('10', '1', '2', '3', 'Which of the following would be the best title for the text? ', 'A．A Rise in Critical Skills for Sharing News Online*B．A Counteraction Against the Over-tweeting Trend*C．The Accumulation of Mutual Trust on Social Media.*D．The Platforms for Projection of Personal Interests.', 'ABCD', '1');
INSERT INTO `question` VALUES ('11', '1', '3', '8', 'Who will be most threatened by automation?', '', '', '1');
INSERT INTO `question` VALUES ('12', '1', '3', '8', 'Which of the following best represent the author\'s view?', '', '', '2');
INSERT INTO `question` VALUES ('13', '1', '3', '8', 'Education in the age of automation should put more emphasis on_____.', '', '', '3');
INSERT INTO `question` VALUES ('14', '1', '3', '8', 'The author suggests that tax policies be aimed at_____.', '', '', '4');
INSERT INTO `question` VALUES ('15', '1', '3', '8', 'In this text, the author presents a problem with_____.', '', '', '1');
INSERT INTO `question` VALUES ('16', '1', '4', '12', 'Directions:Write an email to all international experts in your university, inviting them to attend a graduation ceremony. In this letter, you should state the time, place and other information about the ceremony. You should write neatly on the ANWSER SHEET.\r\n\r\nDo not sign you own name at the end of the letter, use “Li Ming ” instead.\r\n\r\nDo not write the address .', '', '', '2');
INSERT INTO `question` VALUES ('17', '1', '4', '15', 'Directions:Write an essay of 160-200 words based on the following pictures. In y essay, you should 1) describe the pictures briefly; 2) interpret the meaning, and 3) give your comments. You should write neatly on the ANSWER SHEET. ', '', '', '1');
INSERT INTO `question` VALUES ('20', '1', '4', '11', '今天是星期几AAAAAAAAAAA', 'A.星期一*B.星期二*C.星期三*D.星期四AAAAA', 'ABC', '3');

-- ----------------------------
-- Table structure for `subject`
-- ----------------------------
DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='//考题类别';

-- ----------------------------
-- Records of subject
-- ----------------------------
INSERT INTO `subject` VALUES ('1', '语文');
INSERT INTO `subject` VALUES ('2', '数学');
INSERT INTO `subject` VALUES ('3', '英语');
INSERT INTO `subject` VALUES ('8', '物理');
INSERT INTO `subject` VALUES ('9', '化学');
INSERT INTO `subject` VALUES ('10', '地理');
INSERT INTO `subject` VALUES ('11', '历史');
INSERT INTO `subject` VALUES ('12', '政治');
INSERT INTO `subject` VALUES ('13', '生物');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '//考生准考证号',
  `pass` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '//考生密码',
  `tel` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `score` smallint(6) unsigned NOT NULL COMMENT '//考试成绩',
  `subject` tinyint(3) unsigned NOT NULL COMMENT '//考题类别',
  `date` datetime NOT NULL COMMENT '//考试时间',
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '//考试状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='考生信息表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('6', '许多', '978449', '846483', '15077907929', '0', '0', '0000-00-00 00:00:00', '安徽省合肥市兴旺华府骏苑', '0');
INSERT INTO `user` VALUES ('8', '许多', '123456', '123456', '15077907929', '3', '1', '2019-05-08 17:34:49', '安徽省合肥市兴旺华府骏苑', '1');
INSERT INTO `user` VALUES ('9', 'jiajia', '302829', '367861', '15077907929', '0', '0', '0000-00-00 00:00:00', '安徽省合肥市兴旺华府骏苑', '0');
