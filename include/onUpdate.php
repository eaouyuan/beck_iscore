<?php

function xoops_module_update_beck_iscore(&$module, $old_version) {
    GLOBAL $xoopsDB;

    // del_group("學生增刪");
    // del_group("課程管理");
    // del_group("輔導室");

    // mk_group("學生增刪", "學生新增編輯刪除");
    // mk_group("課程管理", "課程管理");
    // mk_group("輔導室", "輔導室");
    mk_group("認輔管理", "認輔管理");


    // if(!chk_chk1()) go_update1();

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

function mk_group($name = "")
{
    global $xoopsDB;
    $sql           = "select groupid from " . $xoopsDB->prefix("groups") . " where `name`='$name'";
    $result        = $xoopsDB->query($sql) or web_error($sql);
    list($groupid) = $xoopsDB->fetchRow($result);
    if (empty($groupid)) {
        $sql = "insert into " . $xoopsDB->prefix("groups") . " (`name`) values('{$name}')";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        //取得最後新增資料的流水編號
        $groupid = $xoopsDB->getInsertId();
    }
    return $groupid;
}

//檢查某欄位是否存在
function chk_chk1(){
    global $xoopsDB;
    $sql="select count(`欄位`) from ".$xoopsDB->prefix("資料表");
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    if(empty($result)) return false;
    return true;
}

//執行更新
function go_update1(){
    global $xoopsDB;
    $sql="ALTER TABLE ".$xoopsDB->prefix("資料表")." ADD `欄位` smallint(5) NOT NULL";
    $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL,3,  mysql_error());

    return true;
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

function rename_win($oldfile,$newfile) {
if (!rename($oldfile,$newfile)) {
if (copy ($oldfile,$newfile)) {
unlink($oldfile);
return TRUE;
}
return FALSE;
}
return TRUE;
}

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
