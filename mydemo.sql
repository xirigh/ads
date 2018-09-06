# Host: localhost  (Version: 5.5.53)
# Date: 2018-08-04 13:33:47
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "db_common_data"
#

DROP TABLE IF EXISTS `db_common_data`;
CREATE TABLE `db_common_data` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `c_title` varchar(30) NOT NULL COMMENT '标码名称',
  `c_key` varchar(50) NOT NULL COMMENT '标码字段',
  `c_value` int(11) DEFAULT NULL COMMENT '标码值',
  `c_value_name` varchar(50) DEFAULT NULL COMMENT '标码值名称',
  `c_sort` int(11) DEFAULT NULL COMMENT '标码排序',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除标志',
  `update_user` int(11) NOT NULL COMMENT '修改人',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  `create_user` int(11) NOT NULL COMMENT '创建人',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

#
# Data for table "db_common_data"
#

INSERT INTO `db_common_data` VALUES (1,'公告级别','n_lev',1,'一般',1,NULL,0,0,0,0),(2,'公告级别','n_lev',2,'警告',2,NULL,0,0,0,0),(3,'公告级别','n_lev',3,'严重',3,NULL,0,0,0,0),(4,'留言类型','um_type',1,'类型1',1,NULL,0,0,0,0),(5,'留言类型','um_type',2,'类型2',2,NULL,0,0,0,0),(6,'留言类型','um_type',3,'类型3',3,NULL,0,0,0,0),(7,'留言类型','um_type',4,'类型4',4,NULL,0,0,0,0),(8,'留言类型','um_type',5,'类型5',5,NULL,0,0,0,0),(9,'留言类型','um_type',6,'类型6',6,NULL,0,0,0,0),(10,'留言类型','um_type',7,'类型7',7,NULL,0,0,0,0),(11,'留言回复状态','um_state',1,'未回复',1,NULL,0,0,0,0),(12,'留言回复状态','um_state',2,'已回复',2,NULL,0,0,0,0);

#
# Structure for table "notice"
#

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

#
# Data for table "notice"
#

INSERT INTO `notice` VALUES (1,'20180730102811826525','aaa','sss','<p>是是是<br></p>',1,NULL,NULL,NULL,NULL,NULL),(3,'20180730102830999615','aaa','sss','<p>是是是<br></p>',1,NULL,NULL,1532917794,NULL,1532917794),(4,'20180730102956915679','aaa','sss',' <p>啊啊<img style=\"width: 144px;\" src=\"/uploads/notice/20180731\\4efd0856a84ae72024292547926ac798.png\"><br></p> ',1,NULL,NULL,1532917840,NULL,1532917840),(5,NULL,'aaa','sss','   <p>是是是<br></p>   ',1,1532937921,NULL,1532931181,NULL,1532931181),(7,'20180730143306362161','qqq','qqqq',' <p>qqqq<br></p> ',2,NULL,NULL,1532932391,NULL,1532932391),(8,NULL,'aaa','sss',' <p>是是是sss<br></p> ',2,1532937921,NULL,1532937921,NULL,1532932498);

#
# Structure for table "user"
#

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

#
# Data for table "user"
#

INSERT INTO `user` VALUES (1,'111','111111q','111111d','111','1111111','111@qqq.com','4',NULL,'aaa',0,NULL,NULL,1533306068,NULL,1533306068),(2,'222','222222q','222222ss','222','11111111','11@qq.com','3',NULL,'11111',0,NULL,NULL,1533306252,NULL,1533306252);

#
# Structure for table "user_module"
#

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

#
# Data for table "user_module"
#

INSERT INTO `user_module` VALUES (1,'1','通知留言管理',1,'1','系统通知',1,'Notice/list','1',NULL,NULL,NULL,NULL,NULL,NULL),(2,'1','通知留言管理',1,'2','用户留言',2,'Usermsg/list','1',NULL,NULL,NULL,NULL,NULL,NULL),(3,'2','权限管理',3,'3','角色管理',1,'User/modulelist','2',NULL,NULL,NULL,NULL,NULL,NULL),(4,'2','权限管理',3,'4','用户管理',2,'User/adminuser','2',NULL,NULL,NULL,NULL,NULL,NULL),(5,'2','权限管理',3,'5','用户密码修改',3,'User/changepwd','2',NULL,NULL,NULL,NULL,NULL,NULL),(6,'3','会员管理',2,'6','添加新会员',1,'User/add','3',NULL,NULL,NULL,NULL,NULL,NULL),(7,'3','会员管理',2,'7','会员信息管理',2,'User/list','3',NULL,NULL,NULL,NULL,NULL,NULL),(8,'4','系统设置',4,'8','奖金参数设置',1,'System/rule','4',NULL,NULL,NULL,NULL,NULL,NULL),(9,'4','系统设置',4,'9','系统参数设置',2,'System/sys','4',NULL,NULL,NULL,NULL,NULL,NULL),(10,'4','系统设置',4,'10','支付账号设置',3,'System/pay','4',NULL,NULL,NULL,NULL,NULL,NULL),(11,'4','系统设置',4,'11','清空数据',4,'System/clear','4',NULL,NULL,NULL,NULL,NULL,NULL);

#
# Structure for table "user_msg"
#

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

#
# Data for table "user_msg"
#

INSERT INTO `user_msg` VALUES (1,'www','sss','是是是',1,2,'qqq',1,NULL,1533019879,1,NULL,'sss',NULL,NULL,1533004293,NULL,1533004293),(2,'22','222','22222',1,1,'222',1,'20180731\\7c64689d542b721b9995324707170c6c.png',NULL,NULL,NULL,NULL,NULL,NULL,1533004359,NULL,1533004359),(3,'333','333','333',1,1,'333',1,'20180731\\34f71646f3a5c645b0dbb0027b101753.png',NULL,NULL,NULL,NULL,NULL,1,1533004430,1,1533004430),(4,'444','444','4444',1,1,'444',1,'20180731\\60c6110d5b572bebfb9f080c46332db6.png',NULL,NULL,NULL,NULL,NULL,1,1533004468,1,1533004468);

#
# Structure for table "user_role"
#

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

#
# Data for table "user_role"
#

INSERT INTO `user_role` VALUES (1,'R153319353','杀杀杀www','杀杀杀www',1533255635,NULL,1533255635,NULL,1533193572),(2,'R153319362','aaa','aaaa',1533255530,NULL,1533255530,NULL,1533193643),(3,'R1533193828000002','333','333',NULL,NULL,1533254579,NULL,1533193835),(4,'R1533194010000003','444','444',NULL,NULL,1533254433,NULL,NULL),(5,'R1533194108000004','555','55',NULL,NULL,1533253724,NULL,1533194118);

#
# Structure for table "user_role_function"
#

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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;

#
# Data for table "user_role_function"
#

INSERT INTO `user_role_function` VALUES (1,'1','1',1533253784,NULL,1533253784,NULL,NULL),(2,'1','2',1533253784,NULL,1533253784,NULL,NULL),(3,'1','1',1533253784,NULL,1533253784,NULL,NULL),(4,'1','2',1533253784,NULL,1533253784,NULL,NULL),(5,'1','3',1533253784,NULL,1533253784,NULL,NULL),(6,'1','4',1533253784,NULL,1533253784,NULL,NULL),(7,'1','9',1533253784,NULL,1533253784,NULL,NULL),(8,'4','1',1533254339,NULL,1533254339,NULL,NULL),(9,'4','2',1533254339,NULL,1533254339,NULL,NULL),(10,'4','7',1533254339,NULL,1533254339,NULL,NULL),(11,'5','6',NULL,NULL,1533194118,NULL,1533194118),(12,'5','1',NULL,NULL,1533194118,NULL,1533194118),(13,'5','3',NULL,NULL,1533194118,NULL,1533194118),(14,'5','4',NULL,NULL,1533194118,NULL,1533194118),(15,'5','5',NULL,NULL,1533194118,NULL,1533194118),(16,'4','1',1533254433,NULL,1533254433,NULL,1533254339),(17,'4','2',1533254433,NULL,1533254433,NULL,1533254339),(18,'4','7',1533254433,NULL,1533254433,NULL,1533254339),(19,'4','3',1533254433,NULL,1533254433,NULL,1533254339),(20,'4','4',1533254433,NULL,1533254433,NULL,1533254339),(21,'4','5',1533254433,NULL,1533254433,NULL,1533254339),(22,'4','1',NULL,NULL,1533254433,NULL,1533254433),(23,'4','2',NULL,NULL,1533254433,NULL,1533254433),(24,'4','3',NULL,NULL,1533254433,NULL,1533254433),(25,'4','4',NULL,NULL,1533254433,NULL,1533254433),(26,'4','5',NULL,NULL,1533254433,NULL,1533254433),(27,'1','6',1533255635,NULL,1533255635,NULL,1533254522),(28,'2','1',1533255635,NULL,1533254571,NULL,1533254571),(29,'2','2',1533255635,NULL,1533254571,NULL,1533254571),(30,'2','6',1533255635,NULL,1533254571,NULL,1533254571),(31,'3','4',NULL,NULL,1533254579,NULL,1533254579),(32,'3','9',NULL,NULL,1533254579,NULL,1533254579);
