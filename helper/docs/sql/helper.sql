-- 用户表
CREATE TABLE IF NOT EXISTS `admin_user` (
  `user_id` int(4) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `salt` varchar(128) NOT NULL COMMENT '密钥',
  `nickname` varchar(50) NOT NULL COMMENT '昵称',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机',
  `stat` tinyint(1) NOT NULL COMMENT '状态| 1正常 2已冻结 3已删除',
  `created_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `last_logined_ts` timestamp NULL DEFAULT NULL COMMENT '上次登录时间',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `uq_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户管理';

INSERT INTO `admin_user`(`user_id`,`username`,`password`,`salt`,`nickname`,`email`,`mobile`,`stat`,`created_ts`,`last_logined_ts`) values (1,'admin','f3c886c6c7fc33b9c373e1d407186c6e','efnn','Bobby','pengbotao@vip.qq.com','',1,'2013-07-22 11:10:40','2013-07-22 16:12:52');

-- 角色表
CREATE TABLE IF NOT EXISTS admin_role(
role_id INT(4) NOT NULL AUTO_INCREMENT COMMENT '角色ID',
role_name VARCHAR(30) NOT NULL COMMENT '角色名称',
remark VARCHAR(255) DEFAULT NULL COMMENT '备注',
stat TINYINT(1) NOT NULL DEFAULT 1 COMMENT '状态| 1正常 2已冻结 3已删除',
created_ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
modified_ts TIMESTAMP NULL DEFAULT NULL COMMENT '修改时间',
PRIMARY KEY(role_id)
)ENGINE = INNODB DEFAULT CHARSET = utf8 COMMENT '角色管理';

-- 用户角色关系表
CREATE TABLE IF NOT EXISTS admin_role_user (
role_user_id INT(4) NOT NULL AUTO_INCREMENT COMMENT 'ID',
role_id INT(4) NOT NULL COMMENT '角色ID',
user_id INT(4) NOT NULL COMMENT '用户ID',
PRIMARY KEY(role_user_id)
)ENGINE = INNODB DEFAULT CHARSET = utf8 COMMENT '用户角色关系管理';

-- 资源节点表
CREATE TABLE IF NOT EXISTS admin_node(
node_id INT(4) NOT NULL AUTO_INCREMENT COMMENT '节点ID',
node_name VARCHAR(50) NOT NULL COMMENT '节点名称',
title VARCHAR(50) NOT NULL COMMENT '节点标题',
remark VARCHAR(255) DEFAULT NULL COMMENT '备注',
pid INT(4) NOT NULL DEFAULT 0 COMMENT '上级ID',
`level` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '级别| 1项目 2模块 3操作',
stat TINYINT(1) NOT NULL DEFAULT 1 COMMENT '状态| 1正常 2已冻结 3已删除',
created_ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
modified_ts TIMESTAMP NULL DEFAULT NULL COMMENT '修改时间',
PRIMARY KEY (node_id)
)ENGINE = INNODB DEFAULT CHARSET = utf8 COMMENT '节点管理';

-- 角色节点关系表
CREATE TABLE IF NOT EXISTS admin_role_node(
role_node_id INT(4) NOT NULL AUTO_INCREMENT COMMENT 'ID',
role_id INT(4) NOT NULL COMMENT '角色ID',
node_id INT(4) NOT NULL COMMENT '节点ID',
PRIMARY KEY(role_node_id)
)ENGINE = INNODB DEFAULT CHARSET = utf8 COMMENT '角色节点管理';