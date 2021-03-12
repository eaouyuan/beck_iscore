<?php

use XoopsModules\Tadtools\Utility;

/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "beck_iscore_adm_teacher.tpl";
include_once "header.php";
include_once "../function.php";

/*-----------function區--------------*/

//顯示預設頁面內容
function teacher_list()
{
    global $xoopsTpl;
    $main = "教師管理";
    $xoopsTpl->assign('content', $main);
}




// 新增教師表單
function teacher_form()
{
    global $xoopsTpl,$xoopsUser;
    // 載入xoops表單元件
    include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
    //建立表單
    $form = new XoopsThemeForm('編輯教師', 'teacher_form', 'teacher.php', 'post', true , '摘要');

    //建立類別選項
    // var_dump($topic_sn);die();
    $select   = new XoopsFormRadio('類別或主題', 'topic_sn', $topic_sn);
    $options['1'] = '街巷故事';
    $options['2'] = '市井觀點';
    $options['3'] = '私房知識塾';
    $select->addOptionArray($options);
    $form->addElement($select);
    //建立教師姓名欄位
    $form->addElement(new XoopsFormText('教師姓名', 'tea_name', 30 , 65 , $tea_name), true);
    //建立教師排序欄位
    $form->addElement(new XoopsFormText('教師排序', 'sort', 30 , 3 , $sort), true);
    //所見即所得編輯器
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/ck.php";
    $ck = new CKEditor("beck_iscore", "content", $content);
    $ck->setToolbarSet('myBasic');
    $ck->setHeight(250);
    $form->addElement(new XoopsFormLabel('文章內容', $ck->render()), true);
    //精選（是否選單）
    $form->addElement(new XoopsFormRadioYN('精選', 'focus', 1));
    //作者輸入框
    $username = $xoopsUser->name();
    $form->addElement(new XoopsFormText('作者', 'username', 60, 100, $username));

    //上傳表單（enctype='multipart/form-data'）
    $TadUpFiles=new TadUpFiles("beck_iscore","/teacher",$file="/file",$image="/image",$thumbs="/image/.thumbs");
    $form->setExtra("enctype='multipart/form-data'");
    //$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
    //$TadUpFiles->set_var('require', true);  //必填
    //$TadUpFiles->set_var("show_tip", false); //不顯示提示
    $TadUpFiles->set_col('sn',$sn); //若 $show_list_del_file ==true 時一定要有
    $upform=$TadUpFiles->upform(true,'pic',null,true,'jpg;png',$thumb);//show_edit秀出編輯工具，upname上傳的欄位要叫什麼，maxlength最多可上傳幾個檔，$show_list_del_file ==true 要不要顯示刪除工具，only_type限製格式，thumb縮圖
    $form->addElement(new XoopsFormLabel('封面圖', $upform));


    //上傳附檔
    $TadUpFiles->set_col('tea_attached',$sn); //若 $show_list_del_file ==true 時一定要有
    $upform=$TadUpFiles->upform(true,'tea_attached');
    $form->addElement(new XoopsFormLabel('附檔', $upform));



    //使用者編號
    $uid = $xoopsUser->uid();
    // var_dump($uid);die();
    $form->addElement(new XoopsFormHidden('uid', $uid));
    //下個動作
    $form->addElement(new XoopsFormHidden('op', 'teacher_insert'));
    //儲存按鈕
    $form->addElement(new XoopsFormButton('', '', '儲存', 'submit'));
    //產生程式碼
    $teacher_form=$form->render();
    //將表單送到樣板
    $xoopsTpl->assign('teacher_form', $teacher_form);

}

function teacher_insert(){
    global $xoopsDB;

    $myts = MyTextSanitizer::getInstance();
    foreach ($_POST as $key => $value) {
        $$key = $myts->addSlashes($value);
        echo "<p>\${$key}={$$key}</p>";
    }

    $tbl = $xoopsDB->prefix('nzsmr_teacher');
    $sql = "insert into `$tbl` (`sort`,`tea_name`,`uid`,`create_time`, `update_time`) values('{$sort}', '{$tea_name}', '{$uid}',  now(), now())";
    $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $sn = $xoopsDB->getInsertId(); //取得最後新增的編號

    //上傳表單（enctype='multipart/form-data'）
    $TadUpFiles=new TadUpFiles("beck_iscore","/teacher",$file="/file",$image="/image",$thumbs="/image/.thumbs");
    $TadUpFiles->set_col('sn',$sn);
    $TadUpFiles->upload_file('pic',1920,640,null,$tea_name,true,false);

    $TadUpFiles->set_col('tea_attached',$sn);
    $TadUpFiles->upload_file('tea_attached');

    return $sn;
    // die(var_dump($_POST));


}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = Request::getString('op');



switch ($op) {

    // case "xxx":
    // xxx();
    // header("location:{$_SERVER['PHP_SELF']}");
    // exit;
    
    case "teacher_form":
        teacher_form();
        break;

    case "teacher_insert":
        $sn=teacher_insert();
        header("location:../index.php?sn={$sn}");
        exit;
    
    default:
        teacher_list();
        $op = 'teacher_list';
        break;

}

$xoopsTpl->assign('now_op', $op);
include_once 'footer.php';
