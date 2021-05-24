<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Beck_iscore\SchoolSet;
use XoopsModules\Beck_iscore\Dept_school;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\SweetAlert;


/*-----------引入檔案區--------------*/
include_once "header.php";
$xoopsOption['template_main'] = "beck_iscore_index.tpl";
include_once XOOPS_ROOT_PATH . "/header.php";


/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = Request::getString('op');
$sn = Request::getInt('sn');

$stu_list['status']   = Request::getString('status');
$stu_list['major_id'] = Request::getString('major_id');
$stu_list['search']   = Request::getString('search');
$g2p=Request::getInt('g2p');
$cos['cos_year'] = Request::getString('cos_year');
$cos['cos_term'] = Request::getString('cos_term');
$cos['dep_id']   = Request::getString('dep_id');
$uscore['dep_id']      = Request::getString('dep_id');
$uscore['course_id']   = Request::getString('course_id');
$uscore['exam_stage']  = Request::getString('exam_stage');
$uscore['exam_number'] = Request::getString('exam_number');
// $student_sn  = Request::getArray('student_sn');//學生編號=>平時成績
// $year        = Request::getString('year');
// $term        = Request::getString('term');
// $dep_id      = Request::getInt('dep_id');
// $course_id   = Request::getInt('course_id');
// $exam_stage  = Request::getInt('exam_stage');
// $exam_number = Request::getInt('exam_number');
// $update_user = Request::getString('update_user');

// die(var_dump($_POST));
// die(var_dump($_GET));
// die(var_dump($_REQUEST));
// die(var_dump($_SESSION));
// var_dump($uscore);die();

switch ($op) {
//學生 管理
    case "student_list":
        student_list($stu_list,$g2p);
        break;//跳出迴圈,往下執行
    
    // 新增、編輯 學生
    case "student_form":
        student_form($sn);
        break;//跳出迴圈,往下執行

    // 新增 學生
    case "student_insert":
        student_insert();
        header("location:tchstu_mag.php?op=student_list");
        exit;//離開，結束程式

    // 更新 學生
    case "student_update":
        student_update($sn);
        header("location:tchstu_mag.php?op=student_list");
        exit;

    // 刪除 學生
    case "student_delete":
        student_delete($sn);
        header("location:tchstu_mag.php?op=student_list");
        exit;

//課程 管理
    //課程 列表
    case "course_list":
        course_list($cos,$g2p);
        break;//跳出迴圈,往下執行
    // 課程 表單
    case "course_form":
        course_form($sn);
        break;//跳出迴圈,往下執行

    // 新增 課程
    case "course_insert":
        $re=course_insert();
        header("location:tchstu_mag.php?op=course_list&cos_year={$re['cos_year']}&cos_term={$re['cos_term']}&dep_id={$re['dep_id']}");
        exit;//離開，結束程式

    // 更新 課程
    case "course_update":
        $re=course_update($sn);
        header("location:tchstu_mag.php?op=course_list&cos_year={$re['cos_year']}&cos_term={$re['cos_term']}&dep_id={$re['dep_id']}");
        exit;
    // 刪除 課程
    case "course_delete":
        $re=course_delete($sn);
        header("location:tchstu_mag.php?op=course_list&cos_year={$re['cos_year']}&cos_term={$re['cos_term']}&dep_id={$re['dep_id']}");
        exit;
//平時成績 管理
    //平時成績 列表
    case "usual_score_list":
        usual_score_list($uscore);
        break;//跳出迴圈,往下執行
    // 表單 平時成績
    case "usual_score_form":
        usual_score_form($uscore);
        break;//跳出迴圈,往下執行

    // 新增、更新 平時成績
    case "usual_score_insert":
        usual_score_insert($uscore);
        header("location:tchstu_mag.php?op=usual_score_list&dep_id={$uscore['dep_id']}&course_id={$uscore['course_id']}");
        exit;//離開，結束程式

    // 刪除 平時成績'
    case "usual_score_delete":
        $re=usual_score_delete($uscore);
        header("location:tchstu_mag.php?op=usual_score_list&dep_id={$uscore['dep_id']}&course_id={$uscore['course_id']}");
        exit;
//段考成績 管理
    //段考成績 列表
    case "stage_score_list":
        stage_score_list($uscore);
        break;//跳出迴圈,往下執行
    // 新增、更新 段考成績
    case "stage_score_insert":
        stage_score_insert($uscore);
        // header("location:tchstu_mag.php?op=stage_score_list&dep_id={$uscore['dep_id']}");
        // header("location:tchstu_mag.php?op=stage_score_list&dep_id={$uscore['dep_id']}&course_id={$uscore['course_id']}");
        exit;//離開，結束程式
//查詢 考科成績 及期末總成績 學期總成績
    //平時成績 列表
    case "query_stage_score":
        query_stage_score($uscore);
        break;//跳出迴圈,往下執行
    // 新增、更新 考科成績
    case "add_query_stage_score_comment":
        add_query_stage_score_comment($uscore);
        header("location:tchstu_mag.php?op=query_stage_score&dep_id={$uscore['dep_id']}&course_id={$uscore['course_id']}");
        exit;//離開，結束程式
    // 學期總成績term_total_score 列表
    case "term_total_score_list":
        term_total_score_list($cos);
        break;//跳出迴圈,往下執行
    // 新增、更新 平時成績
    case "transcript":
        transcript($cos,$sn);
        break;//跳出迴圈,往下執行


    default:
        // semester_list();
        // $op="semester_list";
        break;


}
/*-----------function區--------------*/
// ----------------------------------
// 考科及學期總成績查詢 
    // 列印成績單
    function transcript($pars=[],$sn){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        $SchoolSet= new SchoolSet;
        $stu=[];
        $xoopsTpl->assign('pars', $pars);
        $stu['name']=$SchoolSet->stu_name[$sn];
        $stu['stu_id']=$SchoolSet->stu_id[$sn];
        $stu['dep_name']=$SchoolSet->depsnname[$SchoolSet->stu_dep[$sn]];
        
        // 撈出學程總成績
        $course_groupname=$SchoolSet->query_course_groupname($pars['cos_year'],$pars['cos_term'],$pars['dep_id'])['grpname_sumcred'];
        $term_total_score=$SchoolSet->query_term_total_score($pars['cos_year'],$pars['cos_term'],$pars['dep_id'])[$sn];
        $term_score_detail=$SchoolSet->query_term_score_detail($pars['cos_year'],$pars['cos_term'],$pars['dep_id'])[$sn];
        $xoopsTpl->assign('course_groupname', $course_groupname);

        // var_dump($term_total_score);die();

        $i=1;$stu_da=[];
        foreach ($course_groupname as $grp_name=>$credit){
            $stu_da[$i]['order']       = $i;
            $stu_da[$i]['grp_name']    = $grp_name;
            $stu_da[$i]['credit']      = $credit;
            // var_dump($term_total_score[$sn][$grp_name]['course_total_avg']);
            $stu_da[$i]['score']= $term_score_detail[$grp_name]['course_total_avg']??'-';
            $stu_da[$i]['total_score']= $term_score_detail[$grp_name]['course_total_score']??'-';
            $stu_da[$i]['comment']= $term_score_detail[$grp_name]['comment'];
            $i++;
        }
        $stu['sum_credits']=$term_total_score['sum_credits'];//總學分
        $stu['total_score']=$term_total_score['total_score'];//加權總分
        $stu['total_avg']=$term_total_score['total_avg'];//學期總平均

        $xoopsTpl->assign('stu', $stu);
        $xoopsTpl->assign('all', $stu_da);
        // die(var_dump($stu_da));


        
    }
    // 學期總成績列表
    function term_total_score_list($pars=[]){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;

        if(!$xoopsUser){
            redirect_header('index.php', 3, 'term_total_score_list ! error:2105181152');
        }
        
        $SchoolSet= new SchoolSet;
        // $pars['cos_year']=$pars['cos_year']==''?$SchoolSet->sem_year:$pars['cos_year'];
        // $pars['cos_term']=$pars['cos_term']==''?$SchoolSet->sem_term:$pars['cos_term'];

        // 學年度select
        foreach ($SchoolSet->all_sems as $k=>$v){
            $sems_year[$v['year']]=$v['year'];
        }
        $sems_year_htm=Get_select_opt_htm($sems_year,$pars['cos_year'],'1');
        $xoopsTpl->assign('sems_year_htm', $sems_year_htm);
        // 學期 
        if($pars['cos_year']!=''){
            $terms=$SchoolSet->get_termarray($pars['cos_year']);
        }else{
            $terms=['1'=>'1','2'=>'2'];
        }
        $sems_term_htm=Get_select_opt_htm($terms,$pars['cos_term'],1);
        $xoopsTpl->assign('sems_term_htm', $sems_term_htm);


        // die(var_dump($terms));

        // 學程列表
        $major_name=[];
        foreach ($SchoolSet->dept as $k=>$v){
            $major_name[$v['sn']]=$v['dep_name'];
        }
        $major_htm=Get_select_opt_htm($major_name,$pars['dep_id'],'1');
        $xoopsTpl->assign('major_htm', $major_htm);
        $xoopsTpl->assign('pars', $pars);


        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#stage_score_list", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $myts = MyTextSanitizer::getInstance();
        


        // 學期總成績表格
        if($pars['cos_year']!='' AND  $pars['cos_term']!='' AND $pars['dep_id']!=''){
            $xoopsTpl->assign('showtable', true);
            // 假如 學年度 學期是目前學期，才有重新計算生成成績，否則沒有
            if($pars['cos_year']==$SchoolSet->sem_year AND  $pars['cos_term']==$SchoolSet->sem_term  AND $pars['dep_id']!=''){
                $SchoolSet->year_term_score($pars['cos_year'],$pars['cos_term'],$pars['dep_id']);
            }
            
            // 撈出學程總成績
            $course_groupname=$SchoolSet->query_course_groupname($pars['cos_year'],$pars['cos_term'],$pars['dep_id']);
            $term_total_score=$SchoolSet->query_term_total_score($pars['cos_year'],$pars['cos_term'],$pars['dep_id']);
            $term_score_detail=$SchoolSet->query_term_score_detail($pars['cos_year'],$pars['cos_term'],$pars['dep_id']);
            $xoopsTpl->assign('course_groupname', $course_groupname);
            

            $i=1;$stu_data=[];
            foreach ($term_total_score as $stu_sn=>$data){
                $stu_data[$stu_sn]['order']=$i;
                $stu_data[$stu_sn]['class_name']=$myts->htmlSpecialChars($SchoolSet->class_name[$SchoolSet->stu_sn_classid[$stu_sn]]);
                $stu_data[$stu_sn]['stu_anonymous']=$myts->htmlSpecialChars($SchoolSet->stu_anonymous[$stu_sn]);

                // 填入所有科目\成績 
                foreach ($course_groupname['grpname_sumcred'] as $grpname=>$sumcred){
                    $stu_data[$stu_sn]['scores'][$grpname]=$term_score_detail[$stu_sn][$grpname]['course_total_avg']??'-';
                }
                $stu_data[$stu_sn]['sum_credits']=$term_total_score[$stu_sn]['sum_credits'];
                $stu_data[$stu_sn]['total_score']=$term_total_score[$stu_sn]['total_score'];
                $stu_data[$stu_sn]['total_avg']=$term_total_score[$stu_sn]['total_avg'];
                $stu_data[$stu_sn]['comment']=$term_total_score[$stu_sn]['comment'];
                $i++;
            }
            
            // die(var_dump($term_total_score));
        
        }

        $xoopsTpl->assign('all', $stu_data);

        // $SchoolSet->sem_year;
        // $SchoolSet->sem_term;
        $xoopsTpl->assign('sem_year', $SchoolSet->sem_year);
        $xoopsTpl->assign('sem_term', $SchoolSet->sem_term);


        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

        // $xoopsTpl->assign('op', "course_list");

    }

    // sql-新增 考科成績備註
    function add_query_stage_score_comment($pars=[]){

        global $xoopsDB,$xoopsUser,$xoopsTpl;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, 'add_query_stage_score_comment! error:2105151545');
        }

        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=query_stage_score&dep_id={$pars['dep_id']}&course_id={$pars['course_id']}", 3, 'add_query_stage_score_comment失敗! error:2105151545 檢查結果:'.!$GLOBALS['xoopsSecurity']->check());
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        $comment  = Request::getArray('comment');//學生編號=>平時備註
        // die(var_dump($comment));

        // 新增學生段考成績
        $tbl = $xoopsDB->prefix('yy_query_stage_score');
        foreach($comment as $stusn=>$v){
                $sql = "update " . $tbl . " set `comment`='{$v}'  
                        where `year`='{$year}'
                        AND `term`='{$term}'
                        AND `dep_id`='{$dep_id}'
                        AND `exam_stage`='{$exam_stage}'
                        AND `student_sn`='{$stusn}'
                        ";
                $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }
        redirect_header("tchstu_mag.php?op=query_stage_score&dep_id={$dep_id}&exam_stage={$exam_stage}", 3, '存檔成功！');
    }

    // 列表- 段考成績查詢
    function query_stage_score($pars=[]){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        $SchoolSet= new SchoolSet;
        if (!$xoopsUser) {
            redirect_header('index.php', 3, '無操作權限');
        }
    
        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#stage_score_list", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $myts = MyTextSanitizer::getInstance();

        // 學程名稱下拉選單
        $course['major_htm']=Get_select_opt_htm($SchoolSet->depsnname,$pars['dep_id'],'1');
        // 段考名稱 下拉選單
        // $course['exam_number_htm']=Get_select_opt_htm($SchoolSet->stage_exam_name+['8' => '總成績'],$pars['exam_stage'],'1');
        $course['exam_number_htm']=Get_select_opt_htm($SchoolSet->stage_exam_name,$pars['exam_stage'],'1');
        $course['year']=$SchoolSet->sem_year;
        $course['term']=$SchoolSet->sem_term;
        $course['dep_id']=$pars['dep_id'];
        

        if(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin()){
            $xoopsTpl->assign("ps_edit",true);
        } 

        if($pars['dep_id']!='' AND  $pars['exam_stage']!=''){
            $xoopsTpl->assign('showtable', true);
            $xoopsTpl->assign('pars', $pars);

            if($pars['exam_stage']=='4'){
                $stu_first_exam_avg_score=$SchoolSet->first_exam_avg_score($pars['dep_id']);
            }else{
                $stu_first_exam_avg_score=[];
            }

            // 找出這學期，這次段考的備註[stu_id]=comment
            $stu_comment=$SchoolSet->exam_comment($pars['dep_id'],$pars['exam_stage']);
        
            // 列出一~三次段考 [學程] [段考] [課程id]=[課程中文名稱]
            $dep_exam_course=$SchoolSet->dep_exam_course[$pars['dep_id']][$pars['exam_stage']];
            $xoopsTpl->assign('dep_exam_course', $dep_exam_course);

            // 列出該學程內所有學生sn, name 不含回歸結案
            $major_stu=$SchoolSet->major_stu[$pars['dep_id']];

            // [stu_sn][course id]= score 學生段考成績 
            $stu_score=$SchoolSet->dept_exam_course_score($pars['dep_id'],$pars['exam_stage'],array_keys($dep_exam_course));

            $i=1;
            foreach ($major_stu as $k=>$stu_sn){
                $stu_data[$stu_sn]['order']=$i;
                $stu_data[$stu_sn]['class_name']=$myts->htmlSpecialChars($SchoolSet->class_name[$SchoolSet->stu_sn_classid[$stu_sn]]);
                $stu_data[$stu_sn]['stu_anonymous']=$myts->htmlSpecialChars($SchoolSet->stu_anonymous[$stu_sn]);

                // 填入所有科目段考成績 
                foreach ($dep_exam_course as $course_id=>$course_name){
                    $stu_data[$stu_sn]['scores'][$course_id]=$stu_score[$stu_sn][$course_id];
                    // $stu_data[$stu_sn]['scores'][]=$stu_score[$stu_sn][$course_id];
                }

                // 計算總分、平均
                foreach ($stu_data as $stu_sn=>$v){
                    $j=$sum=0;
                    foreach ($v['scores'] as $course_id=>$score){
                        if(is_numeric($score)){
                            $sum=$sum+$score;
                            $j++;
                        }
                    }
                    if($j==0){
                        $stu_data[$stu_sn]['sum']='-';
                        $stu_data[$stu_sn]['avg']='-';
                        $stu_data[$stu_sn]['reward_method']='';
                    }else{
                        $stu_data[$stu_sn]['sum']=$sum;
                        $stu_data[$stu_sn]['avg']=(float)(round(($sum/$j),2));
                        $stu_data[$stu_sn]['reward_method']=score_range($stu_data[$stu_sn]['avg'],$pars['exam_stage']);
                    }

                    if($pars['exam_stage']=='4' AND $stu_first_exam_avg_score[$stu_sn]>='60'){
                        $stu_data[$stu_sn]['progress_score']=$stu_data[$stu_sn]['avg']-$stu_first_exam_avg_score[$stu_sn];
                        $stu_data[$stu_sn]['reward_method'].=progress_award($stu_data[$stu_sn]['progress_score']);
                    }else{
                        $stu_data[$stu_sn]['progress_score']='';
                    }
                    
                    $stu_data[$stu_sn]['comment']=$stu_comment[$stu_sn];//備註

                }
                $i++;
            }
            // 建立考科總成績檔
            $SchoolSet->add_query_stage_score($pars['dep_id'],$pars['exam_stage'],$stu_data);

            $xoopsTpl->assign('uid', $xoopsUser->uid());
            $xoopsTpl->assign('all', $stu_data);
            $xoopsTpl->assign('op', "add_query_stage_score_comment");
    
        }
        // //帶入使用者編號

        $xoopsTpl->assign('course', $course);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());
        

        // die(var_dump($stu_data));
        // echo('<br>');
        // $SchoolSet->progress_score($pars['dep_id']);
        // var_dump(score_range('91',$pars['exam_stage']));
        // echo('<br>');
        // die();
        // die();
        // die(var_dump($stu_data));
        // die(var_dump($stu_data));
        // $excel_save=[];
        // $excel_save[]=['序號','班級','姓名'];
        // foreach($dep_exam_course as $course_id => $course_name){
        //     $excel_save['0'][]=$course_name;
        // }
        // array_push($excel_save['0'],'總分','平均','獎勵方式','進步分','備註');
    }


// ----------------------------------
// 段考成績 管理
    // sql-新增 段考成績
    function stage_score_insert($pars=[]){

        global $xoopsDB,$xoopsUser,$xoopsTpl;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, 'stage_score_insert! error:2105091725');
        }

        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=stage_score_list&dep_id={$pars['dep_id']}&course_id={$pars['course_id']}", 3, 'stage_score_insert失敗! error:2105100816 檢查結果:'.!$GLOBALS['xoopsSecurity']->check());
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        $stu_score  = Request::getArray('stu_score');//學生編號=>平時成績
        $tea_keyin_score  = Request::getArray('tea_keyin_score');//學生編號=>教師keyin總成績

        // var_dump($tea_keyin_score);        
        // die(var_dump($stu_score));

        // 先刪除該科目段考資料
        $tbl = $xoopsDB->prefix('yy_stage_score');
        foreach($stu_score as $stusn=>$v){
            foreach($v['score'] as $exam_stage=>$score){
                $sql = "DELETE FROM `$tbl` 
                    WHERE `course_id` = '{$course_id}'
                        AND `year` = '{$year}'
                        AND `term` = '{$term}'
                        AND `dep_id` = '{$dep_id}'
                        AND `exam_stage`='{$exam_stage}'
                    ";
                $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            }
            break;
        }


        // 新增學生段考成績
        $tbl = $xoopsDB->prefix('yy_stage_score');
        foreach($stu_score as $stusn=>$v){
            foreach($v['score'] as $exam_stage=>$score){
                $sql = "insert into `$tbl` (
                    `year`,`term`,`dep_id`,`course_id`,`exam_stage`,
                    `student_sn`,`score`,`update_user`,`update_date`
                    ) 
                    values(
                    '{$year}','{$term}','{$dep_id}','{$course_id}','{$exam_stage}',
                    '{$stusn}','{$score}','{$update_user}',now()
                    )";
                $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            }
        }
        // echo($sql);
        // die();
        // 重新計算段考及平時考平均
        $SchoolSet= new SchoolSet;
        $SchoolSet->sscore_calculate( $dep_id,$course_id,$stu_score,$tea_keyin_score);

        // redirect_header("tchstu_mag.php?op=stage_score_list&dep_id={$dep_id}", 3, '存檔成功！');
        redirect_header("tchstu_mag.php?op=stage_score_list&dep_id={$dep_id}&course_id={$course_id}", 3, '存檔成功！');

    }

    // 列表- 段考成績
    function stage_score_list($pars=[]){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        $SchoolSet= new SchoolSet;
        if (!$xoopsUser) {
            redirect_header('index.php', 3, '無操作權限');
        }
            
    
        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#stage_score_list", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $myts = MyTextSanitizer::getInstance();

        if((power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
        
            // 全部學程列表
            $course['major_htm']=Get_select_opt_htm($SchoolSet->depsnname,$pars['dep_id'],'1');
            // 全部課程列表
            foreach ($SchoolSet->dep2course[$pars['dep_id']] as $k=>$v){
                $course_ary[$v]=$SchoolSet->courese_chn[$v];
            }
            $course['course_htm']=Get_select_opt_htm($course_ary,$pars['course_id'],'1');
        }
        else{
            // 教師學程列表
            $tea_course=$SchoolSet->tea_course[$xoopsUser->uid()];
            foreach ($tea_course as $k=>$v){
                $major_namemap[$k]=$SchoolSet->depsnname[$k];
            }
            $course['major_htm']=Get_select_opt_htm($major_namemap,$pars['dep_id'],'1');

            // 教師課程列表
            foreach ($tea_course[$pars['dep_id']] as $k=>$v){
                $course_ary[$v]=$SchoolSet->courese_chn[$v];
            }
            $course['course_htm']=Get_select_opt_htm($course_ary,$pars['course_id'],'1');
        }

        if($pars['dep_id']!='' AND  $pars['course_id']!=''){
            $xoopsTpl->assign('showtable', true);
            // 依課程找 任課教師id、學年、學期、學程
            $sscore['tea_id']    = $SchoolSet->all_course[$pars['course_id']]['tea_id'];
            $sscore['year']      = $SchoolSet->all_course[$pars['course_id']]['cos_year'];
            $sscore['term']      = $SchoolSet->all_course[$pars['course_id']]['cos_term'];
            $sscore['dep_id']    = $SchoolSet->all_course[$pars['course_id']]['dep_id'];
            $sscore['course_id'] = $pars['course_id'];
            $sscore['tea_name']  = $SchoolSet->uid2name[$sscore['tea_id']];
            $sscore['dep_name']  = $SchoolSet->depsnname[$sscore['dep_id']];
            $sscore['course_name']  = $SchoolSet->courese_chn[$sscore['course_id']];
            // die(var_dump($sscore));

            // 判斷是否為教師本人 或管理員
            if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin() or $sscore['tea_id']==$_SESSION['xoopsUserId'])){
                redirect_header("tchstu_mag.php?op=stage_score_list&dep_id={$pars['dep_id']}", 3, 'stage_score_list! error:2105091300');
            }     
            $course['normal_exam_rate']=$SchoolSet->dept[$sscore['dep_id']]['normal_exam']*100;
            $course['section_exam_rate']=$SchoolSet->dept[$sscore['dep_id']]['section_exam']*100;

            // 列出該學程內所有學生sn, name 不含回歸結案
            $major_stu=$SchoolSet->major_stu[$pars['dep_id']];
            foreach ($major_stu as $dep_id=>$stu_sn){
                $stu_data[$stu_sn]['name']=$myts->htmlSpecialChars($SchoolSet->stu_name[$stu_sn]);
                $stu_data[$stu_sn]['stu_anonymous']=$myts->htmlSpecialChars($SchoolSet->stu_anonymous[$stu_sn]);
                // 列出學生及考試成績 空白表格
                foreach ($SchoolSet->exam_name as $k=>$exam_name){
                    $stu_data[$stu_sn]['score'][$k]='';
                }
                $stu_data[$stu_sn]['f_usual']='';
                $stu_data[$stu_sn]['f_stage']='';
                $stu_data[$stu_sn]['f_sum']='';
                $stu_data[$stu_sn]['desc']='-';
            }
            // 三次段考成績時段，是否可keyin
            $addEdit=[];
            foreach($SchoolSet->stage_exam_name as $k=>$name){
                // 判斷新增、修改平時成績權限 
                // if((power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
                //     $addEdit[$k]=true;
                // }else{
                    $addEdit[$k]=$SchoolSet->exam_date_check($name);
                // }
            }
            $xoopsTpl->assign('addEdit', $addEdit);
            foreach($addEdit as $k=>$val){
                // 只要其中一次段考成績有開，就可以寫描述 
                if($val==true){
                    $desc_addEdit=true;
                }
            }
            $xoopsTpl->assign('desc_addEdit', $desc_addEdit);

            // die(var_dump($addEdit));

            // get 撈出平時考的加總平均
            $tb1      = $xoopsDB->prefix('yy_uscore_avg');
            $sql = "SELECT * FROM $tb1 
                Where course_id= '{$pars["course_id"]}'
                ORDER BY `exam_stage`
            ";
            // echo($sql);die();
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            while($data= $xoopsDB->fetchArray($result)){
                $stu_data[$data['student_sn']]['score'][$data['exam_stage']]= $myts->htmlSpecialChars($data['avgscore']);
            }

            // 撈出 段考成績
            $tb1      = $xoopsDB->prefix('yy_stage_score');
            $sql      = "SELECT *  FROM $tb1 
                            Where course_id= '{$pars["course_id"]}'
                            ORDER BY  `student_sn` ,`exam_stage`
                        ";
            // echo($sql);die();
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            while($data= $xoopsDB->fetchArray($result)){
                $stu_data [$data['student_sn']]['score'][$data['exam_stage']]= $myts->htmlSpecialChars($data['score']);
            }
            
            // 撈出 平時考及段考總成績
            $tb1      = $xoopsDB->prefix('yy_stage_sum');
            $sql      = "SELECT *  FROM $tb1 
                            Where course_id= '{$pars["course_id"]}'
                            ORDER BY  `student_sn`
                        ";
            // echo($sql);die();
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            while($data= $xoopsDB->fetchArray($result)){
                $stu_data [$data['student_sn']]['f_usual']= $myts->htmlSpecialChars($data['uscore_avg']);
                $stu_data [$data['student_sn']]['f_stage']= $myts->htmlSpecialChars($data['sscore_avg']);
                $stu_data [$data['student_sn']]['f_sum']= $myts->htmlSpecialChars($data['sum_usual_stage_avg']);
                $stu_data [$data['student_sn']]['desc']= $myts->htmlSpecialChars($data['description']);
                $stu_data [$data['student_sn']]['tea_input_score']= ($data['tea_input_score']=='')?$data['sum_usual_stage_avg']:$data['tea_input_score'];
            }


            // die(var_dump($score));
            // die(var_dump($sscore));
            $uid = $_SESSION['beck_iscore_adm'] ? $sscore['tea_id'] : $xoopsUser->uid();
            $xoopsTpl->assign('uid', $uid);
            $xoopsTpl->assign('sscore', $sscore);
            $xoopsTpl->assign('all', $stu_data);
    
        }
        // //帶入使用者編號

        $xoopsTpl->assign('op', "stage_score_insert");
        $xoopsTpl->assign('course', $course);
        $xoopsTpl->assign('exam_name', $SchoolSet->exam_name);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());
        




    }
// ----------------------------------
// 課程 管理
    // sql-刪除處室
    function course_delete($sn){
        global $xoopsDB,$xoopsUser;

        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header("tchstu_mag.php?op=course_form&sn={$sn}", 3, '無course_delete!error:2104270940');
        }       
       
        $tbl   = $xoopsDB->prefix('yy_course');
        $sql      = "SELECT * FROM $tbl WHERE `sn` = '{$sn}'";
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $cos_exist= $xoopsDB->fetchArray($result);
        // var_dump($cos_exist);die();
        if($cos_exist){
            $tbl = $xoopsDB->prefix('yy_course');
            $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
            // echo($sql);die();
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }else{
            redirect_header("tchstu_mag.php?op=course_list", 3, '無course_delete!error:2104270940');
        }
        return $cos_exist;
    }

    // 列表- 課程
    function course_list($pars=[],$g2p=''){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;

        if(!$xoopsUser){
            redirect_header('index.php', 3, 'course_list!error:2104261048');
        }
        if(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin() ){
            $xoopsTpl->assign('can_edit', true);
        } 

        // var_dump($_REQUEST);
        $myts = MyTextSanitizer::getInstance();

        $tb1      = $xoopsDB->prefix('yy_course');
        $tb2      = $xoopsDB->prefix('yy_department');
        $tb3      = $xoopsDB->prefix('users');
        $sql      = "SELECT  cr.* , de.dep_name , de.dep_status , ur.name as teacher_name
                    FROM $tb1 as cr 
                        LEFT JOIN $tb2 as de ON cr.dep_id=de.sn
                        LEFT JOIN $tb3 as ur ON cr.tea_id=ur.uid
                        " ;
        $have_par='0';
        if($pars['cos_year']!=''){
            $sql.=" WHERE `cos_year`='{$pars['cos_year']}'";
            $have_par='1';
        }
        if($pars['cos_term']!=''){
            if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.="`cos_term`='{$pars['cos_term']}'";
            $have_par='1';
        }
        if(($pars['dep_id']!='')){
            if($have_par=='1'){$sql.=" AND ";}else{$sql.=" WHERE ";};
            $sql.="cr.dep_id = '{$pars['dep_id']}'";
            $have_par='1';
        }
        $SchoolSet= new SchoolSet;

        $sql.=" ORDER BY `sort`,`cos_year` DESC , `cos_term` DESC ,`dep_id` ,`tea_id` , `cos_name`";
        // echo($sql);die();

        //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        // $PageBar = getPageBar($sql, 30, 10);
        // $bar     = $PageBar['bar'];
        // $sql     = $PageBar['sql'];
        // $total   = $PageBar['total'];

        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all      = array();

        if($g2p=='' OR $g2p=='1'){$i=1;}else{$i=($g2p-1)*30+1;}
        $credit_sun=0;
        // var_dump($cos= $xoopsDB->fetchArray($result));die();
        $star_icon=['0'=>'','1'=>'<i class="fa fa-star" aria-hidden="true"></i>'];
        while($cos= $xoopsDB->fetchArray($result)){
            $cos['i']            = $i;
            $cos['cos_year']     = $myts->htmlSpecialChars($cos['cos_year']);       //學號
            $cos['cos_term']     = $myts->htmlSpecialChars($cos['cos_term']);      //姓名
            $cos['year_term']    = $cos['cos_year'].'/'.$cos['cos_term'];
            $cos['dep_name']     = $myts->htmlSpecialChars($cos['dep_name']);
            $cos['teacher_name'] = $myts->htmlSpecialChars($cos['teacher_name']);
            $cos['cos_name']     = $myts->htmlSpecialChars($cos['cos_name']);
            $cos['cos_name_grp'] = $myts->htmlSpecialChars($cos['cos_name_grp']);
            $cos['first_chk']    = Get_bootstrap_switch_opt_htm('first_test',$cos['sn'],$cos['first_test']);
            $cos['f_icon']       = $star_icon[$cos['first_test']];
            $cos['second_chk']   = Get_bootstrap_switch_opt_htm('second_test',$cos['sn'],$cos['second_test']);
            $cos['s_icon']       = $star_icon[$cos['second_test']];
            $credit_sun=$credit_sun+$cos['cos_credits'];
            $all []              = $cos;
            $i++;
        }
        $xoopsTpl->assign('credit_sun', $credit_sun);
        // var_dump($credit_sun);die();
        // 學年度select
        foreach ($SchoolSet->all_sems as $k=>$v){
            $sems_year[$v['year']]=$v['year'];
        }
        $sems_year_htm=Get_select_opt_htm($sems_year,$pars['cos_year'],'1');
        $xoopsTpl->assign('sems_year_htm', $sems_year_htm);
        // 學期 
        $terms=['1'=>'1','2'=>'2'];
        $sems_term_htm=Get_select_opt_htm($terms,$pars['cos_term'],1);
        $xoopsTpl->assign('sems_term_htm', $sems_term_htm);

        // 學程列表
        $major_name=[];
        foreach ($SchoolSet->dept as $k=>$v){
            $major_name[$v['sn']]=$v['dep_name'];
        }
        $major_htm=Get_select_opt_htm($major_name,$pars['dep_id'],'1');
        $xoopsTpl->assign('major_htm', $major_htm);

        $xoopsTpl->assign('all', $all);
        // $xoopsTpl->assign('bar', $bar);
        // $xoopsTpl->assign('total', $total);

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('cos_del', XOOPS_URL . "/modules/beck_iscore/tchstu_mag.php?op=course_delete&sn=", 'sn','確定要刪除課程資料','課程資料資料刪除。');
        
        // $SchoolSet->sem_year;
        // $SchoolSet->sem_term;
        $xoopsTpl->assign('sem_year', $SchoolSet->sem_year);
        $xoopsTpl->assign('sem_term', $SchoolSet->sem_term);


        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

        $xoopsTpl->assign('op', "course_list");

    }
    // sql-更新 課程
    function course_update($sn){
        global $xoopsDB,$xoopsUser;
        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header("tchstu_mag.php?op=course_form&sn={$sn}", 3, '無course_update權限!error:2104261000');
        } 
        
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("school_affairs.php?op=dept_school_form&sn={$sn}", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        $first_test  = $first_test ?? '0' ;
        $second_test = $second_test ?? '0' ;
        $scoring     = $scoring ?? '0' ;
        // die();
        $tbl = $xoopsDB->prefix('yy_course');
        $sql = "update `$tbl` set 
                    `cos_year`='{$cos_year}',
                    `cos_term`='{$cos_term}',
                    `dep_id`='{$dep_id}',
                    `tea_id`='{$tea_id}',
                    `cos_name`=trim('{$cos_name}'),
                    `cos_name_grp`=trim('{$cos_name_grp}'),
                    `cos_credits`='{$cos_credits}',
                    `scoring`='{$scoring}',
                    `first_test`='{$first_test}',
                    `second_test`='{$second_test}',
                    `status`='{$status}',
                    `update_user`='{$uid}',
                    `update_date`=now()
                where `sn`   = '{$sn}'";

        // echo($sql);die();
        $re_val['cos_year']=$cos_year;
        $re_val['cos_term']=$cos_term;
        $re_val['dep_id']=$dep_id;
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        return $re_val;
    }

    // sql-新增 學程
    function course_insert(){
        global $xoopsDB,$xoopsUser;

        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php?op=course_form', 3, '無course_insert權限!error:2104242100');
        } 
        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=student_form", 3, '新增學生，表單Token錯誤，請重新輸入!'.!$GLOBALS['xoopsSecurity']->check());
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
                // die();
        $first_test  = $first_test ?? '0' ;
        $second_test = $second_test ?? '0' ;
        $scoring     = $scoring ?? '0' ;
        
        $tbl   = $xoopsDB->prefix('yy_course');

        $sql_count = "SELECT max(sn)+1 as count FROM $tbl ";
        $result   = $xoopsDB->query($sql_count) or Utility::web_error($sql, __FILE__, __LINE__);
        $sql_count_result= $xoopsDB->fetchArray($result);

        $sql      = "SELECT * FROM $tbl WHERE `cos_year`='{$cos_year}' AND `cos_term`='{$cos_term}'
                    AND `dep_id`='{$dep_id}' AND `tea_id`='{$tea_id}' AND `cos_name`='{$cos_name}'";
        // echo($sql);die();
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $cos_exist= $xoopsDB->fetchArray($result);
        // die(var_dump($cos_exist));
    
        if (!$cos_exist) {
            $sql = "insert into `$tbl` (
                        `cos_year`,`cos_term`,`dep_id`,`tea_id`,`cos_name`,
                        `cos_name_grp`,`cos_credits`,`scoring`,`first_test`, `second_test`,
                        `status`,`update_user`,`update_date`,`sort`
                    )values(
                        '{$cos_year}','{$cos_term}','{$dep_id}','{$tea_id}', trim('{$cos_name}'),
                        trim('{$cos_name_grp}'),'{$cos_credits}','{$scoring}','{$first_test}','{$second_test}',
                        '{$status}','{$uid}',now(),'{$sql_count_result['count']}'
                    )";
            // echo($sql);die();
            $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }else{
            redirect_header('tchstu_mag.php?op=course_form', 3, '此課程已存在!error:2104242225');
        }

        $re_val['cos_year']=$cos_year;
        $re_val['cos_term']=$cos_term;
        $re_val['dep_id']=$dep_id;

        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號
        return $re_val;
    }

    // 表單 課程
    function course_form($sn){
        // var_dump(power_chk("tchstu_mag", "1"));die();
        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            redirect_header('tchstu_mag.php?op=course_list', 3, '無course_form權限!error:2104221800');
        }        

        global $xoopsTpl,$xoopsUser,$xoopsDB;

        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#course_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form_title = '新增課程';
        $cours   = array();

        if($sn){
            $form_title = '編輯課程';
            $tbl    = $xoopsDB->prefix('yy_course');
            $sql    = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $cour  = $xoopsDB->fetchArray($result);
        }
        $xoopsTpl->assign('form_title', $form_title);
        $SchoolSet= new SchoolSet;
        $cour['cos_year']     = $cour['cos_year'] ?? $SchoolSet->sem_year ;
        $cour['cos_term']     = $cour['cos_term'] ?? $SchoolSet->sem_term ;
        $cour['dep_id']       = $cour['dep_id'] ?? '' ;
        $cour['tea_id']       = $cour['tea_id'] ?? '';
        $cour['cos_name']     = $cour['cos_name']?? '' ;
        $cour['cos_name_grp'] = $cour['cos_name_grp'] ?? '';
        $cour['first_test']   = $cour['first_test'] ?? '';
        $cour['second_test']  = $cour['second_test'] ?? '';
        $cour['cos_credits']  = $cour['cos_credits'] ?? '';
        $cour['scoring']      = $cour['scoring'] ?? '1';
        $cour['status']       = $cour['status'] ?? '1';

        // 學程列表
        $major_name=[];
        foreach ($SchoolSet->dept as $k=>$v){
            $major_name[$v['sn']]=$v['dep_name'];
        }
        $cour['major_htm']=Get_select_opt_htm($major_name,$cour['dep_id'],'1');

        // 教師列表
        $teacher_name=[];
        foreach ($SchoolSet->teachers as $k=>$v){
            $teacher_name[$v['uid']]=$v['name'];
        }
        $cour['teacher_htm']=Get_select_opt_htm($teacher_name,$cour['tea_id'],'1');
        
        if($cour['first_test']=='1'){$cour['ftest_htm']='checked';}else{$cour['ftest_htm']='';}
        if($cour['second_test']=='1'){$cour['stest_htm']='checked';}else{$cour['stest_htm']='';}
        if($cour['scoring']=='1'){$cour['score_htm']='checked';}else{$cour['score_htm']='';}
        // var_dump($SchoolSet->teachers);die();
        // $SchoolSet->teachers;

        // 目前狀況
        $status_ary=['0'=>'關閉','1'=>'啟用','2'=>'暫停'] ;
        $cour['status_htm']=Get_select_opt_htm($status_ary,$cour['status'],'1');

        $xoopsTpl->assign('cour', $cour);

        // //帶入使用者編號
        if ($sn) {
            $uid = $_SESSION['beck_iscore_adm'] ? $cour['update_user'] : $xoopsUser->uid();
        } else {
            $uid = $xoopsUser->uid();
        }
        $xoopsTpl->assign('uid', $uid);
        

        // //下個動作
        if ($sn) {
            $op='course_update';
            $xoopsTpl->assign('sn', $sn);
        } else {
            $op='course_insert';
        }
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('cos_del', XOOPS_URL . "/modules/beck_iscore/tchstu_mag.php?op=course_delete&sn=", 'sn','確定要刪除課程資料','課程資料資料刪除。');

    }

// ----------------------------------
// 學生 管理
    // sql-刪除學生
    function student_delete($sn){
        global $xoopsDB,$xoopsUser;

        if(!power_chk("beck_iscore", "1")){
            redirect_header('tchstu_mag.php', 3, '無student_delete權限!error:2104210936');
        } 

        
        $tbl = $xoopsDB->prefix('yy_student');
        $sql = "DELETE FROM `$tbl` WHERE `sn` = '{$sn}'";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    // sql-更新學
    function student_update($sn){

        global $xoopsDB,$xoopsUser;
        if(!power_chk("beck_iscore", "1")){
            redirect_header('index.php', 3, '無student_update權限!error:2104201500');
        } 

        
        //安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("school_affairs.php?op=dept_school_form&sn={$sn}", 3, '表單Token錯誤，請重新輸入!');
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // die();
        $stu_anonymous=name_substr_cut($stu_name);

        $tbl = $xoopsDB->prefix('yy_student');
        $sql = "update `$tbl` set 
                    `stu_name`   = '{$stu_name}',
                    `national_id`= '{$national_id}',
                    `stu_id` = '{$stu_id}', 
                    `stu_no` = '{$stu_no}', 
                    `class_id` = '{$class_id}', 
                    `major_id` = '{$major_id}', 
                    `grade` = '{$grade}', 
                    `arrival_date` = '{$arrival_date}', 
                    `birthday` = '{$birthday}', 
                    `orig_school` = '{$orig_school}', 
                    `household_add` = '{$household_add}', 
                    `address` = '{$address}', 
                    `out_learn` = '{$out_learn}', 
                    `audit` = '{$audit}', 
                    `status` = '{$status}', 
                    `record` = '{$record}', 
                    `social_id` = '{$social_id}', 
                    `guidance_id` = '{$guidance_id}', 
                    `rcv_guidance_id` = '{$rcv_guidance_id}', 
                    `guardian1` = '{$guardian1}', 
                    `guardian1_relationship` = '{$guardian1_relationship}', 
                    `guardian1_cellphone1` = '{$guardian1_cellphone1}', 
                    `guardian1_cellphone2` = '{$guardian1_cellphone2}', 
                    `emergency1_contact1` = '{$emergency1_contact1}', 
                    `emergency1_contact_rel` = '{$emergency1_contact_rel}', 
                    `emergency1_cellphone1` = '{$emergency1_cellphone1}', 
                    `emergency1_cellphone2` = '{$emergency1_cellphone2}', 
                    `emergency1_cellphone2` = '{$emergency1_cellphone2}', 
                    `uid` = '{$uid}', 
                    `update_time` = now(),
                    `stu_anonymous`='{$stu_anonymous}'
                where `sn`   = '{$sn}'";

        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        return $sn;
    }

    // sql-新增 學生
    function student_insert(){

        global $xoopsDB,$xoopsUser;

        if(!power_chk("beck_iscore", "1")){
            redirect_header('index.php', 3, '無student_insert權限!error:210420114');
        } 

        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=student_form", 3, '新增學生，表單Token錯誤，請重新輸入!'.!$GLOBALS['xoopsSecurity']->check());
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // die();
        $stu_anonymous=name_substr_cut($stu_name);

        $tbl = $xoopsDB->prefix('yy_student');
        $sql = "insert into `$tbl` (
            `stu_name`,`national_id`,`stu_id`,`stu_no`,`class_id`,
            `major_id`,`grade`,`arrival_date`,`birthday`,`orig_school`,
            `household_add`,`address`,`out_learn`,`audit`,`status`,
            `record`,`social_id`,`guidance_id`,`rcv_guidance_id`,`guardian1`,
            `guardian1_relationship`,`guardian1_cellphone1`,`guardian1_cellphone2`,`emergency1_contact1`,`emergency1_contact_rel`,
            `emergency1_cellphone1`,`emergency1_cellphone2`,`uid`,`create_time`,`update_time`,`stu_anonymous`) 
            values(
            '{$stu_name}','{$national_id}','{$stu_id}','{$stu_no}','{$class_id}',
            '{$major_id}','{$grade}','{$arrival_date}','{$birthday}','{$orig_school}',
            '{$household_add}','{$address}','{$out_learn}','{$audit}','{$status}',
            '{$record}','{$social_id}','{$guidance_id}','{$rcv_guidance_id}','{$guardian1}',
            '{$guardian1_relationship}','{$guardian1_cellphone1}','{$guardian1_cellphone2}','{$emergency1_contact1}','{$emergency1_contact_rel}',
            '{$emergency1_cellphone1}','{$emergency1_cellphone2}','{$uid}',now(),now(),'{$stu_anonymous}'
            )";
        // echo($sql); 
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sn = $xoopsDB->getInsertId(); //取得最後新增的編號

        return $sn;
    }

    // 表單-新增、編輯 學生
    function student_form($sn){
        // var_dump(power_chk("tchstu_mag", "1"));die();
        if(!power_chk("beck_iscore", "1") or !power_chk("beck_iscore", "3")){
            redirect_header('index.php', 3, '無student_form權限!error:2104191604');
        }        
        // if (!power_chk('beck_iscore', 1)) {
        //     redirect_header('school_affairs.php', 3, '無操作權限');
        // }
        // if (!$xoopsUser) {
        //     redirect_header('index.php', 3, '無操作權限');
        // }
        global $xoopsTpl,$xoopsUser,$xoopsDB;

        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#student_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form_title = '新增學生';
        $stu   = array();

        if($sn){
            $form_title = '編輯學生';
            $tbl        = $xoopsDB->prefix('yy_student');
            $sql        = "SELECT * FROM $tbl Where `sn`='{$sn}'";
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $stu_ifo       = $xoopsDB->fetchArray($result);
        }
        $xoopsTpl->assign('form_title', $form_title);
        $stu['stu_id']                 = $stu_ifo['stu_id'] ?? '' ;
        $stu['stu_no']                 = $stu_ifo['stu_no'] ?? '' ;
        $stu['stu_name']               = $stu_ifo['stu_name'] ?? '' ;
        $stu['stu_anonymous']          = $stu_ifo['stu_anonymous'] ?? '' ;
        $stu['national_id']            = $stu_ifo['national_id'] ?? '';
        $stu['sex']                    = $stu_ifo['sex']?? '0' ;
        $stu['arrival_date']           = $stu_ifo['arrival_date'] ?? '';
        $stu['birthday']               = $stu_ifo['birthday'] ?? '';
        $stu['orig_school']            = $stu_ifo['orig_school'] ?? '';
        $stu['orig_grade']             = $stu_ifo['orig_grade'] ?? '';
        $stu['out_learn']              = $stu_ifo['out_learn'] ?? '';
        
        $stu['household_add']          = $stu_ifo['household_add'] ?? '';
        $stu['address']                = $stu_ifo['address'] ?? '';
        $stu['guardian1']              = $stu_ifo['guardian1'] ?? '';
        $stu['guardian1_relationship'] = $stu_ifo['guardian1_relationship'] ?? '';
        $stu['guardian1_cellphone1']   = $stu_ifo['guardian1_cellphone1'] ?? '';
        $stu['guardian1_cellphone2']   = $stu_ifo['guardian1_cellphone2'] ?? '';
        $stu['emergency1_contact1']    = $stu_ifo['emergency1_contact1'] ?? '';
        $stu['emergency1_contact_rel'] = $stu_ifo['emergency1_contact_rel'] ?? '';
        $stu['emergency1_cellphone1']  = $stu_ifo['emergency1_cellphone1'] ?? '';
        $stu['emergency1_cellphone2']  = $stu_ifo['emergency1_cellphone2'] ?? '';
        $stu['social_id']              = $stu_ifo['social_id'] ?? '';
        $stu['guidance_id']            = $stu_ifo['guidance_id'] ?? '';
        $stu['rcv_guidance_id']        = $stu_ifo['rcv_guidance_id'] ?? '';
        $stu['class_id']               = $stu_ifo['class_id'] ?? '';
        $stu['major_id']               = $stu_ifo['major_id'] ?? '';
        $stu['grade']                  = $stu_ifo['grade'] ?? '';
        $stu['audit']                  = $stu_ifo['audit'] ?? '0';
        $stu['status']                 = $stu_ifo['status'] ?? '';
        $stu['uid']                    = $stu_ifo['uid'] ?? '';
        $stu['record']                 = $stu_ifo['record'] ?? '';

        $SchoolSet= new SchoolSet;
        // 班級
        $stu['class_htm']=Get_select_opt_htm($SchoolSet->class_name,$stu['class_id'],'1');
        $xoopsTpl->assign('class_tutor', json_encode($SchoolSet->class_tutor_name));

        // 學程列表
        $major_name=[];
        foreach ($SchoolSet->dept as $k=>$v){
            $major_name[$v['sn']]=$v['dep_name'];
        }
        $stu['major_htm']=Get_select_opt_htm($major_name,$stu['major_id'],'1');

        // 外學
        $onoff=['0'=>'否','1'=>'是'];
        $stu['out_learn_htm']=radio_htm($onoff,'out_learn', $stu['out_learn']);
        // 隨班附讀	
        $stu['audit_htm']=radio_htm($onoff,'audit', $stu['audit']);


        // 目前狀況
        $status_ary=['0'=>'逾假逃跑','1'=>'在校','2'=>'回歸/結案'] ;
        $stu['status_htm']=Get_select_opt_htm($status_ary,$stu['status'],'1');

        // var_dump($stu['status_htm']);
        // var_dump($class_tutor);
        // die();

        $sex_ary=["0"=>'女',"1"=>'男'];
        $stu['sex_htm']=Get_select_opt_htm($sex_ary,$stu['sex'],'1');
        
        $grade=["1"=>'1',"2"=>'2',"3"=>'3',"畢業或結業"=>'畢業或結業'];
        $stu['orig_grade_htm']=Get_select_opt_htm($grade,$stu['orig_grade'],'1');
        $stu['grade_htm']=Get_select_opt_htm($grade,$stu['grade'],'1');
        
        // 社工師、輔導老師、認輔
        $stu['social_htm']=Get_select_opt_htm($SchoolSet->issocial,$stu['social_id'],'1');
        $stu['guidance_htm']=Get_select_opt_htm($SchoolSet->isguidance,$stu['guidance_id'],'1');
        $stu['rcv_guidance_htm']=Get_select_opt_htm($SchoolSet->uid2name,$stu['rcv_guidance_id'],'1');
        
        $xoopsTpl->assign('stu', $stu);

        // //帶入使用者編號
        if ($sn) {
            $uid = $_SESSION['beck_iscore_adm'] ? $stu['uid'] : $xoopsUser->uid();
        } else {
            $uid = $xoopsUser->uid();
        }
        $xoopsTpl->assign('uid', $uid);
        

        // //下個動作
        if ($sn) {
            $op='student_update';
            $xoopsTpl->assign('sn', $sn);
        } else {
            $op='student_insert';
        }
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }

    // 列表- 學生
    function student_list($pars=[],$g2p=''){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        // if(!power_chk("beck_iscore", "2")){
        if (!$xoopsUser) {
            redirect_header('index.php', 3, 'student_list!error:210420115');
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
        // echo($sql);die();
        // var_dump($pars['status']);
        // var_dump($pars['status']!='');die();
        // $have_par='0';
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
        $sql.=" ORDER BY `sort` ,`stu_no`";
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

        // $is_chk=["0"=>'',"1"=>'checked'];
        // var_dump($stu= $xoopsDB->fetchArray($result));die();

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
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());


        $xoopsTpl->assign('op', "student_list");

    }
// ----------------------------------
// 平時成績 管理
    // sql-平時成績
    function usual_score_delete($pars=[]){
        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, 'usual_score_insert! error:2105052140');
        }
        // die(var_dump($pars));
        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=usual_score_list&dep_id={$pars['dep_id']}&course_id={$pars['course_id']}", 3, 'usual_score_delete錯誤! 檢查結果:'.$GLOBALS['xoopsSecurity']->check());
            throw new Exception($error);
        }

        $tbl = $xoopsDB->prefix('yy_usual_score');
        $sql = "DELETE FROM `$tbl` 
            WHERE `course_id`   = '{$pars['course_id']}'
            AND   `exam_stage`  = '{$pars['exam_stage']}'
            AND   `exam_number` = '{$pars['exam_number']}'
            ";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        

        // 重新計算平時考平均
        $SchoolSet= new SchoolSet;
        $SchoolSet->uscore_avg($pars['course_id'],$pars['exam_stage']);
    }

    // sql-新增 平時成績
    function usual_score_insert($pars=[]){

        global $xoopsDB,$xoopsUser;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, 'usual_score_insert! error:2105052140');
        }

        // 安全判斷 儲存 更新都要做
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header("tchstu_mag.php?op=usual_score_list&dep_id={$pars['dep_id']}&course_id={$pars['course_id']}", 3, 'usual_score_insert! 檢查結果:'.!$GLOBALS['xoopsSecurity']->check());
            throw new Exception($error);
        }
        
        $myts = MyTextSanitizer::getInstance();
        foreach ($_POST as $key => $value) {
            $$key = $myts->addSlashes($value);
            echo "<p>\${$key}={$$key}</p>";
        }
        // die();
        $student_sn  = Request::getArray('student_sn');//學生編號=>平時成績

        $tbl = $xoopsDB->prefix('yy_usual_score');
        $sql = "DELETE FROM `$tbl` 
            WHERE `course_id` = '{$course_id}'
                AND `exam_stage` = '{$exam_stage}'
                AND `exam_number` = '{$exam_number}'
            ";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        foreach($student_sn as $k=>$v){
            $sql = "insert into `$tbl` (
                `year`,`term`,`dep_id`,`course_id`,`exam_stage`,
                `exam_number`,`student_sn`,`score`,`update_user`,`update_date`
                ) 
                values(
                '{$year}','{$term}','{$dep_id}','{$course_id}','{$exam_stage}',
                '{$exam_number}','{$k}','{$v}','{$update_user}',now()
                )";
                // echo($sql);die();

            $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }

        // 重新計算平時考平均
        $SchoolSet= new SchoolSet;
        $SchoolSet->uscore_avg($course_id,$exam_stage);
    }

    // 表單-新增、編輯 平時成績
    function usual_score_form($pars=[]){
        global $xoopsTpl,$xoopsUser,$xoopsDB;

        if (!$xoopsUser) {
            redirect_header('index.php', 3, '無操作權限');
        }
        $SchoolSet= new SchoolSet;
        // 依課程找 任課教師id、學年、學期、學程
        $uscore['tea_id'] = $SchoolSet->all_course[$pars['course_id']]['tea_id'];
        $uscore['year']   = $SchoolSet->all_course[$pars['course_id']]['cos_year'];
        $uscore['term']   = $SchoolSet->all_course[$pars['course_id']]['cos_term'];
        $uscore['dep_id'] = $SchoolSet->all_course[$pars['course_id']]['dep_id'];
        $uscore['course_id'] = $pars['course_id'];
        $uscore['exam_stage'] = $pars['exam_stage'];
        $uscore['exam_number'] = $pars['exam_number'];
    

        if(!(power_chk("beck_iscore", "3") or $xoopsUser->isAdmin() or $uscore['tea_id']==$_SESSION['xoopsUserId'])){
            redirect_header('tchstu_mag.php?op=usual_score_list', 3, 'usual_score_form! error:2105051000');
        }     

        //套用formValidator驗證機制
        if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
            redirect_header("tchstu_mag.php", 3, _TAD_NEED_TADTOOLS);
        }
        include_once TADTOOLS_PATH."/formValidator.php";
        $formValidator      = new formValidator("#usual_score_form", true);
        $formValidator_code = $formValidator->render();
        $xoopsTpl->assign("formValidator_code",$formValidator_code);

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $uscore['exam_stage_name']=$SchoolSet->usual_exam_name[$pars['exam_stage']];
        $uscore['dep_name']=$SchoolSet->depsnname[$pars['dep_id']];
        $uscore['course_name']=$SchoolSet->courese_chn[$pars['course_id']];
        $uscore['tea_name']=$SchoolSet->uid2name[$uscore['tea_id']];
    
        $myts = MyTextSanitizer::getInstance();
        $tbl        = $xoopsDB->prefix('yy_usual_score');
        if($pars['exam_number']==''){
            $sql        = "SELECT max(`exam_number`) as exam_number FROM $tbl  Where 
                                    `course_id`='{$pars["course_id"]}' 
                                AND `exam_stage`='{$pars["exam_stage"]}'
                            ";
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $exam_number= $xoopsDB->fetchArray($result);
            if($exam_number['exam_number']==''){
                $uscore['exam_number']='1';
            }else{
                $uscore['exam_number']=(string)((int)$exam_number['exam_number']+1);
            }

            // 列出該學程內所有學生sn, name 不含回歸結案
            $major_stu=$SchoolSet->major_stu[$pars['dep_id']];
            foreach ($major_stu as $k=>$v){
                $stu_data[$v]['name']=$myts->htmlSpecialChars($SchoolSet->stu_name[$v]);
                $stu_data[$v]['score']='';
            }
        }else{
            $tb2        = $xoopsDB->prefix('yy_student');

            $sql        = "SELECT * FROM $tbl
                            LEFT JOIN $tb2 as stu on $tbl.student_sn=stu.sn
                            
                            Where `course_id`='{$pars["course_id"]}' 
                                AND `exam_stage`='{$pars["exam_stage"]}'
                                AND `exam_number`='{$pars["exam_number"]}'
                                ORDER BY stu.sort
                            ";
            // echo($sql);die();
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    
            while($stu= $xoopsDB->fetchArray($result)){
                $stu_data [$stu['student_sn']]['name']= $myts->htmlSpecialChars($SchoolSet->stu_name[$stu['student_sn']]);
                $stu_data [$stu['student_sn']]['score']= $myts->htmlSpecialChars($stu['score']);
            }
        }
        $xoopsTpl->assign('all', $stu_data);
        $xoopsTpl->assign('uscore', $uscore);

        // //帶入使用者編號
        if ($pars['exam_number']=='') {
            $uid = $xoopsUser->uid();
        } else {
            $uid = $_SESSION['beck_iscore_adm'] ? $uscore['tea_id'] : $xoopsUser->uid();
        }
        $xoopsTpl->assign('uid', $uid);
        

        //下個動作
        $op='usual_score_insert';
        $xoopsTpl->assign('op', $op);

        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());

    }

    // 列表- 平時成績
    function usual_score_list($course=[],$g2p=''){
        global $xoopsTpl,$xoopsDB,$xoopsModuleConfig,$xoopsUser;
        if (!$xoopsUser) {
            redirect_header('index.php', 3, '無操作權限');
        }

        $SchoolSet= new SchoolSet;

        if((power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
            // 全部學程列表
            $course['major_htm']=Get_select_opt_htm($SchoolSet->depsnname,$course['dep_id'],'1');
            // 全部課程列表
            foreach ($SchoolSet->dep2course[$course['dep_id']] as $k=>$v){
                $course_ary[$v]=$SchoolSet->courese_chn[$v];
            }
            $course['course_htm']=Get_select_opt_htm($course_ary,$course['course_id'],'1');
        }
        else{
            // 學程列表
            $tea_course=$SchoolSet->tea_course[$xoopsUser->uid()];
            foreach ($tea_course as $k=>$v){
                $major_namemap[$k]=$SchoolSet->depsnname[$k];
            }
            $course['major_htm']=Get_select_opt_htm($major_namemap,$course['dep_id'],'1');

            // 課程列表
            foreach ($tea_course[$course['dep_id']] as $k=>$v){
                $course_ary[$v]=$SchoolSet->courese_chn[$v];
            }
            $course['course_htm']=Get_select_opt_htm($course_ary,$course['course_id'],'1');
        }


        // die(var_dump($SchoolSet->usual_exam_name));
        if($course['dep_id']!='' AND  $course['course_id']!=''){
            // 三次平時成績時段，是否可keyin
            $addEdit=[];
            foreach($SchoolSet->usual_exam_name as $k=>$name){
                // 判斷新增、修改平時成績權限 
                if((power_chk("beck_iscore", "3") or $xoopsUser->isAdmin())){
                    $addEdit[$k]=true;
                }else{
                    $addEdit[$k]=$SchoolSet->exam_date_check($name);
                }
            }
            $xoopsTpl->assign('addEdit', $addEdit);

            // 依三次平時成績時段結果，產生新增平時成績欄位下拉選單
            foreach($addEdit as $k=>$name){
                if($name==true){
                    $add_uscore_select[$k]=$SchoolSet->usual_exam_name[$k];
                    $xoopsTpl->assign('show_select', true);
                }
            }
            // die(var_dump($add_uscore_select));
            $course['exam_number_htm']=Get_select_opt_htm($add_uscore_select,'','0');

            // get 每次平時成績
            $xoopsTpl->assign('showtable', true);
            $myts = MyTextSanitizer::getInstance();
            $tb1      = $xoopsDB->prefix('yy_usual_score');
            $tb2      = $xoopsDB->prefix('yy_student');
            $sql      = "SELECT sco.* ,stu.stu_name  , stu.sort  FROM $tb1  as sco
                            LEFT  JOIN $tb2 as stu ON sco.student_sn       = stu.sn
                            Where sco.course_id= '{$course["course_id"]}'
                            ORDER BY `exam_stage`,`exam_number`,stu.sort  
                        ";
            // echo($sql);die();
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $stu_uscore=array();
            while($data= $xoopsDB->fetchArray($result)){
                $stu_uscore [$data['exam_stage']][$data['student_sn']]['name']= $myts->htmlSpecialChars($data['stu_name']);
                $stu_uscore [$data['exam_stage']][$data['student_sn']]['score'][$data['exam_number']]= $myts->htmlSpecialChars($data['score']);
            }

            // 撈出每次段考前平時考的加總平均
            $tb1      = $xoopsDB->prefix('yy_uscore_avg');
            $sql      = "SELECT * FROM $tb1  as sco
                        Where sco.course_id='{$course["course_id"]}' 
                        ORDER BY exam_stage,student_sn
                ";
            // echo($sql);die();
            $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            while($data= $xoopsDB->fetchArray($result)){
                // 增加 算平均
                $stu_uscore [$data['exam_stage']][$data['student_sn']]['avg']= $myts->htmlSpecialChars($data['avgscore']);
            }


            foreach($stu_uscore as $exam_stage=>$v2){
                foreach($v2 as $student_sn=>$v3){
                    $score_count[$exam_stage]['score_count'] = count($v3['score']);
                    $score_count[$exam_stage]['test_ary']    = array_keys($v3['score']);
                }
                // $score_count[$exam_stage]['score_count'] = count($stu_uscore[$exam_stage][$student_sn]['score']);
            }
            $xoopsTpl->assign('all', $stu_uscore);
            $xoopsTpl->assign('score_count', $score_count);
            // print_r($stu_uscore);
            // print_r($score_count);
            // die();
        }

        $xoopsTpl->assign('course', $course);
        $xoopsTpl->assign('usual_exam_name', $SchoolSet->usual_exam_name);
    

        // 載入xoops表單元件
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $token =new XoopsFormHiddenToken('XOOPS_TOKEN',360);
        $xoopsTpl->assign('XOOPS_TOKEN' , $token->render());


        $xoopsTpl->assign('op', "usual_score_list");

    }
// ----------------------------------

/*-----------秀出結果區--------------*/

$xoopsTpl->assign('now_op', $op);
$xoopsTpl->assign("toolbar", toolbar_bootstrap($interface_menu));

include_once XOOPS_ROOT_PATH . '/footer.php';
