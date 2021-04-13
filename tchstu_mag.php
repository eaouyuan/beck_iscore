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
// 處室 管理
    case "dept_school_list":
        dept_school_list();
        break;//跳出迴圈,往下執行
    
    // 新增、編輯 處室表單
    case "student_form":
        student_form($sn);
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

    default:
        semester_list();
        $op="semester_list";
        break;


}

/*-----------function區--------------*/

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
        // die();
        $tbl = $xoopsDB->prefix('yy_teacher');
        $sql = "update `$tbl` set 
                    `uid`         = '{$sn}',
                    `dep_id`      = '{$dept_id}',
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
                    `cell_phone`,`enable`,`isteacher`,`isguidance`,`issocial`,`create_uid`,`create_time`,`update_uid`,
                    `update_time`
                )values(
                    '{$sn}','{$dept_id}','{$title}','{$sex}','{$phone}',
                    '{$cell_phone}','{$enable}','{$isteacher}','{$isguidance}','{$issocial}','{$create_uid}', now(),
                    '{$create_uid}',now()
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
        // die(var_dump($_REQUEST));

        $have_par='0';
        if(!empty($pars['dep_id'])){
            $sql.=" WHERE tr.dep_id='{$pars['dep_id']}'";
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
        $SweetAlert->render('tch_del', XOOPS_URL . "/modules/beck_iscore/school_affairs.php?op=teacher_delete&sn=", 'sn','確定要刪除教師基本資料','教師基本資料刪除，但保留帳號。');

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());


        $xoopsTpl->assign('op', "teacher_list");

    }


// ----------------------------------
// 學生 管理
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

    // 表單-新增、編輯 學生
    function student_form($sn){
        

        global $xoopsTpl,$xoopsUser,$xoopsDB;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, '無操作權限');
        }
        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#student_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // if (!power_chk('beck_iscore', 1)) {
        //     redirect_header('school_affairs.php', 3, '無操作權限');
        // }


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
        $stu['record']                    = $stu_ifo['record'] ?? '';

        $SchoolSet= new SchoolSet;
        // 班級、導師、學程
        $class_name=$class_tutor=[];
        foreach ($SchoolSet->class as $k=>$v){
            $class_name[$v['sn']]=$v['class_name'];
            $class_tutor[$v['sn']]=$v['name'];
        }
        $stu['class_htm']=Get_select_opt_htm($class_name,$stu['class_id'],'1');
        $xoopsTpl->assign('class_tutor', json_encode($class_tutor));


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
        $status_ary=['0'=>'在校','1'=>'回歸/結案','2'=>'逾假逃跑'] ;
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
        $stu['rcv_guidance_htm']=Get_select_opt_htm($SchoolSet->get_uid_name(),$stu['rcv_guidance_id'],'1');
        
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
