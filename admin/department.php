<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "beck_iscore_adm_department.tpl";
include_once "header.php";
include_once "../function.php";

/*-----------function區--------------*/

//顯示預設頁面內容
function show_content()
{
    global $xoopsTpl;

    $main = "學程後台頁面開發中";
    $xoopsTpl->assign('content', $main);
}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = Request::getString('op');

switch ($op) {

    // case "xxx":
    // xxx();
    // header("location:{$_SERVER['PHP_SELF']}");
    // exit;

    default:
        show_content();
        break;
}

include_once 'footer.php';
