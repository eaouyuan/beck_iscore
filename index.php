<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Beck_iscore\Announcement;
use XoopsModules\Beck_iscore\Dept_school;
use XoopsModules\Tadtools\TadUpFiles;

/*-----------引入檔案區--------------*/
include_once "header.php";
$xoopsOption['template_main'] = "beck_iscore_index.tpl";
include_once XOOPS_ROOT_PATH . "/header.php";

if (!class_exists('XoopsModules\Beck_iscore\Announcement')) {
    require XOOPS_ROOT_PATH . '/modules/beck_iscore/preloads/autoloader.php';
    // include dirname(__DIR__) . '/beck_iscore/preloads/autoloader.php';
}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = Request::getString('op');
$sn = Request::getInt('sn');
$fileup = Request::getInt('fileup');
$ann_list['ann_class_id']=Request::getInt('ann_class_id');
$ann_list['dept_id']=Request::getInt('dept_id');
$ann_list['search']=Request::getString('search');

// var_dump($_POST);
// var_dump(isset($_REQUEST['search'])); 
// die(var_dump($_SESSION));
// die(var_dump($_REQUEST));
// var_dump($_REQUEST);
// var_dump($sn);
// var_dump($op);
// var_dump($uid);
// var_dump($ann_list); 
// var_dump($dept_id); 
// die();
// die(var_dump($op));
switch ($op) {
    // 公告分類列表
        case "announcement_class_list":
            announcement_class_list();
            break;//跳出迴圈,往下執行
        
        // 新增、編輯 公告分類表單
        case "announcement_class_form":
            announcement_class_form($sn);
            break;//跳出迴圈,往下執行

        // 新增公告分類
        case "announcement_class_insert":
            announcement_class_insert();
            header("location:index.php?op=announcement_class_list");
            exit;//離開，結束程式

        // 更新公告分類
        case "announcement_class_update":
            announcement_class_update($sn);
            header("location:index.php?op=announcement_class_list");
            exit;

        // 刪除公告分類
        case "announcement_class_delete":
            announcement_class_delete($sn);
            header("location:index.php?op=announcement_class_list");
            exit;

    // 公告消息列表
        case "announcement_list":
            announcement_list($ann_list);
            break;//跳出迴圈,往下執行
        
        // 新增、編輯 公告消息表單
        case "announcement_form":
            announcement_form($sn);
            break;//跳出迴圈,往下執行

        // 顯示公告消息
        case "announcement_show":
            announcement_show($sn);
            break;//跳出迴圈,往下執行

        // 新增公告消息
        case "announcement_insert":
            $sn=announcement_insert();
            if($fileup=='1'){
                header("location:index.php?op=announcement_form&sn={$sn}");
            }else{
                header("location:index.php?op=announcement_show&sn={$sn}");
            }
            exit;//離開，結束程式

        // 更新公告消息
        case "announcement_update":
            $sn=announcement_update($sn);
            if($fileup=='1'){
                header("location:index.php?op=announcement_form&sn={$sn}");
            }else{
                header("location:index.php?op=announcement_show&sn={$sn}");
            }
            exit;

        // 刪除公告消息
        case "announcement_delete":
            announcement_delete($sn);
            header("location:index.php?op=announcement_list");
            exit;

        // case "student_show":
        //     student_show($sn);
        //     break;//跳出迴圈,往下執行
    //下載檔案
        case "tufdl":
            $TadUpFiles=new TadUpFiles("beck_iscore","/student",$file="/file",$image="/image",$thumbs="/image/.thumbs");
            $files_sn=isset($_GET['files_sn'])?intval($_GET['files_sn']):"";
            $TadUpFiles->add_file_counter($files_sn,false,false);
            exit;
        
    default:
        // if($sn){
        //     teacher_show($sn);
        //     $op="teacher_show";
        // }else{
        //     // teacher_list();
        //     // $op="teacher_list";
            // announcement_class_list();
        //     // var_dump($xoopsUser->rank());

            // $op="announcement_class_list";
        // }
        // header("location:{$_SERVER['PHP_SELF']}");
        if (!$xoopsUser) {
            break;
        }else{
            // announcement_list(null,'0');
            announcement_list();
            $op="announcement_list";
            break;
        }
}

/*-----------function區--------------*/
// 公告系統-公告分類
    // sql-刪除公告分類
    function announcement_class_delete($sn){
        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser->isAdmin()) {
            redirect_header('index.php', 3, '無操作權限');
        }
        
        $tbl = $xoopsDB->prefix('yy_announcement_class');
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    // sql-更新公告分類
    function announcement_class_update($sn){

        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser->isAdmin()) {
            redirect_header('index.php', 3, '無操作權限');
        }
        
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("index.php?op=announcement_class_form&sn={$sn}", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }

        $tbl = $xoopsDB->prefix('yy_announcement_class');
        $sql = "update `$tbl` set 
                    `ann_class_name`   = '{$ann_class_name}',
                    `enable`= '{$enable}',
                    `uid` = '{$uid}', 
                    `update_time` = now()
                where `sn`   = '{$sn}'";

        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        return $sn;
    }

    // sql-新增公告分類
    function announcement_class_insert(){

        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser->isAdmin()) {
            redirect_header('index.php', 3, '無操作權限');
        }
        
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("index.php?op=announcement_class_form", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }

        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }


        $tbl = $xoopsDB->prefix('yy_announcement_class');
        $sql = "insert into `$tbl` (
            `ann_class_name`,`enable`,`uid`,`create_time`,`update_time`) 
            values('{$ann_class_name}','{$enable}','{$uid}',now(), now())";

        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號

        return $sn;
    }

    // 表單-新增、編輯公告分類
    function announcement_class_form($sn){
        global $xoopsTpl,$xoopsUser,$xoopsDB;

        if (!$xoopsUser->isAdmin()) {
            redirect_header('index.php', 3, '無操作權限');
        }
        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("index.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#announcement_class_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form_title = '新增公告分類';

        if($sn){
            $AnnC       = array();
            $form_title='編輯公告分類';
            $tbl    = $xoopsDB->prefix('yy_announcement_class');
            $sql    = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $AnnC   = $xoopsDB->fetchArray($result);
        }
        $xoopsTpl->assign('form_title', $form_title);

        // 給預設值
        $sn = (!isset($AnnC['sn'])) ? '' : $AnnC['sn'];
        $xoopsTpl->assign('sn', $sn);

        // 公告分類名稱
        $ann_class_name = (!isset($AnnC['ann_class_name'])) ? '' : $AnnC['ann_class_name'];
        $xoopsTpl->assign('ann_class_name', $ann_class_name);

        // 公告分類啟用
        $enable = (!isset($AnnC['enable'])) ? '1' : $AnnC['enable'];
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
            $uid = $_SESSION['beck_iscore_adm'] ? $AnnC['uid'] : $xoopsUser->uid();
        } else {
            $uid = $xoopsUser->uid();
        }
        $xoopsTpl->assign('uid', $uid);
        

        // //下個動作
        if ($sn) {
            $op='announcement_class_update';
            $xoopsTpl->assign('sn', $sn);
        } else {
            $op='announcement_class_insert';
        }
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }

    // 列表-公告分類
    function announcement_class_list(){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        if (!$xoopsUser->isAdmin()) {
            redirect_header('index.php', 3, '無操作權限');
        }

        $myts = MyTextSanitizer::getInstance();

        $tbl      = $xoopsDB->prefix('yy_announcement_class');
        $sql      = "SELECT * FROM $tbl ORDER BY `update_time` DESC";
        
        //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = getPageBar($sql, 10, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];

        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all      = array();

        while($ann_cls= $xoopsDB->fetchArray($result)){
            $ann_cls['sn']             = $myts->htmlSpecialChars($ann_cls['sn']);
            $ann_cls['ann_class_name'] = $myts->htmlSpecialChars($ann_cls['ann_class_name']);
            $ann_cls['enable']         = $myts->htmlSpecialChars($ann_cls['enable']);
            $ann_cls['sort']           = $myts->htmlSpecialChars($ann_cls['sort']);
            $ann_cls['create_time']    = $myts->htmlSpecialChars($ann_cls['create_time']);
            $ann_cls['update_time']    = $myts->htmlSpecialChars($ann_cls['update_time']);
            $ann_cls['enable']=($ann_cls['enable'] =='1')?'是':'否';
            $all    []                 = $ann_cls;
        }
        $xoopsTpl->assign('all', $all);
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);
        
        include_once XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php";
        $sweet_alert = new sweet_alert();
        $sweet_alert->render("announcement_class_del", "index.php?op=announcement_class_delete&sn=", 'sn');

    }

// 公告系統-公告消息
    // sql-刪除公告消息
    function announcement_delete($sn){
        global $xoopsDB,$xoopsUser;

        $tbl        = $xoopsDB->prefix('yy_announcement');
        $sql        = "SELECT * FROM $tbl Where `sn`='{$sn}'";
        $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $Ann        = $xoopsDB->fetchArray($result);

        if(!($xoopsUser->isAdmin() or strval($_SESSION['xoopsUserId'])== $Ann['uid'])){
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
            // var_dump('uid:'.$Ann['uid']);
            // var_dump('_SESSION["xoopsUserId"]:'.$_SESSION['xoopsUserId']);
            // die();

            if(!($xoopsUser->isAdmin() or (strval($_SESSION['xoopsUserId'])== $Ann['uid']))){
                redirect_header('index.php?op=announcement_list', 3, '無操作權限或此公告不存在!');
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
        $ck->setHeight(250);
        $content=$ck->render();
        $xoopsTpl->assign('content', $content);

        // 公告結束日期 預設三個月後
        if(isset($Ann['end_date'])){
            $end_date=$Ann['end_date'];
        }else{
            $end_date=gmdate('Y-m-d',strtotime('+3 month'));
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
    function announcement_list($parameter=null,$show_add_button=''){
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
            $anns['title']        = $myts->htmlSpecialChars($anns['title']);
            // $anns['title']        = word_cut($myts->htmlSpecialChars($anns['title']), 30);
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
        // $xoopsTpl->assign('show_add_button', $show_add_button);

    }


// ----------------------------------
// 新增學生表單
    function student_form($sn){
        global $xoopsTpl,$xoopsUser,$xoopsDB;

        if (!power_chk('beck_iscore', 1)) {
            redirect_header('index.php', 3, '無操作權限');
        }

        if($sn){
            $students=array();
            $tbl      = $xoopsDB->prefix('yy_student');
            $sql      = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $students = $xoopsDB->fetchArray($result);
        }
        // var_dump($students['arrival_date']);
        // var_dump(date("Y/m/d", strtotime($students['arrival_date'])));
        // die();

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        //建立表單
        $form = new XoopsThemeForm('新增學生', 'student_form', 'index.php', 'post', true , '摘要');

        $複選方塊  = new XoopsFormCheckBox('$複選方塊', 'name', '值','ids');
        $options['1'] = '街巷故事';
        $options['2'] = '市井觀點';
        $options['3'] = '私房知識塾';
        $複選方塊->addOptionArray($options);
        
        $單選鈕   = new XoopsFormRadio('$單選鈕', 'name', '值');
        $是否單選  = new XoopsFormRadioYN('$是否單選', 'name', '值');
        // $下拉選單  = new XoopsFormSelect('$下拉選單', 'name', '預設值', 大小, 多選);
        $options['1'] = '街巷故事';
        $options['2'] = '市井觀點';
        $options['3'] = '私房知識塾';
        // $下拉選單->addOptionArray($options);


        // $群組核選  = new XoopsFormSelectCheckGroup('$群組核選', 'name', '值', 大小 ,多選);
        // $國家選單  = new XoopsFormSelectCountry('$國家選單', 'name', 'TW', 大小);
        // $群組選單  = new XoopsFormSelectGroup('$群組選單', 'name', 含訪客, '值', 大小 ,多選);
        // $語系選單  = new XoopsFormSelectLang('$語系選單', 'name', '值', 大小);
        // $比對選單  = new XoopsFormSelectMatchOption('$比對選單', 'name', '值', 大小);
        // $佈景選單  = new XoopsFormSelectTheme('$佈景選單', 'name', '值', 大小);
        // $時區選單  = new XoopsFormSelectTimezone('$時區選單', 'name', '值', 大小);
        // $使用者選單 = new XoopsFormSelectUser('$使用者選單', 'name', 含訪客, '值', 大小 ,多選);
        
        // $form->addElement($複選方塊);
        // $form->addElement($單選鈕);
        // $form->addElement($是否單選);
        // $form->addElement($下拉選單);
        // $form->addElement($群組核選);
        // $form->addElement($國家選單);
        // $form->addElement($群組選單);
        // $form->addElement($語系選單);
        // $form->addElement($比對選單);
        // $form->addElement($佈景選單);
        // $form->addElement($時區選單);
        // $form->addElement($使用者選單);

        

        //建立類別選項
        $select   = new XoopsFormRadio('類別或主題', 'topic_sn', $topic_sn);
        $options['1'] = '街巷故事';
        $options['2'] = '市井觀點';
        $options['3'] = '私房知識塾';
        $select->addOptionArray($options);
        $form->addElement($select);
        
        //學號
        $form->addElement(new XoopsFormText('學號', 'stu_sn', 30 , 65 , $students['stu_sn']), true);
        //學生姓名
        $form->addElement(new XoopsFormText('學生姓名', 'stu_name', 30 , 65 , $students['stu_name']), true);
        //入校日期
        $form->addElement(new XoopsFormDateTime('入校日期', 'arrival_date',15, strtotime($students['arrival_date']),false));
        //生日
        $form->addElement(new XoopsFormDateTime('生日', 'birthday',15,strtotime($students['birthday']),false));
        //身份證字號
        $form->addElement(new XoopsFormText('身份證字號', 'national_id', 30 , 65 , $students['national_id']), true);
        //原轉介單位
        $form->addElement(new XoopsFormText('原轉介單位', 'ori_referral', 30 , 65 , $students['ori_referral']), 0);
        //戶籍
        $form->addElement(new XoopsFormText('戶籍', 'domicile', 30 , 65 , $students['domicile']), 0);
        //族群類別
        $form->addElement(new XoopsFormText('族群類別', 'ethnic_group', 30 , 65 , $students['ethnic_group']), 0);
        //婚姻狀況
        $form->addElement(new XoopsFormText('婚姻狀況', 'marital', 30 , 65 , $students['marital']), 0);
        //身高
        $form->addElement(new XoopsFormText('身高', 'height', 30 , 65 , $students['height']), 0);
        //體重
        $form->addElement(new XoopsFormText('體重', 'weight', 30 , 65 , $students['weight']), 0);
        //低收入戶
        $form->addElement(new XoopsFormText('低收入戶', 'Low_income', 30 , 65 , $students['Low_income']), 0);
        //監護人身心障礙
        $form->addElement(new XoopsFormText('監護人身心障礙', 'guardian_disability', 30 , 65 , $students['guardian_disability']), 0);
        //轉介原因
        $form->addElement(new XoopsFormText('轉介原因', 'referral_reason', 30 , 65 , $students['referral_reason']), 0);
        //原學歷
        $form->addElement(new XoopsFormText('原學歷', 'original_education', 30 , 65 , $students['original_education']), 0);
        //原就學學校
        $form->addElement(new XoopsFormText('原就學學校', 'original_school', 30 , 65 , $students['original_school']), 0);
        //家庭概況
        include_once XOOPS_ROOT_PATH . "/modules/tadtools/ck.php";
        $ck = new CKEditor("beck_iscore", "family_profile", $students['family_profile']);
        $ck->setToolbarSet('myBasic');
        $ck->setHeight(350);
        $form->addElement(new XoopsFormLabel('家庭概況', $ck->render()), true);
        //戶籍地址
        $form->addElement(new XoopsFormText('戶籍地址', 'residence_address', 30 , 65 , $students['residence_address']), 0);
        //居住地址
        $form->addElement(new XoopsFormText('居住地址', 'address', 30 , 65 , $students['address']), 0);
        //監護人1
        $form->addElement(new XoopsFormText('監護人1', 'guardian1', 30 , 65 , $students['guardian1']), 0);
        //監護人關係1
        $form->addElement(new XoopsFormText('監護人關係1', 'guardian_relationship1', 30 , 65 , $students['guardian_relationship1']), 0);
        //監護人手機1
        $form->addElement(new XoopsFormText('監護人手機1', 'guardian_cellphone1', 30 , 65 , $students['guardian_cellphone1']), 0);
        //監護人2
        $form->addElement(new XoopsFormText('監護人2', 'guardian2', 30 , 65 , $students['guardian2']), 0);
        //監護人關係2
        $form->addElement(new XoopsFormText('監護人關係2', 'guardian_relationship2', 30 , 65 , $students['guardian_relationship2']), 0);
        //監護人手機2
        $form->addElement(new XoopsFormText('監護人手機2', 'guardian_cellphone2', 30 , 65 , $students['guardian_cellphone2']), 0);
        //緊急聯絡人1
        $form->addElement(new XoopsFormText('緊急聯絡人1', 'emergency_contact1', 30 , 65 , $students['emergency_contact1']), 0);
        //緊急聯絡人關係1
        $form->addElement(new XoopsFormText('緊急聯絡人關係1', 'emergency_contact_rel1', 30 , 65 , $students['emergency_contact_rel1']), 0);
        //緊急聯絡人手機1
        $form->addElement(new XoopsFormText('緊急聯絡人手機1', 'emergency_cellphone1', 30 , 65 , $students['emergency_cellphone1']), 0);
        //緊急聯絡人2
        $form->addElement(new XoopsFormText('緊急聯絡人2', 'emergency_contact2', 30 , 65 , $students['emergency_contact2']), 0);
        //緊急聯絡人關係2
        $form->addElement(new XoopsFormText('緊急聯絡人關係2', 'emergency_contact_rel2', 30 , 65 , $students['emergency_contact_rel2']), 0);
        //緊急聯絡人手機2
        $form->addElement(new XoopsFormText('緊急聯絡人手機2', 'emergency_cellphone2', 30 , 65 , $students['emergency_cellphone2']), 0);
        //建立學生排序欄位
        $form->addElement(new XoopsFormText('學生排序', 'sort', 30 , 3 , $students['sort']), 0);

        
        //精選（是否選單）
        $form->addElement(new XoopsFormRadioYN('精選', 'focus', 1));
        //作者輸入框
        $username = ($sn) ? $students['stu_name'] : $xoopsUser->name();
        $form->addElement(new XoopsFormText('作者', 'username', 60, 100, $username));

        //上傳表單（enctype='multipart/form-data'）
        $form->setExtra("enctype='multipart/form-data'");
        $TadUpFiles=new TadUpFiles("beck_iscore","/student",$file="/file",$image="/image",$thumbs="/image/.thumbs");
        //$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");設定子目錄，比較進階的應用
        //$TadUpFiles->set_var('require', true);  //必填
        //$TadUpFiles->set_var("show_tip", false); //不顯示提示
        $TadUpFiles->set_col('sn',$sn); //若 $show_list_del_file ==true 時一定要有，設定綁定的欄位名稱及編號
        $upform=$TadUpFiles->upform(true,'stu_pic',null,true,'.jpg,.png');//show_edit秀出編輯工具，upname上傳的欄位要叫什麼，maxlength最多可上傳幾個檔，$show_list_del_file ==true 要不要顯示刪除工具，only_type限製格式，thumb縮圖
        $form->addElement(new XoopsFormLabel('學生大頭照', $upform));


        //上傳附檔
        $TadUpFiles->set_col('stu_file',$sn); //若 $show_list_del_file ==true 時一定要有
        $upform=$TadUpFiles->upform(true,'stu_file');
        $form->addElement(new XoopsFormLabel('附檔', $upform));


        //使用者編號
        if ($sn) {
            $uid = $_SESSION['beck_iscore_adm'] ? $students['uid'] : $xoopsUser->uid();
        } else {
            $uid = $xoopsUser->uid();
        }
        // var_dump($uid);die();
        $form->addElement(new XoopsFormHidden('uid', $uid));
        //下個動作
        if ($sn) {
            $form->addElement(new XoopsFormHidden('op', 'student_update'));
            $form->addElement(new XoopsFormHidden('sn', $sn));
        } else {
            $form->addElement(new XoopsFormHidden('op', 'student_insert'));
        }
        //儲存按鈕
        $form->addElement(new XoopsFormButton('', '', '儲存', 'submit'));
        //產生程式碼
        $student_form=$form->render();
        //將表單送到樣板
        $xoopsTpl->assign('student_form', $student_form);

    }

    function student_insert(){

        global $xoopsDB;
        // var_dump($_POST);
        //安全判斷 儲存 更新都要做
        if (!power_chk('beck_iscore', 1)) {
            redirect_header('index.php', 3, '無操作權限');
        }

        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // 過濾到校日期、生日
        if (validateDate($_POST['arrival_date']['date'],$format = 'Y/m/d')){
            $arrival_date=$_POST['arrival_date']['date'];
        }else{
            echo('到校日期錯誤');
        }
        if (validateDate($_POST['birthday']['date'], $format = 'Y/m/d')){
            $birthday=$_POST['birthday']['date'];
        }else{
            echo('生日錯誤');
        }
        // echo "<p>\$arrival_date={$arrival_date}</p>";
        // echo "<p>\$birthday={$birthday}</p>";
        // die();

        $tbl = $xoopsDB->prefix('yy_student');
        $sql = "insert into `$tbl` (
            `stu_sn                `,`stu_name              `,`arrival_date          `,`birthday              `,`national_id           `,`ori_referral          `,`domicile              `,`ethnic_group          `,`marital               `,`height                `,`weight                `,`Low_income            `,`guardian_disability   `,`referral_reason       `,`original_education    `,`original_school       `,`family_profile        `,`residence_address     `,`address               `,`guardian1             `,`guardian_relationship1`,`guardian_cellphone1   `,`guardian2             `,`guardian_relationship2`,`guardian_cellphone2   `,`emergency_contact1    `,`emergency_contact_rel1`,`emergency_cellphone1  `,`emergency_contact2    `,`emergency_contact_rel2`,`emergency_cellphone2  `,`sort                  `,`uid`                   ,
            `create_time`           ,`update_time`) 
            values('{$stu_sn}','{$stu_name}','{$arrival_date}','{$birthday}','{$national_id}','{$ori_referral}','{$domicile}','{$ethnic_group}','{$marital}','{$height}','{$weight}','{$Low_income}','{$guardian_disability}','{$referral_reason}','{$original_education}','{$original_school}','{$family_profile}','{$residence_address}','{$address}','{$guardian1}','{$guardian_relationship1}','{$guardian_cellphone1}','{$guardian2}','{$guardian_relationship2}','{$guardian_cellphone2}','{$emergency_contact1}','{$emergency_contact_rel1}','{$emergency_cellphone1}','{$emergency_contact2}','{$emergency_contact_rel2}','{$emergency_cellphone2}','{$sort}','{$uid}',now(), now())";

        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號

        //上傳表單（enctype='multipart/form-data'）
        $TadUpFiles=new TadUpFiles("beck_iscore","/student",$file="/file",$image="/image",$thumbs="/image/.thumbs");
        // 圖檔儲存
        $TadUpFiles->set_col('sn',$sn);
        $TadUpFiles->upload_file('stu_pic',1920,640,null,$stu_name,true,false,null, 'png;jpg');
        // 上傳附檔
        $TadUpFiles->set_col('stu_file',$sn);
        $TadUpFiles->upload_file('stu_file',1920,640,null,null,true);

        mk_html($sn);

        return $sn;
        // die(var_dump($_POST));
    }

    function student_update($sn){

        global $xoopsDB;
        if (!power_chk('beck_iscore', 1)) {
            redirect_header('index.php', 3, '無操作權限');
        }

        // var_dump($_POST);die();  
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // 過濾到校日期、生日
        if (validateDate($_POST['arrival_date']['date'],$format = 'Y/m/d')){
            $arrival_date=$_POST['arrival_date']['date'];
        }else{
            echo('到校日期錯誤');
        }
        if (validateDate($_POST['birthday']['date'], $format = 'Y/m/d')){
            $birthday=$_POST['birthday']['date'];
        }else{
            echo('生日錯誤');
        }
        // echo "<p>\$arrival_date={$arrival_date}</p>";
        // echo "<p>\$birthday={$birthday}</p>";
        // die();

        $tbl = $xoopsDB->prefix('yy_student');
        $sql = "update `$tbl` set 
            `stu_sn`   = '{$stu_sn}',   `stu_name`     = '{$stu_name}',     `arrival_date` = '{$arrival_date}',
            `birthday` = '{$birthday}', `national_id`  = '{$national_id}',  `ori_referral` = '{$ori_referral}',
            `domicile` = '{$domicile}', `ethnic_group` = '{$ethnic_group}', `marital`      = '{$marital}',
            `height`   = '{$height}',   `weight`       = '{$weight}',       `Low_income`   = '{$Low_income}',
            `guardian_disability` = '{$guardian_disability}', `referral_reason`   = '{$referral_reason}',
            `original_education`  = '{$original_education}',  `original_school`   = '{$original_school}',
            `family_profile`      = '{$family_profile}',      `residence_address` = '{$residence_address}',
            `address` = '{$address}', `guardian1`='{$guardian1}', `guardian_relationship1`='{$guardian_relationship1}', 
            `guardian_cellphone1`    = '{$guardian_cellphone1}',    `guardian2`              = '{$guardian2}',
            `guardian_relationship2` = '{$guardian_cellphone2}',    `guardian_cellphone2`    = '{$guardian_relationship2}',
            `emergency_contact1`     = '{$emergency_contact1}',     `emergency_contact_rel1` = '{$emergency_contact_rel1}',
            `emergency_cellphone1`   = '{$emergency_cellphone1}',   `emergency_contact2`     = '{$emergency_contact2}',
            `emergency_contact_rel2` = '{$emergency_contact_rel2}', `emergency_cellphone2`   = '{$emergency_cellphone2}',
            `uid` = '{$uid}', `update_time` = now()
            where `sn`   = '{$sn}'";

        // echo($sql);
        // die();

        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        //上傳表單（enctype='multipart/form-data'）
        $TadUpFiles=new TadUpFiles("beck_iscore","/student",$file="/file",$image="/image",$thumbs="/image/.thumbs");
        // 圖檔儲存
        $TadUpFiles->set_col('sn',$sn);
        $TadUpFiles->upload_file('stu_pic',1920,640,null,$stu_name,true,false,null, 'png;jpg');
        // 上傳附檔
        $TadUpFiles->set_col('stu_file',$sn);
        $TadUpFiles->upload_file('stu_file',1920,640,null,null,true);

        mk_html($sn);

        return $sn;
        // die(var_dump($_POST));


    }

    function student_show($sn){
        global $xoopsTpl,$xoopsDB;

        $myts = MyTextSanitizer::getInstance();

        $tbl      = $xoopsDB->prefix('yy_student');
        $sql      = "SELECT * FROM $tbl Where `sn`='{$sn}'";
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $students = $xoopsDB->fetchArray($result);//fetchrow

        $students['stu_sn']                 = $myts->htmlSpecialChars($students['stu_sn']);
        $students['stu_name']               = $myts->htmlSpecialChars($students['stu_name']);
        $students['arrival_date']           = $myts->htmlSpecialChars($students['arrival_date']);
        $students['birthday']               = $myts->htmlSpecialChars($students['birthday']);
        $students['national_id']            = $myts->htmlSpecialChars($students['national_id']);
        $students['ori_referral']           = $myts->htmlSpecialChars($students['ori_referral']);
        $students['domicile']               = $myts->htmlSpecialChars($students['domicile']);
        $students['ethnic_group']           = $myts->htmlSpecialChars($students['ethnic_group']);
        $students['marital']                = $myts->htmlSpecialChars($students['marital']);
        $students['height']                 = $myts->htmlSpecialChars($students['height']);
        $students['weight']                 = $myts->htmlSpecialChars($students['weight']);
        $students['Low_income']             = $myts->htmlSpecialChars($students['Low_income']);
        $students['guardian_disability']    = $myts->htmlSpecialChars($students['guardian_disability']);
        $students['referral_reason']        = $myts->htmlSpecialChars($students['referral_reason']);
        $students['original_education']     = $myts->htmlSpecialChars($students['original_education']);
        $students['original_school']        = $myts->htmlSpecialChars($students['original_school']);
        $students['family_profile']         = $myts->displayTarea($students['family_profile'], 1, 0, 0, 0, 0);
        $students['residence_address']      = $myts->htmlSpecialChars($students['residence_address']);
        $students['address']                = $myts->htmlSpecialChars($students['address']);
        $students['guardian1']              = $myts->htmlSpecialChars($students['guardian1']);
        $students['guardian_relationship1'] = $myts->htmlSpecialChars($students['guardian_relationship1']);
        $students['guardian_cellphone1']    = $myts->htmlSpecialChars($students['guardian_cellphone1']);
        $students['guardian2']              = $myts->htmlSpecialChars($students['guardian2']);
        $students['guardian_relationship2'] = $myts->htmlSpecialChars($students['guardian_relationship2']);
        $students['guardian_cellphone2']    = $myts->htmlSpecialChars($students['guardian_cellphone2']);
        $students['emergency_contact1']     = $myts->htmlSpecialChars($students['emergency_contact1']);
        $students['emergency_contact_rel1'] = $myts->htmlSpecialChars($students['emergency_contact_rel1']);
        $students['emergency_cellphone1']   = $myts->htmlSpecialChars($students['emergency_cellphone1']);
        $students['emergency_contact2']     = $myts->htmlSpecialChars($students['emergency_contact2']);
        $students['emergency_contact_rel2'] = $myts->htmlSpecialChars($students['emergency_contact_rel2']);
        $students['emergency_cellphone2']   = $myts->htmlSpecialChars($students['emergency_cellphone2']);
        $students['sort']                   = $myts->htmlSpecialChars($students['sort']);


        // 顯示上次上傳的圖片
        $TadUpFiles=new TadUpFiles("beck_iscore","/student",$file="/file",$image="/image",$thumbs="/image/.thumbs");
        $TadUpFiles->set_col('sn',$sn);
        $students['cover'] = $TadUpFiles->show_files('stu_pic',false);

        $TadUpFiles->set_col('stu_file',$sn);
        $students['files'] = $TadUpFiles->show_files();

        // die(var_dump($students));
        $xoopsTpl->assign('students', $students);

        if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php")) {
            redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
        }
        include_once XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php";
        $sweet_alert = new sweet_alert();
        $sweet_alert->render("studnet_del", "index.php?op=student_delete&sn=", 'sn');

        // 如果有權限，傳到樣版判斷顯示刪除、修改
        if(power_chk("beck_iscore", "1")){
            $xoopsTpl->assign('student_post', true);
        }
        if(power_chk("beck_iscore", "2")){
            $xoopsTpl->assign('student_delete', true);
        }
        // if(power_chk("read", "1")){$xoopsTpl->assign('', true);}
        
    }
    function student_list(){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig;

        $myts = MyTextSanitizer::getInstance();

        $tbl      = $xoopsDB->prefix('yy_student');
        $sql      = "SELECT * FROM $tbl ORDER BY `sn` DESC";
        
        //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = getPageBar($sql, $xoopsModuleConfig['show_num'], 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];

        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all      = array();
        while($students = $xoopsDB->fetchArray($result)){
            $students['stu_sn']                 = $myts->htmlSpecialChars($students['stu_sn']);
            $students['stu_name']               = $myts->htmlSpecialChars($students['stu_name']);
            $students['arrival_date']           = $myts->htmlSpecialChars($students['arrival_date']);
            $students['birthday']               = $myts->htmlSpecialChars($students['birthday']);
            $students['national_id']            = $myts->htmlSpecialChars($students['national_id']);
            $students['ori_referral']           = $myts->htmlSpecialChars($students['ori_referral']);
            $students['domicile']               = $myts->htmlSpecialChars($students['domicile']);
            $students['ethnic_group']           = $myts->htmlSpecialChars($students['ethnic_group']);
            $students['marital']                = $myts->htmlSpecialChars($students['marital']);
            $students['height']                 = $myts->htmlSpecialChars($students['height']);
            $students['weight']                 = $myts->htmlSpecialChars($students['weight']);
            $students['Low_income']             = $myts->htmlSpecialChars($students['Low_income']);
            $students['guardian_disability']    = $myts->htmlSpecialChars($students['guardian_disability']);
            $students['referral_reason']        = $myts->htmlSpecialChars($students['referral_reason']);
            $students['original_education']     = $myts->htmlSpecialChars($students['original_education']);
            $students['original_school']        = $myts->htmlSpecialChars($students['original_school']);
            $students['family_profile']         = $myts->displayTarea($students['family_profile'], 1, 0, 0, 0, 0);
            $students['residence_address']      = $myts->htmlSpecialChars($students['residence_address']);
            $students['address']                = $myts->htmlSpecialChars($students['address']);
            $students['guardian1']              = $myts->htmlSpecialChars($students['guardian1']);
            $students['guardian_relationship1'] = $myts->htmlSpecialChars($students['guardian_relationship1']);
            $students['guardian_cellphone1']    = $myts->htmlSpecialChars($students['guardian_cellphone1']);
            $students['guardian2']              = $myts->htmlSpecialChars($students['guardian2']);
            $students['guardian_relationship2'] = $myts->htmlSpecialChars($students['guardian_relationship2']);
            $students['guardian_cellphone2']    = $myts->htmlSpecialChars($students['guardian_cellphone2']);
            $students['emergency_contact1']     = $myts->htmlSpecialChars($students['emergency_contact1']);
            $students['emergency_contact_rel1'] = $myts->htmlSpecialChars($students['emergency_contact_rel1']);
            $students['emergency_cellphone1']   = $myts->htmlSpecialChars($students['emergency_cellphone1']);
            $students['emergency_contact2']     = $myts->htmlSpecialChars($students['emergency_contact2']);
            $students['emergency_contact_rel2'] = $myts->htmlSpecialChars($students['emergency_contact_rel2']);
            $students['emergency_cellphone2']   = $myts->htmlSpecialChars($students['emergency_cellphone2']);
            $students['sort']                   = $myts->htmlSpecialChars($students['sort']);
            // 顯示上次上傳的圖片
            $TadUpFiles=new TadUpFiles("beck_iscore","/student",$file="/file",$image="/image",$thumbs="/image/.thumbs");
            $TadUpFiles->set_col('sn',$students['sn']);
            //取得單一圖片 1$kind=images（大圖）/thumb（小圖）/file（檔案）,2$kind="url"/"dir",3$file_sn,4$hash(加密)
            $students['cover'] = $TadUpFiles->get_pic_file('thumb','url',$files_sn);

            $all[]=$students;
        }

        // die(var_dump($all));
        $xoopsTpl->assign('all', $all);
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);
    }

    function student_delete($sn){
        global $xoopsTpl, $xoopsDB;

        if (!power_chk('beck_iscore', 2)) {
            redirect_header('index.php', 3, '無操作權限');
        }

        $TadUpFiles=new TadUpFiles("beck_iscore","/student",$file="/file",$image="/image",$thumbs="/image/.thumbs");

        $tbl = $xoopsDB->prefix('yy_student');
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $TadUpFiles->set_col('sn', $sn);
        $TadUpFiles->del_files();

        $TadUpFiles->set_col('stu_file', $sn);
        $TadUpFiles->del_files();

    }







/*-----------秀出結果區--------------*/

$xoopsTpl->assign('now_op', $op);
$xoopsTpl->assign("toolbar", toolbar_bootstrap($interface_menu));

include_once XOOPS_ROOT_PATH . '/footer.php';
