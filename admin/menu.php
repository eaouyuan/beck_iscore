<?php
$adminmenu = array();

$i                      = 1;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_HOME;
$adminmenu[$i]['link']  = 'admin/index.php';
$adminmenu[$i]['desc']  = _MI_TAD_ADMIN_HOME_DESC;
$adminmenu[$i]['icon']  = 'images/admin/home.png';

$i++;
$adminmenu[$i]['title'] = _MI_beck_iscore_ADMENU1;
$adminmenu[$i]['link']  = "admin/teacher.php";
$adminmenu[$i]['desc']  = _MI_beck_iscore_ADMENU1_DESC;
$adminmenu[$i]['icon']  = 'images/admin/teacher.png';

$i++;
$adminmenu[$i]['title'] = _MI_beck_iscore_ADMENU2;
$adminmenu[$i]['link']  = "admin/department.php";
$adminmenu[$i]['desc']  = _MI_beck_iscore_ADMENU2_DESC;
$adminmenu[$i]['icon']  = 'images/admin/department.png';

$i++;
$adminmenu[$i]['title'] = _MI_beck_iscore_ADMENU3;
$adminmenu[$i]['link']  = "admin/student.php";
$adminmenu[$i]['desc']  = _MI_beck_iscore_ADMENU3_DESC;
$adminmenu[$i]['icon']  = 'images/admin/student.png';

$i++;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_ABOUT;
$adminmenu[$i]['link']  = 'admin/about.php';
$adminmenu[$i]['desc']  = _MI_TAD_ADMIN_ABOUT_DESC;
$adminmenu[$i]['icon']  = 'images/admin/about.png';
