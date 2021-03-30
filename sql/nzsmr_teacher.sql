-- DROP TABLE IF EXISTS `yy_teacher`;
CREATE TABLE `yy_teacher` (
    `sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
    `uid` mediumint(8) unsigned NOT NULL COMMENT '使用者編號',
    `dep_id` smallint(5) unsigned  NOT NULL COMMENT '部門id',
    `title` varchar(255)  NOT NULL COMMENT '教師職稱',
    `sex` enum('0','1')  NOT NULL COMMENT '0:女 1:男',
    `phone`varchar(65)  COMMENT '分機',
    `cell_phone`varchar(65)  COMMENT '手機',
    `enable` enum('0','1') NOT NULL default '1' COMMENT '開關',
    `isteacher` enum('0','1') NOT NULL default '1' COMMENT '是教師',
    `sort` smallint(5) unsigned NOT NULL COMMENT '排序',
    `create_time` datetime NOT NULL,
    `update_time` datetime NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- DROP TABLE IF EXISTS `yy_department`;
CREATE TABLE `yy_department` (
    `sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
    `sort` tinyint(5) unsigned NOT NULL COMMENT '排序',
    `dep_name` varchar(65) NOT NULL COMMENT '學程名稱',
    `dep_status` enum('0','1','2') NOT NULL COMMENT '學程狀態 0關閉 1啟用 2暫停',
    `creat_name` varchar(65) NOT NULL COMMENT '建立者',
    `create_time` datetime NOT NULL,
    `update_time` datetime NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- DROP TABLE IF EXISTS `beck_iscore_files_center`;
CREATE TABLE `beck_iscore_files_center` (
`files_sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '檔案流水號',
`col_name` varchar(255) NOT NULL default '' COMMENT '欄位名稱',
`col_sn` smallint(5) unsigned NOT NULL default 0 COMMENT '欄位編號',
`sort` smallint(5) unsigned NOT NULL default 0 COMMENT '排序',
`kind` enum('img','file') NOT NULL default 'img' COMMENT '檔案種類',
`file_name` varchar(255) NOT NULL default '' COMMENT '檔案名稱',
`file_type` varchar(255) NOT NULL default '' COMMENT '檔案類型',
`file_size` int(10) unsigned NOT NULL default 0 COMMENT '檔案大小',
`description` text NOT NULL COMMENT '檔案說明',
`counter` mediumint(8) unsigned NOT NULL default 0 COMMENT '下載人次',
`original_filename` varchar(255) NOT NULL default '' COMMENT '檔案名稱',
`hash_filename` varchar(255) NOT NULL default '' COMMENT '加密檔案名稱',
`sub_dir` varchar(255) NOT NULL default '' COMMENT '檔案子路徑',
`upload_date` datetime NOT NULL COMMENT '上傳時間',
`uid` mediumint(8) unsigned NOT NULL default 0 COMMENT '上傳者',
`tag` varchar(255) NOT NULL default '' COMMENT '註記',
PRIMARY KEY (`files_sn`)
) ENGINE=MyISAM;

-- DROP TABLE IF EXISTS `yy_student`;
CREATE TABLE `yy_student` (
  `sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `stu_sn` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學號',
  `stu_name` varchar(65) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學生姓名',
  `arrival_date` date NOT NULL COMMENT '入校日期',
  `birthday` date NOT NULL COMMENT '生日',
  `national_id` varchar(20) NOT NULL DEFAULT '' COMMENT '身份證字號',
  `ori_referral` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '原轉介單位',
  `domicile` varchar(255) NOT NULL DEFAULT '' COMMENT '戶籍',
  `ethnic_group` varchar(255) NOT NULL DEFAULT '' COMMENT '族群類別',
  `marital` varchar(255) NOT NULL DEFAULT '' COMMENT '婚姻狀況',
  `height` varchar(255) NOT NULL DEFAULT '' COMMENT '身高',
  `weight` varchar(255) NOT NULL DEFAULT '' COMMENT '體重',
  `Low_income` varchar(255) NOT NULL DEFAULT '' COMMENT '低收入戶',
  `guardian_disability` varchar(255) NOT NULL DEFAULT '' COMMENT '監護人身心障礙',
  `referral_reason` varchar(255) NOT NULL DEFAULT '' COMMENT '轉介原因',
  `original_education` varchar(255) NOT NULL DEFAULT '' COMMENT '原學歷',
  `original_school` varchar(255) NOT NULL DEFAULT '' COMMENT '原就學學校',
  `family_profile` text NOT NULL COMMENT '家庭概況',
  `residence_address` varchar(255) NOT NULL DEFAULT '' COMMENT '戶籍地址',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '居住地址',
  `guardian1` varchar(65) NOT NULL DEFAULT '' COMMENT '監護人1',
  `guardian_relationship1` varchar(65) NOT NULL DEFAULT '' COMMENT '監護人關係1',
  `guardian_cellphone1` varchar(65) NOT NULL DEFAULT '' COMMENT '監護人手機1',
  `guardian2` varchar(65) NOT NULL DEFAULT '' COMMENT '監護人2',
  `guardian_relationship2` varchar(65) NOT NULL DEFAULT '' COMMENT '監護人關係2',
  `guardian_cellphone2` varchar(65) NOT NULL DEFAULT '' COMMENT '監護人手機2',
  `emergency_contact1` varchar(65) NOT NULL DEFAULT '' COMMENT '緊急聯絡人1',
  `emergency_contact_rel1` varchar(65) NOT NULL DEFAULT '' COMMENT '緊急聯絡人關係1',
  `emergency_cellphone1` varchar(65) NOT NULL DEFAULT '' COMMENT '緊急聯絡人手機1',
  `emergency_contact2` varchar(65) NOT NULL DEFAULT '' COMMENT '緊急聯絡人2',
  `emergency_contact_rel2` varchar(65) NOT NULL DEFAULT '' COMMENT '緊急聯絡人關係2',
  `emergency_cellphone2` varchar(65) NOT NULL DEFAULT '' COMMENT '緊急聯絡人手機2',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '建立者',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- 公告消息
-- DROP TABLE IF EXISTS `yy_announcement`;
CREATE TABLE `yy_announcement` (
  `sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `ann_class_id` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公告分類id',
  `dept_id` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '部門分類id',
  `title` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '主題',
  `content` text NOT NULL COMMENT '內容',
  `start_date` date NOT NULL COMMENT '公告起始日期',
  `end_date` date NOT NULL COMMENT '公告結束日期',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '建立者',
  `create_date` datetime NOT NULL COMMENT '建立日期',
  `update_user` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 
  `top` enum('0','1') NOT NULL default '0' COMMENT '置頂',
  `hit_count` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '瀏覽次數',
  `enable` enum('0','1') NOT NULL default '1' COMMENT '開關',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- 學年度
-- DROP TABLE IF EXISTS `yy_semester`;
CREATE TABLE `yy_semester` (
  `sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `year` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學年度',
  `term` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學期',
  `start_date` date NOT NULL COMMENT '開始時間',
  `end_date` date NOT NULL COMMENT '結束時間',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '建立者',
  `create_date` datetime NOT NULL COMMENT '建立日期',
  `update_user` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 
  `activity` enum('0','1') NOT NULL DEFAULT '0' COMMENT '目前學年度',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- 修正學年度及學期不能重複
ALTER TABLE `yy_semester`
ADD UNIQUE `year_term` (`year`, `term`);

-- 公告分類
-- DROP TABLE IF EXISTS `yy_announcement_class`;
CREATE TABLE `yy_announcement_class` (
  `sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `ann_class_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '公告分類名稱',
  `enable` enum('0','1') NOT NULL default '1' COMMENT '開關',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '建立者',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


-- 部門
-- DROP TABLE IF EXISTS `yy_dept_school`;
CREATE TABLE `yy_dept_school` (
  `sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `dept_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '處室名稱',
  `enable` enum('0','1') NOT NULL default '1' COMMENT '開關',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '建立者',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `yy_announcement_class` (`sn`, `ann_class_name`, `enable`, `sort`, `uid`, `create_time`, `update_time`) VALUES
(1,	'最新消息',	'1',	0,	1,	'2021-03-13 16:35:16',	'2021-03-26 14:54:48'),
(4,	'法令規定',	'1',	0,	1,	'2021-03-17 13:51:05',	'2021-03-17 13:51:05'),
(5,	'校內宣導',	'1',	0,	1,	'2021-03-17 13:51:14',	'2021-03-17 13:51:14'),
(8,	'研習課程',	'1',	0,	1,	'2021-03-21 17:26:33',	'2021-03-21 17:26:33');


INSERT INTO `yy_dept_school` (`sn`, `dept_name`, `enable`, `sort`, `uid`, `create_time`, `update_time`) VALUES
(4,	'教務處',	'1',	0,	1,	'2021-03-13 20:46:09',	'2021-03-13 20:46:26'),
(2,	'學務處',	'1',	0,	1,	'2021-03-13 17:29:35',	'2021-03-13 17:29:35'),
(3,	'輔導室',	'0',	0,	1,	'2021-03-13 17:37:12',	'2021-03-13 20:42:05'),
(6,	'秘書室',	'1',	0,	1,	'2021-03-17 13:51:48',	'2021-03-17 13:51:48'),
(7,	'住宿管理員',	'1',	0,	1,	'2021-03-17 13:51:58',	'2021-03-17 13:51:58'),
(8,	'家園處',	'1',	0,	1,	'2021-03-17 13:52:06',	'2021-03-17 13:52:06');
