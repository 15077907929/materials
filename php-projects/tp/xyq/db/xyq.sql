/*
Navicat MySQL Data Transfer

Source Server         : virtual_linux
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : xyq

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-06-27 17:56:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `plugin_wish`
-- ----------------------------
DROP TABLE IF EXISTS `plugin_wish`;
CREATE TABLE `plugin_wish` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `bg_id` tinyint(4) NOT NULL DEFAULT '1',
  `sign_id` tinyint(4) NOT NULL DEFAULT '1',
  `ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of plugin_wish
-- ----------------------------
INSERT INTO `plugin_wish` VALUES ('1', '拼命三郎', '我是石秀，大家好，我来自南京', '7', '1', '192.168.174.1', '2019-06-27 02:05:00');
INSERT INTO `plugin_wish` VALUES ('2', '宋江', '我是呼保义，又称孝义黑三郎，及时雨，', '7', '1', '192.168.174.1', '2019-06-27 02:06:29');
INSERT INTO `plugin_wish` VALUES ('3', '佑恩', '小爱，你还在想我吗？我祝福你一切好！！', '7', '3', '192.168.174.1', '2019-06-27 02:15:24');
INSERT INTO `plugin_wish` VALUES ('4', 'mike', '测试的小纸条', '5', '6', '192.168.174.1', '2019-06-27 02:15:50');
INSERT INTO `plugin_wish` VALUES ('5', 'xuduo3', '今天星期四了，马上周日了，休息的时候去新华书店看看，找找软件项目，有不错的，可以尝试的做一下，积累经验，有一些项目设计的也不错，比自己做的，很很多，多练', '6', '1', '192.168.174.1', '2019-06-27 02:18:29');
INSERT INTO `plugin_wish` VALUES ('6', 'makes', '晚上公司聚会吃饭，去庐州太太', '4', '12', '192.168.174.1', '2019-06-27 02:19:46');
INSERT INTO `plugin_wish` VALUES ('7', 'mama', '希望工作顺利，越来越好', '8', '11', '192.168.174.1', '2019-06-27 02:21:30');
INSERT INTO `plugin_wish` VALUES ('8', '杨雄', '大闹翠屏山', '1', '7', '192.168.174.1', '2019-06-27 02:23:27');
INSERT INTO `plugin_wish` VALUES ('9', '史进', '九纹龙，我要去延安府找我的师傅', '2', '5', '192.168.174.1', '2019-06-27 02:24:19');
INSERT INTO `plugin_wish` VALUES ('10', '周武王', '武王伐纣', '3', '5', '192.168.174.1', '2019-06-27 02:30:58');
INSERT INTO `plugin_wish` VALUES ('11', 'papa', '老爸', '8', '9', '192.168.174.1', '2019-06-27 02:31:36');
INSERT INTO `plugin_wish` VALUES ('12', '奶奶', '奶奶，希望您身体健康，生活幸福，平平安安', '8', '10', '192.168.174.1', '2019-06-27 02:33:55');
INSERT INTO `plugin_wish` VALUES ('17', 'xxii', '马上要下班了', '6', '1', '192.168.174.1', '2019-06-27 05:53:38');
INSERT INTO `plugin_wish` VALUES ('18', '方奥林', '方奥林要离职了，要去上海，今天晚上部门聚餐，为他送行', '7', '1', '192.168.174.1', '2019-06-27 05:54:21');
INSERT INTO `plugin_wish` VALUES ('19', '反射光栅', '发生过哈儿', '5', '3', '192.168.174.1', '2019-06-27 06:04:43');
INSERT INTO `plugin_wish` VALUES ('20', '佑恩', '小爱，你还在想我吗？我祝福你一切好！！', '7', '1', '192.168.174.1', '2019-06-27 06:05:47');
INSERT INTO `plugin_wish` VALUES ('21', '孙悟空', '我爱吃桃子', '7', '4', '192.168.174.1', '2019-06-27 06:06:34');
INSERT INTO `plugin_wish` VALUES ('22', '八戒', '看我钉耙', '7', '1', '192.168.174.1', '2019-06-27 06:06:55');
