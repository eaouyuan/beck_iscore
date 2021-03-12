<?php

function xoops_module_uninstall_beck_iscore(&$module) {
    GLOBAL $xoopsDB;
    $date=date("Ymd");
    
    del_group("編輯群");

    rename(XOOPS_ROOT_PATH."/uploads/beck_iscore",XOOPS_ROOT_PATH."/uploads/beck_iscore_bak_{$date}");

    return true;
}

// 刪除群組
function del_group($name=""){
    global $xoopsDB;
    $sql = "select groupid from ".$xoopsDB->prefix("groups")." where `name`='$name'";
    $result=$xoopsDB->query($sql) or web_error($sql);
    list($groupid)=$xoopsDB->fetchRow($result);
    if(!empty($groupid)){
        $sql = "DELETE FROM ".$xoopsDB->prefix("group_permission")." where `gperm_groupid`='{$groupid}'";
        $xoopsDB->queryF($sql) or web_error($sql);

        $sql_group = "DELETE FROM ".$xoopsDB->prefix("groups")." where `name`='{$name}'";
        $xoopsDB->queryF($sql_group) or web_error($sql);
    }   
}

//刪除目錄
function delete_directory($dirname) {
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
            else
                delete_directory($dirname.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}

//拷貝目錄
function full_copy( $source="", $target=""){
    if ( is_dir( $source ) ){
        @mkdir( $target );
        $d = dir( $source );
        while ( FALSE !== ( $entry = $d->read() ) ){
            if ( $entry == '.' || $entry == '..' ){
                continue;
            }

            $Entry = $source . '/' . $entry;
            if ( is_dir( $Entry ) )    {
                full_copy( $Entry, $target . '/' . $entry );
                continue;
            }
            copy( $Entry, $target . '/' . $entry );
        }
        $d->close();
    }else{
        copy( $source, $target );
    }
}

