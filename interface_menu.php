<?php
//判斷是否對該模組有管理權限
$session_name = basename(__DIR__) . '_adm';
// var_dump($xoopsUser->isAdmin());
// var_dump($session_name);
// die();
// $isAdmin=false;
// var_dump($isAdmin);
// echo('<br>');

if($xoopsUser){
    $isAdmin=$xoopsUser->isAdmin();
}
// var_dump($xoopsUser->isAdmin());
// echo('<br>');
// var_dump($session_name);
// echo('<br>');

// var_dump($isAdmin);
// echo('<br>');
// var_dump($_SESSION[$session_name]);
// echo('<br>');
if (!isset($_SESSION[$session_name])) {
    $_SESSION[$session_name] = ($xoopsUser) ? $xoopsUser->isAdmin() : false;
}
// var_dump($_SESSION);
// die();


//回模組首頁
// $interface_menu[_TAD_TO_MOD] = "index.php";
// $interface_icon[_TAD_TO_MOD] = "";

//模組後台
if ($isAdmin) {
    $interface_menu['新增學生'] = "index.php?op=student_form";
    $interface_icon['新增學生'] = "";

    //管理介面
    $interface_menu[_TAD_TO_ADMIN] = "admin/index.php";
    $interface_icon[_TAD_TO_ADMIN] = "";
}
