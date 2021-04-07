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
$tea_list['dep_id']=Request::getInt('dep_id');
$tea_list['search']=Request::getString('search');
$g2p=Request::getInt('g2p');

// var_dump($_POST);
// die(var_dump($_SESSION));
// die(var_dump($_REQUEST));
// var_dump($_REQUEST);
// var_dump($sn);
// var_dump('g2p:'.$g2p);
// die();

switch ($op) {
// 處室列表
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

// 學年度列表
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
        header("location:school_affairs.php?op=teacher_list");
        // header("location:school_affairs.php?op=teacher_listshow&sn={$sn}");
        exit;//離開，結束程式

    // 更新 教師
    case "teacher_update":
        $sn=teacher_update($sn);
        header("location:school_affairs.php?op=teacher_list");
        // header("location:school_affairs.php?op=teacher_show&sn={$sn}");
        exit;

    // 刪除 教師
    case "teacher_delete":
        teacher_delete($sn);
        header("location:school_affairs.php?op=teacher_list");
        exit;
    
// 班級列表
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
        header("location:school_affairs.php?op=dept_school_list");
        exit;

    default:
        semester_list();
        $op="semester_list";
        break;


}

/*-----------function區--------------*/

// ----------------------------------
// 班級列表
    // sql-刪除 班級
    function class_delete($sn){
        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php', 3, '無操作權限');
        }
        
        $tbl = $xoopsDB->prefix('yy_dept_school');
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    // sql-更新 班級
    function class_update($sn){

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

        // if (!$xoopsUser->isAdmin()) {
        //     redirect_header('school_affairs.php', 3, '無操作權限');
        // }
        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("school_affairs.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#class_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        if (!power_chk('beck_iscore', 1)) {
            redirect_header('school_affairs.php', 3, '無操作權限');
        }


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

        $xoopsTpl->assign('class', $class);

        // 班級狀態，預計啟用
        $class_status_ary=['0'=>'關閉','1'=>'啟用','2'=>'暫停'];
        $class_st_op_htm=Get_select_opt_htm($class_status_ary,$class['class_status'],'0');
        $xoopsTpl->assign('class_st_op_htm', $class_st_op_htm);


        $all_users_data=all_users_data(true);
        // var_dump($all_users_data);die();
        $chk_htm='';
        foreach ($all_users_data as $k=>$v){
            $check= ($class['class_status']==$k)?'checked':'';
            $chk_htm.=<<<HTML
            <div class="form-check form-check-inline  m-2">
                <input class="form-check-input" type="radio" name="teacher" id="teacher_{$v['uid']}" title="{$v['name']}" value="{$v['uid']}">
                <label class="form-check-label" for="teacher_{$v['uid']}">{$v['name']}</label>
            </div>
        HTML;
        }
        $xoopsTpl->assign('chk_htm', $chk_htm);

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
        $class_status=['0'=>'關閉','1'=>'啟用','2'=>'暫停'];
        while(  $class= $xoopsDB->fetchArray($result)){
                $class['sn']           = $myts->htmlSpecialChars($class['sn']);
                $class['class_name']   = $myts->htmlSpecialChars($class['class_name']);
                $class['class_status'] = $myts->htmlSpecialChars($class_status[$class['class_status']]);
                $class['sort']         = $myts->htmlSpecialChars($class['sort']);
                $class['tutor_sn']     = $myts->htmlSpecialChars(users_data($class['tutor_sn'])['name']);
                $all   []              = $class;
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
            redirect_header('index.php?op=teacher_list', 3, '非管理員或該使用者！');
        }
        $tbl = $xoopsDB->prefix('yy_teacher');
        $sql = "DELETE FROM `$tbl` WHERE `uid` = '{$sn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

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
        $tbl = $xoopsDB->prefix('yy_teacher');
        $sql = "update `$tbl` set 
                    `uid`='{$sn}',
                    `dep_id`='{$dept_id}',
                    `title`='{$title}',
                    `sex`='{$sex}',
                    `phone`='{$phone}',
                    `cell_phone`='{$cell_phone}',
                    `enable`='{$enable}',
                    `isteacher`='{$isteacher}',
                    `create_uid`='{$create_uid}',
                    `update_time`=now()
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
                    `cell_phone`,`enable`,`isteacher`,`create_uid`,`create_time`,
                    `update_time`
                )values(
                    '{$sn}','{$dept_id}','{$title}','{$sex}','{$phone}',
                    '{$cell_phone}','{$enable}','{$isteacher}','{$create_uid}', now(),
                    now()
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

    // 表單-新增、編輯公告消息
    function teacher_form($sn){
        global $xoopsTpl,$xoopsUser,$xoopsDB;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, '非會員，無操作權限!');
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
        $tch_en_htm=yn_htm($onoff,'enable',$en_chk);

        // 具備教師身份
        $ynary=['0'=>'否','1'=>'是'];
        $isteacher = (!isset($tch['isteacher'])) ? '0' : $tch['isteacher'];
        $tch_is_html=yn_htm($ynary,'isteacher',$isteacher);

        $xoopsTpl->assign('tch_en_htm', $tch_en_htm);
        $xoopsTpl->assign('tch_is_html', $tch_is_html);

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
        $sql      = "SELECT  ur.name,ur.uname,ur.email, tr.* ,ur.uid
                    FROM $tbl as ur LEFT JOIN $tb2 as tr ON ur.uid=tr.uid" ;
        // die(var_dump($_REQUEST));

        $have_par='0';
        if(!empty($pars['dep_id'])){
            $sql.=" WHERE `dep_id`='{$pars['dep_id']}'";
            $have_par='1';
        }
        if(!empty($pars['search'])){
            if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.="(
                (`name` like '%{$pars['search']}%') or (`uname` like '%{$pars['search']}%') or
                (`email` like '%{$pars['search']}%') or (`title` like '%{$pars['search']}%')
                ) ";
            $have_par='1';
        }
        $sql.=" ORDER BY `update_time` DESC , `uname`";
        // echo($sql);  die();

        //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = getPageBar($sql, 10, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];

        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all      = array();
        if($g2p=='' OR $g2p=='1'){$i=1;}else{$i=$g2p*10+1;}
        $istch_chk=["0"=>'',"1"=>'checked'];
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
            $tch['istch_chk']  = $istch_chk[$tch['isteacher']];
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
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);
        
        // 這是sweet alert 舊的寫法
        // include_once XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php";
        // $sweet_alert = new sweet_alert();
        // $sweet_alert->render("tch_del", "school_affairs.php?op=teacher_delete&sn=", 'sn');

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('tch_del', XOOPS_URL . "/modules/beck_iscore/school_affairs.php?op=teacher_delete&sn=", 'sn','確定要刪除教師基本資料','教師基本資料刪除，但保留帳號。');

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

        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php?op=semester_list', 3, '無操作權限');
        }
        $tbl = $xoopsDB->prefix('yy_semester');
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    // sql-更新 學年度
    function semester_update($sn){

        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php?op=semester_list', 3, '無操作權限');
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

        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php?op=semester_list', 3, '無操作權限');
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
        
        if (!$xoopsUser->isAdmin()) {
            redirect_header('school_affairs.php', 3, '無操作權限');
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
        $Sems['term_htm']=$SchoolSet->Get_term_htm($Sems['term'],$is_new);
        $Sems['activity']=$SchoolSet->Get_activity_htm($Sems['activity']);

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