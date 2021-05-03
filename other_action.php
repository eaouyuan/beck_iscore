<?php
use Xmf\Request;
// print_r($_REQUEST);die();

include_once "../../mainfile.php";
include_once "function.php";

$op = Request::getString('op');
$sn = Request::getInt('sn');
$check_status = Request::getString('check_status');
$odr_ary = Request::getArray('odr');



// if (!$xoopsUser->isAdmin()) {
//     die();
// }
// var_dump($op);
// var_dump($order_ary);
// die();
// 處室列表
switch ($op) {
    // 是否為教師
    case "teacher_istch_edit":
        teacher_identity_edit($sn,$check_status,'isteacher');
        exit;
    // 輔導教師
    case "teacher_isgdc_edit":
        teacher_identity_edit($sn,$check_status,'isguidance');
        exit;
    // 社工師
    case "teacher_isscl_edit":
        teacher_identity_edit($sn,$check_status,'issocial');
        exit;
    case "teacher_sort":
        teacher_sort($odr_ary);
        exit;
    case "course_sort":
        course_sort($odr_ary);
        exit;
    case "student_sort":
        student_sort($odr_ary);
        exit;
    case "exam_keyindate_sort":
        exam_keyindate_sort($odr_ary);
        exit;
    case "course_ftest_sw":
        course_test_sw($sn,$check_status,'first_test');
        exit;
    case "course_stest_sw":
        course_test_sw($sn,$check_status,'second_test');
        exit;

    default:
        echo('this is default switch in op_teacher.php');
    break;


}

function student_sort($odr_ary){
    global $xoopsDB,$xoopsUser;
    $tbl   = $xoopsDB->prefix('yy_student');
    $sort = 1;
    // var_dump($odr_ary);die();
    foreach ($odr_ary as $sn) {
        $sql = "update " . $tbl . " set `sort`='{$sort}'  where `sn`='{$sn}'";
        // $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . " (" . date("Y-m-d H:i:s") . ")" . $sql);
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        // echo('</br>');
        $sort++;
    }
}

function exam_keyindate_sort($odr_ary){
    global $xoopsDB,$xoopsUser;
    $tbl   = $xoopsDB->prefix('yy_exam_keyin_daterange');
    $sort = 1;
    // var_dump($odr_ary);die();
    foreach ($odr_ary as $sn) {
        $sql = "update " . $tbl . " set `sort`='{$sort}'  where `sn`='{$sn}'";
        // $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . " (" . date("Y-m-d H:i:s") . ")" . $sql);
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        // echo('</br>');
        $sort++;
    }
}

function course_test_sw($sn,$check_status,$field){
    global $xoopsDB,$xoopsUser;
    if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
        $return['msg']='權限錯誤!';
        echo json_encode($return);
    } 

    $myts = MyTextSanitizer::getInstance();
    foreach ($_POST as $key => $value) {
        $$key = $myts->addSlashes($value);
        // echo "<p>\${$key}={$$key}</p>";
        $return[$key]=$myts->addSlashes($value);
    }
    // var_dump($return);die();
    $tbl = $xoopsDB->prefix('yy_course');
    $sql = "update `$tbl` set 
                `{$field}`='{$check_status}',
                `update_user`='{$_SESSION['xoopsUserId']}',
                `update_date`=now()
            where `sn`   = '{$sn}'";
    // var_dump($sql);die();
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
  
    $return['msg']='修改成功!';
    echo json_encode($return);
}
function course_sort($odr_ary){
    global $xoopsDB,$xoopsUser;
    if (!$xoopsUser) {
        die();
    }
    $tbl   = $xoopsDB->prefix('yy_course');
    $sort = 1;
    // var_dump($odr_ary);die();
    foreach ($odr_ary as $sn) {
        $sql = "update " . $tbl . " set `sort`='{$sort}'  where `sn`='{$sn}'";
        // $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . " (" . date("Y-m-d H:i:s") . ")" . $sql);
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        // echo('</br>');
        $sort++;
    }
}
function teacher_sort($odr_ary){
    global $xoopsDB,$xoopsUser;
    if (!$xoopsUser->isAdmin()) {
        die();
    }
    $tbl   = $xoopsDB->prefix('yy_teacher');
    foreach ($odr_ary as $sn) {
        $sql      = "SELECT * FROM $tbl WHERE uid='{$sn}'";
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $tch_exist= $xoopsDB->fetchArray($result);
    
        if (!$tch_exist) {
            $sql = "insert into `$tbl` (
                        `uid`,`enable`,`sex`,`create_uid`,`create_time`,`update_uid`,
                        `update_time`
                    )values(
                        '{$sn}','1','','{$_SESSION['xoopsUserId']}', now(),'{$_SESSION['xoopsUserId']}',now()
                    )";
            // echo($sql);die();
            $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }
    }
    $sort = 1;
    // var_dump($odr_ary);die();
    foreach ($odr_ary as $sn) {
        $sql = "update " . $tbl . " set `sort`='{$sort}' ,`update_time`=now() where `uid`='{$sn}'";
        // $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . " (" . date("Y-m-d H:i:s") . ")" . $sql);
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        // echo('</br>');
        $sort++;
    }
}


function teacher_identity_edit($sn,$check_status,$idtf){
    global $xoopsDB,$xoopsUser;
    if (!$xoopsUser->isAdmin()) {
        die();
    }
    $myts = MyTextSanitizer::getInstance();
    foreach ($_POST as $key => $value) {
        $$key = $myts->addSlashes($value);
        // echo "<p>\${$key}={$$key}</p>";
        $return[$key]=$myts->addSlashes($value);

    }
    // var_export($_SESSION['xoopsUserId']);
    // die();
    // //下個動作，教師基本資料是否存在
    $tb2      = $xoopsDB->prefix('yy_teacher');
    $sql      = "SELECT * FROM $tb2 WHERE uid='{$sn}'";
    $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $tch_base = $xoopsDB->fetchArray($result);

    $tbl = $xoopsDB->prefix('yy_teacher');
    if ($tch_base) {
        $sql = "update `$tbl` set 
                    `{$idtf}`='{$check_status}',
                    `update_uid`='{$_SESSION['xoopsUserId']}',
                    `update_time`=now()
                where `uid`   = '{$sn}'";
        // var_dump($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    } else {
        $sql = "insert into `$tbl` (
                    `uid`,`enable`,`{$idtf}`,`sex`,`create_uid`,`create_time`,`update_uid`,
                    `update_time`
                )values(
                    '{$sn}','1','{$check_status}','','{$_SESSION['xoopsUserId']}', now(),'{$_SESSION['xoopsUserId']}',now()
                )";
        // echo($sql);die();

        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號
        // return $sn;
    }
    $return['msg']='修改成功';
    echo json_encode($return);

    // return '34345345';
}
