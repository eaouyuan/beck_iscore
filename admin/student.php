<?php

/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "beck_iscore_adm_student.tpl";
include_once "header.php";
include_once "../function.php";

/*-----------function區--------------*/

//學生列表
function student_list()
{
    global $xoopsTpl;
    $main = "學生列表";
    $xoopsTpl->assign('content', $main);
}





// function system_CleanVars(&$global, $key, $default = '', $type = 'int')
// {
//     $GLOBALS['xoopsLogger']->addDeprecated("system_CleanVars() is deprecated since XOOPS 2.5.11, please use 'Xmf\Request' instead");
//     switch ($type) {
//         case 'array':
//             $ret = (isset($global[$key]) && is_array($global[$key])) ? $global[$key] : $default;
//             break;
//         case 'date':
//             $ret = isset($global[$key]) ? strtotime($global[$key]) : $default;
//             break;
//         case 'string':
//             $ret = isset($global[$key]) ? filter_var($global[$key], FILTER_SANITIZE_SPECIAL_CHARS) : $default;
//             break;
//         case 'int':
//         default:
//             $ret = isset($global[$key]) ? filter_var($global[$key], FILTER_SANITIZE_NUMBER_INT) : $default;
//             break;
//     }
//     if ($ret === false) {
//         return $default;
//     }

//     return $ret;
// }
/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$sn = system_CleanVars($_REQUEST, 'sn', 0, 'int');

switch ($op) {

   

    default:
        student_list();
        $op = 'student_list';
        break;

}

$xoopsTpl->assign('now_op', $op);
include_once 'footer.php';
