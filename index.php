<?php
/*-----------引入檔案區--------------*/
include_once "header.php";
$xoopsOption['template_main'] = "beck_iscore_index.tpl";
include_once XOOPS_ROOT_PATH . "/header.php";


/*-----------function區--------------*/

//顯示教師基本資料
function teacher_show($sn)
{
    global $xoopsTpl,$xoopsDB;

    $tbl = $xoopsDB->prefix('nzsmr_teacher');
    $sql="SELECT * FROM $tbl Where `sn`='{$sn}'";
    $result=$xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $teachers=$xoopsDB->fetchArray($result);//fetchrow

    $TadUpFiles=new TadUpFiles("beck_iscore","/teacher",$file="/file",$image="/image",$thumbs="/image/.thumbs");
    $TadUpFiles->set_col('sn',$sn);
    $teachers['cover'] = $TadUpFiles->show_files('pic',true,'',true,null,null,null,false);
    // $teachers['cover'] = $TadUpFiles->show_files('pic', true, '', true, null, null, null, true);

    $TadUpFiles->set_col('tea_attached',$sn);
    $teachers['files'] = $TadUpFiles->show_files();

    // die(var_dump($teachers));
    $xoopsTpl->assign('teachers', $teachers);
}

//顯示教師列表
function teacher_list()
{
    global $xoopsTpl;

    $main = "模組開發中";
    $xoopsTpl->assign('content', $main);
}

// 新增學生表單
function student_form($sn){
    global $xoopsTpl,$xoopsUser,$xoopsDB;

    if($sn){
        $students=array();
        $tbl      = $xoopsDB->prefix('nzsmr_student');
        $sql      = "SELECT * FROM $tbl Where `sn`='{$sn}'";
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $students = $xoopsDB->fetchArray($result);
    }
    // var_dump($students['arrival_date']);
    // var_dump(date("Y/m/d", strtotime($students['arrival_date'])));
    // die();

    // 載入xoops表單元件
    include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
    //建立表單
    $form = new XoopsThemeForm('新增學生', 'student_form', 'student.php', 'post', true , '摘要');

    //建立類別選項
    // $select   = new XoopsFormRadio('類別或主題', 'topic_sn', $topic_sn);
    // $options['1'] = '街巷故事';
    // $options['2'] = '市井觀點';
    // $options['3'] = '私房知識塾';
    // $select->addOptionArray($options);
    // $form->addElement($select);
    
    //學號
    $form->addElement(new XoopsFormText('學號', 'stu_sn', 30 , 65 , $students['stu_sn']), true);
    //學生姓名
    $form->addElement(new XoopsFormText('學生姓名', 'stu_name', 30 , 65 , $students['stu_name']), true);
    //入校日期
    $form->addElement(new XoopsFormDateTime('入校日期', 'arrival_date',15, strtotime($students['arrival_date']),false));
    //生日
    $form->addElement(new XoopsFormDateTime('生日', 'birthday',15,strtotime($students['birthday']),false));
    //身份證字號
    $form->addElement(new XoopsFormText('身份證字號', 'national_id', 30 , 65 , $students['national_id']), true);
    //原轉介單位
    $form->addElement(new XoopsFormText('原轉介單位', 'ori_referral', 30 , 65 , $students['ori_referral']), 0);
    //戶籍
    $form->addElement(new XoopsFormText('戶籍', 'domicile', 30 , 65 , $students['domicile']), 0);
    //族群類別
    $form->addElement(new XoopsFormText('族群類別', 'ethnic_group', 30 , 65 , $students['ethnic_group']), 0);
    //婚姻狀況
    $form->addElement(new XoopsFormText('婚姻狀況', 'marital', 30 , 65 , $students['marital']), 0);
    //身高
    $form->addElement(new XoopsFormText('身高', 'height', 30 , 65 , $students['height']), 0);
    //體重
    $form->addElement(new XoopsFormText('體重', 'weight', 30 , 65 , $students['weight']), 0);
    //低收入戶
    $form->addElement(new XoopsFormText('低收入戶', 'Low_income', 30 , 65 , $students['Low_income']), 0);
    //監護人身心障礙
    $form->addElement(new XoopsFormText('監護人身心障礙', 'guardian_disability', 30 , 65 , $students['guardian_disability']), 0);
    //轉介原因
    $form->addElement(new XoopsFormText('轉介原因', 'referral_reason', 30 , 65 , $students['referral_reason']), 0);
    //原學歷
    $form->addElement(new XoopsFormText('原學歷', 'original_education', 30 , 65 , $students['original_education']), 0);
    //原就學學校
    $form->addElement(new XoopsFormText('原就學學校', 'original_school', 30 , 65 , $students['original_school']), 0);
    //家庭概況
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/ck.php";
    $ck = new CKEditor("beck_iscore", "family_profile", $students['family_profile']);
    $ck->setToolbarSet('myBasic');
    $ck->setHeight(350);
    $form->addElement(new XoopsFormLabel('家庭概況', $ck->render()), true);
    //戶籍地址
    $form->addElement(new XoopsFormText('戶籍地址', 'residence_address', 30 , 65 , $students['residence_address']), 0);
    //居住地址
    $form->addElement(new XoopsFormText('居住地址', 'address', 30 , 65 , $students['address']), 0);
    //監護人1
    $form->addElement(new XoopsFormText('監護人1', 'guardian1', 30 , 65 , $students['guardian1']), 0);
    //監護人關係1
    $form->addElement(new XoopsFormText('監護人關係1', 'guardian_relationship1', 30 , 65 , $students['guardian_relationship1']), 0);
    //監護人手機1
    $form->addElement(new XoopsFormText('監護人手機1', 'guardian_cellphone1', 30 , 65 , $students['guardian_cellphone1']), 0);
    //監護人2
    $form->addElement(new XoopsFormText('監護人2', 'guardian2', 30 , 65 , $students['guardian2']), 0);
    //監護人關係2
    $form->addElement(new XoopsFormText('監護人關係2', 'guardian_relationship2', 30 , 65 , $students['guardian_relationship2']), 0);
    //監護人手機2
    $form->addElement(new XoopsFormText('監護人手機2', 'guardian_cellphone2', 30 , 65 , $students['guardian_cellphone2']), 0);
    //緊急聯絡人1
    $form->addElement(new XoopsFormText('緊急聯絡人1', 'emergency_contact1', 30 , 65 , $students['emergency_contact1']), 0);
    //緊急聯絡人關係1
    $form->addElement(new XoopsFormText('緊急聯絡人關係1', 'emergency_contact_rel1', 30 , 65 , $students['emergency_contact_rel1']), 0);
    //緊急聯絡人手機1
    $form->addElement(new XoopsFormText('緊急聯絡人手機1', 'emergency_cellphone1', 30 , 65 , $students['emergency_cellphone1']), 0);
    //緊急聯絡人2
    $form->addElement(new XoopsFormText('緊急聯絡人2', 'emergency_contact2', 30 , 65 , $students['emergency_contact2']), 0);
    //緊急聯絡人關係2
    $form->addElement(new XoopsFormText('緊急聯絡人關係2', 'emergency_contact_rel2', 30 , 65 , $students['emergency_contact_rel2']), 0);
    //緊急聯絡人手機2
    $form->addElement(new XoopsFormText('緊急聯絡人手機2', 'emergency_cellphone2', 30 , 65 , $students['emergency_cellphone2']), 0);
    //建立學生排序欄位
    $form->addElement(new XoopsFormText('學生排序', 'sort', 30 , 3 , $students['sort']), 0);

    
    //精選（是否選單）
    $form->addElement(new XoopsFormRadioYN('精選', 'focus', 1));
    //作者輸入框
    $username = ($sn) ? $students['stu_name'] : $xoopsUser->name();
    $form->addElement(new XoopsFormText('作者', 'username', 60, 100, $username));

    //上傳表單（enctype='multipart/form-data'）
    $form->setExtra("enctype='multipart/form-data'");
    $TadUpFiles=new TadUpFiles("beck_iscore","/student",$file="/file",$image="/image",$thumbs="/image/.thumbs");
    //$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");設定子目錄，比較進階的應用
    //$TadUpFiles->set_var('require', true);  //必填
    //$TadUpFiles->set_var("show_tip", false); //不顯示提示
    $TadUpFiles->set_col('sn',$sn); //若 $show_list_del_file ==true 時一定要有，設定綁定的欄位名稱及編號
    $upform=$TadUpFiles->upform(true,'stu_pic',null,true,'.jpg,.png');//show_edit秀出編輯工具，upname上傳的欄位要叫什麼，maxlength最多可上傳幾個檔，$show_list_del_file ==true 要不要顯示刪除工具，only_type限製格式，thumb縮圖
    $form->addElement(new XoopsFormLabel('學生大頭照', $upform));


    //上傳附檔
    $TadUpFiles->set_col('stu_file',$sn); //若 $show_list_del_file ==true 時一定要有
    $upform=$TadUpFiles->upform(true,'stu_file');
    $form->addElement(new XoopsFormLabel('附檔', $upform));


    //使用者編號
    if ($sn) {
        $uid = $_SESSION['beck_iscore_adm'] ? $students['uid'] : $xoopsUser->uid();
    } else {
        $uid = $xoopsUser->uid();
    }
    // var_dump($uid);die();
    $form->addElement(new XoopsFormHidden('uid', $uid));
    //下個動作
    if ($sn) {
        $form->addElement(new XoopsFormHidden('op', 'student_update'));
        $form->addElement(new XoopsFormHidden('sn', $sn));
    } else {
        $form->addElement(new XoopsFormHidden('op', 'student_insert'));
    }
    //儲存按鈕
    $form->addElement(new XoopsFormButton('', '', '儲存', 'submit'));
    //產生程式碼
    $student_form=$form->render();
    //將表單送到樣板
    $xoopsTpl->assign('student_form', $student_form);

}

function student_insert(){

    global $xoopsDB;
    // var_dump($_POST);
    //安全判斷 儲存 更新都要做
    if (!$GLOBALS['xoopsSecurity']->check()) {
        $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
        throw new Exception($error);
    }
    
    $myts = MyTextSanitizer::getInstance();
    foreach ($_POST as $key => $value) {
        $$key = $myts->addSlashes($value);
        echo "<p>\${$key}={$$key}</p>";
    }
    // 過濾到校日期、生日
    if (validateDate($_POST['arrival_date']['date'],$format = 'Y/m/d')){
        $arrival_date=$_POST['arrival_date']['date'];
    }else{
        echo('到校日期錯誤');
    }
    if (validateDate($_POST['birthday']['date'], $format = 'Y/m/d')){
        $birthday=$_POST['birthday']['date'];
    }else{
        echo('生日錯誤');
    }
    // echo "<p>\$arrival_date={$arrival_date}</p>";
    // echo "<p>\$birthday={$birthday}</p>";
    // die();

    $tbl = $xoopsDB->prefix('nzsmr_student');
    $sql = "insert into `$tbl` (
        `stu_sn                `,`stu_name              `,`arrival_date          `,`birthday              `,`national_id           `,`ori_referral          `,`domicile              `,`ethnic_group          `,`marital               `,`height                `,`weight                `,`Low_income            `,`guardian_disability   `,`referral_reason       `,`original_education    `,`original_school       `,`family_profile        `,`residence_address     `,`address               `,`guardian1             `,`guardian_relationship1`,`guardian_cellphone1   `,`guardian2             `,`guardian_relationship2`,`guardian_cellphone2   `,`emergency_contact1    `,`emergency_contact_rel1`,`emergency_cellphone1  `,`emergency_contact2    `,`emergency_contact_rel2`,`emergency_cellphone2  `,`sort                  `,`uid`                   ,
        `create_time`           ,`update_time`) 
        values('{$stu_sn}','{$stu_name}','{$arrival_date}','{$birthday}','{$national_id}','{$ori_referral}','{$domicile}','{$ethnic_group}','{$marital}','{$height}','{$weight}','{$Low_income}','{$guardian_disability}','{$referral_reason}','{$original_education}','{$original_school}','{$family_profile}','{$residence_address}','{$address}','{$guardian1}','{$guardian_relationship1}','{$guardian_cellphone1}','{$guardian2}','{$guardian_relationship2}','{$guardian_cellphone2}','{$emergency_contact1}','{$emergency_contact_rel1}','{$emergency_cellphone1}','{$emergency_contact2}','{$emergency_contact_rel2}','{$emergency_cellphone2}','{$sort}','{$uid}',now(), now())";

    $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $sn = $xoopsDB->getInsertId(); //取得最後新增的編號

    //上傳表單（enctype='multipart/form-data'）
    $TadUpFiles=new TadUpFiles("beck_iscore","/student",$file="/file",$image="/image",$thumbs="/image/.thumbs");
    // 圖檔儲存
    $TadUpFiles->set_col('sn',$sn);
    $TadUpFiles->upload_file('stu_pic',1920,640,null,$stu_name,true,false,null, 'png;jpg');
    // 上傳附檔
    $TadUpFiles->set_col('stu_file',$sn);
    $TadUpFiles->upload_file('stu_file',1920,640,null,null,true);

    return $sn;
    // die(var_dump($_POST));
}

function student_update($sn){

    global $xoopsDB;
    // var_dump($_POST);die();  
    //安全判斷 儲存 更新都要做
    if (!$GLOBALS['xoopsSecurity']->check()) {
        $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
        throw new Exception($error);
    }
    
    $myts = MyTextSanitizer::getInstance();
    foreach ($_POST as $key => $value) {
        $$key = $myts->addSlashes($value);
        echo "<p>\${$key}={$$key}</p>";
    }
    // 過濾到校日期、生日
    if (validateDate($_POST['arrival_date']['date'],$format = 'Y/m/d')){
        $arrival_date=$_POST['arrival_date']['date'];
    }else{
        echo('到校日期錯誤');
    }
    if (validateDate($_POST['birthday']['date'], $format = 'Y/m/d')){
        $birthday=$_POST['birthday']['date'];
    }else{
        echo('生日錯誤');
    }
    // echo "<p>\$arrival_date={$arrival_date}</p>";
    // echo "<p>\$birthday={$birthday}</p>";
    // die();

    $tbl = $xoopsDB->prefix('nzsmr_student');
    $sql = "update `$tbl` set 
        `stu_sn`   = '{$stu_sn}',   `stu_name`     = '{$stu_name}',     `arrival_date` = '{$arrival_date}',
        `birthday` = '{$birthday}', `national_id`  = '{$national_id}',  `ori_referral` = '{$ori_referral}',
        `domicile` = '{$domicile}', `ethnic_group` = '{$ethnic_group}', `marital`      = '{$marital}',
        `height`   = '{$height}',   `weight`       = '{$weight}',       `Low_income`   = '{$Low_income}',
        `guardian_disability` = '{$guardian_disability}', `referral_reason`   = '{$referral_reason}',
        `original_education`  = '{$original_education}',  `original_school`   = '{$original_school}',
        `family_profile`      = '{$family_profile}',      `residence_address` = '{$residence_address}',
        `address` = '{$address}', `guardian1`='{$guardian1}', `guardian_relationship1`='{$guardian_relationship1}', 
        `guardian_cellphone1`    = '{$guardian_cellphone1}',    `guardian2`              = '{$guardian2}',
        `guardian_relationship2` = '{$guardian_cellphone2}',    `guardian_cellphone2`    = '{$guardian_relationship2}',
        `emergency_contact1`     = '{$emergency_contact1}',     `emergency_contact_rel1` = '{$emergency_contact_rel1}',
        `emergency_cellphone1`   = '{$emergency_cellphone1}',   `emergency_contact2`     = '{$emergency_contact2}',
        `emergency_contact_rel2` = '{$emergency_contact_rel2}', `emergency_cellphone2`   = '{$emergency_cellphone2}',
        `uid` = '{$uid}', `update_time` = now()
        where `sn`   = '{$sn}'";

    // echo($sql);
    // die();

    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    //上傳表單（enctype='multipart/form-data'）
    $TadUpFiles=new TadUpFiles("beck_iscore","/student",$file="/file",$image="/image",$thumbs="/image/.thumbs");
    // 圖檔儲存
    $TadUpFiles->set_col('sn',$sn);
    $TadUpFiles->upload_file('stu_pic',1920,640,null,$stu_name,true,false,null, 'png;jpg');
    // 上傳附檔
    $TadUpFiles->set_col('stu_file',$sn);
    $TadUpFiles->upload_file('stu_file',1920,640,null,null,true);

    return $sn;
    // die(var_dump($_POST));


}

function student_show($sn){
    global $xoopsTpl,$xoopsDB;

    $myts = MyTextSanitizer::getInstance();

    $tbl      = $xoopsDB->prefix('nzsmr_student');
    $sql      = "SELECT * FROM $tbl Where `sn`='{$sn}'";
    $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $students = $xoopsDB->fetchArray($result);//fetchrow

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
    $TadUpFiles->set_col('sn',$sn);
    $students['cover'] = $TadUpFiles->show_files('stu_pic',false);

    $TadUpFiles->set_col('stu_file',$sn);
    $students['files'] = $TadUpFiles->show_files();

    // die(var_dump($students));
    $xoopsTpl->assign('students', $students);

    if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php")) {
        redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
    }
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php";
    $sweet_alert = new sweet_alert();
    $sweet_alert->render("studnet_del", "index.php?op=student_delete&sn=", 'sn');

}
function student_list(){
    global $xoopsTpl,$xoopsDB;

    $myts = MyTextSanitizer::getInstance();

    $tbl      = $xoopsDB->prefix('nzsmr_student');
    $sql      = "SELECT * FROM $tbl ORDER BY `sn` DESC";
    
    //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
    $PageBar = getPageBar($sql, 4, 10);
    $bar     = $PageBar['bar'];
    $sql     = $PageBar['sql'];
    $total   = $PageBar['total'];

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
        $students['cover'] = $TadUpFiles->get_pic_file('thumb','url',$files_sn);

        $all[]=$students;
    }

    // die(var_dump($all));
    $xoopsTpl->assign('all', $all);
    $xoopsTpl->assign('bar', $bar);
    $xoopsTpl->assign('total', $total);
}

function student_delete($sn){
    global $xoopsTpl, $xoopsDB;
    $TadUpFiles=new TadUpFiles("beck_iscore","/student",$file="/file",$image="/image",$thumbs="/image/.thumbs");

    $tbl = $xoopsDB->prefix('nzsmr_student');
    $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
    // echo($sql);die();
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $TadUpFiles->set_col('sn', $sn);
    $TadUpFiles->del_files();

    $TadUpFiles->set_col('stu_file', $sn);
    $TadUpFiles->del_files();

}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$sn = system_CleanVars($_REQUEST, 'sn', 0, 'int');
$TadUpFiles=new TadUpFiles("beck_iscore","/student",$file="/file",$image="/image",$thumbs="/image/.thumbs");

switch ($op) {

    case "student_form":
        student_form($sn);
        break;//跳出迴圈,往下執行

    case "student_insert":
        $sn=student_insert();
        header("location:../index.php?sn={$sn}&op=student_show");
        exit;//離開，下面不做
    
    case "student_update":
        student_update($sn);
        header("location: ../index.php?sn={$sn}&op=student_show");
        // header("location:{$_SERVER['PHP_SELF']}");
        exit;

    case "student_show":
        if($sn){
            student_show($sn);
        }else{
            student_list();
            $op="student_list";
        }
        break;

    //下載檔案
    case "tufdl":
        $files_sn=isset($_GET['files_sn'])?intval($_GET['files_sn']):"";
        $TadUpFiles->add_file_counter($files_sn,false,true);
        exit;

    case "student_delete":
        student_delete($sn);
        header("location: index.php");
        exit;
    
    default:
        if($sn){
            teacher_show($sn);
            $op="teacher_show";
        }else{
            // teacher_list();
            // $op="teacher_list";
            student_list();
            $op="student_list";
        }
        break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', $op);
$xoopsTpl->assign("toolbar", toolbar_bootstrap($interface_menu));

include_once XOOPS_ROOT_PATH . '/footer.php';
