<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Beck_iscore\SchoolSet;
use XoopsModules\Beck_iscore\Dept_school;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\BootstrapTable;


/*-----------引入檔案區--------------*/
include_once "header.php";
$xoopsOption['template_main'] = "beck_iscore_index.tpl";
include_once XOOPS_ROOT_PATH . "/header.php";

global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;

$sdate_time='2022-01-03 03:30';
// $edate_time=['2022-01-03 02:30'];
$edate_time=['2022-01-03 05:45','2022-01-03 08:30','2022-01-03 12:00','2022-01-03 16:30','2022-01-03 18:45','2022-01-04 00:00','2022-01-04 02:00','2022-01-04 08:30','2022-01-04 12:00','2022-01-04 16:30','2022-01-04 18:00','2022-01-05 00:00','2022-01-05 02:00','2022-01-05 08:30','2022-01-05 12:00','2022-01-05 16:30','2022-01-05 18:00','2022-01-06 00:00'];
// $edate_time=['2022-01-03 05:45','2022-01-03 08:30','2022-01-03 12:00','2022-01-03 16:30','2022-01-03 18:45','2022-01-04 00:00','2022-01-04 02:00','2022-01-04 08:30','2022-01-04 12:00','2022-01-04 16:30','2022-01-04 18:00','2022-01-05 00:00','2022-01-05 02:00','2022-01-05 08:30','2022-01-05 12:00','2022-01-05 16:30','2022-01-05 18:00','2022-01-06 00:00'];
// echo('asdfas');
$op='btable';
$xoopsTpl->assign('now_op', $op);
include_once XOOPS_ROOT_PATH . '/footer.php';
// $xoopsTpl->display('db:beck_iscore_index.tpl');
// $xoopsTpl->display('db:' . $GLOBALS['xoopsOption']['template_main']);

// foreach($edate_time as $v){
    // var_dump($v);
    // testdate2($sdate_time,'2022-01-05 16:45');
    // testdate2($sdate_time,$v);
// }

function student_list($pars=[],$g2p=''){
    global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
    if (!$xoopsUser) {
        redirect_header('index.php', 3, '無 student_list 權限! error:210420115');
    } 
    if(power_chk("beck_iscore", "1")){
        $xoopsTpl->assign('can_edit', true);
    } 

    // var_dump($_SESSION);die();
    $myts = MyTextSanitizer::getInstance();

    $tb1      = $xoopsDB->prefix('yy_student');
    $tb2      = $xoopsDB->prefix('yy_class');
    $tb3      = $xoopsDB->prefix('yy_department');
    $tb4      = $xoopsDB->prefix('users');
    $sql      = "SELECT  st.* , cl.class_name , cl.class_status, cl.tutor_sn,
                        de.dep_name , de.dep_status , ur.name as tutor_name
                FROM $tb1 as st 
                    LEFT JOIN $tb2 as cl ON st.class_id=cl.sn
                    LEFT JOIN $tb3 as de ON st.major_id=de.sn
                    LEFT JOIN $tb4 as ur ON cl.tutor_sn=ur.uid
                    " ;

    if($pars['status']!=''){
        $sql.=" WHERE status='{$pars['status']}'";
        // $have_par='1';
    }else{
        $sql.=" WHERE status != '2'";
    }
    if($pars['major_id']!=''){
        // if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
        $sql.=" AND `major_id`='{$pars['major_id']}'";
        // $have_par='1';
    }
    if(!empty($pars['search'])){
        // if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
        $sql.=" AND (`stu_name` like '%{$pars['search']}%')";
        // $have_par='1';
    }
    // if($have_par=='1'){$sql.=" AND status != '2'";}else{$sql.=" WHERE status != '2'";};
    $sql.=" ORDER BY `major_id` ,`stu_id` ,`stu_no` DESC";
    // echo($sql);  die();

    //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
    $PageBar = getPageBar($sql, 30, 10);
    $bar     = $PageBar['bar'];
    $sql     = $PageBar['sql'];
    $total   = $PageBar['total'];

    $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $all      = array();

    if($g2p=='' OR $g2p=='1'){$i=1;}else{$i=($g2p-1)*30+1;}
    $SchoolSet= new SchoolSet;

    while($stu= $xoopsDB->fetchArray($result)){
        $stu['i']              = $i;
        $stu['stu_id']          = $myts->htmlSpecialChars($stu['stu_id']);           //學號
        $stu['stu_name']        = $myts->htmlSpecialChars($stu['stu_name']);         //姓名
        $stu['birthday']        = $myts->htmlSpecialChars($stu['birthday']);
        $stu['class_name']      = $myts->htmlSpecialChars($stu['class_name']);
        $stu['dep_name']        = $myts->htmlSpecialChars($stu['dep_name']);
        $stu['tutor_name']      = $myts->htmlSpecialChars($stu['tutor_name']);
        $stu['social_id']       = $myts->htmlSpecialChars($SchoolSet->uid2name[$stu['social_id']]);        //社工
        $stu['guidance_id']     = $myts->htmlSpecialChars($SchoolSet->uid2name[$stu['guidance_id']]);      //輔導老師
        $stu['rcv_guidance_id'] = $myts->htmlSpecialChars($SchoolSet->uid2name[$stu['rcv_guidance_id']]);  //認輔教師
        $all []            = $stu;
        $i++;
    }
    // var_dump($all);die();

    // 目前狀況
    $status_ary=['0'=>'逾假逃跑','1'=>'在校','2'=>'回歸/結案'] ;
    $status_htm=Get_select_opt_htm($status_ary,$pars['status'],'1');
    $xoopsTpl->assign('status_htm', $status_htm);

    // 學程列表
    $major_name=[];
    foreach ($SchoolSet->dept as $k=>$v){
        $major_name[$v['sn']]=$v['dep_name'];
    }
    $major_htm=Get_select_opt_htm($major_name,$pars['major_id'],'1');
    $xoopsTpl->assign('major_htm', $major_htm);

    // 關鍵字傳到樣版
    $parameter['search'] = (!isset($pars['search'])) ? '' : $pars['search'];
    $xoopsTpl->assign('search', $pars['search']);

    $xoopsTpl->assign('all', $all);
    $xoopsTpl->assign('bar', $bar);
    $xoopsTpl->assign('total', $total);

    $SweetAlert = new SweetAlert();
    $SweetAlert->render('stu_del', XOOPS_URL . "/modules/beck_iscore/tchstu_mag.php?op=student_delete&sn=", 'sn','確定要刪除學生基本資料','學生基本資料刪除。');

    // 載入xoops表單元件
    include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
    $token =new XoopsFormHiddenToken('XOOPS_TOKEN',3000);
    $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    $xoopsTpl->assign('op', "student_list");

}