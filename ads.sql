/*
SQLyog Trial v11.01 (32 bit)
MySQL - 5.7.14 : Database - ads
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `ads`;

/*Table structure for table `bank_add` */

DROP TABLE IF EXISTS `bank_add`;

CREATE TABLE `bank_add` (
  `ba_id` int(11) NOT NULL AUTO_INCREMENT,
  `ba_uid` int(11) DEFAULT NULL,
  `ba_type` int(11) DEFAULT NULL COMMENT '充值钱包类型',
  `ba_num` varchar(20) DEFAULT NULL COMMENT '充值数量',
  `ba_money` varchar(20) DEFAULT NULL COMMENT '充值金额',
  `ba_address` varchar(100) DEFAULT NULL COMMENT '充值地址',
  `ba_huilv` varchar(30) DEFAULT NULL COMMENT '汇率',
  `ba_code` int(11) DEFAULT NULL COMMENT '备注码',
  `ba_img_path` varchar(100) DEFAULT NULL COMMENT '截图地址',
  `ba_state` int(11) DEFAULT NULL COMMENT '订单状态',
  `ba_create_time` int(11) DEFAULT NULL,
  `ba_update_time` int(11) DEFAULT NULL,
  `ba_create_user` int(11) DEFAULT NULL,
  `ba_update_user` int(11) DEFAULT NULL,
  `ba_delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`ba_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `bank_add` */

LOCK TABLES `bank_add` WRITE;

insert  into `bank_add`(`ba_id`,`ba_uid`,`ba_type`,`ba_num`,`ba_money`,`ba_address`,`ba_huilv`,`ba_code`,`ba_img_path`,`ba_state`,`ba_create_time`,`ba_update_time`,`ba_create_user`,`ba_update_user`,`ba_delete_time`) values (1,1,1,'0.60512541','200','0xa46675ab6577c887edd56a7777c64c432bb','330.51',218460,'20180822\\bc0dbf0e0bcbde9e2e206e02c25b34f8.png',1,1534907159,1534907159,1,1,NULL),(2,1,2,'1','330.51','0xa46675ab6577c887edd56a7777c64c432bb','330.51',259191,'20180822\\d4a1de53d3797395517ac0d9680708fa.png',1,1534907480,1534907480,1,1,NULL);

UNLOCK TABLES;

/*Table structure for table `bank_give` */

DROP TABLE IF EXISTS `bank_give`;

CREATE TABLE `bank_give` (
  `bg_id` int(11) NOT NULL AUTO_INCREMENT,
  `bg_out_uid` int(11) DEFAULT NULL COMMENT '转出id',
  `bg_in_uid` int(11) DEFAULT NULL COMMENT '转入id',
  `bg_money` varchar(20) DEFAULT NULL COMMENT '金额',
  `bg_type` int(11) DEFAULT NULL COMMENT '转出钱包',
  `bg_create_time` int(11) DEFAULT NULL,
  `bg_update_time` int(11) DEFAULT NULL,
  `bg_create_user` int(11) DEFAULT NULL,
  `bg_update_user` int(11) DEFAULT NULL,
  `bg_delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`bg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `bank_give` */

LOCK TABLES `bank_give` WRITE;

insert  into `bank_give`(`bg_id`,`bg_out_uid`,`bg_in_uid`,`bg_money`,`bg_type`,`bg_create_time`,`bg_update_time`,`bg_create_user`,`bg_update_user`,`bg_delete_time`) values (1,1,2,'50',2,1534908626,1534908626,1,1,NULL);

UNLOCK TABLES;

/*Table structure for table `core_goods` */

DROP TABLE IF EXISTS `core_goods`;

CREATE TABLE `core_goods` (
  `cg_id` int(11) NOT NULL AUTO_INCREMENT,
  `cg_title` varchar(30) DEFAULT NULL COMMENT '基金名',
  `cg_money` int(11) DEFAULT NULL COMMENT '基金单价',
  `cg_day` int(11) DEFAULT NULL COMMENT '日利率',
  `cg_beishu` varchar(10) DEFAULT NULL COMMENT '复利倍数',
  `cg_img` varchar(100) DEFAULT NULL COMMENT '图片',
  `cg_create_time` int(11) NOT NULL DEFAULT '0',
  `cg_update_time` int(11) NOT NULL DEFAULT '0',
  `cg_create_user` int(11) NOT NULL DEFAULT '0',
  `cg_update_user` int(11) NOT NULL DEFAULT '0',
  `cg_delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`cg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `core_goods` */

LOCK TABLES `core_goods` WRITE;

insert  into `core_goods`(`cg_id`,`cg_title`,`cg_money`,`cg_day`,`cg_beishu`,`cg_img`,`cg_create_time`,`cg_update_time`,`cg_create_user`,`cg_update_user`,`cg_delete_time`) values (1,'量化交易',10000,8,'100','20180821\\0be16546ef62249f95cc4a1b6991f51a.png',0,1534837295,0,0,NULL),(2,'博彩套利',20000,15,'150','20180821\\ac1484449b143fdc79b9fe1257ec7f59.png',0,1534837291,0,0,NULL);

UNLOCK TABLES;

/*Table structure for table `core_order` */

DROP TABLE IF EXISTS `core_order`;

CREATE TABLE `core_order` (
  `co_id` int(11) NOT NULL AUTO_INCREMENT,
  `co_uid` int(11) NOT NULL DEFAULT '0',
  `co_cg_id` int(11) NOT NULL DEFAULT '0' COMMENT '基金名',
  `co_num` int(11) NOT NULL DEFAULT '0' COMMENT '购买数',
  `co_money` varchar(20) NOT NULL DEFAULT '0' COMMENT '购买金额',
  `co_count_money` varchar(20) NOT NULL DEFAULT '0' COMMENT '总计收益',
  `co_day_money` varchar(20) NOT NULL DEFAULT '0' COMMENT '昨日收益',
  `co_state` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `co_count_time` int(11) NOT NULL DEFAULT '0' COMMENT '结算时间',
  `co_bei_num` int(11) NOT NULL DEFAULT '0' COMMENT '翻了几番',
  `co_create_time` int(11) NOT NULL DEFAULT '0',
  `co_create_user` int(11) NOT NULL DEFAULT '0',
  `co_update_time` int(11) NOT NULL DEFAULT '0',
  `co_update_user` int(11) NOT NULL DEFAULT '0',
  `co_delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`co_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `core_order` */

LOCK TABLES `core_order` WRITE;

insert  into `core_order`(`co_id`,`co_uid`,`co_cg_id`,`co_num`,`co_money`,`co_count_money`,`co_day_money`,`co_state`,`co_count_time`,`co_bei_num`,`co_create_time`,`co_create_user`,`co_update_time`,`co_update_user`,`co_delete_time`) values (1,1,1,1,'100.00','0.08','0.08',3,1534908009,0,0,0,0,0,NULL),(2,2,1,1,'100.00','0','0',2,1534908062,0,1534908052,2,1534908052,2,NULL),(3,2,2,50,'10000.00','20037.5','37.5',1,1534908524,1,0,0,0,0,NULL);

UNLOCK TABLES;

/*Table structure for table `db_common_data` */

DROP TABLE IF EXISTS `db_common_data`;

CREATE TABLE `db_common_data` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `c_title` varchar(30) NOT NULL COMMENT '标码名称',
  `c_key` varchar(50) NOT NULL COMMENT '标码字段',
  `c_value` int(11) DEFAULT NULL COMMENT '标码值',
  `c_value_name` varchar(50) DEFAULT NULL COMMENT '标码值名称',
  `c_sort` int(11) DEFAULT NULL COMMENT '标码排序',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除标志',
  `update_user` int(11) DEFAULT NULL COMMENT '修改人',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `create_user` int(11) DEFAULT NULL COMMENT '创建人',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

/*Data for the table `db_common_data` */

LOCK TABLES `db_common_data` WRITE;

insert  into `db_common_data`(`c_id`,`c_title`,`c_key`,`c_value`,`c_value_name`,`c_sort`,`delete_time`,`update_user`,`update_time`,`create_user`,`create_time`) values (1,'公告级别','n_lev',1,'一般',1,NULL,0,1533194118,0,1533194118),(2,'公告级别','n_lev',2,'警告',2,NULL,0,1533194118,0,1533194118),(3,'公告级别','n_lev',3,'严重',3,NULL,0,1533194118,0,1533194118),(4,'留言类型','um_type',1,'献言献策',1,NULL,0,1533194118,0,1533194118),(5,'留言类型','um_type',2,'投诉意见',2,NULL,0,1533194118,0,1533194118),(6,'留言类型','um_type',3,'账号申诉',3,NULL,0,1533194118,0,1533194118),(7,'留言类型','um_type',4,'问题反馈',4,NULL,0,1533194118,0,1533194118),(8,'留言类型','um_type',5,'资金充值',5,NULL,0,1533194118,0,1533194118),(9,'留言类型','um_type',6,'客服咨询',6,NULL,0,1533194118,0,1533194118),(10,'留言类型','um_type',7,'合作',7,NULL,0,1533194118,0,1533194118),(11,'留言回复状态','um_state',1,'未回复',1,NULL,0,1533194118,0,1533194118),(12,'留言回复状态','um_state',2,'已回复',2,NULL,0,1533194118,0,1533194118),(13,'性别','sex',0,'保密',1,NULL,0,1533194118,0,1533194118),(14,'性别','sex',1,'男',2,NULL,0,1533194118,0,1533194118),(15,'性别','sex',2,'女',3,NULL,0,1533194118,0,1533194118),(16,'用户类型','v_type',1,'类型1',1,NULL,0,1533194118,0,1533194118),(17,'用户类型','v_type',2,'类型2',2,NULL,0,1533194118,0,1533194118),(18,'用户类型','v_type',3,'类型3',3,NULL,0,1533194118,0,1533194118),(19,'用户类型','v_type',4,'类型4',4,NULL,0,1533194118,0,1533194118),(20,'用户类型','v_type',5,'类型5',5,NULL,0,1533194118,0,1533194118),(21,'用户类型','v_type',6,'类型6',6,NULL,0,1533194118,0,1533194118),(22,'用户类型','v_type',7,'类型7',7,NULL,0,1533194118,0,1533194118);

UNLOCK TABLES;

/*Table structure for table `notice` */

DROP TABLE IF EXISTS `notice`;

CREATE TABLE `notice` (
  `n_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `n_code` varchar(30) DEFAULT NULL COMMENT '公告编号',
  `n_title` varchar(100) DEFAULT NULL COMMENT '公告标题',
  `n_desc` varchar(200) DEFAULT NULL COMMENT '公告描述',
  `n_content` text COMMENT '公告内容',
  `n_lev` int(11) DEFAULT NULL COMMENT '公告级别',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除标志',
  `update_user` int(11) DEFAULT NULL COMMENT '修改人',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `create_user` int(11) DEFAULT NULL COMMENT '创建人',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`n_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `notice` */

LOCK TABLES `notice` WRITE;

UNLOCK TABLES;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `user_id` varchar(30) DEFAULT NULL COMMENT '用户ID',
  `Password` varchar(50) DEFAULT NULL COMMENT '密码1',
  `Password2` varchar(50) DEFAULT NULL COMMENT '密码2',
  `user_name` varchar(30) DEFAULT NULL COMMENT '姓名',
  `user_tel` varchar(50) DEFAULT NULL COMMENT '联系方式',
  `user_email` varchar(100) DEFAULT NULL COMMENT '邮箱地址',
  `role_code` varchar(10) DEFAULT NULL COMMENT '角色编号',
  `last_login_session_id` varchar(100) DEFAULT NULL COMMENT '最后登录sessionID',
  `u_remark` varchar(500) DEFAULT NULL COMMENT '备注',
  `enable_flag` tinyint(1) DEFAULT NULL COMMENT '启用标志',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除标志',
  `update_user` int(11) DEFAULT NULL COMMENT '修改人',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `create_user` int(11) DEFAULT NULL COMMENT '创建人',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user` */

LOCK TABLES `user` WRITE;

insert  into `user`(`u_id`,`user_id`,`Password`,`Password2`,`user_name`,`user_tel`,`user_email`,`role_code`,`last_login_session_id`,`u_remark`,`enable_flag`,`delete_time`,`update_user`,`update_time`,`create_user`,`create_time`) values (1,'admin','111111','111111','admin','1111111','111@qqq.com','1','i3pr33iv4k655htr0il2nblul4','admin',1,NULL,1,1534832026,NULL,1533306068),(2,'user','222222','111111','user','11111111','11@qq.com','1','m8ko8vnb3pegq026ut0fb6tof2','user',1,1534923350,1,1534923350,1,1533306252),(3,'版主','1qqqqqq','qqq1qqqssxc','版主','1111111','11@qq.co','1',NULL,'aaaaa',1,NULL,1,1534918852,1,1533376284),(4,'888888','666666q','666666c','888888','13333333333','','1',NULL,'',1,NULL,1,1534831974,1,1534831969),(5,'user2','111111a','111111q','1111','13333333333','','1',NULL,'',1,NULL,1,1534918790,1,1534918781);

UNLOCK TABLES;

/*Table structure for table `user_bank` */

DROP TABLE IF EXISTS `user_bank`;

CREATE TABLE `user_bank` (
  `ub_id` int(11) NOT NULL AUTO_INCREMENT,
  `ub_uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `ub_money` varchar(30) DEFAULT NULL COMMENT '操作金额',
  `ub_msg` varchar(100) DEFAULT NULL COMMENT '操作留言',
  `ub_type` int(11) NOT NULL DEFAULT '0' COMMENT '操作类型',
  `ub_state` int(11) NOT NULL DEFAULT '0' COMMENT '资金到账状态',
  `ub_create_time` int(11) NOT NULL DEFAULT '0',
  `ub_create_user` int(11) NOT NULL DEFAULT '0',
  `ub_update_time` int(11) NOT NULL DEFAULT '0',
  `ub_update_user` int(11) NOT NULL DEFAULT '0',
  `ub_delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`ub_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_bank` */

LOCK TABLES `user_bank` WRITE;

insert  into `user_bank`(`ub_id`,`ub_uid`,`ub_money`,`ub_msg`,`ub_type`,`ub_state`,`ub_create_time`,`ub_create_user`,`ub_update_time`,`ub_update_user`,`ub_delete_time`) values (1,1,'-100.00','',4,1,1534907609,1,1534907609,1,NULL),(2,1,'0.08','',3,1,1534908009,1,1534908009,1,NULL),(3,2,'10000','系统操作',1,1,1534908212,2,1534908212,2,NULL),(4,2,'-10000.00','',4,1,1534908256,2,1534908256,2,NULL),(5,2,'15','',3,1,1534908368,2,1534908368,2,NULL),(6,1,'0.075','',2,1,1534908368,2,1534908368,1,NULL),(7,2,'15','',3,1,1534908438,2,1534908438,2,NULL),(8,1,'0.075','',2,1,1534908438,2,1534908438,1,NULL),(9,2,'37.5','',3,1,1534908524,2,1534908524,2,NULL),(10,1,'0.1875','',2,1,1534908524,2,1534908524,1,NULL),(11,1,'-100','aaaaaa',5,1,1534908804,0,1534908804,0,NULL);

UNLOCK TABLES;

/*Table structure for table `user_module` */

DROP TABLE IF EXISTS `user_module`;

CREATE TABLE `user_module` (
  `um_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `module_code` varchar(6) DEFAULT NULL COMMENT '模块编号',
  `module_name` varchar(10) DEFAULT NULL COMMENT '模块名称',
  `module_disp_seq` int(11) DEFAULT NULL COMMENT '模块显示顺序',
  `function_code` varchar(10) DEFAULT NULL COMMENT '功能编号',
  `function_name` varchar(30) DEFAULT NULL COMMENT '功能名称',
  `function_disp_seq` int(11) DEFAULT NULL COMMENT '功能显示顺序',
  `function_url` varchar(200) DEFAULT NULL COMMENT '功能链接',
  `module_type` varchar(2) DEFAULT NULL COMMENT '模块分类',
  `um_remark` varchar(200) DEFAULT NULL COMMENT '备注',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除标志',
  `update_user` int(11) DEFAULT NULL COMMENT '修改人',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `create_user` int(11) DEFAULT NULL COMMENT '创建人',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`um_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_module` */

LOCK TABLES `user_module` WRITE;

insert  into `user_module`(`um_id`,`module_code`,`module_name`,`module_disp_seq`,`function_code`,`function_name`,`function_disp_seq`,`function_url`,`module_type`,`um_remark`,`delete_time`,`update_user`,`update_time`,`create_user`,`create_time`) values (1,'1','新闻信息管理',1,'1','系统公告管理',1,'Notice/list','1',NULL,1533194118,1,1533194118,1,1533194118),(2,'1','新闻信息管理',1,'2','系统留言管理',2,'Usermsg/list','1',NULL,NULL,1,1533194118,1,1533194118),(3,'2','权限管理',5,'3','角色管理',1,'User/modulelist','2',NULL,NULL,1,1533194118,1,1533194118),(4,'2','权限管理',5,'4','用户信息管理',2,'User/adminuser','2',NULL,NULL,1,1533194118,1,1533194118),(5,'2','权限管理',5,'5','修改用户密码',3,'User/changepwd','2',NULL,NULL,1,1533194118,1,1533194118),(6,'3','会员管理',3,'6','添加新会员',1,'User/add','3',NULL,NULL,1,1533194118,1,1533194118),(7,'3','会员管理',3,'7','会员信息管理',2,'User/list','3',NULL,NULL,1,1533194118,1,1533194118),(8,'4','系统管理',6,'8','系统参数设置',1,'System/sys','4',NULL,NULL,1,1533194118,1,1533194118),(9,'4','系统管理',6,'9','奖金参数设置',2,'System/rule','4',NULL,1533194118,1,1533194118,1,1533194118),(10,'4','系统管理',6,'10','收款账号管理',3,'System/pay','4',NULL,1533194118,1,1533194118,1,1533194118),(11,'4','系统管理',6,'11','清空数据',4,'System/clear','4',NULL,NULL,1,1533194118,1,1533194118),(12,'5','团队管理',4,'12','会员团队网络',1,'User/usertree','5',NULL,NULL,1,1533194118,1,1533194118),(13,'3','会员管理',3,'13','充值',3,'Bank/add','3',NULL,NULL,1,1533194118,1,1533194118),(14,'3','会员管理',3,'14','钱包扣除',4,'Bank/cut','3',NULL,1533194118,1,1533194118,1,1533194118),(15,'6','财务管理',2,'15','证券管理',1,'Core/goods','6',NULL,NULL,1,1533194118,1,1533194118),(16,'6','财务管理',2,'16','交易列表',2,'Core/list','6',NULL,NULL,1,1533194118,1,1533194118),(17,'6','财务管理',2,'17','充值申请列表',3,'Bank/applyin','6',NULL,NULL,1,1533194118,1,1533194118),(18,'6','财务管理',2,'18','提现申请列表',4,'Bank/applyout','6',NULL,NULL,1,1533194118,1,1533194118),(19,'6','财务管理',2,'19','会员财务明细',5,'Core/jiaoyi','6',NULL,NULL,NULL,NULL,NULL,NULL);

UNLOCK TABLES;

/*Table structure for table `user_msg` */

DROP TABLE IF EXISTS `user_msg`;

CREATE TABLE `user_msg` (
  `um_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `um_code` varchar(30) NOT NULL COMMENT '留言编号',
  `um_title` varchar(100) NOT NULL COMMENT '留言标题',
  `um_content` varchar(500) DEFAULT NULL COMMENT '留言内容',
  `um_type` int(11) DEFAULT NULL COMMENT '留言类型',
  `um_state` int(11) DEFAULT NULL COMMENT '留言状态',
  `um_desc` varchar(200) DEFAULT NULL COMMENT '留言描述',
  `um_uid` int(11) DEFAULT NULL COMMENT '留言用户',
  `um_file` varchar(100) DEFAULT NULL COMMENT '附件地址',
  `um_re_time` int(11) DEFAULT NULL COMMENT '回复时间',
  `um_re_uid` int(11) DEFAULT NULL COMMENT '回复人',
  `um_re_state` int(11) DEFAULT NULL COMMENT '回复状态',
  `um_re_content` varchar(500) DEFAULT NULL COMMENT '回复内容',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除标志',
  `update_user` int(11) DEFAULT NULL COMMENT '修改人',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  `create_user` int(11) DEFAULT NULL COMMENT '创建人',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`um_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_msg` */

LOCK TABLES `user_msg` WRITE;

insert  into `user_msg`(`um_id`,`um_code`,`um_title`,`um_content`,`um_type`,`um_state`,`um_desc`,`um_uid`,`um_file`,`um_re_time`,`um_re_uid`,`um_re_state`,`um_re_content`,`delete_time`,`update_user`,`update_time`,`create_user`,`create_time`) values (1,'','sss','11111',4,2,'1111',1,'20180822\\2930493f2be1fb9d56fb5506c7325195.png',1534908765,1,NULL,'去死吧你',NULL,1,1534908741,1,1534908741);

UNLOCK TABLES;

/*Table structure for table `user_phone_code` */

DROP TABLE IF EXISTS `user_phone_code`;

CREATE TABLE `user_phone_code` (
  `upc_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `upc_phone` char(11) DEFAULT NULL,
  `upc_code` char(6) DEFAULT NULL,
  `upc_begin_time` int(11) DEFAULT NULL,
  `upc_end_time` int(11) DEFAULT NULL,
  `upc_create_time` int(11) DEFAULT NULL,
  `upc_update_time` int(11) DEFAULT NULL,
  `upc_delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`upc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_phone_code` */

LOCK TABLES `user_phone_code` WRITE;

insert  into `user_phone_code`(`upc_id`,`upc_phone`,`upc_code`,`upc_begin_time`,`upc_end_time`,`upc_create_time`,`upc_update_time`,`upc_delete_time`) values (1,'13777777777','836358',1534907255,1534907855,1534907255,1534907255,NULL),(2,'13266666666','846273',1534920339,1534920939,1534920339,1534920339,NULL),(3,'13888888888','895959',1534922718,1534923318,1534922718,1534922718,NULL);

UNLOCK TABLES;

/*Table structure for table `user_role` */

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role` (
  `ur_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `role_code` varchar(20) DEFAULT NULL COMMENT '角色编号',
  `role_name` varchar(20) DEFAULT NULL COMMENT '角色名称',
  `ur_remark` varchar(500) DEFAULT NULL COMMENT '备注',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除标志',
  `update_user` int(11) DEFAULT NULL COMMENT '修改人',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `create_user` int(11) DEFAULT NULL COMMENT '创建人',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`ur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_role` */

LOCK TABLES `user_role` WRITE;

insert  into `user_role`(`ur_id`,`role_code`,`role_name`,`ur_remark`,`delete_time`,`update_user`,`update_time`,`create_user`,`create_time`) values (1,'R1534918699000001','超级管理员','超级管理员',NULL,1,1534918713,1,1534918713);

UNLOCK TABLES;

/*Table structure for table `user_role_function` */

DROP TABLE IF EXISTS `user_role_function`;

CREATE TABLE `user_role_function` (
  `urf_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `role_code` varchar(20) DEFAULT NULL COMMENT '角色编号',
  `function_code` varchar(10) DEFAULT NULL COMMENT '功能编号',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除标志',
  `update_user` int(11) DEFAULT NULL COMMENT '修改人',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `create_user` int(11) DEFAULT NULL COMMENT '创建人',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`urf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_role_function` */

LOCK TABLES `user_role_function` WRITE;

insert  into `user_role_function`(`urf_id`,`role_code`,`function_code`,`delete_time`,`update_user`,`update_time`,`create_user`,`create_time`) values (1,'1','1',NULL,NULL,1534918713,NULL,1534918713),(2,'1','2',NULL,NULL,1534918713,NULL,1534918713),(3,'1','6',NULL,NULL,1534918713,NULL,1534918713),(4,'1','7',NULL,NULL,1534918713,NULL,1534918713),(5,'1','13',NULL,NULL,1534918713,NULL,1534918713),(6,'1','3',NULL,NULL,1534918713,NULL,1534918713),(7,'1','4',NULL,NULL,1534918713,NULL,1534918713),(8,'1','5',NULL,NULL,1534918713,NULL,1534918713),(9,'1','15',NULL,NULL,1534918713,NULL,1534918713),(10,'1','16',NULL,NULL,1534918713,NULL,1534918713),(11,'1','17',NULL,NULL,1534918713,NULL,1534918713),(12,'1','18',NULL,NULL,1534918713,NULL,1534918713),(13,'1','12',NULL,NULL,1534918713,NULL,1534918713),(14,'1','8',NULL,NULL,1534918713,NULL,1534918713),(15,'1','11',NULL,NULL,1534918713,NULL,1534918713);

UNLOCK TABLES;

/*Table structure for table `vip_user` */

DROP TABLE IF EXISTS `vip_user`;

CREATE TABLE `vip_user` (
  `v_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `v_vip_id` varchar(30) NOT NULL COMMENT '会员名',
  `v_pwd1` varchar(50) DEFAULT NULL COMMENT '密码1',
  `v_pwd2` varchar(50) DEFAULT NULL COMMENT '密码2',
  `v_name` varchar(30) DEFAULT NULL COMMENT '真实姓名',
  `v_tel` varchar(50) DEFAULT NULL COMMENT '手机号码',
  `v_email` varchar(100) DEFAULT NULL COMMENT '邮箱地址',
  `v_type` int(11) DEFAULT NULL COMMENT '会员类型',
  `v_session_id` varchar(100) DEFAULT NULL COMMENT '最后登录sessionID',
  `v_recomm_code` varchar(20) DEFAULT NULL COMMENT '推荐码',
  `v_re_recomm_code` varchar(20) DEFAULT NULL COMMENT '推荐人推荐码',
  `v_sex` tinyint(2) DEFAULT NULL COMMENT '性别',
  `v_card_id` varchar(18) DEFAULT NULL COMMENT '身份证号',
  `v_qq` varchar(10) DEFAULT NULL COMMENT 'QQ',
  `v_wechat` varchar(50) DEFAULT NULL COMMENT '微信',
  `v_alipay` varchar(50) DEFAULT NULL COMMENT '支付宝',
  `v_bank` varchar(20) DEFAULT NULL COMMENT '开户行',
  `v_bank_name` varchar(20) DEFAULT NULL COMMENT '开户名',
  `v_card_num` varchar(30) DEFAULT NULL COMMENT '银行卡号',
  `v_bank_address` varchar(100) DEFAULT NULL COMMENT '开户行地址',
  `v_address` varchar(100) DEFAULT NULL COMMENT '收货地址',
  `v_money1` varchar(20) DEFAULT '0' COMMENT '静态钱包余额',
  `v_money2` varchar(20) DEFAULT '0' COMMENT '动态钱包余额',
  `v_que1` varchar(50) DEFAULT NULL COMMENT '密保问题1',
  `v_an1` varchar(100) DEFAULT NULL COMMENT '问题1答案',
  `v_que2` varchar(50) DEFAULT NULL COMMENT '密保问题2',
  `v_an2` varchar(100) DEFAULT NULL COMMENT '问题2答案',
  `v_header` varchar(100) DEFAULT NULL COMMENT '头像',
  `v_share_path` varchar(100) DEFAULT NULL COMMENT '推广链接',
  `v_regin_ip` varchar(50) DEFAULT NULL COMMENT '注册ip',
  `v_login_ip` varchar(50) DEFAULT NULL COMMENT '登录ip',
  `v_remark` varchar(500) DEFAULT NULL COMMENT '备注',
  `enable_flag` tinyint(2) DEFAULT '0' COMMENT '启用标志',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除标志',
  `update_user` int(11) DEFAULT '0' COMMENT '修改人',
  `update_time` int(11) DEFAULT '0' COMMENT '修改时间',
  `create_user` int(11) DEFAULT '0' COMMENT '创建人',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`v_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `vip_user` */

LOCK TABLES `vip_user` WRITE;

insert  into `vip_user`(`v_id`,`v_vip_id`,`v_pwd1`,`v_pwd2`,`v_name`,`v_tel`,`v_email`,`v_type`,`v_session_id`,`v_recomm_code`,`v_re_recomm_code`,`v_sex`,`v_card_id`,`v_qq`,`v_wechat`,`v_alipay`,`v_bank`,`v_bank_name`,`v_card_num`,`v_bank_address`,`v_address`,`v_money1`,`v_money2`,`v_que1`,`v_an1`,`v_que2`,`v_an2`,`v_header`,`v_share_path`,`v_regin_ip`,`v_login_ip`,`v_remark`,`enable_flag`,`delete_time`,`update_user`,`update_time`,`create_user`,`create_time`) values (1,'user','333333q','111111q','张三','13888888888','a1@a.com',1,NULL,'Fp5YX7','#',0,'','','','','','','','','','0','80.92750000000001',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,1534922733,NULL,1534907007),(3,'qqq','111111a','222222q','aaaa','13266666666','a3@a.com',1,NULL,'Jnsg3f','Fp5YX7',1,'','','','aaaaa','','','','','','0','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1534923787,0,1534923787,0,1534920367);

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
