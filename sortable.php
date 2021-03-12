<?php
use Xmf\Request;
/*-----------引入檔案區--------------*/
include_once "header.php";
$xoopsOption['template_main'] = "beck_iscore_index.tpl";
include_once XOOPS_ROOT_PATH . "/header.php";


function student_list(){
    global $xoopsTpl,$xoopsDB,$xoopsModuleConfig;

    $myts = MyTextSanitizer::getInstance();

    $tbl      = $xoopsDB->prefix('yy_student');
    $sql      = "SELECT * FROM $tbl ORDER BY `sort` , `sn` DESC";
    
    //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
    // $PageBar = getPageBar($sql, $xoopsModuleConfig['show_num'], 10);
    // $bar     = $PageBar['bar'];
    // $sql     = $PageBar['sql'];
    // $total   = $PageBar['total'];

    $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $all      = array();
    while($students = $xoopsDB->fetchArray($result)){
        $students['stu_sn']                 = $myts->htmlSpecialChars($students['stu_sn']);
        $students['stu_name']               = $myts->htmlSpecialChars($students['stu_name']);
        $students['arrival_date']           = $myts->htmlSpecialChars($students['arrival_date']);
        $students['birthday']               = $myts->htmlSpecialChars($students['birthday']);
        $students['national_id']            = $myts->htmlSpecialChars($students['national_id']);
        $students['ori_referral']           = $myts->htmlSpecialChars($students['ori_referral']);
        $students['domicile']               = $myts->htmlSpecialChars($students['domicile']);
        $students['ethnic_group']           = $myts->htmlSpecialChars($students['ethnic_group']);
        $students['marital']                = $myts->htmlSpecialChars($students['marital']);
        $students['height']                 = $myts->htmlSpecialChars($students['height']);
        $students['weight']                 = $myts->htmlSpecialChars($students['weight']);
        $students['Low_income']             = $myts->htmlSpecialChars($students['Low_income']);
        $students['guardian_disability']    = $myts->htmlSpecialChars($students['guardian_disability']);
        $students['referral_reason']        = $myts->htmlSpecialChars($students['referral_reason']);
        $students['original_education']     = $myts->htmlSpecialChars($students['original_education']);
        $students['original_school']        = $myts->htmlSpecialChars($students['original_school']);
        $students['family_profile']         = $myts->displayTarea($students['family_profile'], 1, 0, 0, 0, 0);
        $students['residence_address']      = $myts->htmlSpecialChars($students['residence_address']);
        $students['address']                = $myts->htmlSpecialChars($students['address']);
        $students['guardian1']              = $myts->htmlSpecialChars($students['guardian1']);
        $students['guardian_relationship1'] = $myts->htmlSpecialChars($students['guardian_relationship1']);
        $students['guardian_cellphone1']    = $myts->htmlSpecialChars($students['guardian_cellphone1']);
        $students['guardian2']              = $myts->htmlSpecialChars($students['guardian2']);
        $students['guardian_relationship2'] = $myts->htmlSpecialChars($students['guardian_relationship2']);
        $students['guardian_cellphone2']    = $myts->htmlSpecialChars($students['guardian_cellphone2']);
        $students['emergency_contact1']     = $myts->htmlSpecialChars($students['emergency_contact1']);
        $students['emergency_contact_rel1'] = $myts->htmlSpecialChars($students['emergency_contact_rel1']);
        $students['emergency_cellphone1']   = $myts->htmlSpecialChars($students['emergency_cellphone1']);
        $students['emergency_contact2']     = $myts->htmlSpecialChars($students['emergency_contact2']);
        $students['emergency_contact_rel2'] = $myts->htmlSpecialChars($students['emergency_contact_rel2']);
        $students['emergency_cellphone2']   = $myts->htmlSpecialChars($students['emergency_cellphone2']);
        $students['sort']                   = $myts->htmlSpecialChars($students['sort']);
        // 顯示上次上傳的圖片
        $TadUpFiles=new TadUpFiles("beck_iscore","/student",$file="/file",$image="/image",$thumbs="/image/.thumbs");
        $TadUpFiles->set_col('sn',$students['sn']);
        //取得單一圖片 1$kind=images（大圖）/thumb（小圖）/file（檔案）,2$kind="url"/"dir",3$file_sn,4$hash(加密)
        $students['cover'] = $TadUpFiles->get_pic_file('thumb');

        $all[]=$students;
    }

    // die(var_dump($all));
    $xoopsTpl->assign('all', $all);
    // $xoopsTpl->assign('bar', $bar);
    // $xoopsTpl->assign('total', $total);
}



/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = Request::getString('op');
$sn = Request::getInt('sn');
$TadUpFiles=new TadUpFiles("beck_iscore","/student",$file="/file",$image="/image",$thumbs="/image/.thumbs");
// die(var_dump($_SESSION));
// die(var_dump($xoopsUser));
student_list();
$op="student_sortable";
get_jquery(true);




/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', $op);
// $xoopsTpl->assign("toolbar", toolbar_bootstrap($interface_menu));

include_once XOOPS_ROOT_PATH . '/footer.php';
