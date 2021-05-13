<?php
include_once "header.php";
// include_once "../../mainfile.php";

include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = Request::getString('op');
$sn = Request::getInt('sn');

if (!file_exists(XOOPS_ROOT_PATH . "/uploads/beck_iscore/student/html/{$sn}.html")) {
    $html = mk_html($sn);
}else{
    $html=file_get_contents(XOOPS_ROOT_PATH."/uploads/beck_iscore/student/html/{$sn}.html");
}

if ($op == "online") {
    header("location: " . XOOPS_URL . "/uploads/beck_iscore/student/html/{$sn}.html");
}else{
    // 取出檔案
    header("Content-type: text/html");
    header("Content-Disposition: attachment; filename={$sn}.html");
    echo $html;
}
exit;
