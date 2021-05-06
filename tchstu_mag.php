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
// $student_sn  = Request::getArray('student_sn');//學生編號=>平時成績
// $year        = Request::getString('year');
// $term        = Request::getString('term');
// $dep_id      = Request::getInt('dep_id');
// $course_id   = Request::getInt('course_id');
// $exam_stage  = Request::getInt('exam_stage');
// $exam_number = Request::getInt('exam_number');
// $update_user = Request::getString('update_user');


// die(var_dump($_POST));
// die(var_dump($_GET));
// die(var_dump($_REQUEST));
// die(var_dump($_SESSION));
// var_dump($uscore);die();

switch ($op) {
//學生 管理
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

//課程 管理
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
//平時成績 管理
    //平時成績 列表
    case "usual_socre_list":
        usual_socre_list($uscore,$g2p);
        break;//跳出迴圈,往下執行
    // 表單 平時成績
    case "usual_socre_form":
        usual_socre_form($uscore);
        break;//跳出迴圈,往下執行

    // 新增、更新 平時成績
    case "usual_socre_insert":
        usual_socre_insert($uscore);
        header("location:tchstu_mag.php?op=usual_socre_list&dep_id={$uscore['dep_id']}&course_id={$uscore['course_id']}");
        exit;//離開，結束程式

    // 刪除 平時成績'
    case "usual_socre_delete":
        $re=usual_socre_delete($uscore);
        header("location:tchstu_mag.php?op=usual_socre_list&dep_id={$uscore['dep_id']}&course_id={$uscore['course_id']}");
        exit;



    default:
        // semester_list();
        $op="semester_list";
        break;


}

/*-----------function區--------------*/
// ----------------------------------
// 課程 管理
    // sql-刪除處室
    function course_delete($sn){
        global $xoopsDB,$xoopsUser;

        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header("tchstu_mag.php?op=course_form&sn={$sn}", 3, '無course_delete!error:2104270940');
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

        if(!$xoopsUser){
            redirect_header('index.php', 3, 'course_list!error:2104261048');
        }
        if(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin() ){
            $xoopsTpl->assign('can_edit', true);
        } 

        // var_dump($_REQUEST);
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
        $SchoolSet= new SchoolSet;

        $sql.=" ORDER BY `sort`,`cos_year` DESC , `cos_term` DESC ,`dep_id` ,`tea_id` , `cos_name`";
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
        // var_dump($cos= $xoopsDB->fetchArray($result));die();
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
        $sems_year_htm=Get_select_opt_htm($sems_year,$pars['cos_year'],'1');
        $xoopsTpl->assign('sems_year_htm', $sems_year_htm);
        // 學期 
        $terms=['1'=>'1','2'=>'2'];
        $sems_term_htm=Get_select_opt_htm($terms,$pars['cos_term'],1);
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
            redirect_header("tchstu_mag.php?op=course_form&sn={$sn}", 3, '無course_update權限!error:2104261000');
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
            redirect_header('tchstu_mag.php?op=course_form', 3, '無course_insert權限!error:2104242100');
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
            redirect_header('tchstu_mag.php?op=course_list', 3, '無course_form權限!error:2104221800');
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
            redirect_header('tchstu_mag.php', 3, '無student_delete權限!error:2104210936');
        } 

        
        $tbl = $xoopsDB->prefix('yy_student');
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    // sql-更新學
    function student_update($sn){

        global $xoopsDB,$xoopsUser;
        if(!power_chk("beck_iscore", "1")){
            redirect_header('index.php', 3, '無student_update權限!error:2104201500');
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
                    `update_time` = now()
                where `sn`   = '{$sn}'";

        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        return $sn;
    }

    // sql-新增 學生
    function student_insert(){

        global $xoopsDB,$xoopsUser;

        if(!power_chk("beck_iscore", "1")){
            redirect_header('index.php', 3, '無student_insert權限!error:210420114');
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
        

        $tbl = $xoopsDB->prefix('yy_student');
        $sql = "insert into `$tbl` (
            `stu_name`,`national_id`,`stu_id`,`stu_no`,`class_id`,
            `major_id`,`grade`,`arrival_date`,`birthday`,`orig_school`,
            `household_add`,`address`,`out_learn`,`audit`,`status`,
            `record`,`social_id`,`guidance_id`,`rcv_guidance_id`,`guardian1`,
            `guardian1_relationship`,`guardian1_cellphone1`,`guardian1_cellphone2`,`emergency1_contact1`,`emergency1_contact_rel`,
            `emergency1_cellphone1`,`emergency1_cellphone2`,`uid`,`create_time`,`update_time`) 
            values(
            '{$stu_name}','{$national_id}','{$stu_id}','{$stu_no}','{$class_id}',
            '{$major_id}','{$grade}','{$arrival_date}','{$birthday}','{$orig_school}',
            '{$household_add}','{$address}','{$out_learn}','{$audit}','{$status}',
            '{$record}','{$social_id}','{$guidance_id}','{$rcv_guidance_id}','{$guardian1}',
            '{$guardian1_relationship}','{$guardian1_cellphone1}','{$guardian1_cellphone2}','{$emergency1_contact1}','{$emergency1_contact_rel}',
            '{$emergency1_cellphone1}','{$emergency1_cellphone2}','{$uid}',now(),now()
            )";
        // echo($sql); 
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號

        return $sn;
    }

    // 表單-新增、編輯 學生
    function student_form($sn){
        // var_dump(power_chk("tchstu_mag", "1"));die();
        if(!power_chk("beck_iscore", "1")){
            redirect_header('index.php', 3, '無student_form權限!error:2104191604');
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
        $class_name=$class_tutor=[];
        foreach ($SchoolSet->class as $k=>$v){
            $class_name[$v['sn']]=$v['class_name'];
            $class_tutor[$v['sn']]=$v['name'];
        }
        $stu['class_htm']=Get_select_opt_htm($class_name,$stu['class_id'],'1');
        $xoopsTpl->assign('class_tutor', json_encode($class_tutor));

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
        // var_dump($class_tutor);
        // die();

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

        if(!power_chk("beck_iscore", "2")){
            redirect_header('index.php', 3, 'student_list!error:210420115');
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
        // echo($sql);die();
        // var_dump($pars['status']);
        // var_dump($pars['status']!='');die();
        // $have_par='0';
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
        $sql.=" ORDER BY `sort` ,`stu_no`";
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

        // $is_chk=["0"=>'',"1"=>'checked'];
        // var_dump($stu= $xoopsDB->fetchArray($result));die();

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
    function usual_socre_delete($pars=[]){
        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, 'usual_socre_insert! error:2105052140');
        }
        // die(var_dump($pars));
        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=usual_socre_list&dep_id={$pars['dep_id']}&course_id={$pars['course_id']}", 3, 'usual_socre_delete錯誤! 檢查結果:'.$GLOBALS['xoopsSecurity']->check());
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
        

    }

    // sql-新增 平時成績
    function usual_socre_insert($pars=[]){

        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, 'usual_socre_insert! error:2105052140');
        }

        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=usual_socre_list&dep_id={$pars['dep_id']}&course_id={$pars['course_id']}", 3, 'usual_socre_insert! 檢查結果:'.!$GLOBALS['xoopsSecurity']->check());
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
                $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            }
        // echo($sql);die();
        // return $sn;
    }

    // 表單-新增、編輯 平時成績
    function usual_socre_form($pars=[]){
        global $xoopsTpl,$xoopsUser,$xoopsDB;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, '無操作權限');
        }
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
            redirect_header('tchstu_mag.php?op=usual_socre_list', 3, 'usual_socre_form! error:2105051000');
        }     

        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#usual_socre_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $uscore['exam_stage_name']=$SchoolSet->usual_exam_name[$pars['exam_stage']];
        $uscore['dep_name']=$SchoolSet->depsnname[$pars['dep_id']];
        $uscore['course_name']=$SchoolSet->courese_chn[$pars['course_id']];
        $uscore['tea_name']=$SchoolSet->uid2name[$uscore['tea_id']];
    
        $myts = MyTextSanitizer::getInstance();
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

            // 列出該學程內所有學生sn, name 不含回歸結案
            $major_stu=$SchoolSet->major_stu[$pars['dep_id']];
            foreach ($major_stu as $k=>$v){
                $stu_data[$v]['name']=$myts->htmlSpecialChars($SchoolSet->stu_name[$v]);
                $stu_data[$v]['score']='';
            }
        }else{
            $tb2        = $xoopsDB->prefix('yy_student');

            $sql        = "SELECT * FROM $tbl
                            LEFT JOIN $tb2 as stu on $tbl.student_sn=stu.sn
                            
                            Where `course_id`='{$pars["course_id"]}' 
                                AND `exam_stage`='{$pars["exam_stage"]}'
                                AND `exam_number`='{$pars["exam_number"]}'
                                ORDER BY stu.sort
                            ";
            // echo($sql);die();
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    
            while($stu= $xoopsDB->fetchArray($result)){
                $stu_data [$stu['student_sn']]['name']= $myts->htmlSpecialChars($SchoolSet->stu_name[$stu['student_sn']]);
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
        $op='usual_socre_insert';
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }

    // 列表- 平時成績
    function usual_socre_list($course=[],$g2p=''){
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
        $xoopsTpl->assign('course', $course);
        $xoopsTpl->assign('usual_exam_name', $SchoolSet->usual_exam_name);
        if($course['dep_id']!='' AND  $course['course_id']!=''){
            $myts = MyTextSanitizer::getInstance();
            $tb1      = $xoopsDB->prefix('yy_usual_score');
            $tb2      = $xoopsDB->prefix('yy_student');
            $sql        = "SELECT * FROM $tb1  as sco
                            LEFT JOIN $tb2 as stu ON sco.student_sn=stu.sn
                            Where `course_id`='{$course["course_id"]}' 
                            ORDER BY `exam_stage`,`exam_number`,stu.sort  
                        ";
            // echo($sql);die();
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $stu_uscore=array();
            while($data= $xoopsDB->fetchArray($result)){
                // $stu_uscore [$data['course_id']][$data['exam_stage']][$data['student_sn']]['name']= $myts->htmlSpecialChars($data['stu_name']);
                // $stu_uscore [$data['course_id']][$data['exam_stage']][$data['student_sn']]['score'][$data['exam_number']]= $myts->htmlSpecialChars($data['score']);
                $stu_uscore [$data['exam_stage']][$data['student_sn']]['name']= $myts->htmlSpecialChars($data['stu_name']);
                $stu_uscore [$data['exam_stage']][$data['student_sn']]['score'][$data['exam_number']]= $myts->htmlSpecialChars($data['score']);
            }
            // print_r($stu_uscore);die();

            foreach($stu_uscore as $exam_stage=>$v2){
                foreach($v2 as $student_sn=>$v3){
                    $i=$sum=0;
                    foreach($v3['score'] as $exam_number=>$val_score){
                        if(is_numeric($val_score)){
                            $i++;
                            $sum=$sum+ (float)$val_score;
                        }
                        
                    }
                }
                $score_count[$exam_stage]['score_count'] = count($stu_uscore[$exam_stage][$student_sn]['score']);
                $score_count[$exam_stage]['test_ary']    = array_keys($v3['score']);
            }
            
        }
        // var_dump($score_count);die();
        
        $xoopsTpl->assign('all', $stu_uscore);
        $xoopsTpl->assign('score_count', $score_count);
        // $xoopsTpl->assign('bar', $bar);
        // $xoopsTpl->assign('total', $total);

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('stu_del', XOOPS_URL . "/modules/beck_iscore/tchstu_mag.php?op=student_delete&sn=", 'sn','確定要刪除學生基本資料','學生基本資料刪除。');

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());


        $xoopsTpl->assign('op', "usual_socre_list");

    }
// ----------------------------------
/*-----------秀出結果區--------------*/

$xoopsTpl->assign('now_op', $op);
$xoopsTpl->assign("toolbar", toolbar_bootstrap($interface_menu));

include_once XOOPS_ROOT_PATH . '/footer.php';
