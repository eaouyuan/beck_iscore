-- DROP TABLE IF EXISTS `yy_teacher`;
CREATE TABLE `yy_teacher` (
    `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
    `uid` mediumint(8) unsigned NOT NULL COMMENT '教師uid',
    `dep_id` mediumint(8) unsigned  NOT NULL COMMENT '部門id',
    `title` varchar(255)  NOT NULL COMMENT '教師職稱',
    `sex` enum('0','1')  NOT NULL COMMENT '0:女 1:男',
    `phone`varchar(65)  COMMENT '分機',
    `cell_phone`varchar(65)  COMMENT '手機',
    `enable` enum('0','1') NOT NULL default '1' COMMENT '開關',
    `isteacher` enum('0','1') NOT NULL default '0' COMMENT '是教師',
    `isguidance` enum('0','1') NOT NULL default '0' COMMENT '是輔導教師',
    `issocial` enum('0','1') NOT NULL default '0' COMMENT '是社工師',
    `sort` mediumint(8) unsigned NOT NULL COMMENT '排序',
    `create_uid` mediumint(8) unsigned NOT NULL COMMENT '建立者編號',
    `create_time` datetime NOT NULL,
    `update_uid` mediumint(8) NOT NULL COMMENT '修改者',
    `update_time` datetime NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- 教師編號不能重複
ALTER TABLE `yy_teacher` ADD UNIQUE `uid` (`uid`);

-- 學程
-- DROP TABLE IF EXISTS `yy_department`;
CREATE TABLE `yy_department` (
    `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
    `sort` mediumint(8) unsigned NOT NULL COMMENT '排序',
    `dep_name` varchar(65) NOT NULL COMMENT '學程名稱',
    `dep_status` enum('0','1','2') NOT NULL COMMENT '學程狀態 0關閉 1啟用 2暫停',
    `create_uid` mediumint(8) NOT NULL COMMENT '建立者',
    `create_time` datetime NOT NULL,
    `update_uid` mediumint(8) NOT NULL COMMENT '修改者',
    `update_time` datetime NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE `yy_department`
ADD UNIQUE `dep_name` (`dep_name`);

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

CREATE TABLE `yy_student` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `stu_id` varchar(8) NOT NULL COMMENT '學號',
  `stu_no` varchar(8) NOT NULL COMMENT '入學編號',
  `stu_name` varchar(65) NOT NULL COMMENT '學生姓名',
  `national_id` varchar(20) NOT NULL DEFAULT '' COMMENT '身份證字號',
  `sex` enum('0','1')  NOT NULL COMMENT '性別 0女 1男',
  `arrival_date` date NOT NULL COMMENT '入校日期',
  `birthday` date NOT NULL COMMENT '生日',
  `orig_referral` varchar(255) NOT NULL DEFAULT '' COMMENT '原轉介單位',
  `orig_school` varchar(255) NOT NULL DEFAULT '' COMMENT '原就學學校',
  `orig_grade` enum('1','2','3','畢業或結業')  NOT NULL COMMENT '原就讀學校年級',
  
  `household_reg` varchar(255) NOT NULL DEFAULT '' COMMENT '戶籍',
  `household_add` varchar(255) NOT NULL DEFAULT '' COMMENT '戶籍地址',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '居住地址',
  `ethnic_group` varchar(255) NOT NULL DEFAULT '' COMMENT '族群類別',
  `marital` varchar(255) NOT NULL DEFAULT '' COMMENT '婚姻狀況',
  `height` varchar(255) NOT NULL DEFAULT '' COMMENT '身高',
  `weight` varchar(255) NOT NULL DEFAULT '' COMMENT '體重',
  `Low_income` enum('0','1') NOT NULL COMMENT '低收入戶',
  `guardian_disability` varchar(255) NOT NULL DEFAULT '' COMMENT '監護人身心障礙',
  `referral_reason` varchar(255) NOT NULL DEFAULT '' COMMENT '轉介原因',
  `family_profile` text NOT NULL COMMENT '家庭概況',
  `out_learn` enum('0','1') NOT NULL COMMENT '外學',

  `guardian1` varchar(65) NOT NULL DEFAULT '' COMMENT '監護人1',
  `guardian1_relationship` varchar(65) NOT NULL DEFAULT '' COMMENT '監護人1關係',
  `guardian1_cellphone1` varchar(65) NOT NULL DEFAULT '' COMMENT '監護人1手機1',
  `guardian1_cellphone2` varchar(65) NOT NULL DEFAULT '' COMMENT '監護人1手機2',
  `guardian2` varchar(65) NOT NULL DEFAULT '' COMMENT '監護人2',
  `guardian2_relationship` varchar(65) NOT NULL DEFAULT '' COMMENT '監護人2關係',
  `guardian2_cellphone1` varchar(65) NOT NULL DEFAULT '' COMMENT '監護人2手機1',
  `guardian2_cellphone2` varchar(65) NOT NULL DEFAULT '' COMMENT '監護人2手機2',
  `emergency1_contact1` varchar(65) NOT NULL DEFAULT '' COMMENT '緊急聯絡人1',
  `emergency1_contact_rel` varchar(65) NOT NULL DEFAULT '' COMMENT '緊急聯絡人1關係',
  `emergency1_cellphone1` varchar(65) NOT NULL DEFAULT '' COMMENT '緊急聯絡人1手機1',
  `emergency1_cellphone2` varchar(65) NOT NULL DEFAULT '' COMMENT '緊急聯絡人1手機2',
  `emergency2_contact1` varchar(65) NOT NULL DEFAULT '' COMMENT '緊急聯絡人2',
  `emergency2_contact_rel` varchar(65) NOT NULL DEFAULT '' COMMENT '緊急聯絡人2關係',
  `emergency2_cellphone1` varchar(65) NOT NULL DEFAULT '' COMMENT '緊急聯絡人2手機1',
  `emergency2_cellphone2` varchar(65) NOT NULL DEFAULT '' COMMENT '緊急聯絡人2手機2',

  `social_id` mediumint(8) unsigned NOT NULL COMMENT '社工師',
  `guidance_id` mediumint(8) unsigned NOT NULL COMMENT '輔導教師',
  `rcv_guidance_id` mediumint(8) unsigned NOT NULL COMMENT '認輔老師',
  `class_id` mediumint(8) unsigned NOT NULL COMMENT '班級',
  `major_id` mediumint(8) unsigned NOT NULL COMMENT '學程',
  `grade`  enum('1','2','3','畢業或結業')  NOT NULL COMMENT '年級',
  `status` enum('0','1','2') NOT NULL COMMENT '0逾假逃跑 1在校  2回歸/結案 ',
  `audit` enum('0','1') NOT NULL COMMENT '隨班附讀',
  `record` varchar(255) NOT NULL DEFAULT '' COMMENT '學程紀錄(回歸用)',

  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '建立者',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 公告消息
-- DROP TABLE IF EXISTS `yy_announcement`;
CREATE TABLE `yy_announcement` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
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
  `hit_count` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '瀏覽次數',
  `enable` enum('0','1') NOT NULL default '1' COMMENT '開關',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- 學年度
-- DROP TABLE IF EXISTS `yy_semester`;
CREATE TABLE `yy_semester` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `year` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學年度',
  `term` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學期',
  `start_date` date NOT NULL COMMENT '開始時間',
  `end_date` date NOT NULL COMMENT '結束時間',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '建立者',
  `create_date` datetime NOT NULL COMMENT '建立日期',
  `update_user` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 
  `activity` enum('0','1') NOT NULL DEFAULT '0' COMMENT '目前學年度',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
-- 修正學年度及學期不能重複
ALTER TABLE `yy_semester`
ADD UNIQUE `year_term` (`year`, `term`);

-- 公告分類
-- DROP TABLE IF EXISTS `yy_announcement_class`;
CREATE TABLE `yy_announcement_class` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `ann_class_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '公告分類名稱',
  `enable` enum('0','1') NOT NULL default '1' COMMENT '開關',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '建立者',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


-- 學校部門
-- DROP TABLE IF EXISTS `yy_dept_school`;
CREATE TABLE `yy_dept_school` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `dept_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '處室名稱',
  `enable` enum('0','1') NOT NULL default '1' COMMENT '開關',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '建立者',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- DROP TABLE IF EXISTS `yy_class`;
CREATE TABLE `yy_class` (
    `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
    `sort` mediumint(8) unsigned NOT NULL COMMENT '排序',
    `class_name` varchar(65) NOT NULL COMMENT '班級名稱',
    `class_status` enum('0','1','2') NOT NULL DEFAULT '1' COMMENT '班級狀態 0關閉 1啟用 2暫停',
    `tutor_sn` mediumint(8) unsigned NOT NULL COMMENT '導師編號',
    `create_uid` mediumint(8) unsigned NOT NULL COMMENT '建立者',
    `create_time` datetime NOT NULL,
    `update_uid` mediumint(8) unsigned NOT NULL COMMENT '修改者',
    `update_time` datetime NOT NULL,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE `yy_class`
ADD UNIQUE `class_name` (`class_name`);

-- 課程管理
-- DROP TABLE IF EXISTS `yy_semester`;
CREATE TABLE `yy_course` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `cos_year` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學年度',
  `cos_term` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學期',
  `dep_id` mediumint(8) unsigned NOT NULL COMMENT '學程',
  `tea_id` mediumint(8) unsigned NOT NULL COMMENT '教師uid',
  `cos_name` varchar(65) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '課程名稱',
  `cos_name_grp` varchar(65) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '課程群組',
  `cos_credits` int(5) unsigned NOT NULL DEFAULT '1' COMMENT '學分數',
  `scoring` enum('0','1') NOT NULL DEFAULT '1' COMMENT '是否計分',
  `first_test` enum('0','1') NOT NULL DEFAULT '0' COMMENT '第一次段考',
  `second_test` enum('0','1') NOT NULL DEFAULT '0' COMMENT '第二次段考',
  `status` enum('0','1','2') NOT NULL COMMENT '課程狀態 0關閉 1啟用 2暫停',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `update_user` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 

  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
-- 修正學年度、學期、學程、教師、!課程名稱 不能重複
ALTER TABLE `yy_course`
ADD UNIQUE `cos_year_cos_term_dep_id_tea_id` (`cos_year`, `cos_term`, `dep_id`, `tea_id`,`cos_name`);




-- 學年度
INSERT INTO `yy_semester` (`sn`, `year`, `term`, `start_date`, `end_date`, `uid`, `create_date`, `update_user`, `update_date`, `activity`, `sort`) VALUES
(1,	'109',	'2',	'2021-02-01',	'2021-07-04',	1,	'2021-04-09 13:09:58',	1,	'2021-04-09 13:09:58',	'1',	0);

-- 學程
INSERT INTO `yy_department` (`sn`, `sort`, `dep_name`, `dep_status`, `create_uid`, `create_time`, `update_uid`, `update_time`) VALUES
(1,	0,	'國甲',	'1',	1,	'2021-04-09 08:59:07',	1,	'2021-04-09 08:59:07'),
(2,	0,	'國乙',	'1',	1,	'2021-04-09 09:18:04',	1,	'2021-04-09 09:18:04'),
(3,	0,	'資料處理學程',	'1',	1,	'2021-04-09 10:41:26',	1,	'2021-04-09 10:41:26'),
(4,	0,	'美容學程',	'1',	1,	'2021-04-09 10:42:38',	1,	'2021-04-09 10:42:38'),
(5,	0,	'餐旅技術學程',	'1',	1,	'2021-04-09 10:42:27',	1,	'2021-04-09 10:42:27'),
(6,	0,	'新生',	'1',	1,	'2021-04-11 17:52:46',	1,	'2021-04-11 17:52:46');


-- 公告類別
INSERT INTO `yy_announcement_class` (`sn`, `ann_class_name`, `enable`, `sort`, `uid`, `create_time`, `update_time`) VALUES
(1,	'最新消息',	'1',	0,	1,	'2021-03-13 16:35:16',	'2021-03-26 14:54:48'),
(2,	'法令規定',	'1',	0,	1,	'2021-03-17 13:51:05',	'2021-03-17 13:51:05'),
(3,	'校內宣導',	'1',	0,	1,	'2021-03-17 13:51:14',	'2021-03-17 13:51:14'),
(4,	'研習課程',	'1',	0,	1,	'2021-03-21 17:26:33',	'2021-03-21 17:26:33');

-- 學校處室
INSERT INTO `yy_dept_school` (`sn`, `dept_name`, `enable`, `sort`, `uid`, `create_time`, `update_time`) VALUES
(1,	'教務處',	'1',	0,	1,	'2021-03-13 20:46:09',	'2021-03-13 20:46:26'),
(2,	'學務處',	'1',	0,	1,	'2021-03-13 17:29:35',	'2021-03-13 17:29:35'),
(3,	'輔導室',	'1',	0,	1,	'2021-03-13 17:37:12',	'2021-03-13 20:42:05'),
(4,	'秘書室',	'1',	0,	1,	'2021-03-17 13:51:48',	'2021-03-17 13:51:48'),
(5,	'住宿管理員',	'1',	0,	1,	'2021-03-17 13:51:58',	'2021-03-17 13:51:58'),
(6,	'家園處',	'1',	0,	1,	'2021-03-17 13:52:06',	'2021-03-17 13:52:06');

-- 班級
INSERT INTO `yy_class` (`sn`, `sort`, `class_name`, `class_status`, `tutor_sn`, `create_uid`, `create_time`, `update_uid`, `update_time`) VALUES
(1,	0,	'友仁',	'1',	6,	'1',	'2021-04-07 20:54:22',	'1',	'2021-04-08 07:58:42'),
(2,	0,	'友禮',	'1',	38,	'1',	'2021-04-07 20:58:57',	'1',	'2021-04-09 00:31:14'),
(3,	0,	'友愛',	'1',	40,	'1',	'2021-04-07 20:59:10',	'1',	'2021-04-08 13:15:14'),
(4,	0,	'友情',	'1',	15,	'1',	'2021-04-07 20:59:26',	'1',	'2021-04-08 07:59:00');

-- 教師基本資料
INSERT INTO `yy_teacher` (`sn`, `uid`, `dep_id`, `title`, `sex`, `phone`, `cell_phone`, `enable`, `isteacher`, `isguidance`, `issocial`, `sort`, `create_uid`, `create_time`, `update_uid`, `update_time`) VALUES
(31,	2,	0,	'',	'',	NULL,	NULL,	'1',	'0',	'0',	'0',	32,	1,	'2021-04-10 13:06:25',	1,	'2021-04-10 13:14:16'),
(32,	3,	0,	'',	'',	NULL,	NULL,	'1',	'0',	'0',	'0',	33,	1,	'2021-04-10 13:06:27',	1,	'2021-04-10 13:13:56'),
(33,	4,	0,	'',	'',	NULL,	NULL,	'1',	'0',	'0',	'0',	40,	1,	'2021-04-10 13:06:30',	1,	'2021-04-10 13:13:56'),
(15,	5,	1,	'',	'1',	'',	'',	'',	'1',	'0',	'0',	4,	1,	'2021-04-09 13:21:33',	1,	'2021-04-10 13:13:56'),
(20,	6,	2,	'',	'0',	'',	'',	'',	'1',	'0',	'0',	13,	1,	'2021-04-09 13:21:49',	1,	'2021-04-10 13:13:56'),
(29,	7,	6,	'',	'0',	'',	'',	'',	'0',	'0',	'0',	29,	1,	'2021-04-09 13:26:59',	1,	'2021-04-10 13:13:56'),
(10,	8,	1,	'',	'0',	'',	'',	'',	'1',	'0',	'0',	3,	1,	'2021-04-09 13:21:17',	1,	'2021-04-10 13:13:56'),
(38,	9,	0,	'',	'',	NULL,	NULL,	'1',	'0',	'0',	'0',	35,	1,	'2021-04-10 13:07:27',	1,	'2021-04-10 13:13:56'),
(21,	10,	1,	'',	'0',	'',	'',	'',	'0',	'0',	'0',	6,	1,	'2021-04-09 13:24:20',	1,	'2021-04-10 13:13:56'),
(14,	11,	3,	'',	'0',	'',	'',	'',	'1',	'1',	'0',	21,	1,	'2021-04-09 13:21:32',	1,	'2021-04-10 13:13:56'),
(12,	12,	1,	'',	'0',	'',	'',	'',	'1',	'0',	'0',	2,	1,	'2021-04-09 13:21:21',	1,	'2021-04-10 13:13:56'),
(1,	13,	6,	'',	'0',	'',	'',	'',	'1',	'0',	'0',	27,	1,	'2021-04-09 11:40:38',	1,	'2021-04-10 13:13:56'),
(11,	14,	6,	'',	'1',	'',	'',	'',	'1',	'0',	'0',	26,	1,	'2021-04-09 13:21:18',	1,	'2021-04-10 13:13:56'),
(5,	15,	2,	'',	'0',	'',	'',	'',	'1',	'0',	'0',	9,	1,	'2021-04-09 13:21:04',	1,	'2021-04-10 13:13:56'),
(13,	16,	1,	'',	'0',	'',	'',	'',	'1',	'0',	'0',	1,	1,	'2021-04-09 13:21:27',	1,	'2021-04-10 13:13:56'),
(16,	17,	3,	'',	'0',	'',	'',	'',	'1',	'1',	'0',	19,	1,	'2021-04-09 13:21:38',	1,	'2021-04-10 13:13:56'),
(3,	18,	3,	'',	'0',	'',	'',	'',	'1',	'1',	'0',	18,	1,	'2021-04-09 11:43:16',	1,	'2021-04-10 13:13:56'),
(24,	19,	2,	'',	'0',	'',	'',	'',	'0',	'0',	'0',	14,	1,	'2021-04-09 13:24:45',	1,	'2021-04-10 13:13:56'),
(19,	20,	2,	'',	'1',	'',	'',	'',	'1',	'0',	'0',	7,	1,	'2021-04-09 13:21:48',	1,	'2021-04-10 13:13:56'),
(9,	21,	2,	'',	'1',	'',	'',	'',	'1',	'0',	'0',	8,	1,	'2021-04-09 13:21:16',	1,	'2021-04-10 13:13:56'),
(22,	22,	2,	'',	'0',	'',	'',	'',	'0',	'0',	'0',	16,	1,	'2021-04-09 13:24:29',	1,	'2021-04-10 13:13:56'),
(25,	23,	3,	'',	'0',	'',	'',	'',	'0',	'0',	'1',	22,	1,	'2021-04-09 13:25:10',	1,	'2021-04-10 13:13:56'),
(8,	24,	3,	'',	'0',	'',	'',	'',	'1',	'1',	'0',	20,	1,	'2021-04-09 13:21:14',	1,	'2021-04-10 13:13:56'),
(23,	25,	3,	'',	'0',	'',	'',	'',	'0',	'0',	'0',	23,	1,	'2021-04-09 13:24:36',	1,	'2021-04-10 13:13:56'),
(17,	26,	2,	'',	'0',	'',	'',	'',	'1',	'0',	'0',	12,	1,	'2021-04-09 13:21:39',	1,	'2021-04-10 13:13:56'),
(28,	27,	3,	'',	'0',	'',	'',	'',	'0',	'0',	'1',	24,	1,	'2021-04-09 13:26:00',	1,	'2021-04-10 13:13:56'),
(27,	28,	3,	'',	'0',	'',	'',	'',	'0',	'0',	'1',	25,	1,	'2021-04-09 13:25:41',	1,	'2021-04-10 13:13:56'),
(6,	29,	1,	'',	'0',	'',	'',	'',	'1',	'0',	'0',	5,	1,	'2021-04-09 13:21:06',	1,	'2021-04-10 13:13:56'),
(44,	30,	0,	'',	'',	NULL,	NULL,	'1',	'0',	'0',	'0',	42,	1,	'2021-04-10 13:07:33',	1,	'2021-04-10 13:13:56'),
(43,	31,	0,	'',	'',	NULL,	NULL,	'1',	'0',	'0',	'0',	41,	1,	'2021-04-10 13:07:32',	1,	'2021-04-10 13:13:56'),
(42,	32,	0,	'',	'',	NULL,	NULL,	'1',	'0',	'0',	'0',	37,	1,	'2021-04-10 13:07:31',	1,	'2021-04-10 13:13:56'),
(30,	33,	0,	'',	'',	NULL,	NULL,	'1',	'0',	'0',	'0',	44,	1,	'2021-04-09 15:04:02',	1,	'2021-04-10 13:13:56'),
(41,	34,	0,	'',	'',	NULL,	NULL,	'1',	'0',	'0',	'0',	36,	1,	'2021-04-10 13:07:30',	1,	'2021-04-10 13:13:56'),
(40,	35,	0,	'',	'',	NULL,	NULL,	'1',	'0',	'0',	'0',	31,	1,	'2021-04-10 13:07:30',	1,	'2021-04-10 13:14:17'),
(39,	36,	0,	'',	'',	NULL,	NULL,	'1',	'0',	'0',	'0',	30,	1,	'2021-04-10 13:07:29',	1,	'2021-04-10 13:14:19'),
(4,	37,	2,	'',	'0',	'',	'',	'',	'0',	'0',	'0',	17,	1,	'2021-04-09 11:47:27',	1,	'2021-04-10 13:13:56'),
(18,	38,	2,	'',	'0',	'',	'',	'',	'1',	'0',	'0',	10,	1,	'2021-04-09 13:21:42',	1,	'2021-04-10 13:13:56'),
(37,	39,	0,	'',	'',	NULL,	NULL,	'1',	'0',	'0',	'0',	38,	1,	'2021-04-10 13:07:26',	1,	'2021-04-10 13:13:56'),
(2,	40,	2,	'',	'0',	'',	'',	'',	'1',	'0',	'0',	11,	1,	'2021-04-09 11:40:49',	1,	'2021-04-10 13:13:56'),
(7,	41,	6,	'',	'0',	'',	'',	'',	'1',	'1',	'0',	28,	1,	'2021-04-09 13:21:13',	1,	'2021-04-10 13:13:56'),
(35,	42,	0,	'',	'',	NULL,	NULL,	'1',	'0',	'0',	'0',	34,	1,	'2021-04-10 13:07:23',	1,	'2021-04-10 13:13:56'),
(26,	43,	2,	'',	'1',	'',	'',	'',	'0',	'0',	'0',	15,	1,	'2021-04-09 13:25:31',	1,	'2021-04-10 13:13:56'),
(34,	44,	0,	'',	'',	NULL,	NULL,	'1',	'0',	'0',	'0',	39,	1,	'2021-04-10 13:06:32',	1,	'2021-04-10 13:13:56'),
(36,	45,	0,	'',	'',	NULL,	NULL,	'1',	'0',	'0',	'0',	43,	1,	'2021-04-10 13:07:25',	1,	'2021-04-10 13:13:56');