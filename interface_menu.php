<?php
use XoopsModules\Tadtools\Utility;

//判斷是否對該模組有管理權限
$session_name = basename(__DIR__) . '_adm';
// var_dump($xoopsUser->isAdmin());
// var_dump($session_name);
// die();
// $isAdmin=false;
// var_dump($isAdmin);
// echo('<br>');

// if($xoopsUser){
//     $isAdmin=$xoopsUser->isAdmin();
// }
// var_dump($xoopsUser->isAdmin());
// echo('<br>');
// die();
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
if (power_chk("", 1)) {
    // $interface_menu['總表PDF'] = "pdf_all.php";
    // $interface_icon['總表PDF'] = "";

    // $interface_menu['滑動文章'] = "sortable.php";
    // $interface_icon['滑動文章'] = "";
}

//管理介面
if($_SESSION[$session_name] ){
    $interface_menu[_TAD_TO_ADMIN] = "admin/index.php";
    $interface_icon[_TAD_TO_ADMIN] = "";
}
