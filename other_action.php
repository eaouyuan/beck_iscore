<?php
use Xmf\Request;
include_once "../../mainfile.php";
include_once "function.php";

$op = Request::getString('op');
$sn = Request::getInt('sn');
$check_status = Request::getString('check_status');
// var_dump($_POST);
// var_dump($op);
// var_dump($order_ary);
// die();
// 處室列表
switch ($op) {
    // 修改 教師 是否為教師
    case "teacher_istch_edit":
        // var_export($_REQUEST);
        teacher_istch_edit($sn,$check_status);
        exit;
    default:
        echo('this is default switch in op_teacher.php');
    break;


}
function teacher_istch_edit($sn,$check_status){
    global $xoopsDB,$xoopsUser;
    //安全判斷 儲存 更新都要做，但只能一次 否則出錯
    // if (!$GLOBALS['xoopsSecurity']->check()) {
    //     $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
    //     redirect_header("school_affairs.php?op=teacher_list", 3, '表單Token錯誤，請重新操作!');
    //     throw new Exception($error);
    // }

    $myts = MyTextSanitizer::getInstance();
    foreach ($_POST as $key => $value) {
        $$key = $myts->addSlashes($value);
        // echo "<p>\${$key}={$$key}</p>";
        $return[$$key]=$myts->addSlashes($value);

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
                    `isteacher`='{$check_status}'             
                where `uid`   = '{$sn}'";
        // var_dump($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    } else {
        $sql = "insert into `$tbl` (
                    `uid`,`enable`,`isteacher`,`sex`,`create_uid`,`create_time`,
                    `update_time`
                )values(
                    '{$sn}','1','{$check_status}','','{$_SESSION['xoopsUserId']}', now(),
                    now()
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
