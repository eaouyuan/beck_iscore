<?php
use XoopsModules\Tadtools\Utility;

//其他自訂的共同的函數
if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php")) {
    redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50", 3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php";
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;


// 取得使用者資料
function users_data($uid){
    global $xoopsDB;
    $tbl      = $xoopsDB->prefix('users');
    $sql      = "SELECT `uid`,`name`,`uname`,`email` FROM $tbl Where `uid`='{$uid}'";
    $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $user = $xoopsDB->fetchArray($result);//fetchrow
    // var_dump($user);die();
    return $user;

}


function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

function mk_html($sn)
{
    global $xoopsDB;
    $myts = MyTextSanitizer::getInstance();

    $tbl      = $xoopsDB->prefix('yy_student');
    $sql      = "SELECT * FROM $tbl Where `sn`='{$sn}'";
    $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $students = $xoopsDB->fetchArray($result);//fetchrow

    $students['stu_sn']                 = $myts->htmlSpecialChars($students['stu_sn']);
    $students['stu_name']               = $myts->htmlSpecialChars($students['stu_name']);
    $students['arrival_date']           = $myts->htmlSpecialChars($students['arrival_date']);
    $students['family_profile']         = $myts->displayTarea($students['family_profile'], 1, 0, 0, 0, 0);

    $content= "<h1>a{$students['stu_sn']}</h1>";
    $content.= "<h1>a{$students['stu_name']}</h1>";
    $content.= "<p>a{$students['family_profile']}</p>";
    $html= html5($content);



    $dir=XOOPS_ROOT_PATH."/uploads/beck_iscore/student/html";
    mk_dir($dir);


    // 寫入檔案
    file_put_contents(XOOPS_ROOT_PATH."/uploads/beck_iscore/student/html/{$sn}.html",$html);
    return $html;
}
 

function mk_json($sn)
{
    global $xoopsDB, $TadUpFiles;

    $myts = MyTextSanitizer::getInstance();

    $tbl       = $xoopsDB->prefix('snews');
    $sql       = "SELECT * FROM `$tbl` where `focus`=1 ORDER BY `update_time` DESC";
    $result    = $xoopsDB->query($sql) or web_error($sql);
    $all_focus = array();
    while ($snews = $xoopsDB->fetchArray($result)) {
        $content          = str_replace(array("\n", "\r"), '', strip_tags($snews['content']));
        $snews['content'] = word_cut($content, 600);
        $snews['summary'] = word_cut($content, 40);

        $snews['title'] = $myts->htmlSpecialChars($snews['title']);
        $TadUpFiles->set_col('sn', $snews['sn']);
        $snews['cover'] = $TadUpFiles->get_pic_file();
        $all_focus[]    = $snews;
    }

    $json = json_encode($all_focus, JSON_UNESCAPED_UNICODE);

    file_put_contents(XOOPS_ROOT_PATH . "/uploads/snews/focus.json", $json);
    return $html;
}


// 如果有權限，傳到樣版判斷顯示刪除、修改
// if(power_chk("beck_iscore", "1")){
//     $xoopsTpl->assign('student_post', true);
// }
// if(power_chk("beck_iscore", "2")){
//     $xoopsTpl->assign('student_delete', true);
// }
// if(power_chk("read", "1")){$xoopsTpl->assign('', true);}

//取得目前使用者的群組編號
// if (!isset($_SESSION['groups']) or $_SESSION['groups'] === '') {
//     $_SESSION['groups'] = ($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
// }
// var_dump($_SESSION['groups']);


//         http://localhost/beck_iscore/index.php?op=announcement_class_list
// http://localhost/modules/beck_iscore/index.php?op=announcement_class_list
// a1234567




//上傳附檔
// $TadUpFiles=new TadUpFiles("beck_iscore","/student",$file="/file",$image="/image",$thumbs="/image/.thumbs");
// $TadUpFiles->set_col('stu_file',$sn); //若 $show_list_del_file ==true 時一定要有
// $upform=$TadUpFiles->upform(true,'stu_file');
// $form->addElement(new XoopsFormLabel('附檔', $upform));



    // $ann_class_id = $myts->htmlSpecialChars($_POST['ann_c']);
// $dept_id      = $myts->htmlSpecialChars($_POST['dept_c']);
// $title        = $myts->htmlSpecialChars($_POST['title']);
// $content      = $myts->displayTarea($_POST['content'], 1, 0, 0, 0, 0);
// // 過濾到期日
// if (validateDate($_POST['end_date'],$format = 'Y-m-d')){
//     $end_date=$_POST['end_date'];
// }else{
//     echo('公告到期日錯誤');
// }
// $top       = $myts->htmlSpecialChars($_POST['top']);
// $uid       = $myts->htmlSpecialChars($_POST['uid']);
// echo "<p>\$ann_class_id={$ann_class_id}</p>";
// echo "<p>\$dept_id={$dept_id}</p>";
// echo "<p>\$title={$title}</p>";
// echo "<p>\$content={$content}</p>";
// echo "<p>\$end_date={$end_date}</p>";
// echo "<p>\$top={$top}</p>";
// die();