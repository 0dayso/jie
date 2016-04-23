/*
SQLyog Ultimate v12.09 (32 bit)
MySQL - 5.5.37 : Database - jie
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`jie` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `jie`;

/*Table structure for table `j_chat` */

DROP TABLE IF EXISTS `j_chat`;

CREATE TABLE `j_chat` (
  `j_chatid` int(18) unsigned NOT NULL AUTO_INCREMENT COMMENT '聊天id',
  `j_userid` int(9) unsigned NOT NULL COMMENT '发布内容的人',
  `j_chattime` int(10) unsigned NOT NULL COMMENT '发布时间',
  `j_chatcontent` varchar(360) NOT NULL COMMENT '最多120字符的聊天内容',
  `j_touser` int(9) NOT NULL COMMENT '接受者的id',
  `j_read` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '该内容是否已经被用户读取',
  PRIMARY KEY (`j_chatid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `j_chat` */

/*Table structure for table `j_comment` */

DROP TABLE IF EXISTS `j_comment`;

CREATE TABLE `j_comment` (
  `j_commentid` int(9) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `j_commeenttype` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '评论类型1商品评论，2用户评论',
  `j_red` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已经被处理',
  `j_userid` int(9) unsigned NOT NULL DEFAULT '0' COMMENT '对应用户id',
  `j_goods` int(14) unsigned NOT NULL DEFAULT '0' COMMENT '对应商品编号',
  PRIMARY KEY (`j_commentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `j_comment` */

/*Table structure for table `j_goods` */

DROP TABLE IF EXISTS `j_goods`;

CREATE TABLE `j_goods` (
  `goodsid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `userid` int(9) unsigned NOT NULL COMMENT '发布者id',
  `goodsimg0` char(30) NOT NULL COMMENT '首张商品图片',
  `goodsimg1` char(30) DEFAULT NULL COMMENT '第二张商品图片',
  `goodsimg2` char(30) DEFAULT NULL COMMENT '第三张商品图片',
  `goodsimg3` char(30) DEFAULT NULL COMMENT '第四张商品图片',
  `goodsname` varchar(36) NOT NULL COMMENT '商品名称',
  `goodsdepict` varchar(230) NOT NULL COMMENT '商品描述',
  `goodsout` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否过期',
  `paytype` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '付费类型0为免费,1人民币,2积分',
  `paynum` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '付费数目',
  `goodstime` int(10) unsigned NOT NULL COMMENT '商品发布的时间',
  `commentnum` int(7) unsigned NOT NULL DEFAULT '0' COMMENT '商品被评论次数',
  `zannum` int(7) unsigned NOT NULL DEFAULT '0' COMMENT '商品被赞次数',
  `want` int(7) unsigned NOT NULL DEFAULT '0' COMMENT '想要',
  PRIMARY KEY (`goodsid`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Data for the table `j_goods` */

insert  into `j_goods`(`goodsid`,`userid`,`goodsimg0`,`goodsimg1`,`goodsimg2`,`goodsimg3`,`goodsname`,`goodsdepict`,`goodsout`,`paytype`,`paynum`,`goodstime`,`commentnum`,`zannum`,`want`) values (1,3,'3_0_160421092704_479.jpg',NULL,NULL,NULL,'背包','阿迪达斯背包',0,1,120,1461202025,0,0,0),(2,3,'3_0_160421092812_513.jpg','3_1_160421092812_839.jpg',NULL,NULL,'彩鱼','彩色热带鱼，彩色热带鱼，彩色热带鱼，',0,1,120,1461202092,0,0,0),(9,3,'3_0_160421093657_431.jpg',NULL,NULL,NULL,'钓鱼杆','钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼杆钓鱼',0,1,23,1461202617,0,0,0),(10,3,'3_0_160421093836_746.jpg','3_1_160421093836_254.jpg','3_2_160421093836_522.jpg','3_3_160421093836_372.jpg','多肉植物','多肉植物多肉植物多肉植物多肉植物多肉植物多肉植物多肉植物多肉植物多肉植物多肉植物多肉植物多肉植物多肉植物多肉植物多肉植物多肉植物多肉植物',0,1,45,1461202716,0,0,0),(11,3,'3_0_160421093954_352.jpg',NULL,NULL,NULL,'红米','红米红米红米2A',0,1,887,1461202794,0,0,0),(12,3,'3_0_160421094027_946.jpg',NULL,NULL,NULL,'护目镜','护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜护目镜',0,1,10,1461202828,0,0,0),(13,3,'3_0_160421094114_965.jpg',NULL,NULL,NULL,'魅族','魅族note，要不要，九成新',0,1,559,1461202874,0,0,0),(14,3,'3_0_160421094150_378.jpg','3_1_160421094150_252.jpg','3_2_160421094150_419.jpg',NULL,'盆栽','盆栽盆栽盆栽盆栽盆栽盆栽盆栽',0,1,32,1461202910,0,0,0),(15,3,'3_0_160421094237_501.jpg',NULL,NULL,NULL,'汽车','汽车汽车汽车汽车汽车汽车汽车汽车汽车',0,1,200000,1461202957,0,0,0),(16,3,'3_0_160421094316_335.jpg',NULL,NULL,NULL,'书','一本书，九成新，',0,1,54,1461202996,0,0,0),(17,3,'3_0_160421094334_825.jpg',NULL,NULL,NULL,'书','一本书，九成新，',0,0,0,1461203014,0,0,0),(18,3,'3_0_160421094356_376.jpg',NULL,NULL,NULL,'书','一本书，九成新，',0,1,8,1461203036,0,0,0),(19,3,'3_0_160421094430_529.jpg','3_1_160421094430_649.jpg','3_2_160421094430_693.jpg','3_3_160421094430_900.jpg','书架','书架书架书架书架书架书架书架书架书架书架书架书架书架书架书架书架书架书架书架书架书架',0,0,0,1461203071,0,0,0),(20,3,'3_0_160421094458_343.jpg',NULL,NULL,NULL,'兔子','可爱的小兔兔，可爱的小兔兔',0,0,0,1461203098,0,0,0),(21,3,'3_0_160421094520_280.jpg',NULL,NULL,NULL,'乌龟','乌龟乌龟乌龟乌龟乌龟',0,1,38,1461203120,0,0,0),(22,3,'3_0_160421094615_728.jpg',NULL,NULL,NULL,'鹦鹉','鹦鹉鹦鹉鹦鹉鹦鹉鹦鹉',0,1,1234,1461203175,0,0,0);

/*Table structure for table `j_goodsdiscuss` */

DROP TABLE IF EXISTS `j_goodsdiscuss`;

CREATE TABLE `j_goodsdiscuss` (
  `gdid` int(16) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品评论id',
  `goodsid` int(11) unsigned NOT NULL COMMENT '对应商品id',
  `gdtime` int(10) unsigned NOT NULL COMMENT '该评论发布时间',
  `touserid` int(9) unsigned NOT NULL DEFAULT '0' COMMENT '被回复的用户',
  `gdcontent` varchar(360) NOT NULL COMMENT '评论内容',
  `userid` int(9) NOT NULL COMMENT '发表评论用户id',
  PRIMARY KEY (`gdid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `j_goodsdiscuss` */

insert  into `j_goodsdiscuss`(`gdid`,`goodsid`,`gdtime`,`touserid`,`gdcontent`,`userid`) values (1,20,1461404273,0,'23333333333',4),(2,20,1461404347,0,'这些是评论的测试',4),(3,20,1461404361,0,'这些是评论的测试1',4),(4,20,1461404365,0,'这些是评论的测试2',4),(5,20,1461404370,0,'这些是评论的测试3',4),(6,20,1461404373,0,'这些是评论的测试5',4),(7,20,1461404382,0,'这些是评论的测试6',4),(8,20,1461419657,0,'添加的新的评论，看看是否会显示&lt;br/&gt;',4);

/*Table structure for table `j_notice` */

DROP TABLE IF EXISTS `j_notice`;

CREATE TABLE `j_notice` (
  `j_noticeid` int(14) unsigned NOT NULL AUTO_INCREMENT COMMENT '通知编号',
  `j_userid` int(9) unsigned NOT NULL COMMENT '被通知的用户',
  `j_notice` varchar(360) NOT NULL COMMENT '通知的内容',
  `j_red` tinyint(1) unsigned NOT NULL COMMENT '是否已经被处理',
  PRIMARY KEY (`j_noticeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `j_notice` */

/*Table structure for table `j_site` */

DROP TABLE IF EXISTS `j_site`;

CREATE TABLE `j_site` (
  `j_siteid` int(14) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `j_sitetime` int(10) unsigned NOT NULL COMMENT '统计时间',
  `j_sitereg` int(9) unsigned NOT NULL COMMENT '注册用户数目',
  `j_ business` int(14) unsigned NOT NULL DEFAULT '0' COMMENT '交易次数',
  `j_goodsnum` int(14) unsigned NOT NULL DEFAULT '0' COMMENT '商品数目',
  `j_allpoint` int(16) unsigned NOT NULL DEFAULT '0' COMMENT '总积分数目',
  `j_money` decimal(10,4) unsigned NOT NULL DEFAULT '0.0000' COMMENT '公共账户金额数目',
  PRIMARY KEY (`j_siteid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `j_site` */

/*Table structure for table `j_user` */

DROP TABLE IF EXISTS `j_user`;

CREATE TABLE `j_user` (
  `userid` int(9) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(36) NOT NULL COMMENT '用户真实姓名',
  `birthday` varchar(15) NOT NULL COMMENT '用户年龄',
  `userimg` varchar(12) NOT NULL DEFAULT '000000.jpg' COMMENT '用户头像',
  `gender` char(3) NOT NULL DEFAULT '女' COMMENT '用户性别',
  `email` varchar(32) NOT NULL COMMENT '用户的邮箱',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否激活',
  `time` char(10) NOT NULL COMMENT '注册时间',
  `qq` varchar(14) DEFAULT NULL COMMENT '用户QQ',
  `address` varchar(64) DEFAULT '黄家湖' COMMENT '用户地址',
  `tel` char(11) DEFAULT NULL COMMENT '手机号码',
  `password` char(32) NOT NULL COMMENT '用户密码',
  `point` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '用户积分',
  `notice` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '系统通知',
  `chat` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '聊天数目',
  `idaddress` varchar(36) NOT NULL COMMENT '用户身份证上的地址',
  `idcard` varchar(32) NOT NULL COMMENT '加密后的用户身份证号码',
  `logintime` int(10) NOT NULL DEFAULT '0' COMMENT '用户最后登录的时间',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `search_user` (`username`),
  UNIQUE KEY `idcard` (`idcard`),
  UNIQUE KEY `email` (`email`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `j_user` */

insert  into `j_user`(`userid`,`username`,`birthday`,`userimg`,`gender`,`email`,`active`,`time`,`qq`,`address`,`tel`,`password`,`point`,`notice`,`chat`,`idaddress`,`idcard`,`logintime`) values (3,'辛丙亮','1993-11-29','head.jpg','男','709464835@qq.com',0,'1460861551',NULL,'黄家湖',NULL,'00c3814d3cebb9eade510d8b705de750',0,0,0,'湖北省宜都市','5db1638ca75f6feb9c40839514744c19',1461395673),(4,'童森','1993-09-09','tong.jpg','男','383633250@qq.com',0,'1460879585',NULL,'黄家湖',NULL,'00c3814d3cebb9eade510d8b705de750',0,0,0,'武汉市新洲区','6477de12194407b5b4754ab53728bf82',1461399807),(5,'熊仁彬','1995-08-03','head.jpg','男','83235834@qq.com',0,'1460903371',NULL,'黄家湖',NULL,'a178aa7aa25908757b616d6dc222d650',0,0,0,'武汉市江夏区','7adeef82f2cbeee5e05dbb3a6fe30e90',0);

/*Table structure for table `j_userdiscuss` */

DROP TABLE IF EXISTS `j_userdiscuss`;

CREATE TABLE `j_userdiscuss` (
  `j_udid` int(14) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户口碑的id',
  `j_replyid` int(9) unsigned DEFAULT '0' COMMENT '被回复的评论',
  `j_beuserid` int(9) unsigned NOT NULL COMMENT '发布者',
  `j_udtime` int(10) unsigned NOT NULL COMMENT '被创建的时间',
  `j_udcontent` varchar(360) NOT NULL COMMENT '评论的内容',
  `j_start` int(3) unsigned NOT NULL COMMENT '星级',
  `j_begoods` int(14) unsigned NOT NULL COMMENT '对应的商品',
  PRIMARY KEY (`j_udid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `j_userdiscuss` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
