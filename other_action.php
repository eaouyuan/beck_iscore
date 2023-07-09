<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;

include_once "../../mainfile.php";
include_once "function.php";

$op           = Request::getString('op');
$sn           = Request::getInt('sn');
$check_status = Request::getString('check_status');
$odr_ary      = Request::getArray('odr');
$sdate        = Request::getString('sdate');
$edate        = Request::getString('edate');
$ids          = Request::getArray('ids');



// if (!$xoopsUser->isAdmin()) {
//     die();
// }
// var_dump($ids);
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
    case "variable_sort":
        variable_sort($odr_ary);
        exit;
    case "course_ftest_sw":
        course_test_sw($sn,$check_status,'first_test');
        exit;
    case "course_stest_sw":
        course_test_sw($sn,$check_status,'second_test');
        exit;
    case "sw_examkeyindate":
        sw_examkeyindate($sn,$check_status);
        exit;
    case "calculate_hrs":
        calculate_hrs($sdate,$edate);
        exit;
    case "course_batch_del":
        course_batch_del($ids);
        exit;
    default:
        echo('this is default switch in op_teacher.php');
    break;
}
function usual_score_batch($ids){
    global $xoopsDB,$xoopsUser;
    if(!($xoopsUser->isAdmin())){
        $return['code']='0';
        $return['msg']='無 usual_score_batch 權限! error:202307080946';
        echo json_encode($return);
    } 
    $myts = MyTextSanitizer::getInstance();

    $ids_sql="('".implode("','", $ids)."')";
    // 依編號撈出平時考成績
    $tbl = $xoopsDB->prefix('yy_usual_score');
    $sql = "SELECT * FROM $tbl WHERE `sn` IN {$ids_sql}";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $re = $data= $courses=array();
    while($re= $xoopsDB->fetchArray($result)){
        $re ['sn']  = $myts->htmlSpecialChars($re['sn']);
        $re ['dep_id']  = $myts->htmlSpecialChars($re['dep_id']);
        $re ['course_id']  = $myts->htmlSpecialChars($re['course_id']);
        $data []=$re;
        if (!((array_key_exists($re ['course_id'],$courses)) && (in_array($re ['exam_stage'],$courses[$re ['course_id']])))){
            $courses[$re ['course_id']][]=$re ['exam_stage'];
        }
    }
    $data_exist=0;
    if (count($data)>=1){$data_exist=1;}
    // var_dump($courses);die();
    // var_dump($data);die();
    // var_dump($courses);die();
    // var_dump(count($data));die();

    if($data_exist==1){
        $tbl   = $xoopsDB->prefix('yy_usual_score');
        $sql      = "DELETE FROM `$tbl` WHERE `sn` IN {$ids_sql}";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $return['code']='1';
        $return['msg']='編號：'.$ids_sql.'，平時成績刪除成功!';
        // redirect_header("tchstu_mag.php?op=course_batch", 3, '課程刪除成功!');

        // 重新計算平時考平均
        $SchoolSet= new SchoolSet;
        foreach ($courses as $course_id => $value) {
            foreach ($value as $exam_stage) {
                $SchoolSet->uscore_avg($course_id,$exam_stage);
        }}
    }else{
        $return['code']='0';
        $return['msg']='找不到平時成績，請聯繫工程師';
    }
    echo json_encode($return);

}

function course_batch_del($ids){
    global $xoopsDB,$xoopsUser;
    if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
        $return['code']='0';
        $return['msg']='無 course_batch_del 權限! error:202208032307';
        echo json_encode($return);
    } 
    $myts = MyTextSanitizer::getInstance();

    $ids_sql="('".implode("','", $ids)."')";
    // 先撈出課程之段考成績
    $tbl = $xoopsDB->prefix('yy_stage_score');
    $sql = "SELECT  sn FROM $tbl WHERE `course_id` IN {$ids_sql} limit 1";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $re = $data= array();
    while($re= $xoopsDB->fetchArray($result)){
        $data ['sn']  = $myts->htmlSpecialChars($re['sn']);
    }

    $data_exist=0;
    if (count($data)>=1){$data_exist=1;}

    // 沒有段考成績，再看是否有平時成績
    if($data_exist==0){
        $tbl = $xoopsDB->prefix('yy_usual_score');
        $sql = "SELECT  sn FROM $tbl WHERE `course_id` IN {$ids_sql} limit 1";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $re = $data= array();
        while($re= $xoopsDB->fetchArray($result)){
            $data ['sn']  = $myts->htmlSpecialChars($re['sn']);
        }
        if (count($data)>=1){$data_exist=1;}
    }
    if($data_exist==0){
        $tbl   = $xoopsDB->prefix('yy_course');
        $sql      = "DELETE FROM `$tbl` WHERE `sn` IN {$ids_sql}";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $return['code']='1';
        $return['msg']='課程刪除成功!';
        // redirect_header("tchstu_mag.php?op=course_batch", 3, '課程刪除成功!');
    }else{
        $return['code']='0';
        $return['msg']='已存在段考、平時成績，課程無法刪除';
    }
    echo json_encode($return);

}

function calculate_hrs($sdate,$edate){
    global $xoopsDB,$xoopsUser;
    if(!(power_chk("beck_iscore", "6") or $xoopsUser->isAdmin())){
        $return['msg']['error']='無 leave_day_form 權限! error:202203271317';
        echo json_encode($return);
    } 

    $return=Calculation_days_off($sdate,$edate);

    $return['msg']['success']='修改成功!';
    echo json_encode($return);
}
function sw_examkeyindate($sn,$check_status){
    global $xoopsDB,$xoopsUser;
    if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
        $return['msg']['error']='無 exam_keyindate_list 權限! error:202203262343!';
        echo json_encode($return);
    } 

    $myts = MyTextSanitizer::getInstance();
    foreach ($_POST as $key => $value) {
        $$key = $myts->addSlashes($value);
        // echo "<p>\${$key}={$$key}</p>";
        $return[$key]=$myts->addSlashes($value);
    }
    // var_dump($return);die();
    $tbl = $xoopsDB->prefix('yy_exam_keyin_daterange');
    $sql = "update `$tbl` set 
                `status`='{$check_status}',
                `update_user`='{$_SESSION['xoopsUserId']}',
                `update_date`=now()
            where `sn`   = '{$sn}'";
    // var_dump($sql);die();
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $return['msg']['success']='修改成功!';
    echo json_encode($return);
}

function variable_sort($odr_ary){
    global $xoopsDB,$xoopsUser;
    $tbl   = $xoopsDB->prefix('yy_config');
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
    // var_dump($sql);die();

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

}
