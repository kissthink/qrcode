/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : leipi_qrcode

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-07-19 22:24:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `leipi_qrcode`
-- ----------------------------
DROP TABLE IF EXISTS `leipi_qrcode`;
CREATE TABLE `leipi_qrcode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hash` char(32) NOT NULL DEFAULT '' COMMENT '二维码hash',
  `width` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `height` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `type` char(10) NOT NULL DEFAULT '',
  `logo` varchar(255) NOT NULL DEFAULT '' COMMENT '二维码logo',
  `content` text NOT NULL COMMENT '二维码内容',
  `file_path` varchar(255) NOT NULL DEFAULT '' COMMENT '生成后的二维码',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of leipi_qrcode
-- ----------------------------
