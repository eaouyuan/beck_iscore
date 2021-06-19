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
  `normal_exam` decimal(5,2) unsigned NOT NULL COMMENT '平時考佔比',
  `section_exam` decimal(5,2) unsigned NOT NULL COMMENT '段考佔比',
  `dep_status` enum('0','1','2') NOT NULL COMMENT '學程狀態 0關閉 1啟用 2暫停',
  `create_uid` mediumint(8) NOT NULL COMMENT '建立者',
  `create_time` datetime NOT NULL,
  `update_uid` mediumint(8) NOT NULL COMMENT '修改者',
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`sn`),
  UNIQUE KEY `dep_name` (`dep_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `stu_anonymous` varchar(65) NOT NULL COMMENT '學生匿名', 
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


-- 學校處室
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

-- 段考輸入日期設定
CREATE TABLE `yy_exam_keyin_daterange` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `exam_year` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學年度',
  `exam_term` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學期',
  `exam_name` varchar(65) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '段考名稱',
  `start_date` date NOT NULL COMMENT '起始日期',
  `end_date` date NOT NULL COMMENT '結束日期',
  `status` enum('0','1','2') NOT NULL COMMENT '段考日期狀態 0關閉 1啟用 2暫停',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `update_user` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期',
  PRIMARY KEY (`sn`),
  UNIQUE KEY `exam_year_exam_term_exam_name` (`exam_year`,`exam_term`,`exam_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- 平時考成績
CREATE TABLE `yy_usual_score` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `year` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學年度',
  `term` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學期',
  `dep_id` mediumint(8) unsigned NOT NULL COMMENT '學程編號',
  `course_id` mediumint(8) unsigned NOT NULL COMMENT '課程編號',
  `exam_stage` enum('1','3','5') NOT NULL COMMENT '第幾次段考前平時考',
  `exam_number` smallint(5) unsigned NOT NULL default '0' COMMENT '第幾次平時考',
  `student_sn` mediumint(8) unsigned NOT NULL COMMENT '學生編號',
  `score` varchar(5) NULL COMMENT '平時考成績',
  `usual_average_sn` mediumint(8) unsigned NOT NULL COMMENT '平時考加總平均對映編號',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `update_user` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- 修正學年度、學期、段考名稱、第幾次段考前、第幾次平時成績  不能重複
ALTER TABLE `yy_usual_score`
ADD UNIQUE `year_term_course_id_exam_stage_exam_number_student_sn` (`year`, `term`, `course_id`, `exam_stage`, `exam_number`, `student_sn`);

-- 平時考成績的平均
CREATE TABLE `yy_uscore_avg` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `course_id` mediumint(8) unsigned NOT NULL COMMENT '課程編號',
  `exam_stage` enum('1','3','5') NOT NULL COMMENT '第幾次段考前平時考',
  `student_sn` mediumint(8) unsigned NOT NULL COMMENT '學生編號',
  `avgscore` varchar(5) NULL COMMENT '平時考平均',
  `final_score_sn` mediumint(8) unsigned NOT NULL COMMENT '期末總成績sn',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `update_user` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `yy_uscore_avg`
ADD UNIQUE `course_id_exam_stage_student_sn` (`course_id`, `exam_stage`, `student_sn`);

-- 段考成績
CREATE TABLE `yy_stage_score` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `year` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學年度',
  `term` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學期',
  `dep_id` mediumint(8) unsigned NOT NULL COMMENT '學程編號',
  `course_id` mediumint(8) unsigned NOT NULL COMMENT '課程編號',
  `exam_stage` enum('2','4','6') NOT NULL COMMENT '第幾次段考',
  `student_sn` mediumint(8) unsigned NOT NULL COMMENT '學生編號',
  `score` varchar(5) NULL COMMENT '段考成績',
  `final_score_sn` mediumint(8) unsigned NOT NULL COMMENT '期末總成績sn',
  `stage_calculation_sn` mediumint(8) unsigned NOT NULL COMMENT '段考成績計算sn',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `update_user` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `yy_stage_score`
ADD UNIQUE `year_term_dep_id_course_id_exam_stage_student_sn` (`year`, `term`, `course_id`, `exam_stage`, `student_sn`);


-- 段考成績加總
CREATE TABLE `yy_stage_sum` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `course_id` mediumint(8) unsigned NOT NULL COMMENT '課程編號',
  `student_sn` mediumint(8) unsigned NOT NULL COMMENT '學生編號',
  `uscore_sum` varchar(5) NULL COMMENT '平時考加總',
  `uscore_avg` varchar(5) NULL COMMENT '平時考平均',
  `sscore_sum` varchar(5) NULL COMMENT '段考加總',
  `sscore_avg` varchar(5) NULL COMMENT '段考平均',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '質性描述',
  `sum_usual_stage_avg` varchar(5) NULL COMMENT '系統：平時+段考',
  `tea_input_score` varchar(5) NULL COMMENT '教師keyin總成績',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `update_user` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `yy_stage_sum`
ADD UNIQUE `course_id_student_sn` (`course_id`, `student_sn`);


-- 考科成績查詢
CREATE TABLE `yy_query_stage_score` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `year` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學年度',
  `term` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學期',
  `dep_id` mediumint(8) unsigned NOT NULL COMMENT '學程編號',
  `exam_stage` enum('2','4','6','8') NOT NULL COMMENT '第幾次段考',
  `student_sn` mediumint(8) unsigned NOT NULL COMMENT '學生編號',
  `sum_credits` int(5) unsigned NOT NULL DEFAULT '1' COMMENT '總學分數',
  `qscore_sum` varchar(5) NULL COMMENT '段考加總',
  `qscore_avg` varchar(5) NULL COMMENT '段考平均',
  `reward_method` varchar(255) NULL DEFAULT '' COMMENT '獎勵方式',
  `progress_score` varchar(5) NULL DEFAULT '' COMMENT '進步分',
  `comment` varchar(255) NULL DEFAULT '' COMMENT '備註',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `update_user` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `yy_query_stage_score`
ADD UNIQUE `dep_id_exam_stage_student_sn` (`dep_id`, `exam_stage`, `student_sn`);

-- 學期總成績
CREATE TABLE `yy_term_total_score` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `year` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學年度',
  `term` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '學期',
  `dep_id` mediumint(8) unsigned NOT NULL COMMENT '學程編號',
  `student_sn` mediumint(8) unsigned NOT NULL COMMENT '學生編號',
  `sum_credits` varchar(3) NULL COMMENT '總學分數',
  `total_score` varchar(6) NULL COMMENT '總分',
  `total_avg` varchar(5) NULL COMMENT '總平均',
  `comment` varchar(255) NULL DEFAULT '' COMMENT '備註',
  `reward_method` varchar(255) NULL DEFAULT '' COMMENT '獎勵方式',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `update_user` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `yy_term_total_score`
ADD UNIQUE `year_term_dep_id_student_sn` (`year`, `term`, `dep_id`, `student_sn`);

-- 學期總成績-群組科目 分數
CREATE TABLE `yy_term_score_detail` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `year` varchar(8) NOT NULL COMMENT '學年度',
  `term` varchar(8) NOT NULL COMMENT '學期',
  `dep_id` mediumint(8) unsigned NOT NULL COMMENT '學程編號',
  `student_sn` mediumint(8) unsigned NOT NULL COMMENT '學生編號',
  `cos_name_grp` varchar(65) NOT NULL COMMENT '課程群組',
  `course_total_score` varchar(6) NULL COMMENT '總分',
  `course_sum_credits` varchar(3) NULL COMMENT '總學分數',
  `course_total_avg` varchar(5) NULL COMMENT '總平均',
  `comment` varchar(255) NULL DEFAULT '' COMMENT '備註',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `update_user` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `yy_term_score_detail`
ADD UNIQUE `year_term_dep_id_student_sn_cos_name_grp` (`year`, `term`, `dep_id`, `student_sn`, `cos_name_grp`);

-- 每月高關懷學生名單
CREATE TABLE `yy_high_care` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `year` varchar(3) NOT NULL COMMENT '年',
  `month` varchar(2) NOT NULL COMMENT '月',
  `student_sn` mediumint(8) unsigned NOT NULL COMMENT '學生編號',
  `class_id` mediumint(8) unsigned NOT NULL COMMENT '班級',
  `event_desc` text NOT NULL COMMENT '事件說明',
  `keyin_date` date NOT NULL COMMENT '填寫日期',
  `update_user` mediumint(8)  NOT NULL DEFAULT '0' COMMENT '新增/修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- 每月高關懷學生名單列表
CREATE TABLE `yy_high_care_month` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水號',
  `year` varchar(3) NOT NULL COMMENT '年',
  `month` varchar(2) NOT NULL COMMENT '月',
  `event_date` date NOT NULL COMMENT '事件日期',
  `event` varchar(65) NOT NULL COMMENT '事件名稱',
  `comment` text NOT NULL COMMENT '備註',
  `update_user` mediumint(8)  NOT NULL DEFAULT '0' COMMENT '新增/修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `yy_high_care_month`
ADD UNIQUE `year_month` (`year`, `month`);

-- config
CREATE TABLE `yy_config` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '設定檔流水號',
  `gpname` varchar(255) NOT NULL COMMENT '群組名稱',
  `title` varchar(255) NOT NULL COMMENT '中文名稱',
  `gpval` varchar(65) NOT NULL COMMENT '值',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '狀態 0關閉 1啟用',
  `update_user` mediumint(8)  NOT NULL DEFAULT '1' COMMENT '新增/修改者',
  `update_date` datetime NOT NULL DEFAULT now() COMMENT '修改日期', 
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `yy_config`
ADD UNIQUE `gpname_value` (`gpname`, `value`);

-- 認輔教師設定
CREATE TABLE `yy_tea_counseling` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '認輔教師設定流水號',
  `year` varchar(8) NOT NULL COMMENT '學年度',
  `term` varchar(8) NOT NULL COMMENT '學期',
  `tea_uid` mediumint(8) unsigned NOT NULL COMMENT '教師uid',
  `student_sn` mediumint(8) unsigned NOT NULL COMMENT '學生編號',
  `update_user` mediumint(8)  NOT NULL DEFAULT '0' COMMENT '新增/修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `yy_tea_counseling`
ADD UNIQUE `year_term_student_sn` (`year`, `term`, `student_sn`);

-- 認輔紀錄
CREATE TABLE `yy_counseling_rec` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '認輔紀錄流水號',
  `year` varchar(8) NOT NULL COMMENT '學年度',
  `term` varchar(8) NOT NULL COMMENT '學期',
  `notice_time` datetime NOT NULL COMMENT '通報時間',
  `student_sn` mediumint(8) unsigned NOT NULL COMMENT '學生編號',
  `tea_uid` mediumint(8) unsigned NOT NULL COMMENT '教師uid',
  `content` text NOT NULL COMMENT '內容簡述',
  `location` varchar(255) NOT NULL  DEFAULT '' COMMENT '認輔面談地點',
  `focus` varchar(255) NOT NULL DEFAULT '' COMMENT '輔導重點',
  `update_user` mediumint(8)  NOT NULL DEFAULT '0' COMMENT '新增/修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- 認輔紀錄-面談地點、輔導重點
CREATE TABLE `yy_counseling_option` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '認輔紀錄選項流水號',
  `counseling_rec_sn` mediumint(8) unsigned NOT NULL COMMENT '認輔紀錄流水號',
  `gpname` varchar(255) NOT NULL COMMENT '認輔紀錄群組名稱',
  `gpval` varchar(3) NOT NULL COMMENT '值',
  `update_user` mediumint(8)  NOT NULL DEFAULT '0' COMMENT '新增/修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- 獎懲紀錄
CREATE TABLE `yy_reward_punishment` (
  `sn` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '獎懲紀錄流水號',
  `year` varchar(8) NOT NULL COMMENT '學年度',
  `term` varchar(8) NOT NULL COMMENT '學期',
  `student_sn` mediumint(8) unsigned NOT NULL COMMENT '學生編號',
  `RP_kind` enum('1','2') NOT NULL COMMENT '獎懲種類 1獎勵 2懲罰',
  `RP_content` text NOT NULL COMMENT '事由',
  `RP_option` enum('1','2','3','4','5','6','7','8','9','10') NULL COMMENT '1白鴿 2嘉獎 3小功 4大功 5榮舉假 6警告 7小過 8大過 9減少榮舉假 10罰勤',
  `RP_times` varchar(2) NOT NULL COMMENT '獎懲次數',
  `RP_unit` enum('1','2','3') NULL COMMENT '獎懲單位 1次 2小時 3支',
  `comment` varchar(255) NULL COMMENT '備註',
  `event_date` date NOT NULL COMMENT '批示日期',
  `update_user` mediumint(8)  NOT NULL DEFAULT '0' COMMENT '新增/修改者',
  `update_date` datetime NOT NULL COMMENT '修改日期', 
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;




-- 學年度
INSERT INTO `yy_semester` (`sn`, `year`, `term`, `start_date`, `end_date`, `uid`, `create_date`, `update_user`, `update_date`, `activity`, `sort`) VALUES
(1,	'109',	'2',	'2021-02-01',	'2021-07-04',	1,	'2021-04-09 13:09:58',	1,	'2021-04-09 13:09:58',	'1',	0);

-- 學程
INSERT INTO `yy_department` (`sn`, `sort`, `dep_name`, `normal_exam`, `section_exam`, `dep_status`, `create_uid`, `create_time`, `update_uid`, `update_time`) VALUES
(1,	0,	'國甲',	0.60,	0.40,	'1',	1,	'2021-04-09 08:59:07',	1,	'2021-04-28 16:10:07'),
(2,	0,	'國乙',	0.60,	0.40,	'1',	1,	'2021-04-09 09:18:04',	1,	'2021-04-28 16:10:14'),
(3,	0,	'資料處理學程',	0.30,	0.70,	'1',	1,	'2021-04-09 10:41:26',	1,	'2021-04-28 16:10:35'),
(4,	0,	'美容學程',	0.30,	0.70,	'1',	1,	'2021-04-09 10:42:38',	1,	'2021-04-28 16:10:41'),
(5,	0,	'餐旅技術學程',	0.30,	0.70,	'1',	1,	'2021-04-09 10:42:27',	1,	'2021-04-28 16:10:48'),
(6,	0,	'新生',	0.00,	0.00,	'1',	1,	'2021-04-11 17:52:46',	1,	'2021-04-11 17:52:46');


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

INSERT INTO `yy_course` (`sn`, `cos_year`, `cos_term`, `dep_id`, `tea_id`, `cos_name`, `cos_name_grp`, `cos_credits`, `scoring`, `first_test`, `second_test`, `sort`, `status`, `update_user`, `update_date`) VALUES
(1,	'109',	'2',	1,	17,	'國語文',	'國語文',	4,	'1',	'1',	'1',	1,	'1',	1,	'2021-04-27 15:18:27'),
(9,	'109',	'2',	1,	29,	'英語文',	'英語文',	3,	'1',	'1',	'1',	2,	'1',	1,	'2021-04-27 15:19:32'),
(10,	'109',	'2',	1,	5,	'數學',	'數學',	3,	'1',	'1',	'1',	3,	'1',	1,	'2021-04-27 15:19:59'),
(11,	'109',	'2',	1,	13,	'自然',	'自然',	3,	'1',	'1',	'1',	5,	'1',	1,	'2021-04-27 15:20:29'),
(12,	'109',	'2',	1,	14,	'社會2',	'社會2',	3,	'1',	'1',	'1',	4,	'1',	1,	'2021-04-27 15:21:03'),
(13,	'109',	'2',	1,	16,	'健康教育',	'健康教育',	1,	'1',	'0',	'1',	6,	'1',	1,	'2021-04-27 15:22:00'),
(14,	'109',	'2',	1,	15,	'體育',	'體育',	2,	'1',	'0',	'0',	7,	'1',	1,	'2021-04-27 15:22:30'),
(15,	'109',	'2',	1,	6,	'美術',	'美術',	2,	'1',	'0',	'0',	8,	'1',	1,	'2021-04-27 15:22:57'),
(16,	'109',	'2',	1,	12,	'音樂',	'音樂',	2,	'1',	'0',	'0',	9,	'1',	1,	'2021-04-27 15:23:18'),
(17,	'109',	'2',	1,	5,	'生活科技',	'生活科技',	1,	'1',	'0',	'0',	10,	'1',	1,	'2021-04-27 15:23:52'),
(18,	'109',	'2',	1,	16,	'家政',	'家政',	1,	'1',	'0',	'0',	11,	'1',	1,	'2021-04-27 15:24:13'),
(19,	'109',	'2',	1,	41,	'輔導探索',	'輔導探索',	2,	'1',	'0',	'0',	12,	'1',	1,	'2021-04-27 15:24:43'),
(20,	'109',	'2',	2,	14,	'社會',	'社會',	3,	'1',	'1',	'1',	4,	'1',	1,	'2021-04-27 15:49:22'),
(21,	'109',	'2',	2,	13,	'自然',	'自然',	3,	'1',	'1',	'1',	5,	'1',	1,	'2021-04-27 15:20:29'),
(22,	'109',	'2',	2,	21,	'數學',	'數學',	3,	'1',	'1',	'1',	3,	'1',	1,	'2021-04-27 15:45:14'),
(23,	'109',	'2',	2,	29,	'英語文',	'英語文',	3,	'1',	'1',	'1',	2,	'1',	1,	'2021-04-27 15:19:32'),
(24,	'109',	'2',	2,	17,	'國語文',	'國語文',	4,	'1',	'1',	'1',	1,	'1',	1,	'2021-04-27 15:18:27'),
(25,	'109',	'2',	2,	16,	'健康教育',	'健康教育',	1,	'1',	'0',	'1',	6,	'1',	1,	'2021-04-27 15:22:00'),
(26,	'109',	'2',	2,	15,	'體育',	'體育',	2,	'1',	'0',	'0',	7,	'1',	1,	'2021-04-27 15:22:30'),
(27,	'109',	'2',	2,	6,	'美術',	'美術',	2,	'1',	'0',	'0',	8,	'1',	1,	'2021-04-27 15:22:57'),
(28,	'109',	'2',	2,	12,	'音樂',	'音樂',	2,	'1',	'0',	'0',	9,	'1',	1,	'2021-04-27 15:23:18'),
(29,	'109',	'2',	2,	5,	'生活科技',	'生活科技',	1,	'1',	'0',	'0',	11,	'1',	1,	'2021-04-27 15:23:52'),
(30,	'109',	'2',	2,	16,	'家政',	'家政',	1,	'1',	'0',	'0',	10,	'1',	1,	'2021-04-27 15:24:13'),
(31,	'109',	'2',	2,	41,	'輔導探索',	'輔導探索',	2,	'1',	'0',	'0',	12,	'1',	1,	'2021-04-27 15:24:43'),
(32,	'109',	'2',	2,	46,	'資訊科技',	'資訊科技',	1,	'1',	'0',	'0',	13,	'1',	1,	'2021-04-27 15:51:21'),
(38,	'109',	'2',	4,	8,	'國語文',	'國語文',	3,	'1',	'1',	'1',	1,	'1',	1,	'2021-04-28 08:41:29'),
(39,	'109',	'2',	4,	29,	'英語文',	'英語文',	2,	'1',	'1',	'1',	2,	'1',	1,	'2021-04-28 08:41:59'),
(40,	'109',	'2',	4,	21,	'數學',	'數學',	1,	'1',	'1',	'1',	3,	'1',	1,	'2021-04-28 08:43:06'),
(41,	'109',	'2',	4,	16,	'健康與護理',	'健康與護理',	1,	'1',	'0',	'1',	5,	'1',	1,	'2021-04-28 08:43:30'),
(42,	'109',	'2',	4,	15,	'體育',	'體育',	2,	'1',	'0',	'0',	7,	'1',	1,	'2021-04-28 08:43:58'),
(45,	'109',	'2',	4,	12,	'音樂',	'音樂',	1,	'1',	'0',	'0',	8,	'1',	1,	'2021-04-28 09:03:40'),
(46,	'109',	'2',	4,	6,	'美術',	'美術',	1,	'1',	'0',	'0',	9,	'1',	1,	'2021-04-28 09:04:09'),
(47,	'109',	'2',	4,	14,	'家庭教育',	'家庭教育',	1,	'1',	'1',	'1',	6,	'1',	1,	'2021-04-28 09:04:36'),
(48,	'109',	'2',	4,	26,	'家政概論',	'家政概論',	2,	'1',	'1',	'1',	10,	'1',	1,	'2021-04-28 09:05:01'),
(49,	'109',	'2',	4,	6,	'色彩概論',	'色彩概論',	1,	'1',	'1',	'0',	11,	'1',	1,	'2021-04-28 09:05:25'),
(50,	'109',	'2',	4,	40,	'多媒材創作實務',	'多媒材創作實務',	2,	'1',	'0',	'0',	15,	'1',	1,	'2021-04-28 09:05:59'),
(51,	'109',	'2',	4,	46,	'資訊科技',	'資訊科技',	1,	'1',	'0',	'0',	16,	'1',	1,	'2021-04-28 09:06:26'),
(52,	'109',	'2',	4,	41,	'生涯規劃',	'生涯規劃',	1,	'1',	'0',	'0',	17,	'1',	1,	'2021-04-28 09:15:09'),
(53,	'109',	'2',	4,	40,	'美顏',	'美顏',	2,	'1',	'0',	'0',	12,	'1',	1,	'2021-04-28 09:15:02'),
(54,	'109',	'2',	4,	40,	'美髮',	'美髮',	2,	'1',	'1',	'0',	13,	'1',	1,	'2021-04-28 09:07:59'),
(55,	'109',	'2',	4,	40,	'美容美體實務',	'美容美體實務',	2,	'1',	'0',	'0',	18,	'1',	1,	'2021-04-28 09:14:48'),
(56,	'109',	'2',	4,	40,	'家政行職業衛生與安全',	'家政行職業衛生與安全',	1,	'1',	'1',	'1',	14,	'1',	1,	'2021-04-28 09:14:40'),
(57,	'109',	'2',	4,	40,	'美髮造型實務',	'美髮造型實務',	1,	'1',	'0',	'0',	19,	'1',	1,	'2021-04-28 09:14:32'),
(58,	'109',	'2',	4,	15,	'舞台表演實務',	'舞台表演實務',	2,	'1',	'0',	'0',	20,	'1',	1,	'2021-04-28 09:14:24'),
(59,	'109',	'2',	4,	40,	'美容專題實作',	'美容專題實作',	2,	'1',	'0',	'0',	21,	'1',	1,	'2021-04-28 09:14:10'),
(60,	'109',	'2',	4,	26,	'選修特色蔬食料理',	'選修特色蔬食料理',	2,	'1',	'0',	'0',	22,	'1',	1,	'2021-04-28 09:19:30'),
(61,	'109',	'2',	4,	15,	'飾品設計與實務',	'飾品設計與實務',	1,	'1',	'0',	'0',	23,	'1',	1,	'2021-04-28 09:19:54'),
(63,	'109',	'2',	4,	43,	'全民國防教育',	'全民國防教育',	1,	'1',	'0',	'0',	24,	'1',	1,	'2021-04-28 09:35:09'),
(64,	'109',	'2',	4,	41,	'社會',	'社會',	1,	'1',	'1',	'0',	4,	'1',	1,	'2021-04-28 09:37:57'),
(65,	'109',	'2',	3,	29,	'英語文',	'英語文',	2,	'1',	'1',	'1',	3,	'1',	1,	'2021-04-28 08:41:59'),
(66,	'109',	'2',	3,	8,	'國語文',	'國語文',	3,	'1',	'1',	'1',	1,	'1',	1,	'2021-04-28 08:41:29'),
(67,	'109',	'2',	3,	21,	'數學',	'數學',	1,	'1',	'1',	'1',	5,	'1',	1,	'2021-04-28 08:43:06'),
(68,	'109',	'2',	3,	16,	'健康與護理',	'健康與護理',	1,	'1',	'0',	'1',	9,	'1',	1,	'2021-04-28 08:43:30'),
(69,	'109',	'2',	3,	15,	'體育',	'體育',	2,	'1',	'0',	'0',	10,	'1',	1,	'2021-04-28 08:43:58'),
(70,	'109',	'2',	3,	12,	'音樂',	'音樂',	1,	'1',	'0',	'0',	11,	'1',	1,	'2021-04-28 09:03:40'),
(71,	'109',	'2',	3,	6,	'美術',	'美術',	1,	'1',	'0',	'0',	12,	'1',	1,	'2021-04-28 09:04:09'),
(72,	'109',	'2',	3,	20,	'商業概論',	'商業概論',	2,	'1',	'1',	'1',	19,	'1',	1,	'2021-04-28 09:56:18'),
(73,	'109',	'2',	3,	21,	'高三數學',	'高三數學',	2,	'1',	'1',	'1',	6,	'1',	1,	'2021-04-28 09:58:30'),
(74,	'109',	'2',	3,	29,	'高三英文',	'高三英文',	2,	'1',	'1',	'1',	4,	'1',	1,	'2021-04-28 09:58:50'),
(75,	'109',	'2',	3,	20,	'會計學',	'會計學',	3,	'1',	'0',	'0',	21,	'1',	1,	'2021-04-28 10:25:21'),
(76,	'109',	'2',	3,	46,	'資訊科技',	'資訊科技',	1,	'1',	'0',	'0',	13,	'1',	1,	'2021-04-28 09:06:26'),
(77,	'109',	'2',	3,	41,	'生涯規劃',	'生涯規劃',	1,	'1',	'0',	'0',	24,	'1',	1,	'2021-04-28 09:15:09'),
(78,	'109',	'2',	3,	6,	'設計群專一',	'設計群專一',	2,	'1',	'1',	'0',	25,	'1',	1,	'2021-04-28 09:59:32'),
(79,	'109',	'2',	3,	6,	'設計群專二',	'設計群專二',	2,	'1',	'1',	'0',	26,	'1',	1,	'2021-04-28 10:01:41'),
(80,	'109',	'2',	3,	17,	'高三國文',	'高三國文',	2,	'1',	'1',	'1',	2,	'1',	1,	'2021-04-28 10:02:39'),
(81,	'109',	'2',	3,	20,	'門市經營實務',	'門市經營實務',	2,	'1',	'1',	'0',	20,	'1',	1,	'2021-04-28 10:03:13'),
(82,	'109',	'2',	3,	13,	'自然科學',	'自然科學',	1,	'1',	'1',	'0',	8,	'1',	1,	'2021-04-28 10:03:33'),
(84,	'109',	'2',	3,	46,	'資處專題實作',	'資處專題實作',	2,	'1',	'0',	'0',	18,	'1',	1,	'2021-04-28 09:57:53'),
(85,	'109',	'2',	3,	26,	'選修特色蔬食料理',	'選修特色蔬食料理',	2,	'1',	'0',	'0',	27,	'1',	1,	'2021-04-28 09:19:30'),
(87,	'109',	'2',	3,	43,	'全民國防教育',	'全民國防教育',	1,	'1',	'0',	'0',	23,	'1',	1,	'2021-04-28 09:35:09'),
(88,	'109',	'2',	3,	41,	'社會',	'社會',	1,	'1',	'0',	'0',	7,	'1',	1,	'2021-04-28 09:46:05'),
(89,	'109',	'2',	3,	46,	'數位科技應用',	'數位科技應用',	2,	'1',	'0',	'0',	14,	'1',	1,	'2021-04-28 09:47:44'),
(90,	'109',	'2',	3,	46,	'程式語言設計',	'程式語言設計',	1,	'1',	'1',	'1',	15,	'1',	1,	'2021-04-28 09:48:06'),
(91,	'109',	'2',	3,	46,	'數位科技概論',	'數位科技概論',	2,	'1',	'1',	'1',	16,	'1',	1,	'2021-04-28 09:48:25'),
(93,	'109',	'2',	3,	46,	'高三計算機概論',	'高三計算機概論',	1,	'1',	'1',	'0',	17,	'1',	1,	'2021-04-28 09:49:03'),
(94,	'109',	'2',	3,	5,	'多媒體製作與應用',	'多媒體製作與應用',	2,	'1',	'0',	'0',	22,	'1',	1,	'2021-04-28 09:50:37'),
(95,	'109',	'2',	5,	29,	'英語文',	'英語文',	1,	'1',	'1',	'1',	2,	'1',	1,	'2021-04-28 10:41:38'),
(96,	'109',	'2',	5,	8,	'國語文',	'國語文',	3,	'1',	'1',	'1',	1,	'1',	1,	'2021-04-28 08:41:29'),
(97,	'109',	'2',	5,	21,	'數學',	'數學',	1,	'1',	'1',	'1',	3,	'1',	1,	'2021-04-28 08:43:06'),
(98,	'109',	'2',	5,	16,	'健康與護理',	'健康與護理',	1,	'1',	'0',	'1',	7,	'1',	1,	'2021-04-28 08:43:30'),
(99,	'109',	'2',	5,	15,	'體育',	'體育',	2,	'1',	'0',	'0',	8,	'1',	1,	'2021-04-28 08:43:58'),
(100,	'109',	'2',	5,	12,	'音樂',	'音樂',	1,	'1',	'0',	'0',	9,	'1',	1,	'2021-04-28 09:03:40'),
(101,	'109',	'2',	5,	6,	'美術',	'美術',	1,	'1',	'0',	'0',	10,	'1',	1,	'2021-04-28 09:04:09'),
(106,	'109',	'2',	5,	46,	'資訊科技',	'資訊科技',	1,	'1',	'0',	'0',	13,	'1',	1,	'2021-04-28 09:06:26'),
(107,	'109',	'2',	5,	41,	'生涯規劃',	'生涯規劃',	1,	'1',	'0',	'0',	11,	'1',	1,	'2021-04-28 09:15:09'),
(108,	'109',	'2',	5,	26,	'中餐烹飪實習',	'中餐烹飪實習',	4,	'1',	'1',	'1',	15,	'1',	1,	'2021-04-28 10:46:24'),
(109,	'109',	'2',	5,	6,	'觀光餐旅業導論',	'觀光餐旅業導論',	1,	'1',	'0',	'0',	16,	'1',	1,	'2021-04-28 10:46:40'),
(112,	'109',	'2',	5,	13,	'自然科學',	'自然科學',	1,	'1',	'1',	'1',	5,	'1',	1,	'2021-04-28 10:42:12'),
(114,	'109',	'2',	5,	26,	'選修特色蔬食料理',	'選修特色蔬食料理',	2,	'1',	'0',	'0',	17,	'1',	1,	'2021-04-28 09:19:30'),
(115,	'109',	'2',	5,	43,	'全民國防教育',	'全民國防教育',	1,	'1',	'0',	'0',	12,	'1',	1,	'2021-04-28 09:35:09'),
(116,	'109',	'2',	5,	41,	'社會',	'社會',	1,	'1',	'1',	'1',	4,	'1',	1,	'2021-04-28 10:42:01'),
(117,	'109',	'2',	5,	16,	'食物學',	'食物學',	1,	'1',	'1',	'1',	6,	'1',	1,	'2021-04-28 10:43:03'),
(121,	'109',	'2',	5,	26,	'飲料實務',	'飲料實務',	1,	'1',	'0',	'0',	14,	'1',	1,	'2021-04-28 10:45:58'),
(122,	'109',	'2',	5,	38,	'餐飲服務技術',	'餐飲服務技術',	2,	'1',	'0',	'0',	19,	'1',	1,	'2021-04-28 10:47:16'),
(123,	'109',	'2',	5,	38,	'餐飲專題實作',	'餐飲專題實作',	2,	'1',	'0',	'0',	20,	'1',	1,	'2021-04-28 10:48:01'),
(124,	'109',	'2',	5,	38,	'烘焙實務',	'烘焙實務',	4,	'1',	'1',	'1',	18,	'1',	1,	'2021-04-28 10:48:25'),
(125,	'109',	'2',	5,	38,	'蔬果切雕實習',	'蔬果切雕實習',	1,	'1',	'0',	'0',	21,	'1',	1,	'2021-04-28 10:50:17');

INSERT INTO `yy_exam_keyin_daterange` (`sn`, `exam_year`, `exam_term`, `exam_name`, `start_date`, `end_date`, `status`, `sort`, `update_user`, `update_date`) VALUES
(1,	'109',	'2',	'第一次段考',	'2021-04-01',	'2021-04-01',	'1',	2,	1,	'2021-05-01 08:30:47'),
(2,	'109',	'2',	'第一次段考前平時考',	'2021-05-03',	'2021-05-07',	'1',	1,	1,	'2021-05-01 08:31:43'),
(3,	'109',	'2',	'第二次段考前平時考',	'2021-05-04',	'2021-05-14',	'1',	3,	1,	'2021-05-01 08:32:00'),
(4,	'109',	'2',	'第二次段考',	'2021-05-06',	'2021-05-19',	'1',	4,	1,	'2021-05-01 08:32:16'),
(5,	'109',	'2',	'第三次段考前平時考',	'2021-05-07',	'2021-05-19',	'1',	6,	1,	'2021-05-01 08:32:33'),
(6,	'109',	'2',	'期末考',	'2021-05-06',	'2021-05-13',	'1',	5,	1,	'2021-05-01 08:42:46');

INSERT INTO `yy_config` (`sn`, `gpname`, `title`, `gpval`, `description`, `sort`, `status`, `update_user`, `update_date`) VALUES
(1,'AdoptionInterviewLocation','會客室','1','認輔面談地點',1,'1',1,'2021-06-01 16:23:05'),
(2,'AdoptionInterviewLocation','綠園','2','認輔面談地點',2,'1',1,'2021-06-01 16:23:05'),
(3,'AdoptionInterviewLocation','其他','3','認輔面談地點',3,'1',1,'2021-06-01 16:23:05'),
(4,'CounselingFocus','親子互動','1','認輔-輔導重點',1,'1',1,'2021-06-01 16:24:41'),
(5,'CounselingFocus','人際關係','2','認輔-輔導重點',2,'1',1,'2021-06-01 16:24:41'),
(6,'CounselingFocus','兩性交往','3','認輔-輔導重點',3,'1',1,'2021-06-01 16:24:41'),
(7,'CounselingFocus','生涯規劃','4','認輔-輔導重點',4,'1',1,'2021-06-01 16:24:41'),
(8,'CounselingFocus','情緒困擾','5','認輔-輔導重點',5,'1',1,'2021-06-01 16:26:18'),
(9,'CounselingFocus','自我探索','6','認輔-輔導重點',6,'1',1,'2021-06-01 16:26:18'),
(10,'CounselingFocus','學習輔導','7','認輔-輔導重點',7,'1',1,'2021-06-01 16:28:58'),
(11,'CounselingFocus','創傷復原','8','認輔-輔導重點',8,'1',1,'2021-06-01 16:29:13'),
(12,'CounselingFocus','其他','9','認輔-輔導重點',9,'1',1,'2021-06-01 16:29:36');