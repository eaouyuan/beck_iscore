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
$type = Request::getString('type');

$tea_list['dep_id']=Request::getInt('dep_id');
$tea_list['search']=Request::getString('search');
$g2p=Request::getInt('g2p');
$cfg['gpname'] = Request::getString('gpname');
$cfg['desc']   = Request::getString('desc');
$cfg['search'] = Request::getString('search');
$cou['cos_year'] = Request::getString('cos_year');
$cou['cos_term'] = Request::getString('cos_term');

// var_dump($_POST);
// die(var_dump($_SESSION));
// die(var_dump($_REQUEST));
// var_dump($_REQUEST);
// var_dump($d_list);
// var_dump('g2p:'.$g2p);
// die();

switch ($op) {
// 處室 管理
    case "dept_school_list":
        dept_school_list();
        break;//跳出迴圈,往下執行
    
    // 新增、編輯 處室表單
    case "dept_school_form":
        dept_school_form($sn);
        break;//跳出迴圈,往下執行

    // 新增處室
    case "dept_school_insert":
        dept_school_insert();
        header("location:school_affairs.php?op=dept_school_list");
        exit;//離開，結束程式

    // 更新處室
    case "dept_school_update":
        dept_school_update($sn);
        header("location:school_affairs.php?op=dept_school_list");
        exit;

    // 刪除處室
    case "dept_school_delete":
        dept_school_delete($sn);
        header("location:school_affairs.php?op=dept_school_list");
        exit;

// 學年度 列表
    case "semester_list":
        semester_list();
        break;//跳出迴圈,往下執行
    
    // 新增、編輯 學年度表單
    case "semester_form":
        semester_form($sn);
        break;//跳出迴圈,往下執行

    // 新增 學年度
    case "semester_insert":
        $sn=semester_insert();
        header("location:school_affairs.php?op=semester_list");
        exit;//離開，結束程式

    // 更新 學年度
    case "semester_update":
        $sn=semester_update($sn);
        header("location:school_affairs.php?op=semester_list");
        exit;

    // 刪除 學年度
    case "semester_delete":
        semester_delete($sn);
        header("location:school_affairs.php?op=announcement_list");
        exit;
    
// 教師 列表
    case "teacher_list":
        teacher_list($tea_list,$g2p);
        break;//跳出迴圈,往下執行

    // 新增、編輯 教師表單
    case "teacher_form":
        teacher_form($sn);
        break;//跳出迴圈,往下執行

    // 顯示 教師
    case "teacher_show":
        teacher_show($sn);
        break;//跳出迴圈,往下執行

    // 新增 教師
    case "teacher_insert":
        teacher_insert($sn);
        header("location:school_affairs.php?op=teacher_list&dep_id={$tea_list['dep_id']}");
        // header("location:school_affairs.php?op=teacher_listshow&sn={$sn}");
        exit;//離開，結束程式

    // 更新 教師
    case "teacher_update":
        $sn=teacher_update($sn);
        header("location:school_affairs.php?op=teacher_list&dep_id={$tea_list['dep_id']}");
        // header("location:school_affairs.php?op=teacher_show&sn={$sn}");
        exit;

    // 刪除 教師
    case "teacher_delete":
        teacher_delete($sn);
        header("location:school_affairs.php?op=teacher_list");
        exit;
    
// 班級 管理
    case "class_list":
        class_list();
        break;//跳出迴圈,往下執行

    // 新增、編輯 處室表單
    case "class_form":
        class_form($sn);
        break;//跳出迴圈,往下執行

    // 新增
    case "class_insert":
        class_insert();
        header("location:school_affairs.php?op=class_list");
        exit;//離開，結束程式

    // 更新
    case "class_update":
        class_update($sn);
        header("location:school_affairs.php?op=class_list");
        exit;

    // 刪除 班級
    case "class_delete":
        class_delete($sn);
        header("location:school_affairs.php?op=class_list");
        exit;

// 學程 管理
    case "department_list":
        department_list();
        break;//跳出迴圈,往下執行

    // 新增、編輯 處室表單
    case "department_form":
        department_form($sn);
        break;//跳出迴圈,往下執行

    // 新增
    case "department_insert":
        department_insert();
        header("location:school_affairs.php?op=department_list");
        exit;//離開，結束程式

    // 更新
    case "department_update":
        department_update($sn);
        header("location:school_affairs.php?op=department_list");
        exit;

    // 刪除 班級
    case "department_delete":
        department_delete($sn);
        header("location:school_affairs.php?op=department_list");
        exit;
        
// 成績keyin日期 管理
    case "exam_keyindate_list":
        exam_keyindate_list();
        break;//跳出迴圈,往下執行

    // 新增、編輯 成績keyin日期表單
    case "exam_keyindate_form":
        exam_keyindate_form($sn);
        break;//跳出迴圈,往下執行

    // 新增 成績keyin日期
    case "exam_keyindate_insert":
        exam_keyindate_insert();
        header("location:school_affairs.php?op=exam_keyindate_list");
        exit;//離開，結束程式

    // 更新 成績keyin日期
    case "exam_keyindate_update":
        exam_keyindate_update($sn);
        header("location:school_affairs.php?op=exam_keyindate_list");
        exit;

    // 刪除 成績keyin日期
    case "exam_keyindate_delete":
        exam_keyindate_delete($sn);
        header("location:school_affairs.php?op=exam_keyindate_list");
        exit;
// 系統變數設定
    // 變數列表
    case "variable_list":
        variable_list($cfg,$g2p);
        break;//跳出迴圈,往下執行
    case "variable_form":
        variable_form($type,$sn);
        break;//跳出迴圈,往下執行
    case "variable_update":
        variable_update($sn);
        header("location:school_affairs.php?op=variable_list&gpname={$cfg['gpname']}&desc={$cfg['desc']}");
        exit;//離開，結束程式
    case "variable_insert":
        variable_insert($type);
        header("location:school_affairs.php?op=variable_list&gpname={$cfg['gpname']}&desc={$cfg['desc']}");
        exit;//離開，結束程式
    case "variable_delete":
        variable_delete($sn);
        header("location:school_affairs.php?op=variable_list");
        exit;//離開，結束程式
// 認輔設定
    case "counseling_set":
        counseling_set($sn,$cou);
        break;//跳出迴圈,往下執行
    case "counseling_set_update":
        $re=counseling_set_update($sn);
        header("location:school_affairs.php?op=counseling_set&cos_year={$re['year']}&cos_term={$re['term']}&sn={$sn}");
        exit;//離開，結束程式

// 權限管理
    case "permission":
        permission();
        break;//跳出迴圈,往下執行
    
    
    
    
        default:
        semester_list();
        $op="semester_list";
        break;


}

/*-----------function區--------------*/
// ----------------------------------
// 認輔設定
    function counseling_set_update($sn){
        global $xoopsDB,$xoopsUser;
        $SchoolSet= new SchoolSet;
        
        if(!(power_chk("beck_iscore", "5") or $xoopsUser->isAdmin())){
            redirect_header('school_affairs.php?op=counseling_set', 3, '無 counseling_set_update 權限!error:2106072000');
        }
        
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("school_affairs.php?op=counseling_set&sn={$sn}", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
    
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        $d_list = Request::getArray('d_list');
        foreach ($d_list as $key => $value) {
            $$d_list[$key] = $myts->addSlashes($value);
        }
        // var_dump($d_list);die();
        if(count($d_list)==0){
            // redirect_header("school_affairs.php?op=counseling_set&sn={$sn}", 3, '沒有選取認輔學生！');
        }
        foreach ($d_list as $key => $stusn) {
            $tbl = $xoopsDB->prefix('yy_tea_counseling');
            // 學生在其它認輔教師紀錄先刪
            $sql = "DELETE FROM `$tbl`
            WHERE `year` = '{$cos_year}'
            AND `term` = '{$cos_term}'
            AND `student_sn` = '{$stusn}'
            ";
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }

        // 再刪除此教師所有認輔學生
        $tbl = $xoopsDB->prefix('yy_tea_counseling');
        $sql = "DELETE FROM `$tbl`
        WHERE `year` = '{$cos_year}'
        AND `term` = '{$cos_term}'
        AND `tea_uid` = '{$sn}'
        ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        foreach ($d_list as $key => $stusn) {
            // 新增認輔對應紀錄
            $sql = "insert into `$tbl` (
                `year`,`term`,`tea_uid`,`student_sn`,`update_user`,
                `update_date`) 
                values(
                '{$cos_year}','{$cos_term}','{$sn}','{$stusn}','{$uid}',
                now()
                )";
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }
        $re['year']=$cos_year;
        $re['term']=$cos_term;
        $re['sn']=$sn;
        return $re;
    }
    // 認輔教師設定
    function counseling_set($sn,$pars){
        global $xoopsTpl,$xoopsUser,$xoopsDB;
        $SchoolSet= new SchoolSet;
        $myts = MyTextSanitizer::getInstance();
        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        if(!(power_chk("beck_iscore", "5") or $xoopsUser->isAdmin())){
            redirect_header('school_affairs.php?op=', 3, '無 counseling_set 權限!error:2106070953');
        }

        $tbl      = $xoopsDB->prefix('yy_semester');
        $sql      = "SELECT distinct `year` , `term`  FROM $tbl ORDER BY `year`" ;
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while($year_ary= $xoopsDB->fetchArray($result)){
            $sel['year'][$year_ary['year']]= $year_ary['year'];
            $sel['term'][$year_ary['year']][$year_ary['term']]= $year_ary['term'];
        }
 
        $xoopsTpl->assign('sem_year', $SchoolSet->sem_year);
        $xoopsTpl->assign('sem_term', $SchoolSet->sem_term);

        // 學年度
        $sems_year_htm=Get_select_opt_htm($sel['year'],$pars['cos_year'],'1');
        $xoopsTpl->assign('sems_year_htm', $sems_year_htm);
        // 學期
        $sems_term_htm=Get_select_opt_htm($sel['term'][$pars['cos_year']],$pars['cos_term'],1);
        $xoopsTpl->assign('sems_term_htm', $sems_term_htm);
        
        $xoopsTpl->assign('pars', $pars);
        // 顯示教師列表
        if($pars['cos_year']!='' and $pars['cos_term']!=''){
            $xoopsTpl->assign('show_tea', true);
        }

        $teachers=[];
        if($pars['cos_year']==$SchoolSet->sem_year and $pars['cos_term']==$SchoolSet->sem_term){
            foreach($SchoolSet->en_users as $k=>$v){
                $teachers[$v['uid']]=$v['name'];
            }
        }else{
            foreach($SchoolSet->users as $k=>$v){
                $teachers[$v['uid']]=$v['name'];
            }
        }
        

        // var_dump($SchoolSet->en_users);die();

        // 列出所有認輔教師，將有認輔的老師加底色
        $tbl = $xoopsDB->prefix('yy_tea_counseling');
        $sql = "SELECT distinct tea_uid FROM $tbl 
                WHERE `year` = '{$pars['cos_year']}'
                AND `term` = '{$pars['cos_term']}'
                ";
        $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while($data= $xoopsDB->fetchArray($result)){
            $teacher_sel[] = $data['tea_uid'];
        }

        // 教師列表
        $tea_sel=Get_select_opt_color_htm($teachers,$sn,'0',$teacher_sel);
        $xoopsTpl->assign('tea_sel', $tea_sel);
        $xoopsTpl->assign('tea_name',$teachers[$sn]);
        $counseling  = array();
        if($sn){
            $tbl = $xoopsDB->prefix('yy_tea_counseling');
            $sql = "SELECT * FROM $tbl 
                    WHERE `year` = '{$pars['cos_year']}'
                    AND `term` = '{$pars['cos_term']}'
                    AND `tea_uid` = '{$sn}'";
            $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            while($data= $xoopsDB->fetchArray($result)){
                $counseling[$data['student_sn']] = $SchoolSet->stu_anonymous[$data['student_sn']];
            }
            $xoopsTpl->assign('sn', $sn);
            // 認輔列表
            $counseling_sel=Get_select_opt_htm($counseling,'','0');
            $xoopsTpl->assign('counseling_sel', $counseling_sel);
        }

        // 學生列表
        $stu_list_ary=$SchoolSet->stu_anonymous;
        $stu_list_ary=array_diff_key($stu_list_ary,$counseling);

        $stu_sel=Get_select_opt_htm($stu_list_ary,'','0');
        $xoopsTpl->assign('stu_sel', $stu_sel);

        $xoopsTpl->assign('uid', $xoopsUser->uid());
        // $xoopsTpl->assign('op', 'counseling_set');
        $xoopsTpl->assign('op', 'counseling_set_update');

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }

// ----------------------------------
// 權限
    function permission(){
        global $xoopsTpl,$xoopsDB,$xoopsModule,$xoopsUser;
        include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';
        //權限項目陣列（編號超級重要！設定後，以後切勿隨便亂改。）
        $item_list = array(
            '1' => "增刪學生",
            '2' => "學生列表",
            '3' => "課程管理",
            '4' => "高關懷",
            '5' => "認輔管理",
        
        );
        $mid       = $xoopsModule->mid();
        $perm_name = $xoopsModule->dirname();//這是 beck_iscore 模組名稱
        // $perm_name = 'tchstu_mag';//這是 beck_iscore 模組名稱
        // var_dump($xoopsModule);die();
        $formi     = new XoopsGroupPermForm('細部權限設定', $mid, $perm_name, '請勾選欲開放給群組使用的權限：<br>');
        foreach ($item_list as $item_id => $item_name) {
            $formi->addItem($item_id, $item_name);
        }
        echo $formi->render();
        // include_once 'footer.php';
    }

// ----------------------------------
// 系統設定- 變數列表
    // 變數刪除
    function variable_delete($sn){
        global $xoopsDB,$xoopsUser;

        if(!($xoopsUser->isAdmin())){
            redirect_header('school_affairs.php', 3, '無 variable_delete 權限!error:2106051650');
        }       

        $tbl     = $xoopsDB->prefix('yy_config');
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        return true;
    }
    // 變數更新
    function variable_update($sn){
        global $xoopsDB,$xoopsUser;
        $SchoolSet= new SchoolSet;
        
        if(!($xoopsUser->isAdmin())){
            redirect_header('school_affairs.php?op=variable_list', 3, '無 variable_update 權限!error:2106051350');
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

        // 查看變數是否存在
        $tbl     = $xoopsDB->prefix('yy_config');
        $sql     = "SELECT * FROM $tbl 
                Where `gpname`='{$gpname}' AND `gpval`='{$gpval}'";

        $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $exist = $xoopsDB->fetchArray($result);
        if($exist AND $exist['sn']!=$sn){
            redirect_header("school_affairs.php?op=variable_form&type={$type}&sn={$sn}", 3, "群組名稱:{$gpname}，值:{$gpval}，已存在! error:2106051245");
        }

        // 更新變數
        $tbl = $xoopsDB->prefix('yy_config');
        $sql = "update " . $tbl . " 
                set `title`       = '{$title}',
                    `gpval`       = '{$gpval}',
                    `description` = '{$description}',
                    `sort`        = '{$sort}',
                    `status`      = '{$status}',
                    `update_user` = '{$update_user}',
                    `update_date` = now()
                where `sn`          = '{$sn}'
                ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        return true;
    }
    // 新增系統變數
    function variable_insert($type){
        global $xoopsDB,$xoopsUser;
        $SchoolSet= new SchoolSet;
        
        if(!($xoopsUser->isAdmin())){
            redirect_header('school_affairs.php?op=variable_list', 3, '無 variable_insert 權限!error:2105301615');
        } 

        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("school_affairs.php?op=variable_list", 3, '新增 系統變數 ，表單Token錯誤，請重新輸入!'.!$GLOBALS['xoopsSecurity']->check());
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // var_dump($type);die();

        // 查看變數是否存在
        $tbl     = $xoopsDB->prefix('yy_config');
        $sql     = "SELECT * FROM $tbl 
                Where `gpname`='{$gpname}' AND `gpval`='{$gpval}'";

        $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $exist = $xoopsDB->fetchArray($result);
        if($exist){
            redirect_header("school_affairs.php?op=variable_form&type={$type}&sn={$sn}", 3, "群組名稱:{$gpname}，值:{$gpval}，已存在! error:2106051245");
        }
        // die();
        $tbl = $xoopsDB->prefix('yy_config');
        $sql = "insert into `$tbl` (
            `gpname`,`title`,`gpval`,`description`,`sort`,
            `status`,`update_user`,`update_date`) 
            values(
            '{$gpname}','{$title}','{$gpval}','{$description}','{$sort}',
            '{$status}','{$uid}',now()
            )";
        // echo($sql); 
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號
        
        return true;
    }
    // 表單-系統變數
    function variable_form($type,$sn){
        global $xoopsTpl,$xoopsUser,$xoopsDB;
        $SchoolSet= new SchoolSet;
        $myts = MyTextSanitizer::getInstance();
        if(!($xoopsUser->isAdmin())){
            redirect_header('school_affairs.php', 3, '無 variable_form 權限! error:2106049044');
        }

        switch ($type) {
            case "n":
                $form_title = '新增系統變數';
                $op='variable_insert';
                break;//跳出迴圈,往下執
            case "c":
                $form_title = '複製系統變數';
                $op='variable_insert';
                break;//跳出迴圈,往下執
            case "e":
                $form_title = '編輯系統變數';
                $op='variable_update';
                break;//跳出迴圈,往下執
        }
        $xoopsTpl->assign("type",$type);

        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("variable_form.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#variable_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $status_ary=['0'=>'關閉','1'=>'啟用'] ;
        $cfg   = array();

        if($sn){
            $tbl    = $xoopsDB->prefix('yy_config');
            $sql    = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $val    = $xoopsDB->fetchArray($result);
        }
        $xoopsTpl->assign('form_title', $form_title);
        $cfg['sn']          = $myts->htmlSpecialChars($val['sn']);
        $cfg['gpname']      = $myts->htmlSpecialChars($val['gpname']);
        $cfg['title']       = $myts->htmlSpecialChars($val['title']);
        $cfg['gpval']       = (int)($val['gpval']);
        $cfg['description'] = $myts->htmlSpecialChars($val['description']);
        $cfg['status']      = radio_htm($status_ary,'status', $val['status']??'1');
        $cfg['update_date'] = $myts->htmlSpecialChars($val['update_date']);
        $cfg['update_user'] = $SchoolSet->uid2name[$val['update_user']]??'管理員';
        $cfg['sort']        = $myts->htmlSpecialChars($val['sort']??'99');

        $xoopsTpl->assign('cfg', $cfg);


        // //帶入使用者編號
        if ($sn) {
            $uid = $_SESSION['beck_iscore_adm'] ? $val['update_user'] : $xoopsUser->uid();
        } else {
            $uid = $xoopsUser->uid();
        }
        $xoopsTpl->assign('uid', $uid);
        

        // //下個動作
        if ($sn) {
            $xoopsTpl->assign('sn', $sn);
        } 
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }
    function variable_list($pars=[],$g2p=''){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        $SchoolSet= new SchoolSet;
        if(!($xoopsUser->isAdmin())){
            redirect_header('school_affairs.php', 3, '無 variable_list 權限! error:2106031400');
        }
        $myts = MyTextSanitizer::getInstance();
        // $SchoolSet->sys_config;

        // 群組名稱
        $sel['gpname']=Get_select_opt_htm($SchoolSet->sys_var['gpname'],$pars['gpname'],'1');
        // 描述
        $sel['desc']=Get_select_opt_htm($SchoolSet->sys_var['desc'],$pars['desc'],'1');
        $sel['search']=$pars['search'];
        $xoopsTpl->assign('sel', $sel);

        $tbl      = $xoopsDB->prefix('yy_config');
        $sql      = "SELECT * FROM $tbl";

        if($pars['gpname']!=''){
            $sql.=" WHERE `gpname`='{$pars['gpname']}'";
        }elseif($pars['desc']!=''){
            $sql.=" WHERE `description`='{$pars['desc']}'";
        }elseif($pars['search']!=''){
            $sql.=" WHERE (`gpname` like '%{$pars['search']}%' OR `title` like '%{$pars['search']}%' OR `description` like '%{$pars['search']}%')";
        }
        $sql.=" ORDER BY `gpname` , `sort`";
        // echo($sql);die();
        
        
        //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = getPageBar($sql, 12, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];

        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all      = array();
        $status_ary=['0'=>'關閉','1'=>'啟用'] ;
        // var_dump($pars);
        while(  $cfg= $xoopsDB->fetchArray($result)){
            $cfg['sn']          = $myts->htmlSpecialChars($cfg['sn']);
            $cfg['gpname']      = $myts->htmlSpecialChars($cfg['gpname']);
            $cfg['title']       = $myts->htmlSpecialChars($cfg['title']);
            $cfg['gpval']       = $myts->htmlSpecialChars($cfg['gpval']);
            $cfg['desc']        = $myts->htmlSpecialChars($cfg['desc']);
            $cfg['status']      = $myts->htmlSpecialChars($status_ary[$cfg['status']]);
            $cfg['sort']        = (int) $cfg['sort'];
            $cfg['update_date'] = $myts->htmlSpecialChars(date("Y-m-d",strtotime($cfg['update_date'])));
            $all []             = $cfg;
        }
        $xoopsTpl->assign('all', $all);
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);
        
        // die(var_dump($all));

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('var_del', XOOPS_URL . "/modules/beck_iscore/school_affairs.php?op=variable_delete&sn=", 'sn','確定要刪除變數資料','變數資料刪除。');

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

        $xoopsTpl->assign('op', "variable_list");


    }
// ----------------------------------
// 成績keyin日期 管理
    // sql-成績keyin日期
    function exam_keyindate_delete($sn){
        global $xoopsDB,$xoopsUser;

        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header('index.php', 3, '無 exam_keyindate_delete 權限!error:2104210936');
        } 
        
        $tbl = $xoopsDB->prefix('yy_exam_keyin_daterange');
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    // sql-更新 成績keyin日期
    function exam_keyindate_update($sn){

        global $xoopsDB,$xoopsUser;
        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header('index.php', 3, '無 exam_keyindate_update 權限! error:2105010830');
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
        $tbl = $xoopsDB->prefix('yy_exam_keyin_daterange');
        $sql = "update `$tbl` set 
                    `exam_year`   = '{$exam_year}',
                    `exam_term`= '{$exam_term}',
                    `exam_name` = '{$exam_name}', 
                    `start_date` = '{$start_date}', 
                    `end_date` = '{$end_date}', 
                    `status` = '{$status}', 
                    `update_user` = '{$uid}', 
                    `update_date` = now() 
                where `sn`   = '{$sn}'";

        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        return $sn;
    }

    // sql-新增 成績keyin日期
    function exam_keyindate_insert(){

        global $xoopsDB,$xoopsUser;

        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header('index.php', 3, '無 exam_keyindate_insert 權限! error:2104301036');
        } 

        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("school_affairs.php?op=student_form", 3, '新增成績keyin日期，表單Token錯誤，請重新輸入!'.!$GLOBALS['xoopsSecurity']->check());
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
                
        $tbl   = $xoopsDB->prefix('yy_exam_keyin_daterange');

        $sql      = "SELECT * FROM $tbl WHERE `exam_year`='{$exam_year}' AND `exam_term`='{$exam_term}'
                    AND `exam_name`='{$exam_name}' ";
        // echo($sql);die();
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_exist= $xoopsDB->fetchArray($result);
        // die(var_dump($cos_exist));
    
        if (!$data_exist) {
            $sql = "insert into `$tbl` (
                        `exam_year`,`exam_term`,`exam_name`,`start_date`,`end_date`,
                        `status`,`update_user`,`update_date`
                    )values(
                        '{$exam_year}','{$exam_term}','{$exam_name}','{$start_date}', '{$end_date}',
                        '{$status	}','{$uid}',now()
                    )";
            // echo($sql);die();
            $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }else{
            redirect_header('school_affairs.php?op=exam_keyindate_list', 3, '此段考設定已存在!error:2104302257');

        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號
        return $sn;
        }
        
    }

    // 表單-新增、編輯 成績keyin日期
    function exam_keyindate_form($sn){
        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header('index.php', 3, '無 exam_keyindate_form 權限!error:2104301507');
        }        
        global $xoopsTpl,$xoopsUser,$xoopsDB;

        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("school_affairs.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#exam_keyindate_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form_title = '新增成績登錄日期';
        $stu   = array();

        if($sn){
            $form_title = '編輯成績登錄日期';
            $tbl     = $xoopsDB->prefix('yy_exam_keyin_daterange');
            $sql     = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $exam_date = $xoopsDB->fetchArray($result);
        }
        $xoopsTpl->assign('form_title', $form_title);

        $exam_date['exam_year']  = $exam_date['exam_year'] ?? '' ;
        $exam_date['exam_term']  = $exam_date['exam_term'] ?? '' ;
        $exam_date['exam_name']  = $exam_date['exam_name'] ?? '' ;
        $exam_date['start_date'] = $exam_date['start_date'] ?? '';
        $exam_date['end_date']   = $exam_date['end_date']?? '' ;
        $exam_date['status']     = $exam_date['status'] ?? '';
        
        $SchoolSet= new SchoolSet;
        // 學年度select
        foreach ($SchoolSet->all_sems as $k=>$v){
            $sems_year[$v['year']]=$v['year'];
        }
        $exam_year_htm=Get_select_opt_htm($sems_year,$exam_date['exam_year'],'1');
        $xoopsTpl->assign('exam_year_htm', $exam_year_htm);

        // 學期 
        $terms=['1'=>'1','2'=>'2'];
        $exam_term_htm=Get_select_opt_htm($terms,$exam_date['exam_term'],1);
        $xoopsTpl->assign('exam_term_htm', $exam_term_htm);

        // 成績登錄考試類型	
        foreach ($SchoolSet->exam_name as $k=>$v){
            $exam_name_ary[$v]=$v;
        }
        $exam_name_htm=Get_select_opt_htm($exam_name_ary,$exam_date['exam_name'],'1');
        $xoopsTpl->assign('exam_name_htm', $exam_name_htm);

        // 目前狀況
        $status_ary=['0'=>'關閉','1'=>'啟用','2'=>'暫停'] ;
        $status_htm=Get_select_opt_htm($status_ary,$exam_date['status'],'1');
        $xoopsTpl->assign('status_htm', $status_htm);

        $xoopsTpl->assign('exam_date', $exam_date);

        // //帶入使用者編號
        if ($sn) {
            $uid = $_SESSION['beck_iscore_adm'] ? $exam_date['update_user'] : $xoopsUser->uid();
        } else {
            $uid = $xoopsUser->uid();
        }
        $xoopsTpl->assign('uid', $uid);
        

        // //下個動作
        if ($sn) {
            $op='exam_keyindate_update';
            $xoopsTpl->assign('sn', $sn);
        } else {
            $op='exam_keyindate_insert';
        }
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }

    // 列表- 成績keyin日期
    function exam_keyindate_list($pars=[],$g2p=''){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;

        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header('index.php', 3, '無 exam_keyindate_list 權限! error:2104301500');
        } 

        // var_dump($_SESSION);die();
        $myts = MyTextSanitizer::getInstance();

        $tb1      = $xoopsDB->prefix('yy_exam_keyin_daterange');
        $sql      = "SELECT  * FROM $tb1
                    ORDER BY sort,exam_year desc, exam_term desc, exam_name 
                        " ;
        
        //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $Item=24;//每頁幾筆
        $PageBar = getPageBar($sql, $Item, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];

        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all      = array();

        if($g2p=='' OR $g2p=='1'){$i=1;}else{$i=($g2p-1)*$Item+1;}

        // var_dump($stu= $xoopsDB->fetchArray($result));die();
        // 目前狀況
        $status_ary=['0'=>'關閉 ','1'=>'啟用','2'=>'暫停'] ;

        while($exam_data= $xoopsDB->fetchArray($result)){
            $exam_data['i']          = $i;
            $exam_data['exam_year']  = $myts->htmlSpecialChars($exam_data['exam_year']);   //學號
            $exam_data['exam_term']  = $myts->htmlSpecialChars($exam_data['exam_term']);   //姓名
            $exam_data['exam_name']  = $myts->htmlSpecialChars($exam_data['exam_name']);
            $exam_data['start_date'] = $myts->htmlSpecialChars($exam_data['start_date']);
            $exam_data['end_date']   = $myts->htmlSpecialChars($exam_data['end_date']);
            $exam_data['status']     = $myts->htmlSpecialChars($status_ary[$exam_data['status']]);
            $all       []            = $exam_data;
            $i++;
        }

        // var_dump($all);die();

        $xoopsTpl->assign('all', $all);
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('examdate_del', XOOPS_URL . "/modules/beck_iscore/school_affairs.php?op=exam_keyindate_delete&sn=", 'sn','確定要刪除考試成績登入時間基本資料','考試成績登入時間基本資料刪除。');

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());


        $xoopsTpl->assign('op', "exam_keyindate_list");

    }

// ----------------------------------
// 學程 管理 0409
    // sql-刪除 學程
    function department_delete($sn){
        global $xoopsDB,$xoopsUser;
        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php?op=department_list', 3, '無操作權限');
        }
        
        $tbl = $xoopsDB->prefix('yy_department');
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    // sql-更新 學程
    function department_update($sn){

        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php?op=department_list', 3, '無操作權限');
        }
        
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("school_affairs.php?op=department_form&sn={$sn}", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // die();
        $tbl = $xoopsDB->prefix('yy_department');
        $sql = "update `$tbl` set 
                    `dep_name`     = '{$dep_name}',
                    `normal_exam`  = '{$normal_exam}',
                    `section_exam` = '{$section_exam}',
                    `dep_status`   = '{$dep_status}',
                    `update_uid`   = '{$operator_uid}',
                    `update_time`  = now()
                where `sn`   = '{$sn}'";

        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        return $sn;
    }

    // sql-新增 學程
    function department_insert(){

        global $xoopsDB,$xoopsUser;
        // var_dump($_REQUEST);die();

        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php?op=department_list', 3, '無操作權限');
        }
        
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("school_affairs.php?op=dept_school_form", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }

        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // die(var_dump($_POST));

        $tbl = $xoopsDB->prefix('yy_department');
        $sql = "insert into `$tbl` (
            `dep_name`,`dep_status`,`create_uid`,`create_time`,`update_uid`,`update_time`,`normal_exam` , `section_exam`) 
            values('{$dep_name}','{$dep_status}','{$operator_uid}',now(),'{$operator_uid}', now(), '{$normal_exam}', '{$section_exam}')";
        // echo($sql);die();
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號

        return $sn;
    }
 
    // 表單-新增、編輯 班級
    function department_form($sn){
        global $xoopsTpl,$xoopsUser,$xoopsDB;
        // $SchoolSet= new SchoolSet;
        // var_export($SchoolSet->users);die();
        // print_r($SchoolSet->get_depts_user());die();

        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs?op=department_list.php', 3, '無操作權限');
        }
        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("school_affairs.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#department_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // if (!power_chk('beck_iscore', 1)) {
        //     redirect_header('school_affairs.php', 3, '無操作權限');
        // }


        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form_title = '新增學程';

        if($sn){
            $department      = array();
            $form_title = '編輯學程';
            $tbl        = $xoopsDB->prefix('yy_department');
            $sql        = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $department = $xoopsDB->fetchArray($result);
        }
        $xoopsTpl->assign('form_title', $form_title);
        // var_dump($department);die();
        // 給預設值
        $department['sn']           = (!isset($department['sn'])) ? '' : $department['sn'];
        $department['dep_name']     = (!isset($department['dep_name'])) ? '' : $department['dep_name'];
        $department['dep_status']   = (!isset($department['dep_status'])) ? '1' : $department['dep_status'];
        $department['normal_exam']  = (!isset($department['normal_exam'])) ? '' : $department['normal_exam'];
        $department['section_exam'] = (!isset($department['section_exam'])) ? '1' : $department['section_exam'];

        $xoopsTpl->assign('department', $department);
        // 學程狀態，預計啟用
        $department_status_ary=['0'=>'關閉','1'=>'啟用','2'=>'暫停'];
        $department_st_op_htm=Get_select_opt_htm($department_status_ary,$department['dep_status'],'0');
        $xoopsTpl->assign('department_st_op_htm', $department_st_op_htm);
        
        // var_dump($department);die();

        // //帶入使用者編號
        $operator_uid = $xoopsUser->uid();
        $xoopsTpl->assign('operator_uid', $operator_uid);

        // //下個動作
        if ($sn) {
            $op='department_update';
            $xoopsTpl->assign('sn', $sn);
        } else {
            $op='department_insert';
        }
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }

    // 列表- 學程
    function department_list(){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php', 3, '無操作權限');
        }

        $myts = MyTextSanitizer::getInstance();

        $tbl      = $xoopsDB->prefix('yy_department');
        $sql      = "SELECT * FROM $tbl ORDER BY `sn`";
        
        //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = getPageBar($sql, 10, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];

        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all      = array();
        if($g2p=null OR $g2p=='' OR $g2p=='1'){$i=1;}else{$i=$g2p*10+1;}

        $dep_stat=['0'=>'關閉','1'=>'啟用','2'=>'暫停'];
        while(  $department= $xoopsDB->fetchArray($result)){
                $department['no']           = $i;
                $department['sn']           = $myts->htmlSpecialChars($department['sn']);
                $department['dep_name']     = $myts->htmlSpecialChars($department['dep_name']);
                $department['normal_exam']  = $myts->htmlSpecialChars($department['normal_exam']);
                $department['section_exam'] = $myts->htmlSpecialChars($department['section_exam']);
                $department['dep_status']   = $myts->htmlSpecialChars($dep_stat[$department['dep_status']]);
                $department['sort']         = $myts->htmlSpecialChars($department['sort']);
                $all        []              = $department;
                $i++;
        }
        $xoopsTpl->assign('all', $all);
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);
        
        
        $SweetAlert = new SweetAlert();
        $SweetAlert->render('dept_del', XOOPS_URL . "/modules/beck_iscore/school_affairs.php?op=department_delete&sn=", 'sn','確定要刪除學程資料?','刪除後無法還原。');


    }
// ----------------------------------
// 班級列表
    // sql-刪除 班級
    function class_delete($sn){
        global $xoopsDB,$xoopsUser;
        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php?op=class_list', 3, '無操作權限');
        }
        
        $tbl = $xoopsDB->prefix('yy_class');
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    // sql-更新 班級
    function class_update($sn){

        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php?op=class_list', 3, '無操作權限');
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

        $tbl = $xoopsDB->prefix('yy_class');
        $sql = "update `$tbl` set 
                    `class_name`   = '{$class_name}',
                    `class_status`= '{$status}',
                    `tutor_sn`= '{$teacher}',
                    `update_uid` = '{$operator_uid}', 
                    `update_time` = now()
                where `sn`   = '{$sn}'";

        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        return $sn;
    }

    // sql-新增 班級
    function class_insert(){

        global $xoopsDB,$xoopsUser;
        // var_dump($_REQUEST);die();

        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php?op=class_list', 3, '無操作權限');
        }
        
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("school_affairs.php?op=dept_school_form", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }

        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // die(var_dump($_POST));

        $tbl = $xoopsDB->prefix('yy_class');
        $sql = "insert into `$tbl` (
            `class_name`,`class_status`,`tutor_sn`,`create_uid`,`create_time`,`update_uid`,`update_time`) 
            values('{$class_name}','{$status}','{$teacher}','{$operator_uid}',now(),'{$operator_uid}', now())";
        // echo($sql);die();
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號

        return $sn;
    }

    // 表單-新增、編輯 班級
    function class_form($sn){
        global $xoopsTpl,$xoopsUser,$xoopsDB;
        $SchoolSet= new SchoolSet;
        // var_export($SchoolSet->users);die();
        // print_r($SchoolSet->get_depts_user());die();

        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs?op=class_list.php', 3, '無操作權限');
        }
        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("school_affairs.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#class_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form_title = '新增班級';

        if($sn){
            $class      = array();
            $form_title = '編輯學校班級';
            $tbl        = $xoopsDB->prefix('yy_class');
            $sql        = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $class      = $xoopsDB->fetchArray($result);
        }
        $xoopsTpl->assign('form_title', $form_title);
        // var_dump($class);die();
        // 給預設值
        $class['sn']           = (!isset($class['sn'])) ? '' : $class['sn'];
        $class['class_name']   = (!isset($class['class_name'])) ? '' : $class['class_name'];
        $class['class_status'] = (!isset($class['class_status'])) ? '1' : $class['class_status'];
        $class['tutor_sn']     = (!isset($class['tutor_sn'])) ? '' : $class['tutor_sn'];
        $class['tutor_name']   = ($class['tutor_sn']=='') ? '未設定' : $SchoolSet->uid2name[$class['tutor_sn']];

        $xoopsTpl->assign('class', $class);

        // 班級狀態，預計啟用
        $class_status_ary=['0'=>'關閉','1'=>'啟用','2'=>'暫停'];
        $class_st_op_htm=Get_select_opt_htm($class_status_ary,$class['class_status'],'0');
        $xoopsTpl->assign('class_st_op_htm', $class_st_op_htm);
        

        $get_depts_user=$SchoolSet->get_depts_user('teacher');
        // print_r($get_depts_user );die();
        $htm='';
        
        foreach ($get_depts_user as $dep=>$v){
            if(array_key_exists($class['tutor_sn'],$v)){$backcolor="bg-warning";}else{$backcolor="bg-info";}
            $htm.=<<<HTML
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header {$backcolor}" id="head{$dep}">
                            <h2 class="mb-0">
                            <button class="btn btn-block text-center text-black font-weight-bold" type="button" data-toggle="collapse" data-target="#{$dep}" aria-expanded="true" aria-controls="{$dep}">
                                {$dep}
                            </button>
                            </h2>
                        </div>
                
                        <div id="{$dep}" class="collapse" aria-labelledby="head{$dep}" data-parent="#accordionExample">
                            <div class="card-body">
            HTML;
                                $htm.=radio_htm($v,'teacher',$class['tutor_sn']);
            $htm.=<<<HTML
                            </div>
                        </div>
                    </div>
                </div>
            HTML; 

        }
        $xoopsTpl->assign('tchhtm', $htm);

        // //帶入使用者編號
        $operator_uid = $xoopsUser->uid();
        $xoopsTpl->assign('operator_uid', $operator_uid);

        // //下個動作
        if ($sn) {
            $op='class_update';
            $xoopsTpl->assign('sn', $sn);
        } else {
            $op='class_insert';
        }
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }

    // 列表- 班級
    function class_list(){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php', 3, '無操作權限');
        }

        $myts = MyTextSanitizer::getInstance();

        $tbl      = $xoopsDB->prefix('yy_class');
        $sql      = "SELECT * FROM $tbl ORDER BY `sn`";
        
        //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = getPageBar($sql, 10, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];

        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all      = array();
        if($g2p=='' OR $g2p=='1'){$i=1;}else{$i=$g2p*10+1;}

        $class_status=['0'=>'關閉','1'=>'啟用','2'=>'暫停'];
        while(  $class= $xoopsDB->fetchArray($result)){
                $class['no']           = $i;
                $class['sn']           = $myts->htmlSpecialChars($class['sn']);
                $class['class_name']   = $myts->htmlSpecialChars($class['class_name']);
                $class['class_status'] = $myts->htmlSpecialChars($class_status[$class['class_status']]);
                $class['sort']         = $myts->htmlSpecialChars($class['sort']);
                $class['tutor_sn']     = $myts->htmlSpecialChars(users_data($class['tutor_sn'])['name']);
                $all   []              = $class;
                $i++;
        }
        $xoopsTpl->assign('all', $all);
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);
        
        
        $SweetAlert = new SweetAlert();
        $SweetAlert->render('cls_del', XOOPS_URL . "/modules/beck_iscore/school_affairs.php?op=class_delete&sn=", 'sn','確定要刪除班級資料?','刪除後無法還原。');


    }
// ----------------------------------
// 教師列表    
    // sql-刪除 教師基本資料
    function teacher_delete($sn){
        global $xoopsDB,$xoopsUser;

        $tbl        = $xoopsDB->prefix('yy_teacher');
        $sql        = "SELECT * FROM $tbl Where `uid`='{$sn}'";
        $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $tch        = $xoopsDB->fetchArray($result);

        if(!(($xoopsUser->isAdmin()) or ($_SESSION['xoopsUserId']== $tch['uid']))){
            redirect_header('school_affairs.php?op=teacher_list', 3, '非管理員或該使用者！');
        }

        $tbl        = $xoopsDB->prefix('groups_users_link');
        $sql        = "SELECT * FROM $tbl Where `uid`='{$sn}'";
        $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while($gul= $xoopsDB->fetchArray($result)){
            $user['groupid'][]=$gul['groupid'];
        }

        if(in_array('1',$user['groupid'])){
            redirect_header('school_affairs.php?op=teacher_list', 2, '該教師是管理員無法刪除！');
        }
        // var_dump($user);die();

        $tbl = $xoopsDB->prefix('yy_teacher');
        $sql = "DELETE FROM `$tbl` WHERE `uid` = '{$sn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $tbl = $xoopsDB->prefix('groups_users_link');
        $sql = "DELETE FROM `$tbl` WHERE `uid` = '{$sn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $tbl = $xoopsDB->prefix('users');
        $sql = "DELETE FROM `$tbl` WHERE `uid` = '{$sn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        redirect_header('school_affairs.php?op=teacher_list', 2, '刪除成功！');

    }

    // sql-更新 教師基本資料
    function teacher_update($sn){

        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, '無操作權限');
        }

        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("index.php?op=announcement_form&sn={$sn}", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }

        update_group($sn);
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // die();
        $tbl = $xoopsDB->prefix('yy_teacher');
        $sql = "update `$tbl` set 
                    `uid`         = '{$sn}',
                    `dep_id`      = '{$dep_id}',
                    `title`       = '{$title}',
                    `sex`         = '{$sex}',
                    `phone`       = '{$phone}',
                    `cell_phone`  = '{$cell_phone}',
                    `enable`      = '{$enable}',
                    `isteacher`   = '{$isteacher}',
                    `isguidance`  = '{$isguidance}',
                    `issocial`    = '{$issocial}',
                    `update_uid`  = '{$create_uid}',
                    `update_time` = now()
                where `uid`   = '{$sn}'";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $tbl = $xoopsDB->prefix('users');
        $sql = "update `$tbl` set 
                    `email`='{$email}'
                where `uid`   = '{$sn}'";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        
        return $sn;
    }

    // sql-新增  教師基本資料
    function teacher_insert($sn){

        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, '無操作權限');
        }
        
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("index.php?op=announcement_form", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // die(var_dump($uid));
        update_group($sn);

        $tbl = $xoopsDB->prefix('users');
        $sql = "update `$tbl` set 
                    `email`='{$email}'
                where `uid`   = '{$sn}'";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);


        $tbl = $xoopsDB->prefix('yy_teacher');
        $sql = "insert into `$tbl` (
                    `uid`,`dep_id`,`title`,`sex`,`phone`,
                    `cell_phone`,`enable`,`isteacher`,`isguidance`,`issocial`,
                    `create_uid`,`create_time`,`update_uid`,`update_time`,`sort`
                )values(
                    '{$sn}','{$dep_id}','{$title}','{$sex}','{$phone}',
                    '{$cell_phone}','{$enable}','{$isteacher}','{$isguidance}','{$issocial}',
                    '{$create_uid}', now(),'{$create_uid}',now(),'99'
                )";
        // echo($sql);die();

        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號
        return $sn;
    }

    function teacher_show($sn){
        global $xoopsTpl,$xoopsDB,$xoopsUser;
    
        if (!$xoopsUser){redirect_header('index.php', 3, '無操作權限。error:2104041922');}

        $myts = MyTextSanitizer::getInstance();
    
        $tbl        = $xoopsDB->prefix('yy_teacher');
        $sql        = "SELECT * FROM $tbl Where `uid`='{$sn}'";
        $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $tch        = $xoopsDB->fetchArray($result);
        $xoopsTpl->assign('sn', $sn);

        // var_dump($tch);die();
        $form_title  = '教師基本資料';
        $xoopsTpl->assign('form_title', $form_title);

        if($tch){
            $tch['uid']         = $myts->htmlSpecialChars($tch['uid']);
            $tch['dep_id']      = $myts->htmlSpecialChars($tch['dep_id']);
            $tch['title']       = $myts->htmlSpecialChars($tch['title']);
            $tch['sex']         = $myts->htmlSpecialChars($tch['sex']);
            $tch['phone']       = $myts->htmlSpecialChars($tch['phone']);
            $tch['cell_phone']  = $myts->htmlSpecialChars($tch['cell_phone']);
            $tch['enable']      = $myts->htmlSpecialChars($tch['enable']);
            $tch['isteacher']   = $myts->htmlSpecialChars($tch['isteacher']);
            $tch['update_time'] = date("Y-m-d",strtotime($myts->htmlSpecialChars($tch['update_time'])));
            $tch['uname']       = users_data($sn)['uname'];
            $tch['name']        = users_data($sn)['name'];
            $tch['email']       = users_data($sn)['email'];
            $tch['dept_name']   = dept_school::GetDept($tch['dep_id'])['dept_name'];
        }

        // var_dump($tch);die();
        $xoopsTpl->assign('tch', $tch);

        // 性別
        $sex_id = (!isset($tch['sex'])) ? '' : $tch['sex'];
        $sex_ary=["0"=>'女',"1"=>'男'];
        $tch_sex_htm=Get_select_opt_htm($sex_ary,$sex_id,'1');
        $xoopsTpl->assign('tch_sex_htm', $tch_sex_htm);

        // 處室分類
        $tch_dept_id = (!isset($tch['dep_id'])) ? '' : $tch['dep_id'];
        $dept_c_sel_htm=Dept_school::GetDept_Class_Sel_htm($tch_dept_id,'1');
        $xoopsTpl->assign('dept_c_sel_htm', $dept_c_sel_htm);


    }

    // 表單-新增、編輯教師消息
    function teacher_form($sn){
        global $xoopsTpl,$xoopsUser,$xoopsDB;

        if(!(($xoopsUser->isAdmin()) or ($_SESSION['xoopsUserId']== $sn))){
            redirect_header('index.php', 3, '非管理員或編輯本人資料，無操作權限!2104081741');
        }


        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("index.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#teacher_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form_title = '編輯教師基本資料';
        $space='1';//發佈處室空白選項
        $tch=[];
        if($sn){
            $tbl    = $xoopsDB->prefix('users');
            $tb2    = $xoopsDB->prefix('yy_teacher');
            $sql    = "SELECT * , ur.uid FROM $tbl as ur LEFT JOIN $tb2 as tr ON ur.uid=tr.uid
                    WHERE ur.uid='{$sn}'            
            ";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $tch    = $xoopsDB->fetchArray($result);
        
            if(!(($xoopsUser->isAdmin()) OR ($_SESSION['xoopsUserId']== $tch['uid']))){
                redirect_header('school_affairs.php?op=teacher_list', 3, '非管理員或非個人基本資料!');
            }
        }else{
            redirect_header('index.php', 3, '無教師基本資料!');
        }
        // var_export($tch);die();

        $xoopsTpl->assign('form_title', $form_title);
        $xoopsTpl->assign('tch', $tch);

        // 性別
        $sex_id = (!isset($tch['sex'])) ? '' : $tch['sex'];
        $sex_ary=["0"=>'女',"1"=>'男'];
        $tch_sex_htm=Get_select_opt_htm($sex_ary,$sex_id,'1');
        $xoopsTpl->assign('tch_sex_htm', $tch_sex_htm);

        // 處室分類
        $tch_dept_id = (!isset($tch['dep_id'])) ? '' : $tch['dep_id'];
        $dept_c_sel_htm=Dept_school::GetDept_Class_Sel_htm($tch_dept_id,$space);
        $xoopsTpl->assign('dept_c_sel_htm', $dept_c_sel_htm);

        // 教師開關
        $onoff=['0'=>'關','1'=>'開'];
        $en_chk = (!isset($tch['enable'])) ? '0' : $tch['enable'];
        $tch_en_htm=radio_htm($onoff,'enable',$en_chk);
        $xoopsTpl->assign('tch_en_htm', $tch_en_htm);

        // 具備教師身份
        $ynary=['0'=>'否','1'=>'是'];
        $isteacher = (!isset($tch['isteacher'])) ? '0' : $tch['isteacher'];
        $tch_is_html=radio_htm($ynary,'isteacher',$isteacher);
        $xoopsTpl->assign('tch_is_html', $tch_is_html);
        // 具備輔導教師身份
        $isguidance = (!isset($tch['isguidance'])) ? '0' : $tch['isguidance'];
        $gdc_is_html=radio_htm($ynary,'isguidance',$isguidance);
        $xoopsTpl->assign('gdc_is_html', $gdc_is_html);
        // 具備教師身份
        $issocial = (!isset($tch['issocial'])) ? '0' : $tch['issocial'];
        $scl_is_html=radio_htm($ynary,'issocial',$issocial);
        $xoopsTpl->assign('scl_is_html', $scl_is_html);
        // 教師啟用
        $isenable = (!isset($tch['enable'])) ? '1' : $tch['enable'];
        $eal_is_html=radio_htm($ynary,'enable',$isenable);
        $xoopsTpl->assign('eal_is_html', $eal_is_html);

        // //帶入使用者編號
        $xoopsTpl->assign('create_uid', $xoopsUser->uid());
        
        // //下個動作，教師基本資料是否存在
        $tb2      = $xoopsDB->prefix('yy_teacher');
        $sql      = "SELECT * FROM $tb2 WHERE uid='{$sn}'";
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $tch_base = $xoopsDB->fetchArray($result);
        $xoopsTpl->assign('sn', $sn);
        if ($tch_base) {
            $op='teacher_update';
        } else {
            $op='teacher_insert';
        }
        $xoopsTpl->assign('op', $op);


        $user_groups=users_group($sn);
        $XoopGroupUser=new XoopsFormSelectGroup('group', 'group', false, $user_groups,3,true);
        $xoopsTpl->assign('XoopGroupUser' , $XoopGroupUser->render());

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());
        
        if($xoopsUser->isAdmin()){
            $xoopsTpl->assign('show_GrpAIstch', true);
        }

    }

    // 列表- 教師
    function teacher_list($pars=[],$g2p=''){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;

        if (!$xoopsUser->isAdmin()) {
            redirect_header('index.php', 3, '無操作權限');
        }
        // var_dump($_SESSION);die();
        $myts = MyTextSanitizer::getInstance();

        $tbl      = $xoopsDB->prefix('users');
        $tb2      = $xoopsDB->prefix('yy_teacher');
        $sql      = "SELECT  ur.name,ur.uname,ur.email, tr.* ,ur.uid,tr.sort
                    FROM $tbl as ur LEFT JOIN $tb2 as tr ON ur.uid=tr.uid" ;
        // echo($sql);die();

        $have_par='0';
        if(!empty($pars['dep_id'])){
            $sql.=" WHERE tr.dep_id='{$pars['dep_id']}'";
            $have_par='1';
        }
        if(!empty($pars['search'])){
            if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.="(
                (`name` like '%{$pars['search']}%') or (`uname` like '%{$pars['search']}%') or
                (`email` like '%{$pars['search']}%') or (tr.title like '%{$pars['search']}%')
                ) ";
            $have_par='1';
        }
        if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
        $sql.=" ur.uid != '1' ORDER BY `sort` ";
        // echo($sql);  die();

        //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        // $PageBar = getPageBar($sql, 10, 10);
        // $bar     = $PageBar['bar'];
        // $sql     = $PageBar['sql'];
        // $total   = $PageBar['total'];

        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all      = array();
        if($g2p=='' OR $g2p=='1'){$i=1;}else{$i=$g2p*10+1;}
        $is_chk=["0"=>'',"1"=>'checked'];
        while($tch= $xoopsDB->fetchArray($result)){
            $tch['sn']         = $i;
            $tch['uid']        = $myts->htmlSpecialChars($tch['uid']);
            $tch['uname']      = $myts->htmlSpecialChars($tch['uname']);       //帳號
            $tch['name']       = $myts->htmlSpecialChars($tch['name']);        //姓名
            $tch['email']      = $myts->htmlSpecialChars($tch['email']);
            $tch['dep_id']     = $tch['dep_id']?$myts->htmlSpecialChars(Dept_school::GetDept($tch['dep_id'])['dept_name']):'';
            $tch['title']      = $myts->htmlSpecialChars($tch['title']);
            $tch['sex']        = $myts->htmlSpecialChars($tch['sex']);
            $tch['phone']      = $myts->htmlSpecialChars($tch['phone']);
            $tch['cell_phone'] = $myts->htmlSpecialChars($tch['cell_phone']);
            $tch['enable']     = $myts->htmlSpecialChars($tch['enable']);
            // $tch['isteacher']  = $myts->htmlSpecialChars($tch['isteacher']);
            $tch['sort']       = $myts->htmlSpecialChars($tch['sort']);
            $tch['istch_chk']  = $is_chk[$tch['isteacher']];
            $tch['isgdc_chk']  = $is_chk[$tch['isguidance']];
            $tch['isscl_chk']  = $is_chk[$tch['issocial']];
            $all []            = $tch;
            $i++;
        }
        // var_export($all);die();

        // 處室分類
        $tea_dept_id    = (!isset($pars['dep_id'])) ? '' : $pars['dep_id'];
        $dept_c_sel_htm = Dept_school::GetDept_Class_Sel_htm($tea_dept_id);
        $xoopsTpl->assign('dept_c_sel_htm', $dept_c_sel_htm);

        // 關鍵字傳到樣版
        $parameter['search'] = (!isset($pars['search'])) ? '' : $pars['search'];
        $xoopsTpl->assign('search', $pars['search']);
        // var_dump($ann_list);die();

        $xoopsTpl->assign('all', $all);
        // $xoopsTpl->assign('bar', $bar);
        // $xoopsTpl->assign('total', $total);

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('tch_del', XOOPS_URL . "/modules/beck_iscore/school_affairs.php?op=teacher_delete&sn=", 'sn','確定要刪除教師基本資料','教師刪除!');

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());


        $xoopsTpl->assign('op', "teacher_list");

    }


// ----------------------------------
// 學年度
    // sql-刪除學年度
    function semester_delete($sn){
        global $xoopsDB,$xoopsUser;

        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header('school_affairs.php?op=semester_list', 2, '無 semester_delete 權限!error:2104242100');
        } 

        $tbl = $xoopsDB->prefix('yy_semester');
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    // sql-更新 學年度
    function semester_update($sn){

        global $xoopsDB,$xoopsUser;
        
        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header('school_affairs.php?op=semester_list', 2, '無 semester_update 權限!error:2104242100');
        } 
        
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("school_affairs.php?op=semester_form&sn={$sn}", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }

        $tbl = $xoopsDB->prefix('yy_semester');
        
        // 將所有目前學期清空
            if($activity=='1'){
            $sql = "update `$tbl` set `activity`   = '0'";
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }

        $sql = "update `$tbl` set 
                    `year`        = '{$year}',
                    `term`        = '{$term}',
                    `start_date`  = '{$start_date}',
                    `end_date`    = '{$end_date}',
                    `uid`         = '{$uid}',
                    `update_user` = '{$uid}',
                    `update_date` = now(),
                    `activity`    = '{$activity}'
                where `sn`        = '{$sn}'";

        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        return $sn;
    }

    // sql-新增 學年度
    function semester_insert(){

        global $xoopsDB,$xoopsUser;

        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header('school_affairs.php?op=semester_list', 2, '無 semester_insert 權限!error:2104242100');
        } 

        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("school_affairs.php?op=semester_list", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }

        // 判斷學年度與學期是否存在
        $tbl = $xoopsDB->prefix('yy_semester');
        $sql        = "SELECT * FROM $tbl Where `year`='{$year}' AND `term`='{$term}'";
        $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $duplicate  = $xoopsDB->fetchArray($result);
        if (!empty($duplicate)) {
            redirect_header('school_affairs.php?op=semester_form', 3, '學年度與學期已有設定!');
        }
        // var_dump(empty($duplicate));var_dump($duplicate);die();

        // 將所有目前學期清空
        if($activity=='1'){
            $sql = "update `$tbl` set `activity`   = '0'";
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }
        // echo($sql);die();

        $sql = "insert into `$tbl` (
                    `year`,`term`,`start_date`,`end_date`,`uid`,
                    `create_date`,`update_user`,`update_date`,`activity`
                )values(
                    '{$year}','{$term}','{$start_date}','{$end_date}','{$uid}',
                    now(),'{$uid}',now(), '{$activity}'
                )";

        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號

        return $sn;
    }

    // 表單-新增、編輯 學年度 semester
    function semester_form($sn){
        global $xoopsTpl,$xoopsUser,$xoopsDB,$TadUpFiles;
        
        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header('school_affairs.php?', 2, '無 semester_form 權限!error:2104242100');
        } 

        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("school_affairs.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#semester_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $Sems=[];
        $form_title= '新增學年度';
        $is_new='1';
        if($sn){
            $form_title = '編輯學年度';
            $tbl          = $xoopsDB->prefix('yy_semester');
            $sql          = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result       = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $Sems         = $xoopsDB->fetchArray($result);
            $is_new='0';
        }

        // 給預設值
        $xoopsTpl->assign('form_title ', $form_title);
        
        $SchoolSet= new SchoolSet;
        //取得學期及目前學年度
        // 學期 
        $terms=['1'=>'1','2'=>'2'];
        $Sems['term_htm']=Get_select_opt_htm($terms,$Sems['term'],1);

        // 目前學年度選項
        $opt_ary=['0'=>'否','1'=>'是'];
        $Sems['activity']=radio_htm($opt_ary,'activity',$Sems['activity']);

        $xoopsTpl->assign('Sems', $Sems);

        // //帶入使用者編號
        if ($sn) {
            $uid = $_SESSION['beck_iscore_adm'] ? $Sems['uid'] : $xoopsUser->uid();
        } else {
            $uid = $xoopsUser->uid();
        }
        $xoopsTpl->assign('is_new', $is_new);
        $xoopsTpl->assign('uid', $uid);
        

        // //下個動作
        if ($sn) {
            $op='semester_update';
            $xoopsTpl->assign('sn', $sn);
        } else {
            $op='semester_insert';
        }
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }

    // 列表- 學年度
    function semester_list(){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php', 3, '無操作權限');
        }

        $myts = MyTextSanitizer::getInstance();

        $tbl      = $xoopsDB->prefix('yy_semester');
        $sql      = "SELECT * FROM $tbl ORDER BY `year` DESC , `term` DESC ";
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all      = array();

        while($sems= $xoopsDB->fetchArray($result)){
            $sems['sn']         = $myts->htmlSpecialChars($sems['sn']);
            $sems['year']       = $myts->htmlSpecialChars($sems['year']);
            $sems['term']       = $myts->htmlSpecialChars($sems['term']);
            $sems['start_date'] = $myts->htmlSpecialChars($sems['start_date']);
            $sems['end_date']   = $myts->htmlSpecialChars($sems['end_date']);
            $sems['activity']   = $myts->htmlSpecialChars($sems['activity']);
            $all  []            = $sems;
        }
        // var_dump($all);die();
        
        $xoopsTpl->assign('all', $all);

        include_once XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php";
        $sweet_alert = new sweet_alert();
        $sweet_alert->render("sems_del", "school_affairs.php?op=semester_delete&sn=", 'sn');

        // if($_SESSION['beck_iscore_adm'] OR $_SESSION['xoopsUserId']== $Ann['uid']){
        // $xoopsTpl->assign('is_admin', $_SESSION['beck_iscore_adm']);
        // }
        $xoopsTpl->assign('op', "semester_list");

    }

// ----------------------------------
// 處室列表
    // sql-刪除處室
    function dept_school_delete($sn){
        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php', 3, '無操作權限');
        }
        
        $tbl = $xoopsDB->prefix('yy_dept_school');
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    // sql-更新處室
    function dept_school_update($sn){

        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php', 3, '無操作權限');
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

        $tbl = $xoopsDB->prefix('yy_dept_school');
        $sql = "update `$tbl` set 
                    `dept_name`   = '{$dept_name}',
                    `enable`= '{$enable}',
                    `uid` = '{$uid}', 
                    `update_time` = now()
                where `sn`   = '{$sn}'";

        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        return $sn;
    }

    // sql-新增處室
    function dept_school_insert(){

        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php', 3, '無操作權限');
        }
        
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("school_affairs.php?op=dept_school_form", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }

        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // die(var_dump($_POST));

        $tbl = $xoopsDB->prefix('yy_dept_school');
        $sql = "insert into `$tbl` (
            `dept_name`,`enable`,`uid`,`create_time`,`update_time`) 
            values('{$dept_name}','{$enable}','{$uid}',now(), now())";

        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號

        return $sn;
    }

    // 表單-新增、編輯處室
    function dept_school_form($sn){
        global $xoopsTpl,$xoopsUser,$xoopsDB;

        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php', 3, '無操作權限');
        }
        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("school_affairs.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#deptpart_school_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // if (!power_chk('beck_iscore', 1)) {
        //     redirect_header('school_affairs.php', 3, '無操作權限');
        // }


        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form_title = '新增學校處室';

        if($sn){
            $dt_scl       = array();
            $form_title='編輯學校處室';
            $tbl    = $xoopsDB->prefix('yy_dept_school');
            $sql    = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $dt_scl   = $xoopsDB->fetchArray($result);
        }
        $xoopsTpl->assign('form_title', $form_title);

        // 給預設值
        $sn = (!isset($dt_scl['sn'])) ? '' : $dt_scl['sn'];
        $xoopsTpl->assign('sn', $sn);

        // 學校處室名稱
        $dept_name = (!isset($dt_scl['dept_name'])) ? '' : $dt_scl['dept_name'];
        $xoopsTpl->assign('dept_name', $dept_name);

        // 公告分類啟用
        $enable = (!isset($dt_scl['enable'])) ? '1' : $dt_scl['enable'];
        $enable_opt_ary=['1'=>'開','0'=>'關'];
        $enable_option='';
        foreach ($enable_opt_ary as $k=>$v){
            $enable_check= ($enable==$k)?'checked':'';
            $enable_option.=<<<HTML
            <div class="form-check form-check-inline  m-2">
                <input class="form-check-input" type="radio" name="enable" id="enable{$k}" title="{$v}" value="{$k}" {$enable_check}>
                <label class="form-check-label" for="enable{$k}">{$v}</label>
            </div>
    HTML;
        }
        $xoopsTpl->assign('enable_option', $enable_option);

        // //帶入使用者編號
        if ($sn) {
            $uid = $_SESSION['beck_iscore_adm'] ? $dt_scl['uid'] : $xoopsUser->uid();
        } else {
            $uid = $xoopsUser->uid();
        }
        $xoopsTpl->assign('uid', $uid);
        

        // //下個動作
        if ($sn) {
            $op='dept_school_update';
            $xoopsTpl->assign('sn', $sn);
        } else {
            $op='dept_school_insert';
        }
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }

    // 列表-處室
    function dept_school_list(){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php', 3, '無操作權限');
        }

        $myts = MyTextSanitizer::getInstance();

        $tbl      = $xoopsDB->prefix('yy_dept_school');
        $sql      = "SELECT * FROM $tbl ORDER BY `update_time` DESC";
        
        //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = getPageBar($sql, 10, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];

        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all      = array();

        while(  $dt_scl= $xoopsDB->fetchArray($result)){
                $dt_scl['sn']          = $myts->htmlSpecialChars($dt_scl['sn']);
                $dt_scl['dept_name']   = $myts->htmlSpecialChars($dt_scl['dept_name']);
                $dt_scl['enable']      = $myts->htmlSpecialChars($dt_scl['enable']);
                $dt_scl['sort']        = $myts->htmlSpecialChars($dt_scl['sort']);
                $dt_scl['create_time'] = $myts->htmlSpecialChars($dt_scl['create_time']);
                $dt_scl['update_time'] = $myts->htmlSpecialChars($dt_scl['update_time']);
                $dt_scl['enable']      = ($dt_scl['enable'] =='1')?'是':'否';
                $all    []             = $dt_scl;
        }
        $xoopsTpl->assign('all', $all);
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);
        
        include_once XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php";
        $sweet_alert = new sweet_alert();
        $sweet_alert->render("dept_school_del", "school_affairs.php?op=dept_school_delete&sn=", 'sn');

    }
// ----------------------------------

/*-----------秀出結果區--------------*/

$xoopsTpl->assign('now_op', $op);
$xoopsTpl->assign("toolbar", toolbar_bootstrap($interface_menu));

include_once XOOPS_ROOT_PATH . '/footer.php';
