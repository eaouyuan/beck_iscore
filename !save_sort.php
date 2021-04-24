<?php
// use Xmf\Request;
// include_once "../../mainfile.php";
// include_once "function.php";

// $op = Request::getString('action');
// $order_ary = Request::getArray('sn');

// // var_dump($_POST);
// // var_dump($op);
// // var_dump($order_ary);
// // die();


// $sort = 1;
// foreach ($order_ary as $sn) {
//     $sql = "update " . $xoopsDB->prefix($op) . " set `sort`='{$sort}' ,`update_time`=now() where `sn`='{$sn}'";
//     // $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . " (" . date("Y-m-d H:i:s") . ")" . $sql);
//     $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
//     // echo($sql);
//     // echo('</br>');
//     $sort++;
    
// }
// // die();
// echo _TAD_SORTED . "(" . date("Y-m-d H:i:s") . ")";
// redirect_header(XOOPS_URL ."/modules/beck_iscore/index.php");


