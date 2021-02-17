<?php

function xoops_module_install_beck_iscore(&$module) {

    mk_dir(XOOPS_ROOT_PATH."/uploads/beck_iscore");
    mk_group("編輯群", "校務行政系統-編輯群");

    return true;
}



// 官方語法，建立群組
function mk_group($name = "", $description = "")
{
    $member_handler = xoops_gethandler('member');
    $group          = $member_handler->createGroup();
    $group->setVar("name", $name);
    $group->setVar("description", $description);
    $member_handler->insertGroup($group);
}

//建立目錄
function mk_dir($dir=""){
    //若無目錄名稱秀出警告訊息
    if(empty($dir))return;
    //若目錄不存在的話建立目錄
    if (!is_dir($dir)) {
        umask(000);
        //若建立失敗秀出警告訊息
        mkdir($dir, 0777);
    }
}

