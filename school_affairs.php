<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Beck_iscore\SchoolSet;
// use XoopsModules\Beck_iscore\Dept_school;
use XoopsModules\Tadtools\TadUpFiles;

/*-----------引入檔案區--------------*/
include_once "header.php";
$xoopsOption['template_main'] = "beck_iscore_index.tpl";
include_once XOOPS_ROOT_PATH . "/header.php";


/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = Request::getString('op');
$sn = Request::getInt('sn');

// var_dump($_POST);
// die(var_dump($_SESSION));
// die(var_dump($_REQUEST));
// var_dump($_REQUEST);
// var_dump($sn);
// var_dump($op);
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
        if(isset($ann_list)){
            teacher_list($ann_list,'1');
        }else{
            teacher_list(null,'1');
        }
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
        $sn=teacher_insert();
        header("location:index.php?op=teacher_show&sn={$sn}");
        exit;//離開，結束程式

    // 更新 教師
    case "teacher_update":
        $sn=teacher_update($sn);
        header("location:index.php?op=teacher_show&sn={$sn}");
        exit;

    // 刪除 教師
    case "teacher_delete":
        teacher_delete($sn);
        header("location:index.php?op=teacher_list");
        exit;

    default:
        semester_list();
        $op="semester_list";
        break;


}

/*-----------function區--------------*/

// 教師列表
    // sql-刪除公告消息
    function announcement_delete($sn){
        global $xoopsDB,$xoopsUser;

        $tbl        = $xoopsDB->prefix('yy_announcement');
        $sql        = "SELECT * FROM $tbl Where `sn`='{$sn}'";
        $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $Ann        = $xoopsDB->fetchArray($result);

        if(!($xoopsUser->isAdmin() or $_SESSION['xoopsUserId']== $Ann['uid'])){
            redirect_header('index.php?op=announcement_list', 3, '非管理員或公告建立者！');
        }
        $tbl = $xoopsDB->prefix('yy_announcement');
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $TadUpFiles=new TadUpFiles("beck_iscore","/announcement");
        $TadUpFiles->set_col('ann_file', $sn);
        $TadUpFiles->del_files();

    }

    // sql-更新公告消息
    function announcement_update($sn){

        global $xoopsDB,$xoopsUser;

        // if (!$xoopsUser->isAdmin()) {
        //     redirect_header('index.php', 3, '無操作權限');
        // }
        // if(!($xoopsUser->isAdmin() AND $_SESSION['xoopsUserId']== $Ann['uid'])){
        //     redirect_header('index.php?op=announcement_list', 3, '無操作權限');
        // }
        
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("index.php?op=announcement_form&sn={$sn}", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        $tbl = $xoopsDB->prefix('yy_announcement');
        $sql = "update `$tbl` set 
                    `ann_class_id`   = '{$ann_class_id}',
                    `dept_id`= '{$dept_id}',
                    `title` = '{$title}', 
                    `content` = '{$content}', 
                    `end_date` = '{$end_date}', 
                    `update_user` = '{$uid}', 
                    `update_date` = now(),
                    `top`='{$top}'
                where `sn`   = '{$sn}'";

        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        //上傳表單（enctype='multipart/form-data'）
        $TadUpFiles=new TadUpFiles("beck_iscore","/announcement");
        // 上傳附檔
        $TadUpFiles->set_col('ann_file',$sn);
        $TadUpFiles->upload_file('ann_file',1920,640,null,null,true);

        return $sn;
    }

    // sql-新增公告消息
    function announcement_insert(){

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
        // var_dump($_POST);die();

        $tbl = $xoopsDB->prefix('yy_announcement');
        $sql = "insert into `$tbl` (
                    `ann_class_id`,`dept_id`,`title`,`content`,`start_date`,
                    `end_date`,`uid`,`create_date`,`update_user`,`update_date`,
                    `top`
                )values(
                    '{$ann_class_id}','{$dept_id}','{$title}','{$content}',now(),
                    '{$end_date}','{$uid}',now(), '{$uid}',now(),
                    '{$top}'
                )";
        // echo($sql);die();

        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號
        
        //上傳表單（enctype='multipart/form-data'）
        $TadUpFiles=new TadUpFiles("beck_iscore","/announcement");
        // 上傳附檔
        $TadUpFiles->set_col('ann_file',$sn);
        $TadUpFiles->upload_file('ann_file',1920,640,null,null,true);

        return $sn;
    }

    function announcement_show($sn){
        global $xoopsTpl,$xoopsDB,$xoopsUser;
    
        if (!$xoopsUser){redirect_header('index.php', 3, '無操作權限。error:2103212230');}

        $myts = MyTextSanitizer::getInstance();
    
        $tbl        = $xoopsDB->prefix('yy_announcement');
        $sql        = "SELECT * FROM $tbl Where `sn`='{$sn}'";
        $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $Ann        = $xoopsDB->fetchArray($result);

        if (!$Ann or !$sn){redirect_header('index.php?op=announcement_list', 3, '不存在的公告編號！');}

        $Ann['form_title']   = '公告消息瀏覽';
        $Ann['sn']           = $myts->htmlSpecialChars($Ann['sn']);
        $Ann['ann_class_id'] = $myts->htmlSpecialChars($Ann['ann_class_id']);
        $Ann['dept_id']      = $myts->htmlSpecialChars($Ann['dept_id']);
        $Ann['title']        = $myts->htmlSpecialChars($Ann['title']);
        $Ann['content']      = $myts->displayTarea($Ann['content'], 1, 0, 0, 0, 0);
        $Ann['start_date']   = $myts->htmlSpecialChars($Ann['start_date']);
        $Ann['end_date']     = $myts->htmlSpecialChars($Ann['end_date']);
        $Ann['uid']          = $myts->htmlSpecialChars($Ann['uid']);
        $Ann['create_date']  = $myts->htmlSpecialChars($Ann['create_date']);
        $Ann['update_user']  = $myts->htmlSpecialChars($Ann['update_user']);
        $Ann['update_date']  = date("Y-m-d",strtotime($myts->htmlSpecialChars($Ann['update_date'])));
        $Ann['top']          = $myts->htmlSpecialChars($Ann['top']);
        $Ann['hit_count']    = $myts->htmlSpecialChars($Ann['hit_count']);
        $Ann['enable']       = $myts->htmlSpecialChars($Ann['enable']);
        $Ann['sort']         = $myts->htmlSpecialChars($Ann['sort']);
        
        $Ann['uname']        = users_data($Ann['uid'])['uname'];
        $Ann['dept_name']    = dept_school::GetDept($Ann['dept_id'])['dept_name'];
        $Ann['ann_class_id'] = announcement::GetAnn_Class($Ann['ann_class_id'])['ann_class_name'];


        //　瀏覽次數累加
        $Ann['hit_count']++;
        $sql_hitcount = "update `$tbl` set `hit_count`   = '{$Ann['hit_count']}'   where `sn`   = '{$sn}'";
        $xoopsDB->queryF($sql_hitcount) or Utility::web_error($sql_hitcount, __FILE__, __LINE__);

        // 顯示附檔
        $TadUpFiles=new TadUpFiles("beck_iscore","/announcement");
        $TadUpFiles->set_col('ann_file',$sn);
        $Ann['files'] = $TadUpFiles->show_files('ann_file',false,'filename');
        
        // var_dump($Ann);die();
        $xoopsTpl->assign('Ann', $Ann);
    
        if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php")) {
            redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
        }
        include_once XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php";
        $sweet_alert = new sweet_alert();
        $sweet_alert->render("ann_del", "index.php?op=announcement_delete&sn=", 'sn');
    
        if($xoopsUser->isAdmin() OR $_SESSION['xoopsUserId']== $Ann['uid']){
            $xoopsTpl->assign('ann_edit_del', true);
        }
    }

    // 表單-新增、編輯公告消息
    function announcement_form($sn){
        global $xoopsTpl,$xoopsUser,$xoopsDB,$TadUpFiles;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, '無操作權限');
        }

        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("index.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#announcement_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form_title = '新增公告消息';
        $space='0';//顯示公告分類及發佈處室空白選項
        $Ann=[];
        if($sn){
            $form_title = '編輯公告消息';
            $tbl        = $xoopsDB->prefix('yy_announcement');
            $sql        = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $Ann        = $xoopsDB->fetchArray($result);
        
            if(!($xoopsUser->isAdmin() AND $_SESSION['xoopsUserId']== $Ann['uid'])){
                redirect_header('index.php?op=announcement_list', 3, '無操作權限');
            }
            $space='1';
        }
        // die(var_dump($Ann));

        // 給預設值
        $xoopsTpl->assign('form_title', $form_title);
        $sn = (!isset($Ann['sn'])) ? '' : $Ann['sn'];
        $xoopsTpl->assign('sn', $sn);

        // 公告分類
        $ann_class_id = (!isset($Ann['ann_class_id'])) ? '' : $Ann['ann_class_id'];
        $ann_c_sel_htm=Announcement::GetAnn_Class_Sel_htm($ann_class_id,$space);
        $xoopsTpl->assign('ann_c_sel_htm', $ann_c_sel_htm);
        
        // 處室分類
        $ann_dept_id = (!isset($Ann['dept_id'])) ? '' : $Ann['dept_id'];
        $dept_c_sel_htm=Dept_school::GetDept_Class_Sel_htm($ann_dept_id,$space);
        $xoopsTpl->assign('dept_c_sel_htm', $dept_c_sel_htm);
        
        // 標題
        $xoopsTpl->assign('title', $Ann['title']);

        //內容ckeditor
        include_once XOOPS_ROOT_PATH . "/modules/tadtools/ck.php";
        $ck = new CKEditor("beck_iscore", "content", $Ann['content']);
        $ck->setToolbarSet('mySimple');
        $ck->setHeight(350);
        $content=$ck->render();
        $xoopsTpl->assign('content', $content);

        // 公告結束日期 預設一個月後
        if(isset($Ann['end_date'])){
            $end_date=$Ann['end_date'];
        }else{
            $end_date=gmdate('Y-m-d',strtotime('+1 month'));
        }
        $xoopsTpl->assign('end_date', $end_date);

        // 置頂
        $top = (!isset($Ann['top'])) ? '0' : $Ann['top'];
        $top_opt_ary=['0'=>'否','1'=>'是'];
        $top_option='';
        foreach ($top_opt_ary as $k=>$v){
            $top_check= ($top==$k)?'checked':'';
            $top_option.=<<<HTML
            <div class="form-check form-check-inline  m-2">
                <input class="form-check-input" type="radio" name="top" id="top{$k}" title="{$v}" value="{$k}" {$top_check}>
                <label class="form-check-label" for="top{$k}">{$v}</label>
            </div>
        HTML;
        }
        $xoopsTpl->assign('top_option', $top_option);

        //上傳附檔
        $TadUpFiles=new TadUpFiles("beck_iscore","/announcement");
        $TadUpFiles->set_col('ann_file',$sn); //若 $show_list_del_file ==true 時一定要有
        $upform=$TadUpFiles->upform(true,'ann_file');
        $xoopsTpl->assign('upform', $upform);

    
        // //帶入使用者編號
        if ($sn) {
            $uid = $_SESSION['beck_iscore_adm'] ? $Ann['uid'] : $xoopsUser->uid();
        } else {
            $uid = $xoopsUser->uid();
        }
        $xoopsTpl->assign('uid', $uid);
        

        // //下個動作
        if ($sn) {
            $op='announcement_update';
            $xoopsTpl->assign('sn', $sn);
        } else {
            $op='announcement_insert';
        }
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }

    // 列表-公告消息
    function teacher_list($parameter=null,$show_add_button){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        if (!$xoopsUser) {
            redirect_header('index.php', 3, '無操作權限');
        }

        $myts = MyTextSanitizer::getInstance();

        $now=date('Y-m-d');
        $tbl      = $xoopsDB->prefix('yy_announcement');
        $sql      = "SELECT `sn`,`ann_class_id`,`dept_id`,`title`,`start_date`,
                            `end_date`,`update_user`,`update_date`,`top`,
                            `hit_count` FROM $tbl WHERE ";

        $have_par='0';
        if(!empty($parameter['ann_class_id'])){
            $sql.="`ann_class_id`='{$parameter['ann_class_id']}'";
            $have_par='1';
        }
        if(!empty($parameter['dept_id'])){
            if($have_par=='1'){$sql.=" AND ";}
            $sql.="`dept_id`='{$parameter['dept_id']}'";
            $have_par='1';
        }
        if(!empty($parameter['search'])){
            if($have_par=='1'){$sql.=" AND ";}
            $sql.="((`content` like '%{$parameter['search']}%') or (`title` like '%{$parameter['search']}%')) ";
            $have_par='1';
        }
        if($have_par=='0'){
            $sql.=" `end_date`>='{$now}' ORDER BY `top` DESC ,`sn` DESC";
        }else{
            $sql.=" ORDER BY `top` DESC , `sn` DESC";
        }
        // echo($sql); // die();
        
        //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = getPageBar($sql, 10, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];

        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all      = array();

        while($anns= $xoopsDB->fetchArray($result)){
            $anns['sn']           = $myts->htmlSpecialChars($anns['sn']);
            $anns['ann_class_id'] = $myts->htmlSpecialChars(Announcement::GetAnn_Class($anns['ann_class_id'])['ann_class_name']);
            $anns['dept_id']      = $myts->htmlSpecialChars(Dept_school::GetDept($anns['dept_id'])['dept_name']);
            $anns['title']        = word_cut($myts->htmlSpecialChars($anns['title']), 30);
            $anns['top']          = $myts->htmlSpecialChars($anns['top']);
            $anns['start_date']   = $myts->htmlSpecialChars($anns['start_date']);
            $anns['end_date']     = $myts->htmlSpecialChars($anns['end_date']);
            $anns['update_user']  = $myts->htmlSpecialChars($anns['update_user']);
            $all  []              = $anns;
        }
        // var_dump($all);die();
        
        // 公告分類
        $ann_class_id = (!isset($parameter['ann_class_id'])) ? '' : $parameter['ann_class_id'];
        $ann_c_sel_htm=Announcement::GetAnn_Class_Sel_htm($ann_class_id);
        $xoopsTpl->assign('ann_c_sel_htm', $ann_c_sel_htm);
        
        // 處室分類
        $ann_dept_id = (!isset($parameter['dept_id'])) ? '' : $parameter['dept_id'];
        $dept_c_sel_htm=Dept_school::GetDept_Class_Sel_htm($ann_dept_id);
        $xoopsTpl->assign('dept_c_sel_htm', $dept_c_sel_htm);

        // 關鍵字傳到樣版
        $parameter['search'] = (!isset($parameter['search'])) ? '' : $parameter['search'];
        $xoopsTpl->assign('search', $parameter['search']);
        // var_dump($ann_list);die();

        $xoopsTpl->assign('all', $all);
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);
        
        include_once XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php";
        $sweet_alert = new sweet_alert();
        $sweet_alert->render("ann_del", "index.php?op=announcement_delete&sn=", 'sn');

        // if($_SESSION['beck_iscore_adm'] OR $_SESSION['xoopsUserId']== $Ann['uid']){
        $xoopsTpl->assign('is_admin', $_SESSION['beck_iscore_adm']);
        // }
        $xoopsTpl->assign('op', "announcement_list");
        $xoopsTpl->assign('show_add_button', $show_add_button);

    }

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
            $AnnC       = array();
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
