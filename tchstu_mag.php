<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Beck_iscore\SchoolSet;
use XoopsModules\Beck_iscore\Dept_school;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\SweetAlert;


/*-----------引入檔案區--------------*/
include_once "header.php";
$xoopsOption['template_main'] = "beck_iscore_index.tpl";
include_once XOOPS_ROOT_PATH . "/header.php";


/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = Request::getString('op');
$sn = Request::getInt('sn');

$stu_list['status']   = Request::getString('status');
$stu_list['major_id'] = Request::getString('major_id');
$stu_list['search']   = Request::getString('search');
$g2p=Request::getInt('g2p');
$cos['cos_year'] = Request::getString('cos_year');
$cos['cos_term'] = Request::getString('cos_term');
$cos['dep_id']   = Request::getString('dep_id');
$uscore['dep_id']      = Request::getString('dep_id');
$uscore['course_id']   = Request::getString('course_id');
$uscore['exam_stage']  = Request::getString('exam_stage');
$uscore['exam_number'] = Request::getString('exam_number');
$uscore['score_syn'] = Request::getString('score_syn');

$hi_care['year']  = Request::getString('year');
$hi_care['month'] = Request::getString('month');
$counseling['year']   = Request::getString('year');
$counseling['term']   = Request::getString('term');
$counseling['stu_sn'] = Request::getString('stu_sn');
$counseling['tea_uid'] = Request::getString('tea_uid');
$RP['RP_kind'] = Request::getString('RP_kind');
$RP['dep_id'] = Request::getString('dep_id');
$RP['class_id'] = Request::getString('class_id');
$RP['stu_sn'] = Request::getString('stu_sn');
$RP['sdate'] = Request::getString('sdate');
$RP['edate'] = Request::getString('edate');
$AB['class_id'] = Request::getString('class_id');
$AB['year'] = Request::getString('year');
$AB['term'] = Request::getString('term');
$AB['major_id'] = Request::getString('major_id');
$AB['stu_sn'] = Request::getString('stu_sn');
$AB['AB_period'] = Request::getString('AB_period');


// die(var_dump($score_syn));
// die(var_dump($_GET));
// die(var_dump($_REQUEST));
// die(var_dump($_SESSION));
// var_dump($type);die();

switch ($op) {
// 學生 管理
    case "student_list":
        student_list($stu_list,$g2p);
        break;//跳出迴圈,往下執行
    // 新增、編輯 學生
    case "student_form":
        student_form($sn);
        break;//跳出迴圈,往下執行

    // 新增 學生
    case "student_insert":
        student_insert();
        header("location:tchstu_mag.php?op=student_list");
        exit;//離開，結束程式

    // 更新 學生
    case "student_update":
        student_update($sn);
        header("location:tchstu_mag.php?op=student_list");
        exit;

    // 刪除 學生
    case "student_delete":
        student_delete($sn);
        header("location:tchstu_mag.php?op=student_list");
        exit;

// 課程 管理
    //課程 列表
    case "course_list":
        course_list($cos,$g2p);
        break;//跳出迴圈,往下執行
    // 課程 表單
    case "course_form":
        course_form($sn);
        break;//跳出迴圈,往下執行

    // 新增 課程
    case "course_insert":
        $re=course_insert();
        header("location:tchstu_mag.php?op=course_list&cos_year={$re['cos_year']}&cos_term={$re['cos_term']}&dep_id={$re['dep_id']}");
        exit;//離開，結束程式

    // 更新 課程
    case "course_update":
        $re=course_update($sn);
        header("location:tchstu_mag.php?op=course_list&cos_year={$re['cos_year']}&cos_term={$re['cos_term']}&dep_id={$re['dep_id']}");
        exit;
    // 刪除 課程
    case "course_delete":
        $re=course_delete($sn);
        header("location:tchstu_mag.php?op=course_list&cos_year={$re['cos_year']}&cos_term={$re['cos_term']}&dep_id={$re['dep_id']}");
        exit;
// 平時成績 管理
    //平時成績 列表
    case "usual_score_list":
        usual_score_list($uscore);
        break;//跳出迴圈,往下執行
    // 表單 平時成績
    case "usual_score_form":
        usual_score_form($uscore);
        break;//跳出迴圈,往下執行

    // 新增、更新 平時成績
    case "usual_score_insert":
        usual_score_insert($uscore);
        header("location:tchstu_mag.php?op=usual_score_list&dep_id={$uscore['dep_id']}&course_id={$uscore['course_id']}");
        exit;//離開，結束程式

    // 刪除 平時成績'
    case "usual_score_delete":
        $re=usual_score_delete($uscore);
        header("location:tchstu_mag.php?op=usual_score_list&dep_id={$uscore['dep_id']}&course_id={$uscore['course_id']}");
        exit;
// 段考成績 管理
    //段考成績 列表
    case "stage_score_list":
        stage_score_list($uscore);
        break;//跳出迴圈,往下執行
    // 新增、更新 段考成績
    case "stage_score_insert":
        stage_score_insert($uscore);
        // header("location:tchstu_mag.php?op=stage_score_list&dep_id={$uscore['dep_id']}&course_id={$uscore['course_id']}");
        redirect_header("tchstu_mag.php?op=stage_score_list&dep_id={$uscore['dep_id']}&course_id={$uscore['course_id']}", 3, '存檔成功！');
        exit;//離開，結束程式
    case "stage_score_synchronize":
        stage_score_insert($uscore);
        header("location:tchstu_mag.php?op=stage_score_list&dep_id={$uscore['dep_id']}&course_id={$uscore['course_id']}&score_syn=1");
        exit;//離開，結束程式
// 查詢 考科成績 及期末總成績 學期總成績
    //平時成績 列表
    case "query_stage_score":
        query_stage_score($uscore);
        break;//跳出迴圈,往下執行
    // 新增、更新 考科成績
    case "add_query_stage_score_comment":
        add_query_stage_score_comment($uscore);
        header("location:tchstu_mag.php?op=query_stage_score&dep_id={$uscore['dep_id']}&course_id={$uscore['course_id']}");
        exit;//離開，結束程式
    // 學期總成績term_total_score 列表
    case "term_total_score_list":
        term_total_score_list($cos);
        break;//跳出迴圈,往下執行
    // 列印成績單
    case "transcript":
        transcript($cos,$sn);
        break;//跳出迴圈,往下執行

// 高關懷名單
    // 新增 高關懷名單
    case "high_care_update":
        high_care_update($sn);
        header("location:tchstu_mag.php?op=high_care_mon&year={$hi_care['year']}&month={$hi_care['month']}");
        exit;//離開，結束程式
    case "high_care_insert":
        $re=high_care_insert();
        header("location:tchstu_mag.php?op=high_care_mon&year={$re['year']}&month={$re['month']}");
        exit;//離開，結束程式
    case "high_care_mon":
        high_care_mon($hi_care);
        break;//跳出迴圈,往下執行
    case "high_care_delete":
        $re=high_care_delete($sn);
        header("location:tchstu_mag.php?op=high_care_mon&year={$re['year']}&month={$re['month']}");
        exit;
    case "high_care_form":
        high_care_form($sn);
        break;//跳出迴圈,往下執行
    case "high_care_list":
        high_care_list($g2p);
        break;//跳出迴圈,往下執行
// 認輔管理
    case "counseling_list":
        counseling_list($cos);
        break;//跳出迴圈,往下執行
    case "counseling_show":
        counseling_show($counseling);
        break;//跳出迴圈,往下執行
    case "counseling_form":
        counseling_form($counseling,$sn);
        break;//跳出迴圈,往下執行
    case "counseling_insert":
        $re=counseling_insert();
        header("location:tchstu_mag.php?op=counseling_show&year={$re['year']}&term={$re['term']}&stu_sn={$re['stu_sn']}&tea_uid={$re['tea_uid']}");
        exit;//離開，結束程式
    case "counseling_update":
        $re=counseling_update($sn);
        header("location:tchstu_mag.php?op=counseling_show&year={$re['year']}&term={$re['term']}&stu_sn={$re['stu_sn']}&tea_uid={$re['tea_uid']}");
        exit;//離開，結束程式
    case "counseling_delete":
        $re=counseling_delete($sn);
        header("location:tchstu_mag.php?op=counseling_show&year={$re['year']}&term={$re['term']}&stu_sn={$re['student_sn']}&tea_uid={$re['tea_uid']}");
        exit;
// 獎懲管理
    case "reward_punishment_list":
        reward_punishment_list($RP);
        break;//跳出迴圈,往下執行
    case "reward_punishment_form":
        reward_punishment_form($counseling,$sn);
        break;//跳出迴圈,往下執行
    case "reward_punishment_insert":
        $re=reward_punishment_insert();
        header("location:tchstu_mag.php?op=reward_punishment_list");
        exit;//離開，結束程式
    case "reward_punishment_delete":
        $re=reward_punishment_delete($sn);
        header("location:tchstu_mag.php?op=reward_punishment_list");
        exit;
    case "reward_punishment_update":
        $re=reward_punishment_update($sn);
        header("location:tchstu_mag.php?op=reward_punishment_list");
        exit;//離開，結束程式
    case "reward_punishment_sum":
        reward_punishment_sum($RP);
        break;//跳出迴圈,往下執行
// 出缺勤管理
    case "absence_record_form":
        absence_record_form($AB,$sn);
        break;//跳出迴圈,往下執行
    case "absence_record_insert":
        $re=absence_record_insert();
        header("location:tchstu_mag.php?op=absence_record_list");
        exit;//離開，結束程式
    case "absence_record_update":
        $re=absence_record_update($sn);
        header("location:tchstu_mag.php?op=absence_record_list");
        exit;//離開，結束程式
    case "absence_record_list":
        absence_record_list($AB);
        break;//跳出迴圈,往下執行
    case "absence_record_delete":
        $re=absence_record_delete($sn);
        header("location:tchstu_mag.php?op=absence_record_list");
        exit;
// 導師評語
    case "mentor_comment":
        mentor_comment($sn);
        break;//跳出迴圈,往下執行
    case "mentor_comment_update":
        $re=mentor_comment_update($sn);
        header("location:tchstu_mag.php?op=mentor_comment");
        exit;//離開，結束程式

// 下載檔案
    case "tufdl":
        $TadUpFiles=new TadUpFiles("beck_iscore","/counseling",$file="/file",$image="/image",$thumbs="/image/.thumbs");
        $files_sn=isset($_GET['files_sn'])?intval($_GET['files_sn']):"";
        $TadUpFiles->add_file_counter($files_sn,false,false);
        exit;
// default
    default:
        // semester_list();
        // $op="semester_list";
        break;


}
/*-----------function區--------------*/
// 導師評語
    function mentor_comment_update($sn){
        global $xoopsDB,$xoopsUser;
        $SchoolSet= new SchoolSet;
        
        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin() or $xoopsUser)){
            redirect_header('tchstu_mag.php', 3, '無 mentor_comment_update 權限!error:2106261121');
        }
        if(!($sn)){
            redirect_header('tchstu_mag.php?op=mentor_comment', 3, '未選定學生 ! error:2106271014');
        }
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=mentor_comment&sn={$sn}", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }

        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // die();

        // 再刪除此學生導師評語
        $tbl = $xoopsDB->prefix('yy_mentor_comment');
        $sql = "DELETE FROM `$tbl`
        WHERE `year` = '{$year}'
        AND `term` = '{$term}'
        AND `student_sn` = '{$sn}'
        ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        $sql = "insert into `$tbl` (
                    `year`,`term`,`student_sn`,`Comment`,`update_user`,
                    `update_date`
                )values(
                    '{$year}','{$term}','{$sn}','{$tea_Comment}','{$uid}',
                    now()
                )";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $returnnewsn = $xoopsDB->getInsertId(); //取得最後新增的編號

        if($returnnewsn){
            redirect_header("tchstu_mag.php?op=mentor_comment&sn={$sn}", 2, '儲存成功 ! ');
        }

        return true;
    }
    function mentor_comment($sn){
        global $xoopsTpl,$xoopsUser,$xoopsDB;
        $SchoolSet= new SchoolSet;
        $myts = MyTextSanitizer::getInstance();
        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin() or $xoopsUser)){
            redirect_header('tchstu_mag.php', 3, '無 mentor_comment 權限!error:2106261121');
        }
        $xoopsTpl->assign('sem_year', $SchoolSet->sem_year);
        $xoopsTpl->assign('sem_term', $SchoolSet->sem_term);
        
        $class_name=$SchoolSet->class_name[$SchoolSet->tutorid_classid[$xoopsUser->uid()]]==''?'':$SchoolSet->class_name[$SchoolSet->tutorid_classid[$xoopsUser->uid()]].'班';
        $xoopsTpl->assign('class_name', $class_name);

        $teacher_name=$SchoolSet->uid2name[$xoopsUser->uid()];
        $xoopsTpl->assign('teacher_name', $teacher_name);

        // 學生列表
        $student_list=[];
        if($xoopsUser->isAdmin() or power_chk("beck_iscore", "3")){
            // $student_list=$SchoolSet->stu_anonymous;
            $stu_sel=Get_select_grp_opt_htm($SchoolSet->classname_stuid,$sn,'0');
        }else{
            $tutor_class_name=$SchoolSet->class_name_all[$SchoolSet->tutorid_classid[$xoopsUser->uid()]];
            $clss_stusn_stuaname[$tutor_class_name]=$SchoolSet->classname_stuid[$tutor_class_name];
            $stu_sel=Get_select_grp_opt_htm($clss_stusn_stuaname,$sn,'0');
            $student_list=$SchoolSet->classid_stuid[$SchoolSet->tutorid_classid[$xoopsUser->uid()]];
        }

        $xoopsTpl->assign('stu_sel', $stu_sel);

        $com['A']=Get_select_opt_htm($SchoolSet->MentorCommentA,'','0');
        $com['B']=Get_select_opt_htm($SchoolSet->MentorCommentB,'','0');
        $com['C']=Get_select_opt_htm($SchoolSet->MentorCommentC,'','0');
        $xoopsTpl->assign('com', $com);
        // die(var_dump($xoopsUser->uid()));
        // die(var_dump(array_key_exists($xoopsUser->uid(), $student_list)));

        if($sn){
            $tbl = $xoopsDB->prefix('yy_mentor_comment');
            $sql = "SELECT * FROM $tbl
                    WHERE `year` = '{$SchoolSet->sem_year}'
                    AND `term` = '{$SchoolSet->sem_term}'
                    AND `student_sn` = '{$sn}'";
            // echo($sql);die();
            $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $ru= $xoopsDB->fetchArray($result);
            if(!(array_key_exists($sn, $student_list) or $xoopsUser->isAdmin() or power_chk("beck_iscore", "3"))){
                redirect_header('tchstu_mag.php?op=mentor_comment', 2, '錯誤班級導師身份!error:2106271032');
            }
        }
        $ru ['year']        = $myts->htmlSpecialChars($ru['year']);
        $ru ['term']        = $myts->htmlSpecialChars($ru['term']);
        $ru ['student_sn']  = $myts->htmlSpecialChars($ru['student_sn']);
        $ru ['Comment']     = $myts->displayTarea($ru['Comment'], 1, 0, 0, 0, 0);
        $ru ['update_user'] = $myts->htmlSpecialChars($ru['update_user']);
        $xoopsTpl->assign('all', $ru);


        if ($sn) {
            $uid = $_SESSION['beck_iscore_adm'] ? $ru['update_user'] : $xoopsUser->uid();
            $xoopsTpl->assign('sn', $sn);
        } else {
            $uid = $xoopsUser->uid();
        }
        $xoopsTpl->assign('uid', $uid);
        $xoopsTpl->assign('op', 'mentor_comment_update');

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }

// ----------------------------------
// 出缺勤管理
    function absence_record_delete($sn){
        global $xoopsDB,$xoopsUser;

        if(!(power_chk("beck_iscore", "6") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php', 2, '無 absence_record_delete 權限! error:2106190045');
        }
        
        // 刪除學生出缺勤紀錄
        $tbl    = $xoopsDB->prefix('yy_absence_time');
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        return;
    }
    function absence_record_list($pars=[]){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        $SchoolSet= new SchoolSet;
        $myts = MyTextSanitizer::getInstance();
        if(!(power_chk("beck_iscore", "6") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php', 2, '無 absence_record_list 權限! error:2106231030');
        }
        // var_dump($SchoolSet->sem_sn);die();

        $pars['year']=($pars['year']=='')?(string)$SchoolSet->sem_year:$pars['year'];
        $pars['term']=($pars['term']=='')?(string)$SchoolSet->sem_term:$pars['term'];
        
        // 學年
        foreach ($SchoolSet->all_sems as $k=>$v){
            $sems_year[$v['year']]=$v['year'];
        }
        $sel['year']=Get_select_opt_htm($sems_year,$pars['year'],'1');
        // 學期
        $terms=['1'=>'1','2'=>'2'];
        $sel['term']=Get_select_opt_htm($terms,$pars['term'],1);
        // 學程
        $sel['major_htm']=Get_select_opt_htm($SchoolSet->depsnname,$pars['major_id'],'1');
        // 班級
        $sel['class_name']=Get_select_opt_htm($SchoolSet->class_name,$pars['class_id'],'1');
        // 學生
        $sel['stu_sn']=Get_select_grp_opt_htm($SchoolSet->classname_stuid,$pars['stu_sn'],'1');
        // 時段: 晨 日 夜間 
        $sel['AB_period']=Get_select_opt_htm($SchoolSet->AB_period,$pars['AB_period'],'1');
        $xoopsTpl->assign('sel', $sel);


        $tbl = $xoopsDB->prefix('yy_absence_time');
        $tb2 = $xoopsDB->prefix('yy_student');
        $sql = "SELECT  * , a.sn as ABsn FROM $tbl as a LEFT JOIN $tb2  as b ON a.stu_sn =b.sn";
        // echo($sql);die();

        $have_par='0';
        if($pars['year']!=''){
            $sql.=" WHERE `year`='{$pars['year']}'";
            $have_par='1';
        }
        if($pars['term']!=''){
            if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.="`term`='{$pars['term']}'";
            $have_par='1';
        }
        if(($pars['major_id']!='')){
            if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.="`major_id` = '{$pars['major_id']}'";
            $have_par='1';
        }
        if(($pars['stu_sn']!='')){
            if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.="`stu_sn` = '{$pars['stu_sn']}'";
            $have_par='1';
        }
        if(($pars['AB_period']!='')){
            if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.="`AB_period` = '{$pars['AB_period']}'";
            $have_par='1';
        }

        if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
        $sql.=" `status`!='2' ORDER BY `AB_date` DESC , `stu_sn` , `AB_period` ";
        // echo($sql);die();
        // getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        // $PageBar = getPageBar($sql, 100, 10);
        // $bar     = $PageBar['bar'];
        // $sql     = $PageBar['sql'];
        // $total   = $PageBar['total'];
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all = $ru = array();
        while($ru= $xoopsDB->fetchArray($result)){
            // die(var_dump($ru));
            $ru ['ABsn'] = $myts->htmlSpecialChars($ru['ABsn']);
            $ru ['class_name']     = $myts->htmlSpecialChars($SchoolSet->class_name[$SchoolSet->stu_sn_classid[$ru['stu_sn']]]);
            $ru ['AB_kind_name']   = $myts->htmlSpecialChars($SchoolSet->AB_kind_anther[$ru['AB_kind']]);
            $ru ['stu_name']   = $myts->htmlSpecialChars($SchoolSet->stu_anonymous[$ru['stu_sn']]);
            $ru ['depsnname']    = $myts->htmlSpecialChars($SchoolSet->depsnname[$SchoolSet->stu_dep[$ru['stu_sn']]]);
            $ru ['stu_info']    = $ru ['depsnname'].'<br>'.$ru ['class_name'].' / '.$ru ['stu_name'];
            $ru ['AB_period_name']   = $myts->htmlSpecialChars($SchoolSet->AB_period[$ru['AB_period']]);
            $ru ['sdate']   = $myts->htmlSpecialChars($ru['sdate']);
            $ru ['edate']   = $myts->htmlSpecialChars($ru['edate']);
            $ru ['AB_hour']   = $myts->htmlSpecialChars($ru['AB_hour']);
            $all []            = $ru;
            $Summary[$ru['AB_kind']]['name']=$ru['AB_kind_name'];
            $Summary[$ru['AB_kind']]['hour']+=$ru['AB_hour'];
            
        }
        // die(var_dump($all));

        ksort($Summary);
        $remove_AB_option=['G'=>'晤談'];          
        $Summary=array_diff_key($Summary, $remove_AB_option);

        foreach($Summary as $k=>$v){
            $summary_ary[]=$Summary[$k]['name'].$Summary[$k]['hour'].'小時';
        }
        if (count($summary_ary)>0){
            $summary_text='總計：'.implode("、", $summary_ary).'。';
            $xoopsTpl->assign('summary_text', $summary_text);
        }

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('AB_del', XOOPS_URL . "/modules/beck_iscore/tchstu_mag.php?op=absence_record_delete&sn=", 'sn','確定要刪除學生出缺勤紀錄？','學生出缺勤紀錄刪除。');

        $xoopsTpl->assign('all', $all);
        // $xoopsTpl->assign('bar', $bar);
        // $xoopsTpl->assign('total', $total);
        $xoopsTpl->assign('op', "absence_record_list");
    }
    function absence_record_form($pars=[],$sn){
        global $xoopsTpl,$xoopsUser,$xoopsDB;
        $SchoolSet= new SchoolSet;
        $myts = MyTextSanitizer::getInstance();

        if(!(power_chk("beck_iscore", "6") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php', 2, '無 absence_record_form 權限! error:2106201624');
        }
        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#absence_record_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form_title = '新增學生出缺勤紀錄';
        if($sn){
            $form_title = '編輯學生出缺勤紀錄';
            $tbl     = $xoopsDB->prefix('yy_absence_time');
            $sql     = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result            = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $ru                = $xoopsDB->fetchArray($result);
            $ru ['stime']          = date("H:i", strtotime($ru['sdate']));
            $ru ['etime']          = date("H:i", strtotime($ru['edate']));
        }
        $ru ['ABsn']           = $myts->htmlSpecialChars($ru['sn']);
        $ru ['year']           = $myts->htmlSpecialChars($ru['year']);
        $ru ['term']           = $myts->htmlSpecialChars($ru['term']);
        $ru ['AB_date']        = $myts->htmlSpecialChars($ru['AB_date']);
        $ru ['class_name']     = $myts->htmlSpecialChars($SchoolSet->class_name[$SchoolSet->stu_sn_classid[$ru['stu_sn']]]);
        $ru ['AB_kind_name']   = $myts->htmlSpecialChars($SchoolSet->AB_kind[$ru['AB_kind']]);
        $ru ['stu_name']       = $myts->htmlSpecialChars($SchoolSet->stu_anonymous[$ru['stu_sn']]);
        $ru ['depsnname']      = $myts->htmlSpecialChars($SchoolSet->depsnname[$SchoolSet->stu_dep[$ru['stu_sn']]]);
        $ru ['AB_period_name'] = $myts->htmlSpecialChars($SchoolSet->AB_period[$ru['AB_period']]);
        $ru ['AB_period']      = $myts->htmlSpecialChars($ru['AB_period']);
        $ru ['sdate']          = $myts->htmlSpecialChars($ru['sdate']);
        $ru ['edate']          = $myts->htmlSpecialChars($ru['edate']);
        $ru ['AB_hour']        = $myts->htmlSpecialChars($ru['AB_hour']);
        $ru ['AB_content']     = $myts->displayTarea($ru['AB_content'], 1, 0, 0, 0, 0);

        if($ru['AB_period']==''){
            $AB_period_show['1']=true;
            $AB_period_show['2']=true;
            $AB_period_show['3']=true;
        }else{
            $AB_period_show[$ru['AB_period']]=true;
        }
        $xoopsTpl->assign('AB_period_show', $AB_period_show);
        $xoopsTpl->assign('form_title', $form_title);
        $xoopsTpl->assign('ru', $ru);

        // 學年
        foreach ($SchoolSet->all_sems as $k=>$v){
        $sems_year[$v['year']]=$v['year'];
        }

        $sel['year']=Get_select_opt_htm($sems_year,$pars['year']=(($pars['year']=='')?$SchoolSet->sem_year:$pars['year']),'1');
        // 學期
        $terms=['1'=>'1','2'=>'2'];
        $sel['term']=Get_select_opt_htm($terms,$pars['term']=(($pars['term']=='')?$SchoolSet->sem_term:$pars['term']),'1');


        $sel['class_name']=Get_select_opt_htm($SchoolSet->class_name,$pars['class_id'],'1');

        if($pars['class_id']==''){
            $sel['stu']=Get_select_grp_opt_htm($SchoolSet->classname_stuid, $AB_form['stu_sn'],'1');
        }else{
            $sel['stu']=Get_select_opt_htm($SchoolSet->classid_stuid[$pars['class_id']], $AB_form['stu_sn'],'1');
        }

        $xoopsTpl->assign('stu_sn_classid', Json_encode($SchoolSet->stu_sn_classid));
        
        $sel['AB_kind']=radio_htm($SchoolSet->AB_kind,'AB_kind',$ru['AB_kind']);
        if($ru['AB_kind']=='99'){$sel['AB_kind_99']='checked';}

        $xoopsTpl->assign('sel', $sel);

        // //帶入使用者編號
        if ($sn) {
            $uid = $_SESSION['beck_iscore_adm'] ? $ru['update_user'] : $xoopsUser->uid();
        } else {
            $uid = $xoopsUser->uid();
        }
        $xoopsTpl->assign('uid', $uid);
        
        // 下個動作
        if ($sn) {
            $op='absence_record_update';
            $xoopsTpl->assign('sn', $sn);
        } else {
            $op='absence_record_insert';
        }
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

        // die(var_dump($ru));
    }
    function absence_record_update($sn){
        global $xoopsDB,$xoopsUser;

        if(!(power_chk("beck_iscore", "6") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php', 2, '無 absence_record_update 權限! error:2106221340');
        }

        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=absence_record_list", 2, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // die();

        if($AB_period=='1'){
            $sql_sdate=$AB_date.' '.$earlym_stime.':00';
            $sql_edate=$AB_date.' '.$earlym_etime.':00';
            $sql_AB_hour=$earlym_hour;

        }elseif($AB_period=='2'){
            $sql_sdate=$AB_date.' '.$morning_stime.':00';
            $sql_edate=$AB_date.' '.$morning_etime.':00';
            $sql_AB_hour=$morning_hour;

        }elseif($AB_period=='3'){
            $sql_sdate=$AB_date.' '.$night_stime.':00';
            $sql_edate=$AB_date.' '.$night_etime.':00';
            $sql_AB_hour=$night_hour;
        }

        // 更新缺曠明細
        $tbl = $xoopsDB->prefix('yy_absence_time');
        $sql = "update " . $tbl . " set 
                `AB_kind`='{$AB_kind}',      
                `AB_other_text`='{$AB_other_text}',      
                `AB_date`='{$AB_date}',      
                `AB_content`='{$AB_content}',      
                `AB_period`='{$AB_period}',      
                `sdate`='{$sql_sdate}',          
                `edate`='{$sql_edate}',          
                `AB_hour`='{$sql_AB_hour}',
                `update_user`='{$uid}',
                `update_date`=now()
                where `sn`='{$sn}' 
                ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        // echo($sql);die();

        return;
    }
    function absence_record_insert(){
        global $xoopsDB,$xoopsUser;
        if(!(power_chk("beck_iscore", "6") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php', 2, '無 absence_record_insert 權限! error:2106221000');
        }
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=absence_record_list", 2, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // die();
    
        $Ab_times=[];
        if($earlym_hour!=''){
            $Ab_times['1']['sdate']=$AB_date.' '.$earlym_stime.':00';
            $Ab_times['1']['edate']=$AB_date.' '.$earlym_etime.':00';
            $Ab_times['1']['hour']=$earlym_hour;
        }
        if($morning_hour!=''){
            $Ab_times['2']['sdate']=$AB_date.' '.$morning_stime.':00';
            $Ab_times['2']['edate']=$AB_date.' '.$morning_etime.':00';
            $Ab_times['2']['hour']=$morning_hour;
        }
        if($night_hour!=''){
            $Ab_times['3']['sdate']=$AB_date.' '.$night_stime.':00';
            $Ab_times['3']['edate']=$AB_date.' '.$night_etime.':00';
            $Ab_times['3']['hour']=$night_hour;
        }
        // var_dump($Ab_times);die();

        $tbl = $xoopsDB->prefix('yy_absence_time');
        foreach($Ab_times as $AB_period=>$v){
            $sql = "insert into `$tbl` (
                        `year`,`term`,`stu_sn`,`AB_kind`,`AB_other_text`,
                        `AB_date`,`AB_content`,`AB_period`,`sdate`,`edate`,
                        `AB_hour`,`update_user`,`update_date`
                    )values(
                        '{$year}','{$term}','{$stu_id}','{$AB_kind}','{$AB_other_text}',
                        '{$AB_date}','{$AB_content}','{$AB_period}','{$v['sdate']}','{$v['edate']}',
                        '{$v['hour']}','{$uid}',now()
                    )";
            // echo($sql);die();
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            // $sn = $xoopsDB->getInsertId(); //取得最後新增的編號
        }
        return;
    }

// ----------------------------------
// 獎懲管理
    function reward_punishment_sum($pars=[]){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        $SchoolSet= new SchoolSet;
        $myts = MyTextSanitizer::getInstance();
        if(!(power_chk("beck_iscore", "6") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php', 2, '無 reward_punishment_sum 權限! error:2106191755');
        }
        
    
        $sel['sdate']=$pars['sdate'];
        $sel['edate']=$pars['edate'];
        $xoopsTpl->assign('sel', $sel);

        $tbl = $xoopsDB->prefix('yy_reward_punishment');
        $tb2 = $xoopsDB->prefix('yy_student');
        $sql = "SELECT  student_sn,RP_option,sum(RP_times) as sum_times
                FROM $tbl as rp LEFT JOIN $tb2 as st ON rp.student_sn =st.sn
                ";
        $have_par='0';
        if(($pars['sdate']!='' AND $pars['edate']!='')){
            $sql.=" WHERE `event_date` >= '{$pars['sdate']}' AND `event_date` <= '{$pars['edate']}'";
            $have_par='1';
        }
        if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.=" `status`!='2' GROUP BY RP_option,student_sn
                ORDER BY major_id,st.sort";
        // echo($sql);die();

        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all = $ru =  array();
        while($ru= $xoopsDB->fetchArray($result)){
            $ru ['student_sn'] = $myts->htmlSpecialChars($ru['student_sn']);
            $ru ['RP_option']  = $myts->htmlSpecialChars($ru['RP_option']);
            $ru ['sum_times']  = $myts->htmlSpecialChars($ru['sum_times']);
            $all [$ru ['student_sn']][$ru ['RP_option']] = $ru ['sum_times'];
        }
        // var_dump($SchoolSet->RP_option);die();
        $option_sum=[];
        foreach ($all as $stusn => $v1){
            foreach ($SchoolSet->RP_option as $key => $opt_name){
                $option_sum[$stusn][$key]=$all[$stusn][$key]??'0';
            }

            $option_sum[$stusn]['title']=$SchoolSet->class_name[$SchoolSet->stu_sn_classid[$stusn]].'/'.$SchoolSet->stu_anonymous[$stusn];
        }
        // var_dump($SchoolSet->sem_term_sdate);die();

        $xoopsTpl->assign('sem_term_sdate', $SchoolSet->sem_term_sdate);
        $xoopsTpl->assign('sem_term_edate', $SchoolSet->sem_term_edate);
        $xoopsTpl->assign('all', $option_sum);
        $xoopsTpl->assign('RP_option', $SchoolSet->RP_option);
        $xoopsTpl->assign('op', "reward_punishment_sum");
    }
    function reward_punishment_update($sn){
        global $xoopsDB,$xoopsUser;

        if(!(power_chk("beck_iscore", "6") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php', 2, '無 reward_punishment_update 權限! error:2106190900');
        }

        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=reward_punishment_list", 2, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // var_dump($_POST);die();

        // var_dump($counseling_op);die();
        // 更新獎懲紀錄
        $tbl = $xoopsDB->prefix('yy_reward_punishment');
        $sql = "update " . $tbl . " set 
            `student_sn`='{$student_sn}',
            `RP_kind`='{$RP_kind}',
            `RP_content`='{$RP_content}',
            `RP_option`='{$RP_option}',
            `RP_times`='{$RP_times}',
            `RP_unit`='{$RP_unit}',
            `event_date`='{$event_date}',
            `update_user`='{$uid}',
            `update_date`=now()
            where `sn`='{$sn}'
            ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        return;
    }
    function reward_punishment_delete($sn){
        global $xoopsDB,$xoopsUser;

        if(!(power_chk("beck_iscore", "6") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php', 2, '無 reward_punishment_delete 權限! error:2106190045');
        }
        
        // 刪除獎懲資料
        $tbl    = $xoopsDB->prefix('yy_reward_punishment');
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        return;
    }
    function reward_punishment_insert(){
        global $xoopsDB,$xoopsUser;

        if(!(power_chk("beck_iscore", "6") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php', 2, '無 reward_punishment_insert 權限! error:2106181100');
        }

        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=counseling_list", 2, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }

        $tbl = $xoopsDB->prefix('yy_reward_punishment');
        $sql = "insert into `$tbl` (
                `year`,`term`,`student_sn`,`RP_kind`,`RP_content`,
                `RP_option`,`RP_times`,`RP_unit`,`event_date`,`update_user`,
                `update_date`
                )values(
                    '{$year}','{$term}','{$student_sn}','{$RP_kind}','{$RP_content}',
                    '{$RP_option}','{$RP_times}','{$RP_unit}','{$event_date}','{$uid}',
                    now()
                )";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號

        $re['year']=$year;
        $re['term']=$term;
        $re['stu_sn']=$student_sn;
        $re['tea_uid']=$tea_uid;
        return $re;
    }
    function reward_punishment_form($pars=[],$sn){
        global $xoopsTpl,$xoopsUser,$xoopsDB;
        $SchoolSet= new SchoolSet;
        $myts = MyTextSanitizer::getInstance();

        if(!(power_chk("beck_iscore", "6") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php', 2, '無 reward_punishment_form 權限! error:2106181100');
        }

        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#reward_punishment_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form_title = '新增學生獎懲紀錄';
        if($sn){
            $form_title = '編輯學生獎懲紀錄';
            $tbl     = $xoopsDB->prefix('yy_reward_punishment');
            $sql     = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $stu = $xoopsDB->fetchArray($result);
            if(!($stu['update_user']==$xoopsUser->uid() OR $xoopsUser->isAdmin())){
                redirect_header('tchstu_mag.php?op=reward_punishment_list', 3, '非填報人員，無權限 !error:2106190837');
            }
        }
        $xoopsTpl->assign('form_title', $form_title);
        // var_dump($stu);die();

        $RP_form['year']       = $myts->htmlSpecialChars($stu['year']??$SchoolSet->sem_year);
        $RP_form['term']       = $myts->htmlSpecialChars($stu['term']??$SchoolSet->sem_term);
        $RP_form['student_sn'] = $myts->htmlSpecialChars($stu['student_sn']);
        $RP_form['RP_kind']    = $myts->htmlSpecialChars($stu['RP_kind']);
        $RP_form['RP_content'] = $myts->displayTarea($stu['RP_content'], 1, 0, 0, 0, 0);
        $RP_form['RP_option']  = $myts->htmlSpecialChars($stu['RP_option']);
        $RP_form['RP_times']   = $myts->htmlSpecialChars($stu['RP_times']);
        $RP_form['RP_unit']    = $myts->htmlSpecialChars($stu['RP_unit']);
        $RP_form['event_date'] = $myts->htmlSpecialChars($stu['event_date']);
        $RP_form['update_user'] = $myts->htmlSpecialChars($stu['update_user']);
        $xoopsTpl->assign('RP_form', $RP_form);

        $sel_stu=Get_select_grp_opt_htm($SchoolSet->classname_stuid, $RP_form['student_sn'],'1');
        $xoopsTpl->assign('sel_stu', $sel_stu);

        $rdo_RP_kind=color_radio_htm($SchoolSet->RP_kind,'RP_kind',  $RP_form['RP_kind'],'1');
        $xoopsTpl->assign('rdo_RP_kind', $rdo_RP_kind);

        $rdo_RP_option=color_radio_htm($SchoolSet->RP_option,'RP_option', $RP_form['RP_option'],'5','0');
        $xoopsTpl->assign('rdo_RP_option', $rdo_RP_option);

        $rdo_RP_unit=radio_htm($SchoolSet->RP_unit,'RP_unit', $RP_form['RP_unit']);
        $xoopsTpl->assign('rdo_RP_unit', $rdo_RP_unit);

        // var_dump($counseling_otp_ary);die();
        // //帶入使用者編號
        if ($sn) {
            $uid = $_SESSION['beck_iscore_adm'] ? $RP_form['update_user'] : $xoopsUser->uid();
        } else {
            $uid = $xoopsUser->uid();
        }
        $xoopsTpl->assign('uid', $uid);
        
        // 下個動作
        if ($sn) {
            $op='reward_punishment_update';
            $xoopsTpl->assign('sn', $sn);
        } else {
            $op='reward_punishment_insert';
        }
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }
    function reward_punishment_list($pars=[]){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        $SchoolSet= new SchoolSet;
        $myts = MyTextSanitizer::getInstance();
        if(!(power_chk("beck_iscore", "6") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php', 2, '無 reward_punishment_list 權限! error:2106171120');
        }

        $sel['RP_kind']=Get_select_opt_htm($SchoolSet->RP_kind,$pars['RP_kind'],$show_space='1');
        $sel['major_htm']=Get_select_opt_htm($SchoolSet->depsnname,$pars['dep_id'],'1');
        $sel['class_name']=Get_select_opt_htm($SchoolSet->class_name,$pars['class_id'],'1');
        $sel['stu_anonymous']=Get_select_grp_opt_htm($SchoolSet->classname_stuid,$pars['stu_sn'],'1');
        $sel['sdate']=$pars['sdate'];
        $sel['edate']=$pars['edate'];
        $xoopsTpl->assign('sel', $sel);

        $tbl = $xoopsDB->prefix('yy_reward_punishment');
        $tb2 = $xoopsDB->prefix('yy_student');
        $sql = "SELECT  *,$tbl.sn as rpsn FROM $tbl LEFT JOIN $tb2 ON $tbl.student_sn =$tb2.sn";

        $have_par='0';
        if($pars['RP_kind']!=''){
            $sql.=" WHERE `RP_kind`='{$pars['RP_kind']}'";
            $have_par='1';
        }
        if($pars['dep_id']!=''){
            if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.="`major_id`='{$pars['dep_id']}'";
            $have_par='1';
        }
        if(($pars['class_id']!='')){
            if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.="`class_id` = '{$pars['class_id']}'";
            $have_par='1';
        }
        if(($pars['stu_sn']!='')){
            if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.="`student_sn` = '{$pars['stu_sn']}'";
            $have_par='1';
        }
        if(($pars['sdate']!='' AND $pars['edate']!='')){
            if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.=" `event_date` >= '{$pars['sdate']}' AND `event_date` <= '{$pars['edate']}'";
            $have_par='1';
        }
        if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
        $sql.=" `status`!='2' ORDER BY `event_date` DESC";
        // echo($sql);die();
        //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        // $PageBar = getPageBar($sql, 100, 10);
        // $bar     = $PageBar['bar'];
        // $sql     = $PageBar['sql'];
        // $total   = $PageBar['total'];
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all = $ru =$Summary= array();
        while($ru= $xoopsDB->fetchArray($result)){
            $ru ['year']       = $myts->htmlSpecialChars($ru['year']);
            $ru ['term']       = $myts->htmlSpecialChars($ru['term']);
            if($ru['RP_kind']=='1'){$ru['color']='text-success';}else{$ru['color']='text-danger';}
            $ru ['RP_kind_name']    = $myts->htmlSpecialChars($SchoolSet->RP_kind[$ru['RP_kind']]);
            $ru ['event_date'] = $myts->htmlSpecialChars($ru['event_date']);
            $ru ['student_name'] = $myts->htmlSpecialChars($SchoolSet->stu_anonymous[$ru['student_sn']]);
            $ru ['class_name']    = $myts->htmlSpecialChars($SchoolSet->class_name[$SchoolSet->stu_sn_classid[$ru['student_sn']]]);
            $ru ['depsnname']    = $myts->htmlSpecialChars($SchoolSet->depsnname[$SchoolSet->stu_dep[$ru['student_sn']]]);
            $ru ['stu_info']    = $ru ['depsnname'].'<br>'.$ru ['class_name'].' / '.$ru ['student_name'];
            $ru ['RP_content'] = $myts->displayTarea($ru['RP_content'], 1, 0, 0, 0, 0);
            $ru ['depsnname']    = $myts->htmlSpecialChars($SchoolSet->depsnname[$SchoolSet->stu_dep[$ru['student_sn']]]);
            $ru ['RP_option_name'] = $myts->htmlSpecialChars($SchoolSet->RP_option[$ru['RP_option']]);
            $ru ['RP_times']  = $myts->htmlSpecialChars($ru['RP_times']);
            $ru ['RP_unit_name']   = $myts->htmlSpecialChars($SchoolSet->RP_unit[$ru['RP_unit']]);
            $ru ['RP_item']   = $ru ['RP_option_name']. $ru ['RP_times'].$ru ['RP_unit_name'] ;
            $all []            = $ru;
            $Summary[$ru['RP_option']]['name']=$ru['RP_option_name'];
            $Summary[$ru['RP_option']]['times']+=$ru['RP_times'];
            $Summary[$ru['RP_option']]['unit']=$ru['RP_unit_name'];
        }
        ksort($Summary);
        $remove_RP_option=['1'=>'白鴿','5'=>'榮譽假時數','9'=>'減少榮舉假','10'=>'罰勤'];          
        $Summary=array_diff_key($Summary, $remove_RP_option);

        foreach($Summary as $k=>$v){
            $summary_ary[]=$Summary[$k]['times'].$Summary[$k]['unit'].$Summary[$k]['name'];
        }
        if (count($summary_ary)>0){
            $summary_text='總計共：'.implode("，", $summary_ary).'。';
            $xoopsTpl->assign('summary_text', $summary_text);
        }

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('RP_del', XOOPS_URL . "/modules/beck_iscore/tchstu_mag.php?op=reward_punishment_delete&sn=", 'sn','確定要刪除學生獎懲紀錄','學生獎懲紀錄刪除。');
        

        $xoopsTpl->assign('all', $all);
        // $xoopsTpl->assign('bar', $bar);
        // $xoopsTpl->assign('total', $total);
        $xoopsTpl->assign('op', "reward_punishment_list");
    }


// ----------------------------------
// 學生認輔管理
    function counseling_update($sn){
        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser) {
            redirect_header('tchstu_mag.php', 2, '無 counseling_update 權限! error:21060121730');
        }
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=counseling_show", 2, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        
        $CounselingFocus_ary = implode(",", Request::getArray('CounselingFocus')); ;
        // var_dump($CounselingFocus_ary);die();

        // 更新認輔紀錄
        $tbl = $xoopsDB->prefix('yy_counseling_rec');
        $sql = "update " . $tbl . " set 
            `notice_time`='{$notice_time}',
            `AdoptionInterviewLocation`='{$AdoptionInterviewLocation}',
            `location`='{$location}',
            `CounselingFocus`='{$CounselingFocus_ary}',
            `focus`='{$focus}',
            `content`='{$content}',
            `update_user`='{$uid}',
            `update_date`=now()
            where `sn`='{$sn}'
            ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        //上傳表單（enctype='multipart/form-data'）
        $TadUpFiles=new TadUpFiles("beck_iscore","/counseling");
        // 上傳附檔
        $TadUpFiles->set_col('counseling_file',$sn);
        $TadUpFiles->upload_file('counseling_file');

        $re['year']=$year;
        $re['term']=$term;
        $re['stu_sn']=$student_sn;
        $re['tea_uid']=$tea_uid;
        return $re;
    }

    function counseling_insert(){
        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser) {
            redirect_header('tchstu_mag.php', 2, '無 counseling_insert 權限! error:21060121730');
        }
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=counseling_list", 2, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }

        $CounselingFocus_ary = Request::getArray('CounselingFocus');
        // 輔導重點轉string
        $Counseling_ary2str=implode(",",$CounselingFocus_ary); 
        $tbl = $xoopsDB->prefix('yy_counseling_rec');
        $sql = "insert into `$tbl` (
                `year`,`term`,`notice_time`,`student_sn`,`tea_uid`,
                `AdoptionInterviewLocation`,`location`,`CounselingFocus`,`focus`,`content`,
                `update_user`,`update_date`
                )values(
                    '{$year}','{$term}','{$notice_time}','{$student_sn}','{$tea_uid}',
                    '{$AdoptionInterviewLocation}','{$location}','{$Counseling_ary2str}','{$focus}','{$content}',
                    '{$uid}',now()
                )";
        // echo($sql);die();
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號
        
        //上傳表單（enctype='multipart/form-data'）
        $TadUpFiles=new TadUpFiles("beck_iscore","/counseling");
        // 上傳附檔
        $TadUpFiles->set_col('counseling_file',$sn);
        $TadUpFiles->upload_file('counseling_file');

        $re['year']=$year;
        $re['term']=$term;
        $re['stu_sn']=$student_sn;
        $re['tea_uid']=$tea_uid;
        return $re;
    }

    function counseling_form($pars=[],$sn){
        global $xoopsTpl,$xoopsUser,$xoopsDB;
        $SchoolSet= new SchoolSet;
        $myts = MyTextSanitizer::getInstance();

        if (!$xoopsUser) {
            redirect_header('tchstu_mag.php', 2, '無 counseling_form 權限! error:21060121000');
        }

        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#counseling_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form_title = '新增認輔學生紀錄';
        if($sn){
            $form_title = '編輯認輔學生紀錄';
            $tbl     = $xoopsDB->prefix('yy_counseling_rec');
            $sql     = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $stu = $xoopsDB->fetchArray($result);
            if(!($stu['tea_uid']==$xoopsUser->uid() OR $xoopsUser->isAdmin())){
                redirect_header('tchstu_mag.php?op=counseling_list', 3, '非填報人員，無權限 !error:2105302220');
            }
        }
        $xoopsTpl->assign('form_title', $form_title);
        $info['sn']                        = $myts->htmlSpecialChars($stu['sn']);
        $info['year']                      = $myts->htmlSpecialChars($stu['year']??$pars['year']);
        $info['term']                      = $myts->htmlSpecialChars($stu['term']??$pars['term']);
        $info['notice_time']               = $myts->htmlSpecialChars($stu['notice_time']??'');
        $info['student_sn']                = $myts->htmlSpecialChars($stu['student_sn']??$pars['stu_sn']);
        $info['tea_uid']                   = $myts->htmlSpecialChars($stu['tea_uid']??$pars['tea_uid']);
        $info['content']                   = $myts->displayTarea($stu['content'], 1, 0, 0, 0, 0);
        $info['AdoptionInterviewLocation'] = $myts->htmlSpecialChars($stu['AdoptionInterviewLocation']);
        $info['location']                  = $myts->htmlSpecialChars($stu['location']);
        $info['CounselingFocus']           = $myts->htmlSpecialChars($stu['CounselingFocus']);
        $info['CounselingFocus_ary']       = explode(",",$info['CounselingFocus']);
        $info['focus']                     = $myts->htmlSpecialChars($stu['focus']);
        $info['stu_name']                  = $SchoolSet->stu_anonymous[$info['student_sn']];
        $info['tea_name']                  = $SchoolSet->uid2name[$info['tea_uid']];
        $info['class']                     = $SchoolSet->class_name[$SchoolSet->stu_sn_classid[$info['student_sn']]];
        $xoopsTpl->assign('info', $info);

        $chk['location']=radio_htm($SchoolSet->sys_config['AdoptionInterviewLocation'],'AdoptionInterviewLocation',$info['AdoptionInterviewLocation']);
        $chk['focus']=checkbox_htm($SchoolSet->sys_config['CounselingFocus'],'CounselingFocus[]',$info['CounselingFocus_ary'],1.5);

        if($info['AdoptionInterviewLocation']=='99'){
            $chk_99['AdoptionInterviewLocation']='checked';
        }else{
            $chk_99['AdoptionInterviewLocation']='';
        }

        if(in_array('99',$info['CounselingFocus_ary'])){
            $chk_99['CounselingFocus']='checked';
        }else{
            $chk_99['CounselingFocus']='';
        }

        $xoopsTpl->assign('chk', $chk);
        $xoopsTpl->assign('chk_99', $chk_99);
        
        // var_dump($counseling_otp_ary);die();
        // //帶入使用者編號
        if ($sn) {
            $uid = $_SESSION['beck_iscore_adm'] ? $info['tea_uid'] : $xoopsUser->uid();
        } else {
            $uid = $xoopsUser->uid();
        }
        $xoopsTpl->assign('uid', $uid);
        
        // 下個動作
        if ($sn) {
            $op='counseling_update';
            $xoopsTpl->assign('sn', $sn);
        } else {
            $op='counseling_insert';
        }
        $xoopsTpl->assign('op', $op);


        //上傳附檔
        $TadUpFiles=new TadUpFiles("beck_iscore","/counseling");
        $TadUpFiles->set_col('counseling_file',$sn); //若 $show_list_del_file ==true 時一定要有
        $upform=$TadUpFiles->upform(true,'counseling_file');
        $xoopsTpl->assign('upform', $upform);
        
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }

    function counseling_delete($sn){
        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser) {
            redirect_header('tchstu_mag.php', 2, '無 counseling_delete 權限! error:21060142116');
        }    

        $tbl     = $xoopsDB->prefix('yy_counseling_rec');
        $sql     = "SELECT * FROM $tbl Where `sn`='{$sn}'";
        $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $stu = $xoopsDB->fetchArray($result);
        if(!($stu['tea_uid']==$xoopsUser->uid() OR $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php?op=counseling_list', 3, '非填報人員，無權限 !error:2106142120');
        }
        // die(var_dump($stu));

        // 刪除認輔資料
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        // 附檔刪除
        $TadUpFiles=new TadUpFiles("beck_iscore","/counseling");
        $TadUpFiles->set_col('counseling_file', $sn);
        $TadUpFiles->del_files();

        return $stu;
    }

    function counseling_show($pars=[]){
        global $xoopsTpl,$xoopsUser,$xoopsDB;
        $SchoolSet= new SchoolSet;
        $myts = MyTextSanitizer::getInstance();

        if (!$xoopsUser) {
            redirect_header('tchstu_mag.php', 2, '無 counseling_show 權限! error:21060120942');
        }

        $info['stu_name']=$SchoolSet->stu_anonymous_all[$pars['stu_sn']];
        $info['tea_name']=$SchoolSet->uid2name[$pars['tea_uid']];
        $info['class']=$SchoolSet->class_name_all[$SchoolSet->stu_sn_classid_all[$pars['stu_sn']]];
        $info['stu_sn']=$pars['stu_sn'];
        $info['tea_uid']=$pars['tea_uid'];
        $info['year']=$pars['year'];
        $info['term']=$pars['term'];
        $xoopsTpl->assign('info', $info);
        
        $tbl     = $xoopsDB->prefix('yy_tea_counseling');
        $sql     = "SELECT * FROM $tbl 
                    Where `year`='{$info['year']}' 
                    AND `term`='{$info['term']}'
                    AND `student_sn`='{$info['stu_sn']}'
                    AND `tea_uid`='{$info['tea_uid']}'";
        $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $stu = $xoopsDB->fetchArray($result);
        
        if(!($stu['tea_uid']==$xoopsUser->uid() OR $xoopsUser->isAdmin() or power_chk("beck_iscore", "5"))){
            redirect_header('tchstu_mag.php?op=counseling_list', 3, '非填報人員，無權限 !error:2106131027');
        }

        $tbl      = $xoopsDB->prefix('yy_counseling_rec');
        $sql      = "SELECT * FROM $tbl
                    Where `year`='{$info['year']}' 
                    AND `term`='{$info['term']}'
                    AND `student_sn`='{$info['stu_sn']}'
                    AND `tea_uid`='{$info['tea_uid']}'
                        ORDER BY `sn` DESC"; 
        // echo($sql);die();                    
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all  = $Counsel = array();
        $opt_all=$SchoolSet->sys_config;
        
        // 顯示附檔
        $TadUpFiles=new TadUpFiles("beck_iscore","/counseling");
        while($ycr= $xoopsDB->fetchArray($result)){
            $ycr['sn']                        = $myts->htmlSpecialChars($ycr['sn']);
            $ycr['year']                      = $myts->htmlSpecialChars($ycr['year']);
            $ycr['term']                      = $myts->htmlSpecialChars($ycr['term']);
            $ycr['notice_time']               = $myts->htmlSpecialChars($ycr['notice_time']);
            $ycr['student_sn']                = $myts->htmlSpecialChars($ycr['student_sn']);
            $ycr['tea_uid']                   = $myts->htmlSpecialChars($ycr['tea_uid']);
            $ycr['content_ptr']               = str_replace("\n","<br>",$ycr['content']);
            $ycr['content']                   = $myts->displayTarea($ycr['content'], 1, 0, 0, 0, 0);
            $ycr['AdoptionInterviewLocation'] = $myts->htmlSpecialChars($ycr['AdoptionInterviewLocation']);
            $ycr['location']                  = $myts->htmlSpecialChars($ycr['location']);
            $ycr['CounselingFocus']           = $myts->htmlSpecialChars($ycr['CounselingFocus']);
            $ycr['focus']                     = $myts->htmlSpecialChars($ycr['focus']);
            $TadUpFiles->set_col('counseling_file',$ycr['sn']);
            $Counsel[$ycr['sn']]['files'] = $TadUpFiles->show_files('counseling_file',false,'filename');
            $ycr['AdoptionLocation_htm'] = $ycr['AdoptionLocation_oth_htm']=$ycr['CounselingFocus_htm']=$ycr['CounselingFocus_oth_htm']='';
            // 面談地點
            foreach($opt_all['AdoptionInterviewLocation'] as $v=>$text){
                if($v==$ycr['AdoptionInterviewLocation']){
                    $ycr['AdoptionLocation_htm'].="<div class='col-2'><i class='fa fa-square' aria-hidden='true'></i> {$text}</div>";
                }else{
                    $ycr['AdoptionLocation_htm'].="<div class='col-2'><i class='fa fa-square-o' aria-hidden='true'></i> {$text}</div>";
                }
            }
            if($ycr['AdoptionInterviewLocation']=='99'){
                $ycr['AdoptionLocation_oth_htm'].=<<<HTML
                        <div><i class="fa fa-square" aria-hidden="true"></i> 其他： <u>{$ycr['location']}</u></div>
                HTML;
            }else{
                $ycr['AdoptionLocation_oth_htm'].=<<<HTML
                        <div><i class="fa fa-square-o" aria-hidden="true"></i> 其他： <u></u></div>
                HTML;
            }
            // 輔導重點
            foreach($opt_all['CounselingFocus'] as $v=>$text){
                if(in_array($v,explode(",",$ycr['CounselingFocus']))){
                    $ycr['CounselingFocus_htm'].="<div class='col-2'><i class='fa fa-square' aria-hidden='true'></i> {$text}</div>";
                }else{
                    $ycr['CounselingFocus_htm'].="<div class='col-2'><i class='fa fa-square-o' aria-hidden='true'></i> {$text}</div>";
                }
            }
            if(in_array('99',explode(",",$ycr['CounselingFocus']))){
                $ycr['CounselingFocus_oth_htm'].=<<<HTML
                <div><i class="fa fa-square" aria-hidden="true"></i>其他： <u>{$ycr['focus']}</u></div>
            HTML;
            }else{
                $ycr['CounselingFocus_oth_htm'].=<<<HTML
                <div><i class="fa fa-square-o" aria-hidden="true"></i> 其他： <u></u></div>
            HTML;
            }
            
            $all [$ycr['sn']]             = $ycr;
        }
        $xoopsTpl->assign('all', $all);
        $xoopsTpl->assign('Counsel', $Counsel);
        
        $uid = $_SESSION['beck_iscore_adm'] ? $ycr['tea_uid'] : $xoopsUser->uid();
        $xoopsTpl->assign('uid', $uid);

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('counseling_del', XOOPS_URL . "/modules/beck_iscore/tchstu_mag.php?op=counseling_delete&sn=", 'sn','確定要刪除認輔紀錄','學生認輔紀錄刪除。');
    }

    function counseling_list($pars=[]){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        $SchoolSet= new SchoolSet;
        $myts = MyTextSanitizer::getInstance();
        
        $counseling_manage=false;
        if((power_chk("beck_iscore", "5") or $xoopsUser->isAdmin())){
            $counseling_manage=true;
            $xoopsTpl->assign('counseling_manage', $counseling_manage);

        }
        if (!$xoopsUser) {
            redirect_header('tchstu_mag.php', 2, '無 counseling_list 權限! error:2106081000');
        }

        $pars['cos_year']=($pars['cos_year']=='')?(string)$SchoolSet->sem_year:$pars['cos_year'];
        $pars['cos_term']=($pars['cos_term']=='')?(string)$SchoolSet->sem_term:$pars['cos_term'];


        // 學年度select
        $tbl      = $xoopsDB->prefix('yy_counseling_rec');
        $sql      = "SELECT distinct `year` , `term`  FROM $tbl ORDER BY `year`" ;
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while($year_ary= $xoopsDB->fetchArray($result)){
            $sel['year'][$year_ary['year']]= $year_ary['year'];
            $sel['term'][$year_ary['year']][$year_ary['term']]= $year_ary['term'];
        }
        
        foreach ($SchoolSet->all_sems as $k=>$v){
            $sems_year[$v['year']]=$v['year'];
        }
        // $exam_year_htm=Get_select_opt_htm($sems_year,$exam_date['exam_year'],'1');
        // $xoopsTpl->assign('exam_year_htm', $exam_year_htm);

        // 學期 
        $terms=['1'=>'1','2'=>'2'];
        // $exam_term_htm=Get_select_opt_htm($terms,$exam_date['exam_term'],1);
        // $xoopsTpl->assign('exam_term_htm', $exam_term_htm);


        asort($sems_year);
        asort($sel['term']);

        // 學年度
        $sems_year_htm=Get_select_opt_htm($sems_year,$pars['cos_year'],'1');
        $xoopsTpl->assign('sems_year_htm', $sems_year_htm);
        // 學期
        $sems_term_htm=Get_select_opt_htm($terms,$pars['cos_term'],1);
        $xoopsTpl->assign('sems_term_htm', $sems_term_htm);
        // // 學年度
        // $sems_year_htm=Get_select_opt_htm($sel['year'],$pars['cos_year'],'1');
        // $xoopsTpl->assign('sems_year_htm', $sems_year_htm);
        // // 學期
        // $sems_term_htm=Get_select_opt_htm($sel['term'][$pars['cos_year']],$pars['cos_term'],1);
        // $xoopsTpl->assign('sems_term_htm', $sems_term_htm);

        
        if($counseling_manage){
            $tbl = $xoopsDB->prefix('yy_tea_counseling');
            $sql = "SELECT  * FROM $tbl 
                    WHERE `year`='{$pars['cos_year']}' 
                    AND  `term`='{$pars['cos_term']}' 
                    ORDER BY `year` DESC, `term` DESC, `tea_uid`"; 

            //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
            $PageBar = getPageBar($sql, 60, 10);
            $bar     = $PageBar['bar'];
            $sql     = $PageBar['sql'];
            $total   = $PageBar['total'];
        }else{
            $tbl = $xoopsDB->prefix('yy_tea_counseling');
            $sql = "SELECT  * FROM $tbl 
                    WHERE `tea_uid`='{$xoopsUser->uid()}' 
                    ORDER BY `year` DESC, `term` DESC, `student_sn`"; 
        }
        
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while($ru= $xoopsDB->fetchArray($result)){
            $data['year']          = $myts->htmlSpecialChars($ru['year']);
            $data['term']          = $myts->htmlSpecialChars($ru['term']);
            $data['tea_uid']       = $myts->htmlSpecialChars($ru['tea_uid']);
            $data['tea_name']      = $myts->htmlSpecialChars($SchoolSet->uid2name[$ru['tea_uid']]);
            $data['student_sn']    = $myts->htmlSpecialChars($ru['student_sn']);
            $data['stu_anonymous'] = $myts->htmlSpecialChars($SchoolSet->stu_anonymous_all[$ru['student_sn']]);
            $data['class_name']    = $myts->htmlSpecialChars($SchoolSet->class_name_all[$SchoolSet->stu_sn_classid_all[$ru['student_sn']]]);
            $data['class_id']      = $myts->htmlSpecialChars($SchoolSet->stu_sn_classid_all[$ru['student_sn']]);
            $all  [] = $data;
        }
        $i=0;
        $tbl = $xoopsDB->prefix('yy_counseling_rec');
        foreach($all as $k =>$v){
            $sql = "SELECT count(sn) count  FROM $tbl 
                    WHERE `year`= {$v['year']} 
                    AND `term`= {$v['term']}
                    AND `student_sn`= {$v['student_sn']}
                    GROUP BY `year`,`term`,`student_sn`
            ";
            $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $ru= $xoopsDB->fetchArray($result);
            $all[$i]['count']=$ru['count']??'0';
            $i++;
        }
            // var_dump($all);die();

        $xoopsTpl->assign('all', $all);
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);
        $xoopsTpl->assign('op', "counseling_list");
    }

// ----------------------------------
// 每月高關懷名單 
    // 列表- 高關懷名單
    function high_care_list($g2p){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        $SchoolSet= new SchoolSet;
        if(!(power_chk("beck_iscore", "4") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php', 2, '無 high_care_list 權限! error:2105311342');
        }
        $myts = MyTextSanitizer::getInstance();

        $tbl      = $xoopsDB->prefix('yy_high_care');
        $sql      = "SELECT  `year`,`month`,min(`keyin_date`) as event_date FROM $tbl GROUP BY `year`,`month` ORDER BY `year` DESC  , `month` DESC";
        // echo($sql);die();
        //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = getPageBar($sql, 20, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];

        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all      = array();
        $i=1;
        if($g2p==''or $g2p==1){$i=1;}else{$i=($g2p-1)*20+$i;}
        while(  $hcm= $xoopsDB->fetchArray($result)){
            $hcm['sn']         = $myts->htmlSpecialChars($i);
            $hcm['year']       = $myts->htmlSpecialChars($hcm['year']);
            $hcm['month']      = $myts->htmlSpecialChars($hcm['month']);
            $hcm['event']      = $myts->htmlSpecialChars($hcm['year'].'年'.$hcm['month'].'月，高關懷名單');
            $hcm['event_date'] = $myts->htmlSpecialChars($hcm['event_date']);
            $all []            = $hcm;
            $i++;
        }

        $xoopsTpl->assign('all', $all);
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);
        
        // die(var_dump($all));

    }
    // sql-刪除 每月高關懷名單 
    function high_care_delete($sn){
        global $xoopsDB,$xoopsUser;

        if(!(power_chk("beck_iscore", "4") or $xoopsUser->isAdmin())){
            redirect_header('index.php', 3, '無 high_care_delete 權限!error:2105310845');
        }       

        $tbl     = $xoopsDB->prefix('yy_high_care');
        $sql     = "SELECT * FROM $tbl Where `sn`='{$sn}'";
        $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $stu = $xoopsDB->fetchArray($result);
        if(!($stu['update_user']==$xoopsUser->uid() OR $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php?op=high_care_mon', 3, '非填報人員，無刪除權限 !error:2105310849');
        }

        // 刪除資料
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        return $stu;
    }
    // sql-更新 高關懷名單紀錄
    function high_care_update($sn){
        global $xoopsDB,$xoopsUser;
        $SchoolSet= new SchoolSet;
        
        if(!(power_chk("beck_iscore", "4") or $xoopsUser->isAdmin())){
            redirect_header('index.php', 3, '無 high_care_update 權限!error:2105310800');
        } 
        
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("school_affairs.php?op=dept_school_form&sn={$sn}", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // die();
        
        // 更新高關懷名單紀錄
        $tbl = $xoopsDB->prefix('yy_high_care');
        $sql = "update " . $tbl . " 
                set `keyin_date`=now(), 
                    `event_desc` ='{$event_desc}',
                    `update_user` ='{$uid}',
                    `update_date` =now()
                where `sn`='{$sn}'
                ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $re['year']=$year;
        $re['month']=$month;

        return true;
    }
    // 新增高關懷名單sql
    function high_care_insert(){
        global $xoopsDB,$xoopsUser;
        $SchoolSet= new SchoolSet;
        
        if(!(power_chk("beck_iscore", "4") or $xoopsUser->isAdmin())){
            redirect_header('index.php', 3, '無 high_care_insert 權限!error:2105301615');
        } 

        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=high_care_mon", 3, '新增 每月高關懷名單 ，表單Token錯誤，請重新輸入!'.!$GLOBALS['xoopsSecurity']->check());
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        $class_id=($SchoolSet->stu_sn_classid[$student_sn]);

        $tbl = $xoopsDB->prefix('yy_high_care');
        $sql = "insert into `$tbl` (
            `year`,`month`,`student_sn`,`class_id`,`event_desc`,
            `keyin_date`,`update_user`,`update_date`) 
            values(
            '{$year}','{$month}','{$student_sn}','{$class_id}','{$event_desc}',
            now(),'{$uid}',now()
            )";
        // echo($sql); 
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號
        
        $re['year']=$year;
        $re['month']=$month;

        return $re;
    }
    // 表單-新增、編輯 學生
    function high_care_form($sn){
        global $xoopsTpl,$xoopsUser,$xoopsDB;
        $SchoolSet= new SchoolSet;
        $myts = MyTextSanitizer::getInstance();

        if(!(power_chk("beck_iscore", "4") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php?op=high_care_mon', 3, '無 high_care_form 權限!error:2105281537');
        }        
        // 西元年轉民國年
        $taiwan_year = date('Y')-1911;
        $now_month = date('m');
        // $taiwan_year_v = str_pad($taiwan_year,3,'0',STR_PAD_LEFT);//將數字由左邊補零至3位數
        $now_year_ary = [$taiwan_year=>(string)$taiwan_year,$taiwan_year+1=>(string)($taiwan_year+1)];
        // 通報時間年
        $year_sel=Get_select_opt_htm($now_year_ary,$taiwan_year,'0');
        $xoopsTpl->assign('year_sel', $year_sel);
        // 通報時間月列表
        $month_sel=Get_select_opt_htm($SchoolSet->month_ary,$now_month,'0');
        $xoopsTpl->assign('month_sel', $month_sel);
        // 學生sn[name]
        $stu_sel=Get_select_opt_htm($SchoolSet->stu_anonymous,'','1');
        $xoopsTpl->assign('stu_sel', $stu_sel);
        // 填寫人員
        $xoopsTpl->assign('teacher_name', $xoopsUser->name());

        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#op_high_care_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form_title = '新增每月高關懷學生';
        $stu = array();

        if($sn){
            $form_title = '編輯高關懷學生紀錄';
            $tbl     = $xoopsDB->prefix('yy_high_care');
            $sql     = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $stu = $xoopsDB->fetchArray($result);
            $xoopsTpl->assign('edit', ture);
            if(!($stu['update_user']==$xoopsUser->uid() OR $xoopsUser->isAdmin())){
                redirect_header('tchstu_mag.php?op=high_care_mon', 3, '非填報人員，無權限 !error:2105302220');
            }
        }
        $xoopsTpl->assign('form_title', $form_title);
        $stu['year']         = $myts->htmlSpecialChars($stu['year']??$taiwan_year);                //日期
        $stu['month']        = $myts->htmlSpecialChars($stu['month']??$now_month);                 //月份
        $stu['student_name'] = $myts->htmlSpecialChars($SchoolSet->stu_anonymous[$stu['student_sn']]);
        $stu['event_desc']   = $myts->displayTarea($stu['event_desc'], 1, 0, 0, 0, 0);
        $xoopsTpl->assign('stu', $stu);
        
        // var_dump($_SESSION);die();
        // //帶入使用者編號
        if ($sn) {
            $uid = $_SESSION['beck_iscore_adm'] ? $stu['update_user'] : $xoopsUser->uid();
        } else {
            $uid = $xoopsUser->uid();
        }
        $xoopsTpl->assign('uid', $uid);
        
        // 下個動作
        if ($sn) {
            $op='high_care_update';
            $xoopsTpl->assign('sn', $sn);
        } else {
            $op='high_care_insert';
        }
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }
    // 該月高關懷名單
    function high_care_mon($hi_care=[]){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        $myts = MyTextSanitizer::getInstance();
        $SchoolSet= new SchoolSet;
        if(!(power_chk("beck_iscore", "4") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php', 2, '無 high_care_mon 權限! error:2105272100');
        }
        // 西元年轉民國年
        $taiwan_year = date('Y')-1911;
        $now_month = date('m');
        $hi_care['year']=($hi_care['year']=='')?(string)$taiwan_year:$hi_care['year'];
        $hi_care['month']=($hi_care['month']=='')?(string)$now_month:$hi_care['month'];

        $tbl      = $xoopsDB->prefix('yy_high_care');
        $sql      = "SELECT distinct `year` FROM $tbl ORDER BY `year`" ;
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while($year_ary= $xoopsDB->fetchArray($result)){
            $years['year']= $myts->htmlSpecialChars($year_ary['year']);
            $now_year_ary [$years['year']] = $years['year'];
        }
        asort($now_year_ary);
        // var_dump($all);die();

        // 通報時間列表
        $year_sel=Get_select_opt_htm($now_year_ary,$hi_care['year'],'0');
        $xoopsTpl->assign('year_sel', $year_sel);
        // 月份列表時間列表
        $month_sel=Get_select_opt_htm($SchoolSet->month_ary,$hi_care['month'],'0');
        $xoopsTpl->assign('month_sel', $month_sel);
        $xoopsTpl->assign('hi_care', $hi_care);
        // die(var_dump($hi_care));

        $tbl      = $xoopsDB->prefix('yy_high_care');
        $sql      = "SELECT  * FROM $tbl 
                        WHERE `year`= '{$hi_care['year']}'
                        AND `month`= '{$hi_care['month']}'
                        ORDER BY `sn` DESC
                        " ;
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all      = array();
        while($data= $xoopsDB->fetchArray($result)){
            $data['sn']          = $myts->htmlSpecialChars($data['sn']);
            $data['year']        = $myts->htmlSpecialChars($data['year']);
            $data['month']       = $myts->htmlSpecialChars($data['month']);
            $data['student']     = $myts->htmlSpecialChars($SchoolSet->stu_anonymous[$data['student_sn']]);
            $data['class']       = $myts->htmlSpecialChars($SchoolSet->class_name[$data['class_id']]);
            $data['event_desc']  = $myts->displayTarea($data['event_desc'], 1, 0, 0, 0, 0);
            $data['keyin_date']  = $myts->htmlSpecialChars($data['keyin_date']);
            if($data['update_user']==$xoopsUser->uid() OR $xoopsUser->isAdmin()){
                $data['edit']=true;
            }else{$data['edit']=false;}
            $data['update_user'] = $myts->htmlSpecialChars($SchoolSet->uid2name[$data['update_user']]??'未命名');
            $all  [] = $data;
        }
        $xoopsTpl->assign('all', $all);

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('hi_care_del', XOOPS_URL . "/modules/beck_iscore/tchstu_mag.php?op=high_care_delete&sn=", 'sn','確定要刪除關懷學生紀錄','關懷學生紀錄刪除。');

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

        $xoopsTpl->assign('op', "high_care_mon");

    }
// ----------------------------------
// 考科及學期總成績查詢 
    // 列印成績單
    function transcript($pars=[],$sn){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        $SchoolSet= new SchoolSet;
        $stu=[];
        $xoopsTpl->assign('pars', $pars);
        $stu['name']=$SchoolSet->stu_name_all[$sn];
        $stu['stu_id']=$SchoolSet->stu_id_all[$sn];
        $stu['dep_name']=$SchoolSet->depsnname[$SchoolSet->stu_dep_all[$sn]];
        
        // 撈出學程總成績
        $course_groupname=$SchoolSet->query_course_groupname($pars['cos_year'],$pars['cos_term'],$pars['dep_id'])['grpname_sumcred'];
        $term_total_score=$SchoolSet->query_term_total_score($pars['cos_year'],$pars['cos_term'],$pars['dep_id'])[$sn];
        $term_score_detail=$SchoolSet->query_term_score_detail($pars['cos_year'],$pars['cos_term'],$pars['dep_id'])[$sn];
        $xoopsTpl->assign('course_groupname', $course_groupname);

        $stu['grade']=$term_total_score['grade'];

        // var_dump($stu);die();

        $i=1;$stu_da=[];
        foreach ($course_groupname as $grp_name=>$credit){
            $stu_da[$i]['order']       = $i;
            $stu_da[$i]['grp_name']    = $grp_name;
            $stu_da[$i]['credit']      = $credit;
            // var_dump($term_total_score[$sn][$grp_name]['course_total_avg']);
            $stu_da[$i]['score']= $term_score_detail[$grp_name]['course_total_avg']??'-';
            $stu_da[$i]['total_score']= $term_score_detail[$grp_name]['course_total_score']??'-';
            $stu_da[$i]['comment']= $term_score_detail[$grp_name]['comment'];
            $i++;
        }
        $stu['sum_credits']=$term_total_score['sum_credits'];//總學分
        $stu['total_score']=$term_total_score['total_score'];//加權總分
        $stu['total_avg']=$term_total_score['total_avg'];//學期總平均

        // 導師評語
        if($sn){
            $tbl = $xoopsDB->prefix('yy_mentor_comment');
            $sql = "SELECT * FROM $tbl
                    WHERE `year` = '{$pars['cos_year']}'
                    AND `term` = '{$pars['cos_term']}'
                    AND `student_sn` = '{$sn}'";
            // echo($sql);die();
            $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $ru= $xoopsDB->fetchArray($result);
        }
        $stu['mentor_comment']=$ru['Comment'];//導師評語

        $xoopsTpl->assign('stu', $stu);
        $xoopsTpl->assign('all', $stu_da);
        // die(var_dump($stu));


        
    }
    // 學期總成績列表
    function term_total_score_list($pars=[]){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;

        if(!$xoopsUser){
            redirect_header('index.php', 3, 'term_total_score_list ! error:2105181152');
        }
        
        $SchoolSet= new SchoolSet;
        // $pars['cos_year']=$pars['cos_year']==''?$SchoolSet->sem_year:$pars['cos_year'];
        // $pars['cos_term']=$pars['cos_term']==''?$SchoolSet->sem_term:$pars['cos_term'];

        // 學年度select
        foreach ($SchoolSet->all_sems as $k=>$v){
            $sems_year[$v['year']]=$v['year'];
        }
        $sems_year_htm=Get_select_opt_htm($sems_year,$pars['cos_year'],'1');
        $xoopsTpl->assign('sems_year_htm', $sems_year_htm);
        // 學期 
        if($pars['cos_year']!=''){
            $terms=$SchoolSet->get_termarray($pars['cos_year']);
        }else{
            $terms=['1'=>'1','2'=>'2'];
        }
        $sems_term_htm=Get_select_opt_htm($terms,$pars['cos_term'],1);
        $xoopsTpl->assign('sems_term_htm', $sems_term_htm);


        // die(var_dump($terms));

        // 學程列表
        $major_name=[];
        foreach ($SchoolSet->dept as $k=>$v){
            $major_name[$v['sn']]=$v['dep_name'];
        }
        $pars['dep_name']=$SchoolSet->depsnname[$pars['dep_id']];
        $major_htm=Get_select_opt_htm($major_name,$pars['dep_id'],'1');
        $xoopsTpl->assign('major_htm', $major_htm);
        $xoopsTpl->assign('pars', $pars);


        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#stage_score_list", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $myts = MyTextSanitizer::getInstance();
        


        // 學期總成績表格
        if($pars['cos_year']!='' AND  $pars['cos_term']!='' AND $pars['dep_id']!=''){
            $xoopsTpl->assign('showtable', true);
            // 假如 學年度 學期是目前學期，才有重新計算生成成績，否則沒有
            if($pars['cos_year']==$SchoolSet->sem_year AND  $pars['cos_term']==$SchoolSet->sem_term  AND $pars['dep_id']!=''){
                $SchoolSet->year_term_score($pars['cos_year'],$pars['cos_term'],$pars['dep_id']);
            }
            
            // 撈出學程總成績
            $course_groupname=$SchoolSet->query_course_groupname($pars['cos_year'],$pars['cos_term'],$pars['dep_id']);
            $term_total_score=$SchoolSet->query_term_total_score($pars['cos_year'],$pars['cos_term'],$pars['dep_id']);
            $term_score_detail=$SchoolSet->query_term_score_detail($pars['cos_year'],$pars['cos_term'],$pars['dep_id']);
            $xoopsTpl->assign('course_groupname', $course_groupname);

            // die(var_dump($term_score_detail));
            

            $i=1;$stu_data=[];
            foreach ($term_total_score as $stu_sn=>$data){
                $stu_data[$stu_sn]['order']=$i;
                $stu_data[$stu_sn]['class_name']=$myts->htmlSpecialChars($SchoolSet->class_name_all[$SchoolSet->stu_sn_classid_all[$stu_sn]]);
                $stu_data[$stu_sn]['stu_anonymous']=$myts->htmlSpecialChars($SchoolSet->stu_anonymous_all[$stu_sn]);

                // 填入所有科目\成績 
                foreach ($course_groupname['grpname_sumcred'] as $grpname=>$sumcred){
                    $stu_data[$stu_sn]['scores'][$grpname]=$term_score_detail[$stu_sn][$grpname]['course_total_avg']??'-';
                }
                $stu_data[$stu_sn]['sum_credits']   = $term_total_score[$stu_sn]['sum_credits'];
                $stu_data[$stu_sn]['total_score']   = $term_total_score[$stu_sn]['total_score'];
                $stu_data[$stu_sn]['total_avg']     = $term_total_score[$stu_sn]['total_avg'];
                $stu_data[$stu_sn]['comment']       = $term_total_score[$stu_sn]['comment'];
                $stu_data[$stu_sn]['reward_method'] = $term_total_score[$stu_sn]['reward_method'];
                $i++;
            }
            
        
        }

        $xoopsTpl->assign('all', $stu_data);

        // $SchoolSet->sem_year;
        // $SchoolSet->sem_term;
        $xoopsTpl->assign('sem_year', $SchoolSet->sem_year);
        $xoopsTpl->assign('sem_term', $SchoolSet->sem_term);


        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

        // $xoopsTpl->assign('op', "course_list");

    }

    // sql-新增 考科成績備註
    function add_query_stage_score_comment($pars=[]){

        global $xoopsDB,$xoopsUser,$xoopsTpl;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, 'add_query_stage_score_comment! error:2105151545');
        }

        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=query_stage_score&dep_id={$pars['dep_id']}&course_id={$pars['course_id']}", 3, 'add_query_stage_score_comment失敗! error:2105151545 檢查結果:'.!$GLOBALS['xoopsSecurity']->check());
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        $comment  = Request::getArray('comment');//學生編號=>平時備註
        // die(var_dump($comment));

        // 新增學生段考成績
        $tbl = $xoopsDB->prefix('yy_query_stage_score');
        foreach($comment as $stusn=>$v){
                $sql = "update " . $tbl . " set `comment`='{$v}'  
                        where `year`='{$year}'
                        AND `term`='{$term}'
                        AND `dep_id`='{$dep_id}'
                        AND `exam_stage`='{$exam_stage}'
                        AND `student_sn`='{$stusn}'
                        ";
                $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }
        redirect_header("tchstu_mag.php?op=query_stage_score&dep_id={$dep_id}&exam_stage={$exam_stage}", 3, '存檔成功！');
    }

    // 列表- 段考成績查詢
    function query_stage_score($pars=[]){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        $SchoolSet= new SchoolSet;
        if (!$xoopsUser) {
            redirect_header('index.php', 3, '無操作權限');
        }
    
        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#stage_score_list", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $myts = MyTextSanitizer::getInstance();

        // 學程名稱下拉選單
        $course['major_htm']=Get_select_opt_htm($SchoolSet->depsnname,$pars['dep_id'],'1');
        // 段考名稱 下拉選單
        // $course['exam_number_htm']=Get_select_opt_htm($SchoolSet->stage_exam_name+['8' => '總成績'],$pars['exam_stage'],'1');
        $course['exam_number_htm']=Get_select_opt_htm($SchoolSet->stage_exam_name,$pars['exam_stage'],'1');
        $course['year']=$SchoolSet->sem_year;
        $course['term']=$SchoolSet->sem_term;
        $course['dep_id']=$pars['dep_id'];
        

        if(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin()){
            $xoopsTpl->assign("ps_edit",true);
        } 

        if($pars['dep_id']!='' AND  $pars['exam_stage']!=''){
            $xoopsTpl->assign('showtable', true);
            $xoopsTpl->assign('pars', $pars);

            if($pars['exam_stage']=='4'){
                $stu_first_exam_avg_score=$SchoolSet->first_exam_avg_score($pars['dep_id']);
            }else{
                $stu_first_exam_avg_score=[];
            }

            // 找出這學期，這次段考的備註[stu_id]=comment
            $stu_comment=$SchoolSet->exam_comment($pars['dep_id'],$pars['exam_stage']);
        
            // 列出一~三次段考 [學程] [段考] [課程id]=[課程中文名稱]
            $dep_exam_course=$SchoolSet->dep_exam_course[$pars['dep_id']][$pars['exam_stage']];
            $xoopsTpl->assign('dep_exam_course', $dep_exam_course);

            // 列出該學程內所有學生sn, name 不含回歸結案
            $major_stu=$SchoolSet->major_stu[$pars['dep_id']];

            // [stu_sn][course id]= score 學生段考成績 
            $stu_score=$SchoolSet->dept_exam_course_score($pars['dep_id'],$pars['exam_stage'],array_keys($dep_exam_course));

            $i=1;
            foreach ($major_stu as $k=>$stu_sn){
                $stu_data[$stu_sn]['order']=$i;
                $stu_data[$stu_sn]['class_name']=$myts->htmlSpecialChars($SchoolSet->class_name[$SchoolSet->stu_sn_classid[$stu_sn]]);
                $stu_data[$stu_sn]['stu_anonymous']=$myts->htmlSpecialChars($SchoolSet->stu_anonymous[$stu_sn]);

                // 填入所有科目段考成績 
                foreach ($dep_exam_course as $course_id=>$course_name){
                    $stu_data[$stu_sn]['scores'][$course_id]=$stu_score[$stu_sn][$course_id];
                    // $stu_data[$stu_sn]['scores'][]=$stu_score[$stu_sn][$course_id];
                }

                // 計算總分、平均
                foreach ($stu_data as $stu_sn=>$v){
                    $j=$sum=0;
                    foreach ($v['scores'] as $course_id=>$score){
                        if(is_numeric($score)){
                            $sum=$sum+$score;
                            $j++;
                        }
                    }
                    if($j==0){
                        $stu_data[$stu_sn]['sum']='-';
                        $stu_data[$stu_sn]['avg']='-';
                        $stu_data[$stu_sn]['reward_method']='';
                    }else{
                        $stu_data[$stu_sn]['sum']=$sum;
                        $stu_data[$stu_sn]['avg']=(float)(round(($sum/$j),0));
                        $stu_data[$stu_sn]['reward_method']=score_range($stu_data[$stu_sn]['avg'],$pars['exam_stage']);
                    }

                    if($pars['exam_stage']=='4' AND $stu_first_exam_avg_score[$stu_sn]>='60'){
                        $stu_data[$stu_sn]['frist_exam_score']=$stu_first_exam_avg_score[$stu_sn];
                        $stu_data[$stu_sn]['progress_score']=round($stu_data[$stu_sn]['avg']-$stu_first_exam_avg_score[$stu_sn],0);
                        $stu_data[$stu_sn]['reward_method'].=progress_award($stu_data[$stu_sn]['progress_score']);
                    }else{
                        $stu_data[$stu_sn]['progress_score']='';
                    }
                    
                    $stu_data[$stu_sn]['comment']=$stu_comment[$stu_sn];//備註

                }
                $i++;
            }
            // die(var_dump($stu_data));
            // 建立考科總成績檔
            $SchoolSet->add_query_stage_score($pars['dep_id'],$pars['exam_stage'],$stu_data);

            $xoopsTpl->assign('uid', $xoopsUser->uid());
            $xoopsTpl->assign('all', $stu_data);
            $xoopsTpl->assign('op', "add_query_stage_score_comment");
    
        }
        // //帶入使用者編號

        $xoopsTpl->assign('course', $course);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());
        
    }


// ----------------------------------
// 段考成績 管理
    // sql-新增 段考成績
    function stage_score_insert($pars=[]){

        global $xoopsDB,$xoopsUser,$xoopsTpl;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, 'stage_score_insert! error:2105091725');
        }

        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=stage_score_list&dep_id={$pars['dep_id']}&course_id={$pars['course_id']}", 3, 'stage_score_insert失敗! error:2105100816 檢查結果:'.!$GLOBALS['xoopsSecurity']->check());
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }

        $stu_score  = Request::getArray('stu_score');//學生編號=>平時成績
        $tea_keyin_score  = Request::getArray('tea_keyin_score');//學生編號=>教師keyin總成績

        // var_dump($tea_keyin_score);        
        // die(var_dump($stu_score));

        // 先刪除該科目段考資料
        $tbl = $xoopsDB->prefix('yy_stage_score');
        foreach($stu_score as $stusn=>$v){
            foreach($v['score'] as $exam_stage=>$score){
                $sql = "DELETE FROM `$tbl` 
                    WHERE `course_id` = '{$course_id}'
                        AND `year` = '{$year}'
                        AND `term` = '{$term}'
                        AND `dep_id` = '{$dep_id}'
                        AND `exam_stage`='{$exam_stage}'
                    ";
                $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            }
            break;
        }


        // 新增學生段考成績
        $tbl = $xoopsDB->prefix('yy_stage_score');
        foreach($stu_score as $stusn=>$v){
            foreach($v['score'] as $exam_stage=>$score){
                $sql = "insert into `$tbl` (
                    `year`,`term`,`dep_id`,`course_id`,`exam_stage`,
                    `student_sn`,`score`,`update_user`,`update_date`
                    ) 
                    values(
                    '{$year}','{$term}','{$dep_id}','{$course_id}','{$exam_stage}',
                    '{$stusn}','{$score}','{$update_user}',now()
                    )";
                $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            }
        }
        // echo($sql);
        // die();
        // 重新計算段考及平時考平均
        $SchoolSet= new SchoolSet;
        $SchoolSet->sscore_calculate( $dep_id,$course_id,$stu_score,$tea_keyin_score);

        // redirect_header("tchstu_mag.php?op=stage_score_list&dep_id={$dep_id}", 3, '存檔成功！');
        // redirect_header("tchstu_mag.php?op=stage_score_list&dep_id={$dep_id}&course_id={$course_id}", 3, '存檔成功！');

    }

    // 列表- 段考成績
    function stage_score_list($pars=[]){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        $SchoolSet= new SchoolSet;
        if (!$xoopsUser) {
            redirect_header('index.php', 3, '無操作權限');
        }
            
    
        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#stage_score_list", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $myts = MyTextSanitizer::getInstance();

        if((power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
        
            // 全部學程列表
            $course['major_htm']=Get_select_opt_htm($SchoolSet->depsnname,$pars['dep_id'],'1');
            // 全部課程列表
            foreach ($SchoolSet->dep2course[$pars['dep_id']] as $k=>$v){
                $course_ary[$v]=$SchoolSet->courese_chn[$v];
            }
            $course['course_htm']=Get_select_opt_htm($course_ary,$pars['course_id'],'1');
        }
        else{
            // 教師學程列表
            $tea_course=$SchoolSet->tea_course[$xoopsUser->uid()];
            foreach ($tea_course as $k=>$v){
                $major_namemap[$k]=$SchoolSet->depsnname[$k];
            }
            $course['major_htm']=Get_select_opt_htm($major_namemap,$pars['dep_id'],'1');

            // 教師課程列表
            foreach ($tea_course[$pars['dep_id']] as $k=>$v){
                $course_ary[$v]=$SchoolSet->courese_chn[$v];
            }
            $course['course_htm']=Get_select_opt_htm($course_ary,$pars['course_id'],'1');
        }

        if($pars['dep_id']!='' AND  $pars['course_id']!=''){
            $xoopsTpl->assign('showtable', true);
            // 依課程找 任課教師id、學年、學期、學程
            $sscore['tea_id']    = $SchoolSet->all_course[$pars['course_id']]['tea_id'];
            $sscore['year']      = $SchoolSet->all_course[$pars['course_id']]['cos_year'];
            $sscore['term']      = $SchoolSet->all_course[$pars['course_id']]['cos_term'];
            $sscore['dep_id']    = $SchoolSet->all_course[$pars['course_id']]['dep_id'];
            $sscore['course_id'] = $pars['course_id'];
            $sscore['tea_name']  = $SchoolSet->uid2name[$sscore['tea_id']];
            $sscore['dep_name']  = $SchoolSet->depsnname[$sscore['dep_id']];
            $sscore['course_name']  = $SchoolSet->courese_chn[$sscore['course_id']];
            // die(var_dump($sscore));

            // 判斷是否為教師本人 或管理員
            if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin() or $sscore['tea_id']==$_SESSION['xoopsUserId'])){
                redirect_header("tchstu_mag.php?op=stage_score_list&dep_id={$pars['dep_id']}", 3, 'stage_score_list! error:2105091300');
            }     
            $course['normal_exam_rate']=$SchoolSet->dept[$sscore['dep_id']]['normal_exam']*100;
            $course['section_exam_rate']=$SchoolSet->dept[$sscore['dep_id']]['section_exam']*100;

            // 列出該學程內所有學生sn, name 不含回歸結案
            $major_stu=$SchoolSet->major_stu[$pars['dep_id']];
            foreach ($major_stu as $dep_id=>$stu_sn){
                $stu_data[$stu_sn]['name']=$myts->htmlSpecialChars($SchoolSet->stu_name_all[$stu_sn]);
                $stu_data[$stu_sn]['stu_anonymous']=$myts->htmlSpecialChars($SchoolSet->stu_anonymous_all[$stu_sn]);
                // 列出學生及考試成績 空白表格
                foreach ($SchoolSet->exam_name as $k=>$exam_name){
                    $stu_data[$stu_sn]['score'][$k]='';
                }
                $stu_data[$stu_sn]['f_usual']='';
                $stu_data[$stu_sn]['f_stage']='';
                $stu_data[$stu_sn]['f_sum']='';
                $stu_data[$stu_sn]['desc']='-';
            }
            // die(var_dump($major_stu));
            // 三次段考成績時段，是否可keyin
            $addEdit=[];
            foreach($SchoolSet->stage_exam_name as $k=>$name){
                // 判斷新增、修改平時成績權限 
                // if((power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
                //     $addEdit[$k]=true;
                // }else{
                    $addEdit[$k]=$SchoolSet->exam_date_check($name);
                // }
            }
            $xoopsTpl->assign('addEdit', $addEdit);
            foreach($addEdit as $k=>$val){
                // 只要其中一次段考成績有開，就可以寫描述 
                if($val==true){
                    $desc_addEdit=true;
                }
            }
            $xoopsTpl->assign('desc_addEdit', $desc_addEdit);

            // die(var_dump($addEdit));

            // get 撈出平時考的加總平均
            $tb1      = $xoopsDB->prefix('yy_uscore_avg');
            $sql = "SELECT * FROM $tb1 
                Where course_id= '{$pars["course_id"]}'
                ORDER BY `exam_stage`
            ";
            // echo($sql);die();
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            while($data= $xoopsDB->fetchArray($result)){
                $stu_data[$data['student_sn']]['score'][$data['exam_stage']]= $myts->htmlSpecialChars($data['avgscore']);
            }

            // 撈出 段考成績
            $tb1      = $xoopsDB->prefix('yy_stage_score');
            $sql      = "SELECT *  FROM $tb1 
                            Where course_id= '{$pars["course_id"]}'
                            ORDER BY  `student_sn` ,`exam_stage`
                        ";
            // echo($sql);die();
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            while($data= $xoopsDB->fetchArray($result)){
                $stu_data [$data['student_sn']]['score'][$data['exam_stage']]= $myts->htmlSpecialChars($data['score']);
            }
            
            // 撈出 平時考及段考總成績
            $tb1      = $xoopsDB->prefix('yy_stage_sum');
            $sql      = "SELECT *  FROM $tb1 
                            Where course_id= '{$pars["course_id"]}'
                            ORDER BY  `student_sn`
                        ";
            // echo($sql);die();
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            while($data= $xoopsDB->fetchArray($result)){
                $stu_data [$data['student_sn']]['name']=$myts->htmlSpecialChars($SchoolSet->stu_name_all[$data['student_sn']]);
                $stu_data [$data['student_sn']]['stu_anonymous']=$myts->htmlSpecialChars($SchoolSet->stu_anonymous_all[$data['student_sn']]);
                $stu_data [$data['student_sn']]['f_usual']= $myts->htmlSpecialChars($data['uscore_avg']);
                $stu_data [$data['student_sn']]['f_stage']= $myts->htmlSpecialChars($data['sscore_avg']);
                $stu_data [$data['student_sn']]['f_sum']= $myts->htmlSpecialChars($data['sum_usual_stage_avg']);
                $stu_data [$data['student_sn']]['desc']= $myts->htmlSpecialChars($data['description']);
                $stu_data [$data['student_sn']]['tea_input_score']= ($data['tea_input_score']=='')?$data['sum_usual_stage_avg']:$data['tea_input_score'];
            }

            $score_syn=$pars['score_syn']?$pars['score_syn']:'0';
            // die(var_dump($pars['score_syn']));
            // die(var_dump($sscore));
            $uid = $_SESSION['beck_iscore_adm'] ? $sscore['tea_id'] : $xoopsUser->uid();
            $xoopsTpl->assign('uid', $uid);
            $xoopsTpl->assign('sscore', $sscore);
            $xoopsTpl->assign('all', $stu_data);
            $xoopsTpl->assign('score_syn', $score_syn);
    
        }
        // //帶入使用者編號

        $xoopsTpl->assign('op', "stage_score_insert");
        $xoopsTpl->assign('course', $course);
        $xoopsTpl->assign('exam_name', $SchoolSet->exam_name);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());
        




    }
// ----------------------------------
// 課程 管理
    // sql-刪除處室
    function course_delete($sn){
        global $xoopsDB,$xoopsUser;

        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header("tchstu_mag.php?op=course_form&sn={$sn}", 3, '無course_delete 權限! error:2104270940');
        }       
       
        $tbl   = $xoopsDB->prefix('yy_course');
        $sql      = "SELECT * FROM $tbl WHERE `sn` = '{$sn}'";
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $cos_exist= $xoopsDB->fetchArray($result);
        // var_dump($cos_exist);die();
        if($cos_exist){
            $tbl = $xoopsDB->prefix('yy_course');
            $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
            // echo($sql);die();
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }else{
            redirect_header("tchstu_mag.php?op=course_list", 3, '無course_delete!error:2104270940');
        }
        return $cos_exist;
    }
    // 列表- 課程
    function course_list($pars=[],$g2p=''){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        $SchoolSet= new SchoolSet;

        if(!$xoopsUser){
            redirect_header('index.php', 3, 'course_list! error:2104261048');
        }
        if(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin() ){
            $xoopsTpl->assign('can_edit', true);
        } 

        $pars['cos_year']=($pars['cos_year']=='')?(string)$SchoolSet->sem_year:$pars['cos_year'];
        $pars['cos_term']=($pars['cos_term']=='')?(string)$SchoolSet->sem_term:$pars['cos_term'];

        // var_dump($pars);die();
        $myts = MyTextSanitizer::getInstance();

        $tb1      = $xoopsDB->prefix('yy_course');
        $tb2      = $xoopsDB->prefix('yy_department');
        $tb3      = $xoopsDB->prefix('users');
        $sql      = "SELECT  cr.* , de.dep_name , de.dep_status , ur.name as teacher_name
                    FROM $tb1 as cr 
                        LEFT JOIN $tb2 as de ON cr.dep_id=de.sn
                        LEFT JOIN $tb3 as ur ON cr.tea_id=ur.uid
                        " ;
        $have_par='0';
        if($pars['cos_year']!=''){
            $sql.=" WHERE `cos_year`='{$pars['cos_year']}'";
            $have_par='1';
        }
        if($pars['cos_term']!=''){
            if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.="`cos_term`='{$pars['cos_term']}'";
            $have_par='1';
        }
        if(($pars['dep_id']!='')){
            if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.="cr.dep_id = '{$pars['dep_id']}'";
            $have_par='1';
        }

        $sql.=" ORDER BY `cos_year` DESC , `cos_term` DESC ,`dep_id` ,`sort`,`tea_id` , `cos_name`";
        // echo($sql);die();

        //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        // $PageBar = getPageBar($sql, 30, 10);
        // $bar     = $PageBar['bar'];
        // $sql     = $PageBar['sql'];
        // $total   = $PageBar['total'];

        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all      = array();

        if($g2p=='' OR $g2p=='1'){$i=1;}else{$i=($g2p-1)*30+1;}
        $credit_sun=0;
        $star_icon=['0'=>'','1'=>'<i class="fa fa-star" aria-hidden="true"></i>'];
        while($cos= $xoopsDB->fetchArray($result)){
            $cos['i']            = $i;
            $cos['cos_year']     = $myts->htmlSpecialChars($cos['cos_year']);       //學號
            $cos['cos_term']     = $myts->htmlSpecialChars($cos['cos_term']);      //姓名
            $cos['year_term']    = $cos['cos_year'].'/'.$cos['cos_term'];
            $cos['dep_name']     = $myts->htmlSpecialChars($cos['dep_name']);
            $cos['teacher_name'] = $myts->htmlSpecialChars($cos['teacher_name']);
            $cos['cos_name']     = $myts->htmlSpecialChars($cos['cos_name']);
            $cos['cos_name_grp'] = $myts->htmlSpecialChars($cos['cos_name_grp']);
            $cos['first_chk']    = Get_bootstrap_switch_opt_htm('first_test',$cos['sn'],$cos['first_test']);
            $cos['f_icon']       = $star_icon[$cos['first_test']];
            $cos['second_chk']   = Get_bootstrap_switch_opt_htm('second_test',$cos['sn'],$cos['second_test']);
            $cos['s_icon']       = $star_icon[$cos['second_test']];
            $credit_sun=$credit_sun+$cos['cos_credits'];
            $all []              = $cos;
            $i++;
        }
        $xoopsTpl->assign('credit_sun', $credit_sun);
        // var_dump($credit_sun);die();
        // 學年度select
        foreach ($SchoolSet->all_sems as $k=>$v){
            $sems_year[$v['year']]=$v['year'];
        }
        $sems_year_htm=Get_select_opt_htm($sems_year,$pars['cos_year'],'0');
        $xoopsTpl->assign('sems_year_htm', $sems_year_htm);
        // 學期 
        $terms=['1'=>'1','2'=>'2'];
        $sems_term_htm=Get_select_opt_htm($terms,$pars['cos_term'],'0');
        $xoopsTpl->assign('sems_term_htm', $sems_term_htm);

        // 學程列表
        $major_name=[];
        foreach ($SchoolSet->dept as $k=>$v){
            $major_name[$v['sn']]=$v['dep_name'];
        }
        $major_htm=Get_select_opt_htm($major_name,$pars['dep_id'],'1');
        $xoopsTpl->assign('major_htm', $major_htm);

        $xoopsTpl->assign('all', $all);
        // $xoopsTpl->assign('bar', $bar);
        // $xoopsTpl->assign('total', $total);

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('cos_del', XOOPS_URL . "/modules/beck_iscore/tchstu_mag.php?op=course_delete&sn=", 'sn','確定要刪除課程資料','課程資料資料刪除。');
        
        // $SchoolSet->sem_year;
        // $SchoolSet->sem_term;
        $xoopsTpl->assign('sem_year', $SchoolSet->sem_year);
        $xoopsTpl->assign('sem_term', $SchoolSet->sem_term);


        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

        $xoopsTpl->assign('op', "course_list");

    }
    // sql-更新 課程
    function course_update($sn){
        global $xoopsDB,$xoopsUser;
        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header("tchstu_mag.php?op=course_form&sn={$sn}", 3, '無 course_update 權限!error:2104261000');
        } 
        
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("school_affairs.php?op=dept_school_form&sn={$sn}", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        $first_test  = $first_test ?? '0' ;
        $second_test = $second_test ?? '0' ;
        $scoring     = $scoring ?? '0' ;
        // die();
        $tbl = $xoopsDB->prefix('yy_course');
        $sql = "update `$tbl` set 
                    `cos_year`='{$cos_year}',
                    `cos_term`='{$cos_term}',
                    `dep_id`='{$dep_id}',
                    `tea_id`='{$tea_id}',
                    `cos_name`=trim('{$cos_name}'),
                    `cos_name_grp`=trim('{$cos_name_grp}'),
                    `cos_credits`='{$cos_credits}',
                    `scoring`='{$scoring}',
                    `first_test`='{$first_test}',
                    `second_test`='{$second_test}',
                    `status`='{$status}',
                    `update_user`='{$uid}',
                    `update_date`=now()
                where `sn`   = '{$sn}'";

        // echo($sql);die();
        $re_val['cos_year']=$cos_year;
        $re_val['cos_term']=$cos_term;
        $re_val['dep_id']=$dep_id;
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        return $re_val;
    }
    // sql-新增 學程
    function course_insert(){
        global $xoopsDB,$xoopsUser;

        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php?op=course_form', 3, '無 course_insert 權限!error:2104242100');
        } 
        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=student_form", 3, '新增學生，表單Token錯誤，請重新輸入!'.!$GLOBALS['xoopsSecurity']->check());
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
                // die();
        $first_test  = $first_test ?? '0' ;
        $second_test = $second_test ?? '0' ;
        $scoring     = $scoring ?? '0' ;
        
        $tbl   = $xoopsDB->prefix('yy_course');

        $sql_count = "SELECT max(sn)+1 as count FROM $tbl ";
        $result   = $xoopsDB->query($sql_count) or Utility::web_error($sql, __FILE__, __LINE__);
        $sql_count_result= $xoopsDB->fetchArray($result);

        $sql      = "SELECT * FROM $tbl WHERE `cos_year`='{$cos_year}' AND `cos_term`='{$cos_term}'
                    AND `dep_id`='{$dep_id}' AND `tea_id`='{$tea_id}' AND `cos_name`='{$cos_name}'";
        // echo($sql);die();
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $cos_exist= $xoopsDB->fetchArray($result);
        // die(var_dump($cos_exist));
    
        if (!$cos_exist) {
            $sql = "insert into `$tbl` (
                        `cos_year`,`cos_term`,`dep_id`,`tea_id`,`cos_name`,
                        `cos_name_grp`,`cos_credits`,`scoring`,`first_test`, `second_test`,
                        `status`,`update_user`,`update_date`,`sort`
                    )values(
                        '{$cos_year}','{$cos_term}','{$dep_id}','{$tea_id}', trim('{$cos_name}'),
                        trim('{$cos_name_grp}'),'{$cos_credits}','{$scoring}','{$first_test}','{$second_test}',
                        '{$status}','{$uid}',now(),'{$sql_count_result['count']}'
                    )";
            // echo($sql);die();
            $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }else{
            redirect_header('tchstu_mag.php?op=course_form', 3, '此課程已存在!error:2104242225');
        }

        $re_val['cos_year']=$cos_year;
        $re_val['cos_term']=$cos_term;
        $re_val['dep_id']=$dep_id;

        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號
        return $re_val;
    }
    // 表單 課程
    function course_form($sn){
        // var_dump(power_chk("tchstu_mag", "1"));die();
        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php?op=course_list', 3, '無 course_form 權限!error:2104221800');
        }        

        global $xoopsTpl,$xoopsUser,$xoopsDB;

        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#course_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form_title = '新增課程';
        $cours   = array();

        if($sn){
            $form_title = '編輯課程';
            $tbl    = $xoopsDB->prefix('yy_course');
            $sql    = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $cour  = $xoopsDB->fetchArray($result);
        }
        $xoopsTpl->assign('form_title', $form_title);
        $SchoolSet= new SchoolSet;
        $cour['cos_year']     = $cour['cos_year'] ?? $SchoolSet->sem_year ;
        $cour['cos_term']     = $cour['cos_term'] ?? $SchoolSet->sem_term ;
        $cour['dep_id']       = $cour['dep_id'] ?? '' ;
        $cour['tea_id']       = $cour['tea_id'] ?? '';
        $cour['cos_name']     = $cour['cos_name']?? '' ;
        $cour['cos_name_grp'] = $cour['cos_name_grp'] ?? '';
        $cour['first_test']   = $cour['first_test'] ?? '';
        $cour['second_test']  = $cour['second_test'] ?? '';
        $cour['cos_credits']  = $cour['cos_credits'] ?? '';
        $cour['scoring']      = $cour['scoring'] ?? '1';
        $cour['status']       = $cour['status'] ?? '1';

        // 學程列表
        $major_name=[];
        foreach ($SchoolSet->dept as $k=>$v){
            $major_name[$v['sn']]=$v['dep_name'];
        }
        $cour['major_htm']=Get_select_opt_htm($major_name,$cour['dep_id'],'1');

        // 教師列表
        $teacher_name=[];
        foreach ($SchoolSet->teachers as $k=>$v){
            $teacher_name[$v['uid']]=$v['name'];
        }
        $cour['teacher_htm']=Get_select_opt_htm($teacher_name,$cour['tea_id'],'1');
        
        if($cour['first_test']=='1'){$cour['ftest_htm']='checked';}else{$cour['ftest_htm']='';}
        if($cour['second_test']=='1'){$cour['stest_htm']='checked';}else{$cour['stest_htm']='';}
        if($cour['scoring']=='1'){$cour['score_htm']='checked';}else{$cour['score_htm']='';}
        // var_dump($SchoolSet->teachers);die();
        // $SchoolSet->teachers;

        // 目前狀況
        $status_ary=['0'=>'關閉','1'=>'啟用','2'=>'暫停'] ;
        $cour['status_htm']=Get_select_opt_htm($status_ary,$cour['status'],'1');

        $xoopsTpl->assign('cour', $cour);

        // //帶入使用者編號
        if ($sn) {
            $uid = $_SESSION['beck_iscore_adm'] ? $cour['update_user'] : $xoopsUser->uid();
        } else {
            $uid = $xoopsUser->uid();
        }
        $xoopsTpl->assign('uid', $uid);
        

        // //下個動作
        if ($sn) {
            $op='course_update';
            $xoopsTpl->assign('sn', $sn);
        } else {
            $op='course_insert';
        }
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('cos_del', XOOPS_URL . "/modules/beck_iscore/tchstu_mag.php?op=course_delete&sn=", 'sn','確定要刪除課程資料','課程資料資料刪除。');

    }

// ----------------------------------
// 學生 管理
    // sql-刪除學生
    function student_delete($sn){
        global $xoopsDB,$xoopsUser;

        if(!power_chk("beck_iscore", "1")){
            redirect_header('tchstu_mag.php', 2, '無 student_delete 權限!error:2104210936');
        } 

        
        $tbl = $xoopsDB->prefix('yy_student');
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    // sql-更新學生
    function student_update($sn){

        global $xoopsDB,$xoopsUser;
        if(!power_chk("beck_iscore", "1")){
            redirect_header('index.php', 3, '無 student_update 權限! error:2104201500');
        } 

        
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("school_affairs.php?op=dept_school_form&sn={$sn}", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // die();
        $stu_anonymous=name_substr_cut($stu_name);

        $tbl = $xoopsDB->prefix('yy_student');
        $sql = "update `$tbl` set 
                    `stu_name`   = '{$stu_name}',
                    `national_id`= '{$national_id}',
                    `stu_id` = '{$stu_id}', 
                    `stu_no` = '{$stu_no}', 
                    `class_id` = '{$class_id}', 
                    `major_id` = '{$major_id}', 
                    `grade` = '{$grade}', 
                    `arrival_date` = '{$arrival_date}', 
                    `birthday` = '{$birthday}', 
                    `orig_school` = '{$orig_school}', 
                    `orig_grade` = '{$orig_grade}', 
                    `household_add` = '{$household_add}', 
                    `address` = '{$address}', 
                    `out_learn` = '{$out_learn}', 
                    `audit` = '{$audit}', 
                    `status` = '{$status}', 
                    `record` = '{$record}', 
                    `social_id` = '{$social_id}', 
                    `guidance_id` = '{$guidance_id}', 
                    `rcv_guidance_id` = '{$rcv_guidance_id}', 
                    `guardian1` = '{$guardian1}', 
                    `guardian1_relationship` = '{$guardian1_relationship}', 
                    `guardian1_cellphone1` = '{$guardian1_cellphone1}', 
                    `guardian1_cellphone2` = '{$guardian1_cellphone2}', 
                    `emergency1_contact1` = '{$emergency1_contact1}', 
                    `emergency1_contact_rel` = '{$emergency1_contact_rel}', 
                    `emergency1_cellphone1` = '{$emergency1_cellphone1}', 
                    `emergency1_cellphone2` = '{$emergency1_cellphone2}', 
                    `emergency1_cellphone2` = '{$emergency1_cellphone2}', 
                    `uid` = '{$uid}', 
                    `update_time` = now(),
                    `stu_anonymous`='{$stu_anonymous}'
                where `sn`   = '{$sn}'";

        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        redirect_header("tchstu_mag.php?op=student_form&sn={$sn}", 2, '學生更新成功!');
        return $sn;
    }

    // sql-新增 學生
    function student_insert(){

        global $xoopsDB,$xoopsUser;

        if(!power_chk("beck_iscore", "1")){
            redirect_header('index.php', 3, '無 student_insert 權限!  error:210420114');
        } 

        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=student_form", 3, '新增學生，表單Token錯誤，請重新輸入!'.!$GLOBALS['xoopsSecurity']->check());
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // die();
        $stu_anonymous=name_substr_cut($stu_name);

        $tbl = $xoopsDB->prefix('yy_student');
        $sql = "insert into `$tbl` (
            `stu_name`,`national_id`,`stu_id`,`stu_no`,`class_id`,
            `major_id`,`grade`,`arrival_date`,`birthday`,`orig_school`,`orig_grade`,
            `household_add`,`address`,`out_learn`,`audit`,`status`,
            `record`,`social_id`,`guidance_id`,`rcv_guidance_id`,`guardian1`,
            `guardian1_relationship`,`guardian1_cellphone1`,`guardian1_cellphone2`,`emergency1_contact1`,`emergency1_contact_rel`,
            `emergency1_cellphone1`,`emergency1_cellphone2`,`uid`,`create_time`,`update_time`,`stu_anonymous`) 
            values(
            '{$stu_name}','{$national_id}','{$stu_id}','{$stu_no}','{$class_id}',
            '{$major_id}','{$grade}','{$arrival_date}','{$birthday}','{$orig_school}','{$orig_grade}',
            '{$household_add}','{$address}','{$out_learn}','{$audit}','{$status}',
            '{$record}','{$social_id}','{$guidance_id}','{$rcv_guidance_id}','{$guardian1}',
            '{$guardian1_relationship}','{$guardian1_cellphone1}','{$guardian1_cellphone2}','{$emergency1_contact1}','{$emergency1_contact_rel}',
            '{$emergency1_cellphone1}','{$emergency1_cellphone2}','{$uid}',now(),now(),'{$stu_anonymous}'
            )";
        // echo($sql); 
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號
        redirect_header("tchstu_mag.php?op=student_form&sn={$sn}", 2, '學生新增成功!');

        return $sn;
    }

    // 表單-新增、編輯 學生
    function student_form($sn){
        // var_dump(power_chk("tchstu_mag", "1"));die();
        if(!(power_chk("beck_iscore", 1) or power_chk("beck_iscore", 3))){
            redirect_header('tchstu_mag.php', 3, '無 student_form 權限!  error:2104191604');
        }        
        // if (!power_chk('beck_iscore', 1)) {
        //     redirect_header('school_affairs.php', 3, '無操作權限');
        // }
        // if (!$xoopsUser) {
        //     redirect_header('index.php', 3, '無操作權限');
        // }
        global $xoopsTpl,$xoopsUser,$xoopsDB;

        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#student_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form_title = '新增學生';
        $stu   = array();

        if($sn){
            $form_title = '編輯學生';
            $tbl        = $xoopsDB->prefix('yy_student');
            $sql        = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $stu_ifo       = $xoopsDB->fetchArray($result);
        }
        $xoopsTpl->assign('form_title', $form_title);
        $stu['stu_id']                 = $stu_ifo['stu_id'] ?? '' ;
        $stu['stu_no']                 = $stu_ifo['stu_no'] ?? '' ;
        $stu['stu_name']               = $stu_ifo['stu_name'] ?? '' ;
        $stu['stu_anonymous']          = $stu_ifo['stu_anonymous'] ?? '' ;
        $stu['national_id']            = $stu_ifo['national_id'] ?? '';
        $stu['sex']                    = $stu_ifo['sex']?? '0' ;
        $stu['arrival_date']           = $stu_ifo['arrival_date'] ?? '';
        $stu['birthday']               = $stu_ifo['birthday'] ?? '';
        $stu['orig_school']            = $stu_ifo['orig_school'] ?? '';
        $stu['orig_grade']             = $stu_ifo['orig_grade'] ?? '';
        $stu['out_learn']              = $stu_ifo['out_learn'] ?? '';
        
        $stu['household_add']          = $stu_ifo['household_add'] ?? '';
        $stu['address']                = $stu_ifo['address'] ?? '';
        $stu['guardian1']              = $stu_ifo['guardian1'] ?? '';
        $stu['guardian1_relationship'] = $stu_ifo['guardian1_relationship'] ?? '';
        $stu['guardian1_cellphone1']   = $stu_ifo['guardian1_cellphone1'] ?? '';
        $stu['guardian1_cellphone2']   = $stu_ifo['guardian1_cellphone2'] ?? '';
        $stu['emergency1_contact1']    = $stu_ifo['emergency1_contact1'] ?? '';
        $stu['emergency1_contact_rel'] = $stu_ifo['emergency1_contact_rel'] ?? '';
        $stu['emergency1_cellphone1']  = $stu_ifo['emergency1_cellphone1'] ?? '';
        $stu['emergency1_cellphone2']  = $stu_ifo['emergency1_cellphone2'] ?? '';
        $stu['social_id']              = $stu_ifo['social_id'] ?? '';
        $stu['guidance_id']            = $stu_ifo['guidance_id'] ?? '';
        $stu['rcv_guidance_id']        = $stu_ifo['rcv_guidance_id'] ?? '';
        $stu['class_id']               = $stu_ifo['class_id'] ?? '';
        $stu['major_id']               = $stu_ifo['major_id'] ?? '';
        $stu['grade']                  = $stu_ifo['grade'] ?? '';
        $stu['audit']                  = $stu_ifo['audit'] ?? '0';
        $stu['status']                 = $stu_ifo['status'] ?? '';
        $stu['uid']                    = $stu_ifo['uid'] ?? '';
        $stu['record']                 = $stu_ifo['record'] ?? '';

        $SchoolSet= new SchoolSet;


        // 班級
        if($sn){
            $stu['class_htm']=Get_select_opt_htm($SchoolSet->class_name_all,$stu['class_id'],'1');
        }else{
            $stu['class_htm']=Get_select_opt_htm($SchoolSet->class_name,$stu['class_id'],'1');
        }

        $xoopsTpl->assign('class_tutor', json_encode($SchoolSet->class_tutor_name));
        // var_dump($SchoolSet->class_name);// die();
        // 學程列表
        $major_name=[];
        foreach ($SchoolSet->dept as $k=>$v){
            $major_name[$v['sn']]=$v['dep_name'];
        }
        $stu['major_htm']=Get_select_opt_htm($major_name,$stu['major_id'],'1');

        // 外學
        $onoff=['0'=>'否','1'=>'是'];
        $stu['out_learn_htm']=radio_htm($onoff,'out_learn', $stu['out_learn']);
        // 隨班附讀	
        $stu['audit_htm']=radio_htm($onoff,'audit', $stu['audit']);


        // 目前狀況
        $status_ary=['0'=>'逾假逃跑','1'=>'在校','2'=>'回歸/結案'] ;
        $stu['status_htm']=Get_select_opt_htm($status_ary,$stu['status'],'1');

        // var_dump($stu['status_htm']);
       

        $sex_ary=["0"=>'女',"1"=>'男'];
        $stu['sex_htm']=Get_select_opt_htm($sex_ary,$stu['sex'],'1');
        
        $grade=["1"=>'1',"2"=>'2',"3"=>'3',"畢業或結業"=>'畢業或結業'];
        $stu['orig_grade_htm']=Get_select_opt_htm($grade,$stu['orig_grade'],'1');
        $stu['grade_htm']=Get_select_opt_htm($grade,$stu['grade'],'1');
        
        // 社工師、輔導老師、認輔
        $stu['social_htm']=Get_select_opt_htm($SchoolSet->issocial,$stu['social_id'],'1');
        $stu['guidance_htm']=Get_select_opt_htm($SchoolSet->isguidance,$stu['guidance_id'],'1');
        $stu['rcv_guidance_htm']=Get_select_opt_htm($SchoolSet->uid2name,$stu['rcv_guidance_id'],'1');
        
        $xoopsTpl->assign('stu', $stu);

        // //帶入使用者編號
        if ($sn) {
            $uid = $_SESSION['beck_iscore_adm'] ? $stu['uid'] : $xoopsUser->uid();
        } else {
            $uid = $xoopsUser->uid();
        }
        $xoopsTpl->assign('uid', $uid);
        

        // //下個動作
        if ($sn) {
            $op='student_update';
            $xoopsTpl->assign('sn', $sn);
        } else {
            $op='student_insert';
        }
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }

    // 列表- 學生
    function student_list($pars=[],$g2p=''){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        if (!$xoopsUser) {
            redirect_header('index.php', 3, '無 student_list 權限! error:210420115');
        } 
        if(power_chk("beck_iscore", "1")){
            $xoopsTpl->assign('can_edit', true);
        } 

        // var_dump($_SESSION);die();
        $myts = MyTextSanitizer::getInstance();

        $tb1      = $xoopsDB->prefix('yy_student');
        $tb2      = $xoopsDB->prefix('yy_class');
        $tb3      = $xoopsDB->prefix('yy_department');
        $tb4      = $xoopsDB->prefix('users');
        $sql      = "SELECT  st.* , cl.class_name , cl.class_status, cl.tutor_sn,
                            de.dep_name , de.dep_status , ur.name as tutor_name
                    FROM $tb1 as st 
                        LEFT JOIN $tb2 as cl ON st.class_id=cl.sn
                        LEFT JOIN $tb3 as de ON st.major_id=de.sn
                        LEFT JOIN $tb4 as ur ON cl.tutor_sn=ur.uid
                        " ;

        if($pars['status']!=''){
            $sql.=" WHERE status='{$pars['status']}'";
            // $have_par='1';
        }else{
            $sql.=" WHERE status != '2'";
        }
        if($pars['major_id']!=''){
            // if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.=" AND `major_id`='{$pars['major_id']}'";
            // $have_par='1';
        }
        if(!empty($pars['search'])){
            // if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.=" AND (`stu_name` like '%{$pars['search']}%')";
            // $have_par='1';
        }
        // if($have_par=='1'){$sql.=" AND status != '2'";}else{$sql.=" WHERE status != '2'";};
        $sql.=" ORDER BY `major_id` ,`sort` ,`stu_no` DESC";
        // echo($sql);  die();

        //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = getPageBar($sql, 30, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];

        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all      = array();

        if($g2p=='' OR $g2p=='1'){$i=1;}else{$i=($g2p-1)*30+1;}
        $SchoolSet= new SchoolSet;

        while($stu= $xoopsDB->fetchArray($result)){
            $stu['i']              = $i;
            $stu['stu_id']          = $myts->htmlSpecialChars($stu['stu_id']);           //學號
            $stu['stu_name']        = $myts->htmlSpecialChars($stu['stu_name']);         //姓名
            $stu['birthday']        = $myts->htmlSpecialChars($stu['birthday']);
            $stu['class_name']      = $myts->htmlSpecialChars($stu['class_name']);
            $stu['dep_name']        = $myts->htmlSpecialChars($stu['dep_name']);
            $stu['tutor_name']      = $myts->htmlSpecialChars($stu['tutor_name']);
            $stu['social_id']       = $myts->htmlSpecialChars($SchoolSet->uid2name[$stu['social_id']]);        //社工
            $stu['guidance_id']     = $myts->htmlSpecialChars($SchoolSet->uid2name[$stu['guidance_id']]);      //輔導老師
            $stu['rcv_guidance_id'] = $myts->htmlSpecialChars($SchoolSet->uid2name[$stu['rcv_guidance_id']]);  //認輔教師
            $all []            = $stu;
            $i++;
        }
        // var_dump($all);die();

        // 目前狀況
        $status_ary=['0'=>'逾假逃跑','1'=>'在校','2'=>'回歸/結案'] ;
        $status_htm=Get_select_opt_htm($status_ary,$pars['status'],'1');
        $xoopsTpl->assign('status_htm', $status_htm);

        // 學程列表
        $major_name=[];
        foreach ($SchoolSet->dept as $k=>$v){
            $major_name[$v['sn']]=$v['dep_name'];
        }
        $major_htm=Get_select_opt_htm($major_name,$pars['major_id'],'1');
        $xoopsTpl->assign('major_htm', $major_htm);

        // 關鍵字傳到樣版
        $parameter['search'] = (!isset($pars['search'])) ? '' : $pars['search'];
        $xoopsTpl->assign('search', $pars['search']);

        $xoopsTpl->assign('all', $all);
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('stu_del', XOOPS_URL . "/modules/beck_iscore/tchstu_mag.php?op=student_delete&sn=", 'sn','確定要刪除學生基本資料','學生基本資料刪除。');

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

        $xoopsTpl->assign('op', "student_list");

    }
// ----------------------------------
// 平時成績 管理
    // sql-平時成績
    function usual_score_delete($pars=[]){
        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, 'usual_score_insert! error:2105052140');
        }
        // die(var_dump($pars));
        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=usual_score_list&dep_id={$pars['dep_id']}&course_id={$pars['course_id']}", 3, 'usual_score_delete錯誤! 檢查結果:'.$GLOBALS['xoopsSecurity']->check());
            throw new Exception($error);
        }

        $tbl = $xoopsDB->prefix('yy_usual_score');
        $sql = "DELETE FROM `$tbl` 
            WHERE `course_id`   = '{$pars['course_id']}'
            AND   `exam_stage`  = '{$pars['exam_stage']}'
            AND   `exam_number` = '{$pars['exam_number']}'
            ";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        

        // 重新計算平時考平均
        $SchoolSet= new SchoolSet;
        $SchoolSet->uscore_avg($pars['course_id'],$pars['exam_stage']);
    }

    // sql-新增 平時成績
    function usual_score_insert($pars=[]){

        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, 'usual_score_insert! error:2105052140');
        }

        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=usual_score_list&dep_id={$pars['dep_id']}&course_id={$pars['course_id']}", 3, 'usual_score_insert! 檢查結果:'.!$GLOBALS['xoopsSecurity']->check());
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // die();
        $student_sn  = Request::getArray('student_sn');//學生編號=>平時成績

        $tbl = $xoopsDB->prefix('yy_usual_score');
        $sql = "DELETE FROM `$tbl` 
            WHERE `course_id` = '{$course_id}'
                AND `exam_stage` = '{$exam_stage}'
                AND `exam_number` = '{$exam_number}'
            ";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        foreach($student_sn as $k=>$v){
            $sql = "insert into `$tbl` (
                `year`,`term`,`dep_id`,`course_id`,`exam_stage`,
                `exam_number`,`student_sn`,`score`,`update_user`,`update_date`
                ) 
                values(
                '{$year}','{$term}','{$dep_id}','{$course_id}','{$exam_stage}',
                '{$exam_number}','{$k}','{$v}','{$update_user}',now()
                )";
                // echo($sql);die();

            $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }

        // 重新計算平時考平均
        $SchoolSet= new SchoolSet;
        $SchoolSet->uscore_avg($course_id,$exam_stage);
    }

    // 表單-新增、編輯 平時成績
    function usual_score_form($pars=[]){
        global $xoopsTpl,$xoopsUser,$xoopsDB;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, '無操作權限');
        }
        $myts = MyTextSanitizer::getInstance();

        $SchoolSet= new SchoolSet;
        // 依課程找 任課教師id、學年、學期、學程
        $uscore['tea_id'] = $SchoolSet->all_course[$pars['course_id']]['tea_id'];
        $uscore['year']   = $SchoolSet->all_course[$pars['course_id']]['cos_year'];
        $uscore['term']   = $SchoolSet->all_course[$pars['course_id']]['cos_term'];
        $uscore['dep_id'] = $SchoolSet->all_course[$pars['course_id']]['dep_id'];
        $uscore['course_id'] = $pars['course_id'];
        $uscore['exam_stage'] = $pars['exam_stage'];
        $uscore['exam_number'] = $pars['exam_number'];
    

        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin() or $uscore['tea_id']==$_SESSION['xoopsUserId'])){
            redirect_header('tchstu_mag.php?op=usual_score_list', 3, '無 usual_score_form 權限!  error:2105051000');
        }     

        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#usual_score_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $uscore['exam_stage_name']=$SchoolSet->usual_exam_name[$pars['exam_stage']];
        $uscore['dep_name']=$SchoolSet->depsnname[$pars['dep_id']];
        $uscore['course_name']=$SchoolSet->courese_chn[$pars['course_id']];
        $uscore['tea_name']=$SchoolSet->uid2name[$uscore['tea_id']];
    
        // 列出該學程內所有學生sn, name 不含回歸結案
        $major_stu=$SchoolSet->major_stu[$pars['dep_id']];
        foreach ($major_stu as $k=>$stusn){
            $stu_data[$stusn]['name']=$myts->htmlSpecialChars($SchoolSet->stu_name[$stusn]);
            $stu_data[$stusn]['score']='';
        }

        $tbl        = $xoopsDB->prefix('yy_usual_score');
        if($pars['exam_number']==''){
            $sql        = "SELECT max(`exam_number`) as exam_number FROM $tbl  Where 
                                    `course_id`='{$pars["course_id"]}' 
                                AND `exam_stage`='{$pars["exam_stage"]}'
                            ";
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $exam_number= $xoopsDB->fetchArray($result);
            if($exam_number['exam_number']==''){
                $uscore['exam_number']='1';
            }else{
                $uscore['exam_number']=(string)((int)$exam_number['exam_number']+1);
            }

 
        }else{
            // 找出，要撈哪些學生的平時成績
            $sql_stusn = "('".implode("','", $major_stu)."')";

            $tb2        = $xoopsDB->prefix('yy_student');
            $sql        = "SELECT * FROM $tbl
                            LEFT JOIN $tb2 as stu on $tbl.student_sn=stu.sn
                            
                            Where `course_id`='{$pars["course_id"]}' 
                                AND `exam_stage`='{$pars["exam_stage"]}'
                                AND `exam_number`='{$pars["exam_number"]}'
                                AND $tbl.student_sn IN $sql_stusn
                                ORDER BY stu.sort
                            ";
            // echo($sql);die();
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    
            while($stu= $xoopsDB->fetchArray($result)){
                // $stu_data [$stu['student_sn']]['name']= $myts->htmlSpecialChars($SchoolSet->stu_name[$stu['student_sn']]);
                $stu_data [$stu['student_sn']]['score']= $myts->htmlSpecialChars($stu['score']);
            }
        }
        $xoopsTpl->assign('all', $stu_data);
        $xoopsTpl->assign('uscore', $uscore);

        // //帶入使用者編號
        if ($pars['exam_number']=='') {
            $uid = $xoopsUser->uid();
        } else {
            $uid = $_SESSION['beck_iscore_adm'] ? $uscore['tea_id'] : $xoopsUser->uid();
        }
        $xoopsTpl->assign('uid', $uid);
        

        //下個動作
        $op='usual_score_insert';
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }

    // 列表- 平時成績
    function usual_score_list($course=[],$g2p=''){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        if (!$xoopsUser) {
            redirect_header('index.php', 3, '無操作權限');
        }

        $SchoolSet= new SchoolSet;

        if((power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            // 全部學程列表
            $course['major_htm']=Get_select_opt_htm($SchoolSet->depsnname,$course['dep_id'],'1');
            // 全部課程列表
            foreach ($SchoolSet->dep2course[$course['dep_id']] as $k=>$v){
                $course_ary[$v]=$SchoolSet->courese_chn[$v];
            }
            $course['course_htm']=Get_select_opt_htm($course_ary,$course['course_id'],'1');
        }
        else{
            // 學程列表
            $tea_course=$SchoolSet->tea_course[$xoopsUser->uid()];
            foreach ($tea_course as $k=>$v){
                $major_namemap[$k]=$SchoolSet->depsnname[$k];
            }
            $course['major_htm']=Get_select_opt_htm($major_namemap,$course['dep_id'],'1');

            // 課程列表
            foreach ($tea_course[$course['dep_id']] as $k=>$v){
                $course_ary[$v]=$SchoolSet->courese_chn[$v];
            }
            $course['course_htm']=Get_select_opt_htm($course_ary,$course['course_id'],'1');
        }


        // die(var_dump($SchoolSet->usual_exam_name));
        if($course['dep_id']!='' AND  $course['course_id']!=''){
            // 三次平時成績時段，是否可keyin
            $addEdit=[];
            foreach($SchoolSet->usual_exam_name as $k=>$name){
                // 判斷新增、修改平時成績權限 
                if((power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
                    $addEdit[$k]=true;
                }else{
                    $addEdit[$k]=$SchoolSet->exam_date_check($name);
                }
            }
            $xoopsTpl->assign('addEdit', $addEdit);

            // 依三次平時成績時段結果，產生新增平時成績欄位下拉選單
            foreach($addEdit as $k=>$name){
                if($name==true){
                    $add_uscore_select[$k]=$SchoolSet->usual_exam_name[$k];
                    $xoopsTpl->assign('show_select', true);
                }
            }
            $course['exam_number_htm']=Get_select_opt_htm($add_uscore_select,'','0');

            $myts = MyTextSanitizer::getInstance();
            
            // 找出三次段考前，平時考的次數
            $tb1      = $xoopsDB->prefix('yy_usual_score');
            $sql      = "SELECT `year`,
                                `term`,
                                `dep_id`,
                                `course_id`,
                                `exam_stage`,
                                MAX(`exam_number`) as `uexam_times`  
                        FROM $tb1 
                        Where `course_id`= '{$course["course_id"]}'
                        GROUP BY 
                                `year`,
                                `term`,
                                `dep_id`,
                                `course_id`,
                                `exam_stage`
                        ORDER BY `exam_stage`
                                ";
            // echo($sql);die();
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            while($data= $xoopsDB->fetchArray($result)){
                $uexam_times[$data['exam_stage']]= $data['uexam_times'];
            }

            // 列出該學程內所有學生sn, name 不含回歸結案
            $major_stu=$SchoolSet->major_stu[$course['dep_id']];
            foreach ($uexam_times as $exam_stage=>$uexam_times){
                foreach ($major_stu as $stu_sn){
                    // 做出學生段考成績空白表單
                    $stu_uscore[$exam_stage][$stu_sn]['name']=$myts->htmlSpecialChars($SchoolSet->stu_name_all[$stu_sn]);
                    $stu_uscore[$exam_stage][$stu_sn]['stu_anonymous']=$myts->htmlSpecialChars($SchoolSet->stu_anonymous_all[$stu_sn]);
                    for($i=1;$i<=$uexam_times;$i++){
                        $stu_uscore[$exam_stage][$stu_sn]['score'][$i]='';
                    }
                }
            }
        
            // get 每次平時成績
            $xoopsTpl->assign('showtable', true);

            $sql_stusn = "('".implode("','", $major_stu)."')";
            // var_dump($sql_stusn);die();
            
            $tb1      = $xoopsDB->prefix('yy_usual_score');
            $tb2      = $xoopsDB->prefix('yy_student');
            $sql      = "SELECT sco.* ,stu.stu_name  , stu.sort  FROM $tb1  as sco
                            LEFT  JOIN $tb2 as stu ON sco.student_sn       = stu.sn
                            Where sco.course_id= '{$course["course_id"]}'
                            AND sco.student_sn IN $sql_stusn
                            ORDER BY `exam_stage`,`exam_number`,stu.sort  
                        ";
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            // $stu_uscore=array();
            while($data= $xoopsDB->fetchArray($result)){
                $stu_uscore[$data['exam_stage']][$data['student_sn']]['score'][$data['exam_number']]= $myts->htmlSpecialChars($data['score']);
            }

            // 撈出每次段考前平時考的加總平均
            $tb1      = $xoopsDB->prefix('yy_uscore_avg');
            $sql      = "SELECT * FROM $tb1  as sco
                        Where sco.course_id='{$course["course_id"]}' 
                        AND `student_sn` IN $sql_stusn
                        ORDER BY exam_stage,student_sn
                ";
            // echo($sql);die();
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            while($data= $xoopsDB->fetchArray($result)){
                // 增加 算平均
                $stu_uscore [$data['exam_stage']][$data['student_sn']]['avg']= $myts->htmlSpecialChars($data['avgscore']);
            }

            foreach($stu_uscore as $exam_stage=>$v2){
                foreach($v2 as $student_sn=>$v3){
                    $score_count[$exam_stage]['score_count'] = count($v3['score']);
                    $score_count[$exam_stage]['test_ary']    = array_keys($v3['score']);
                }
            }

            $xoopsTpl->assign('all', $stu_uscore);
            $xoopsTpl->assign('score_count', $score_count);
            // print_r($stu_uscore);
            // print_r($score_count);
            // die();

        }

        $xoopsTpl->assign('course', $course);
        $xoopsTpl->assign('usual_exam_name', $SchoolSet->usual_exam_name);
        
        $table_color=['1'=>'table-primary','3'=>'table-success','5'=>'table-warning'];
        $xoopsTpl->assign('table_color', $table_color);


        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());


        $xoopsTpl->assign('op', "usual_score_list");

    }
// ----------------------------------

/*-----------秀出結果區--------------*/

$xoopsTpl->assign('now_op', $op);
$xoopsTpl->assign("toolbar", toolbar_bootstrap($interface_menu));

include_once XOOPS_ROOT_PATH . '/footer.php';
