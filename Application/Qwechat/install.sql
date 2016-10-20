/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50712
 Source Host           : localhost
 Source Database       : pal_qwechat

 Target Server Type    : MySQL
 Target Server Version : 50712
 File Encoding         : utf-8

 Date: 10/18/2016 17:09:00 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `db_qwechat`
-- ----------------------------
DROP TABLE IF EXISTS `db_qwechat`;
CREATE TABLE `db_qwechat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL,
  `name` char(32) NOT NULL COMMENT '微信名称，用于识别企业多个微信',
  `allow_partys` text NOT NULL,
  `close` int(11) NOT NULL,
  `description` varchar(255) NOT NULL COMMENT '微信名称，用于识别企业多个微信',
  `redirect_domain` varchar(100) NOT NULL,
  `agentid` varchar(255) NOT NULL,
  `report_location_flag` tinyint(4) NOT NULL,
  `square_logo_url` varchar(255) NOT NULL,
  `round_logo_url` varchar(255) NOT NULL,
  `isreportuser` tinyint(4) NOT NULL,
  `allow_tags` text NOT NULL,
  `allow_userinfos` text NOT NULL,
  `isreportenter` tinyint(4) NOT NULL,
  `token` char(255) NOT NULL,
  `encodingaeskey` char(255) NOT NULL,
  `appid` char(255) NOT NULL,
  `appsecret` char(255) NOT NULL,
  `rootkey` char(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  `subscribe_rob` int(11) NOT NULL,
  `auto_rob` int(11) NOT NULL,
  `enter_agent_rob` int(11) NOT NULL,
  `tail` varchar(100) NOT NULL COMMENT '小尾巴',
  `wechat_rob` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `db_qwechat_department`
-- ----------------------------
DROP TABLE IF EXISTS `db_qwechat_department`;
CREATE TABLE `db_qwechat_department` (
  `department_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `name` char(32) NOT NULL COMMENT '微信名称，用于识别企业多个微信',
  `parentid` int(11) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `order` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `db_qwechat_member`
-- ----------------------------
DROP TABLE IF EXISTS `db_qwechat_member`;
CREATE TABLE `db_qwechat_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `aid` int(10) NOT NULL,
  `shopid` int(10) DEFAULT NULL,
  `userid` char(64) NOT NULL,
  `name` char(64) NOT NULL DEFAULT '' COMMENT '昵称',
  `department` text,
  `position` varchar(32) DEFAULT NULL,
  `mobile` char(15) NOT NULL COMMENT '用户手机',
  `gender` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '性别',
  `qq` char(32) NOT NULL,
  `email` char(32) NOT NULL COMMENT '用户邮箱',
  `weixinid` char(32) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '会员状态',
  `extattr` text NOT NULL,
  `nickname` varchar(30) NOT NULL COMMENT '用户名',
  `simple_name` varchar(30) NOT NULL COMMENT '用户简称',
  `marriage` tinyint(4) DEFAULT NULL,
  `idcard` varchar(18) DEFAULT NULL,
  `bankcard` varchar(25) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `birthday` varchar(10) DEFAULT NULL,
  `joinday` varchar(10) DEFAULT NULL,
  `join_from` tinyint(4) DEFAULT NULL,
  `leaveday` varchar(10) DEFAULT NULL,
  `leave_type` tinyint(4) DEFAULT NULL,
  `leave_why` varchar(100) DEFAULT NULL,
  `calendar` tinyint(4) DEFAULT '0' COMMENT '0阳历，1农历',
  `description` text,
  `province` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `district` int(11) NOT NULL,
  `community` int(11) NOT NULL,
  `address` varchar(20) DEFAULT NULL,
  `motto` varchar(32) DEFAULT NULL,
  `out_description` text,
  `can_aid` text,
  `Latitude` text NOT NULL,
  `Longitude` text NOT NULL,
  `Precision` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=352 DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
--  Table structure for `db_qwechat_menu`
-- ----------------------------
DROP TABLE IF EXISTS `db_qwechat_menu`;
CREATE TABLE `db_qwechat_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `pid` int(11) NOT NULL,
  `key` varchar(255) DEFAULT NULL,
  `linkurl` varchar(255) NOT NULL,
  `sort` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`) USING BTREE,
  KEY `sort` (`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='微信菜单';

-- ----------------------------
--  Table structure for `db_qwechat_notice`
-- ----------------------------
DROP TABLE IF EXISTS `db_qwechat_notice`;
CREATE TABLE `db_qwechat_notice` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `appid` int(11) NOT NULL,
  `AgentID` int(11) NOT NULL,
  `ToUserName` varchar(255) NOT NULL,
  `FromUserName` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `CreateTime` int(11) NOT NULL,
  `MsgType` text NOT NULL,
  `MsgId` int(11) NOT NULL,
  `Content` text NOT NULL,
  `PicUrl` varchar(255) NOT NULL,
  `MediaId` varchar(255) DEFAULT NULL,
  `Event` varchar(100) NOT NULL,
  `EventKey` varchar(100) NOT NULL,
  `status` tinyint(4) DEFAULT '0' COMMENT '0 未处理 1 无效 2.差评 3. 好评',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `db_qwechat_shop`
-- ----------------------------
DROP TABLE IF EXISTS `db_qwechat_shop`;
CREATE TABLE `db_qwechat_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL,
  `name` varchar(32) NOT NULL COMMENT '来自平台，1美团2饿了么3淘点点，4百度',
  `mobile` varchar(32) NOT NULL,
  `mobile_shopowner` varchar(32) NOT NULL,
  `qq` int(32) NOT NULL,
  `qq_shopowner` int(32) NOT NULL,
  `address` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '4',
  `mapstyle` tinyint(4) NOT NULL DEFAULT '4',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `coordinate` varchar(100) NOT NULL COMMENT '商品中心坐标',
  `department_id` int(11) NOT NULL,
  `shopowner` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `db_qwechat_site`
-- ----------------------------
DROP TABLE IF EXISTS `db_qwechat_site`;
CREATE TABLE `db_qwechat_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL,
  `name` varchar(32) NOT NULL COMMENT '来自平台，1美团2饿了么3淘点点，4百度',
  `mobile` varchar(32) NOT NULL,
  `qq` int(32) NOT NULL,
  `shopowner` varchar(32) DEFAULT NULL,
  `qq_shopowner` int(32) NOT NULL,
  `mobile_shopowner` varchar(32) NOT NULL,
  `logo` int(11) NOT NULL,
  `motto` varchar(32) NOT NULL,
  `address` varchar(100) NOT NULL,
  `coordinate` varchar(100) NOT NULL COMMENT '商品中心坐标',
  `hr` text NOT NULL,
  `pics` text NOT NULL,
  `about` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '4',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `view` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `db_qwechat_site_zhufu`
-- ----------------------------
DROP TABLE IF EXISTS `db_qwechat_site_zhufu`;
CREATE TABLE `db_qwechat_site_zhufu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `aid` int(10) DEFAULT NULL,
  `uid` int(10) NOT NULL,
  `name` char(32) DEFAULT '' COMMENT '昵称',
  `openid` char(32) DEFAULT '' COMMENT '昵称',
  `status` tinyint(4) DEFAULT '0' COMMENT '会员状态',
  `secret` tinyint(4) DEFAULT '0' COMMENT '会员状态',
  `content` text,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `hongbao` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 COMMENT='会员表';

SET FOREIGN_KEY_CHECKS = 1;
