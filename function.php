<?php
use XoopsModules\Tadtools\Utility;

//其他自訂的共同的函數
if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php")) {
    redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50", 3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php";

require_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;

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