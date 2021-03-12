<?php
include_once "header.php";
include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';
//權限項目陣列（編號超級重要！設定後，以後切勿隨便亂改。）
$item_list = array(
    '1' => "管理學生（新增、編輯）",
    '2' => "刪除學生",
);
$mid       = $xoopsModule->mid();
$perm_name = $xoopsModule->dirname();//這是beck_iscore 模組名稱
$formi     = new XoopsGroupPermForm('細部權限設定', $mid, $perm_name, '請勾選欲開放給群組使用的權限：<br>');
foreach ($item_list as $item_id => $item_name) {
    $formi->addItem($item_id, $item_name);
}
echo $formi->render();



include_once 'footer.php';
