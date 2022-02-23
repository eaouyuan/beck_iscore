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


$sdate_time='2022-01-03 03:30';
// $edate_time=['2022-01-03 02:30'];
$edate_time=['2022-01-03 05:45','2022-01-03 08:30','2022-01-03 12:00','2022-01-03 16:30','2022-01-03 18:45','2022-01-04 00:00','2022-01-04 02:00','2022-01-04 08:30','2022-01-04 12:00','2022-01-04 16:30','2022-01-04 18:00','2022-01-05 00:00','2022-01-05 02:00','2022-01-05 08:30','2022-01-05 12:00','2022-01-05 16:30','2022-01-05 18:00','2022-01-06 00:00'];
// $edate_time=['2022-01-03 05:45','2022-01-03 08:30','2022-01-03 12:00','2022-01-03 16:30','2022-01-03 18:45','2022-01-04 00:00','2022-01-04 02:00','2022-01-04 08:30','2022-01-04 12:00','2022-01-04 16:30','2022-01-04 18:00','2022-01-05 00:00','2022-01-05 02:00','2022-01-05 08:30','2022-01-05 12:00','2022-01-05 16:30','2022-01-05 18:00','2022-01-06 00:00'];

// foreach($edate_time as $v){
    // var_dump($v);
    testdate2($sdate_time,'2022-01-05 16:45');
    // testdate2($sdate_time,$v);
// }