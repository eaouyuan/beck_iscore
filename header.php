<?php
//載入XOOPS主設定檔（必要）
require_once "../../mainfile.php";
require_once 'preloads/autoloader.php';
//載入自訂的共同函數檔
require_once "function.php";
//載入工具選單設定檔（亦可將 interface_menu.php 的內容複製到此檔下方，並刪除 interface_menu.php）
require_once "interface_menu.php";

// //判斷是否對該模組有管理權限
// $session_name = basename(__DIR__) . '_adm';
// // var_dump($xoopsUser->isAdmin());die();
// if (!isset($_SESSION[$session_name])) {
//     $_SESSION[$session_name] = ($xoopsUser) ? $xoopsUser->isAdmin() : false;
// }

// //回模組首頁
// $interface_menu[_TAD_TO_MOD] = "index.php";
// $interface_icon[_TAD_TO_MOD] = "fa-chevron-right";

// //模組後台
// if ($isAdmin) {
//     $interface_menu[_TAD_TO_ADMIN] = "admin/teacher.php";
//     $interface_icon[_TAD_TO_ADMIN] = "fa-chevron-right";
// }