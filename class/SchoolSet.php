<?php
namespace XoopsModules\Beck_iscore;
use XoopsModules\Tadtools\CkEditor;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\StarRating;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\SyntaxHighlighter;
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;

class SchoolSet
{
    private static $_instance;
    public $sem_sn; //學年度編號
    public $sem_year; //目前學年度
    public $sem_term; //目前學期
    public $all_sems; //所有學年度資料
    public $users; //使用者資料
    public $teachers; //教師資料
    public $class; //班級資料
    public $dept; //所有學程資料
    public $depsnname; //學程 sn map name
    public $deptofsch; //處室資料
    public $isguidance; //輔導老師
    public $issocial; //社工師
    public $exam_name; //考試名稱
    public $usual_exam_name; //平時考名稱
    public $stage_exam_name; //段考名稱
    public $tea_course; //教師課表 教師  學程 課程
    public $dep2course; //學程對課程
    public $courese_chn; //課程中文名稱
    public $all_course; //所有課程 sn-> data
    public $uid2name; // uid map 中文姓名
    public $major_stu; // 學程map 學生們sn
    public $stu_name; //  學生sn map name
    // public $tch_sex; //性別
 


    //建構函數
    public function __construct()
    {            
        $this->get_semester();
        $this->get_teachers_data();
        $this->get_class();
        $this->get_dept();  //學程
        $this->get_deptofsch();//get 學校處室
        $this->get_social_guidance();// get 社工師及輔導老師
        $this->get_course();// get 社工師及輔導老師
        $this->get_uid_name();// get uid 2 name
        $this->get_stu_data();// get stu data
        $this->exam_name=['1'=>'第一次段考前平時考','2'=>'第一次段考','3'=>'第二次段考前平時考','4'=>'第二次段考','5'=>'第三次段考前平時考','6'=>'期末考'];
        $this->usual_exam_name=['1'=>'第一次段考前平時考','3'=>'第二次段考前平時考','5'=>'第三次段考前平時考'];
        $this->stage_exam_name=['2'=>'第一次段考','4'=>'第二次段考','6'=>'期末考'];

    }

    // 計算段考及平時考成績 加總 平均
    public function sscore_calculate( $dep_id='',$coursid=''){
        global $xoopsDB,$xoopsUser;
        //找出學程對映 成績分配比例
        $tb1      = $xoopsDB->prefix('yy_department');
        $sql      = "SELECT * FROM $tb1 Where `sn`='{$dep_id}' ";
        // echo($sql);die();
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $score_rate= $xoopsDB->fetchArray($result);
        // die(var_dump($score_rate));

        // 算出學生 平時考加總 平均
        $tb1      = $xoopsDB->prefix('yy_uscore_avg');
        $sql      = "SELECT * FROM $tb1  
                        Where `course_id`='{$coursid}' 
                        ORDER BY `student_sn` ,`exam_stage`
                    ";
        // echo($sql);die();
        $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all=[];
        while($data= $xoopsDB->fetchArray($result)){
            $all[$data['student_sn']]['uscore'][]=$data['avgscore'];
        }
        
        foreach($all as $stu_sn=>$score_ary){
            $i=$sum=0;
            foreach($score_ary['uscore'] as $seq=>$score){
                if(is_numeric($score)){
                    $i++;
                    $sum=$sum+ (float)$score;
                }
            }
            if($i==0){
                $all[$stu_sn]['uavg']='-';
                $all[$stu_sn]['usum']='-';
            }else{
                $all[$stu_sn]['usum']=$sum;
                $all[$stu_sn]['uavg']=round((float)(($sum/$i)*(float)$score_rate['normal_exam']),2);
            }
        }
        


        // var_dump($all);
        // 算出學生 段考成績加總 平均
        $tb1      = $xoopsDB->prefix('yy_stage_score');
        $sql      = "SELECT * FROM $tb1  
                        Where `course_id`='{$coursid}' 
                        ORDER BY `student_sn` ,`exam_stage`
                    ";
        // echo($sql);die();
        $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while($data= $xoopsDB->fetchArray($result)){
            $all[$data['student_sn']]['sscore'][]=$data['score'];
        }
        // var_dump($all);die();
        foreach($all as $stu_sn=>$score_ary){
            $i=$sum=0;
            foreach($score_ary['sscore'] as $seq=>$score){
                if(is_numeric($score)){
                    $i++;
                    $sum=$sum+ (float)$score;
                }
            }
            if($i==0){
                $all[$stu_sn]['savg']='-';
                $all[$stu_sn]['ssum']='-';
            }else{
                $all[$stu_sn]['ssum']=$sum;
                $all[$stu_sn]['savg']=round((float)(($sum/$i)*(float)$score_rate['section_exam']),2);
            }
        }
        // var_dump($all);die();
        // 平時考+段考
        foreach($all as $stu_sn=>$score_ary){
            if(is_numeric($score_ary['uavg']) OR  is_numeric($score_ary['savg'])){
                $all[$stu_sn]['uavg_savg_sum']=(float)$score_ary['uavg']+ (float)$score_ary['savg'];
            }else{
                $all[$stu_sn]['uavg_savg_sum']='-';
            }
        }


        // 刪除學生 總成績
        $tbl = $xoopsDB->prefix('yy_stage_sum');
        $sql = "DELETE FROM `$tbl` WHERE `course_id` = '{$coursid}'";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        // die(var_dump($all));
        

        // 新增學生總成績
        $tbl = $xoopsDB->prefix('yy_stage_sum');
        foreach($all as $stusn=>$v){
            $sql_1 = "insert into `$tbl` (
                `course_id`,`student_sn`,`uscore_sum`,`uscore_avg`,`sscore_sum`,
                `sscore_avg`,`sum_usual_stage_avg`,`update_user`,`update_date`
                ) 
                values(
                '{$coursid}','{$stusn}','{$v['usum']}','{$v['uavg']}','{$v['ssum']}',
                '{$v['savg']}','{$v['uavg_savg_sum']}','{$xoopsUser->uid()}',now()
                )";
                // echo($sql_1);die();
            $xoopsDB->queryF($sql_1) or Utility::web_error($sql, __FILE__, __LINE__);
            $all[$stusn]['final_sum_sn'] = $xoopsDB->getInsertId(); //取得最後新增的編號

        }
        // die(var_dump($all));

        foreach($all as $stusn=>$v){
            // 段考成績欄位"final_score_sn" 對映到 yy_stage_sum  sn
            $tbl = $xoopsDB->prefix('yy_stage_score');
            $sql = "update `$tbl` set `final_score_sn`   = '{$v['final_sum_sn']}'
                        where `course_id`   = '{$coursid}'
                        AND `student_sn`   = '{$stusn}'
                        ";
            // echo($sql);die();
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }
        // die(var_dump($all));
        
        // 段考成績欄位"final_score_sn" 對映到 yy_stage_sum  sn
        foreach($all as $stusn=>$v){
            $tbl = $xoopsDB->prefix('yy_uscore_avg');
            $sql = "update `$tbl` set `final_score_sn`   = '{$v['final_sum_sn']}'
                        where `course_id`   = '{$coursid}'
                        AND `student_sn`   = '{$stusn}'
                        ";
            // echo($sql);die();
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }

    }

    // 計算平時成績 平均
    public function uscore_avg($coursid='',$stage=''){
        global $xoopsDB,$xoopsUser;

        // 算出每位學生總平均
        $tb1      = $xoopsDB->prefix('yy_usual_score');
        $sql      = "SELECT * FROM $tb1  
                        Where `course_id`='{$coursid}' 
                        AND `exam_stage` = '{$stage}'
                        ORDER BY `exam_stage`,`exam_number` 
                    ";
        $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        // echo($sql);die();
        $all=[];
        while($data= $xoopsDB->fetchArray($result)){
            $all[$data['student_sn']][]=$data['score'];
        }
        foreach($all as $stu_sn=>$score_ary){
            $i=$sum=0;
            
            foreach($score_ary as $seq=>$score){
                if(is_numeric($score)){
                    $i++;
                    $sum=$sum+ (float)$score;
                }
            }
            // var_dump($sum);die();
            if($i==0){
                $all[$stu_sn]['avg']='-';
            }else{
                $all[$stu_sn]['avg']=(float)($sum/$i);
            }

        }
        // die(var_dump($all));

        // 刪除學生平均成績
        $tbl = $xoopsDB->prefix('yy_uscore_avg');
        $sql = "DELETE FROM `$tbl` 
            WHERE `course_id`   = '{$coursid}'
            AND   `exam_stage`  = '{$stage}'
            ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        // 新增學生平均成績
        $tbl = $xoopsDB->prefix('yy_uscore_avg');
        foreach($all as $stusn=>$v){
            $sql_1 = "insert into `$tbl` (
                `course_id`,`exam_stage`,`student_sn`,`avgscore`,`update_user`,
                `update_date`
                ) 
                values(
                '{$coursid}','{$stage}','{$stusn}','{$v['avg']}','{$xoopsUser->uid()}',
                now()
                )";
                // echo($sql_1);die();
            $xoopsDB->queryF($sql_1) or Utility::web_error($sql, __FILE__, __LINE__);
            $all[$stusn]['avg_sn'] = $xoopsDB->getInsertId(); //取得最後新增的編號

        }
        // die(var_dump($all));

        // 學生平時成績修改欄位"usual_average_sn" 對映到 平均成績資料表 sn
        foreach($all as $stusn=>$v){
            $tbl = $xoopsDB->prefix('yy_usual_score');
            $sql = "update `$tbl` set `usual_average_sn`   = '{$v['avg_sn']}'
                        where `course_id`   = '{$coursid}'
                        AND `exam_stage`   = '{$stage}'
                        AND `student_sn`   = '{$stusn}'
                        ";
    
            // echo($sql);die();
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }
    }

    // get 目前考試keyin日期
    public function exam_date_check($name=''){
        global $xoopsDB;
        $tbl        = $xoopsDB->prefix('yy_exam_keyin_daterange');
        $sql        = "SELECT * FROM $tbl 
                        Where `exam_year`='{$this->sem_year}'
                        AND `exam_term`='{$this->sem_term}'
                        AND `exam_name` ='$name'
                        ORDER BY sort
                        ";
        $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        // echo($sql);die();
        $data= $xoopsDB->fetchArray($result);
        $today= date("Y-m-d");

        if($data['status']=='0'){
            return true;
        }elseif (((strtotime($data['start_date']))<=(strtotime($today)))&&((strtotime($data['end_date']))>=(strtotime($today)))){
            return true;
        }else{
            return false;
        }
        
        // var_dump('name:'.$name);// var_dump('sdate:'.$data['start_date']);// var_dump('edate:'.$data['end_date']);// var_dump('today:'.$today);
        // var_dump('a:'.$a);// die();
    }

    // get 目前課程資料
    private function get_course(){
        global $xoopsDB;
        $tbl = $xoopsDB->prefix('yy_course');
        $sql            = "SELECT * FROM $tbl 
                            Where `cos_year`='{$this->sem_year}' 
                                AND `cos_term`='{$this->sem_term}' 
                                AND `status`='1' 
                                order by sort,tea_id ,dep_id 
                        ";
        $result         = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $tea_course=$dep2course=$courese_chn=$all_course=[];
        while($all= $xoopsDB->fetchArray($result)){
            $tea_course[$all['tea_id']][$all['dep_id']][]= $all['sn'];
            $dep2course[$all['dep_id']][]= $all['sn'];
            $courese_chn[$all['sn']]=$all['cos_name'];
            $courese_chn[$all['sn']]=$all['cos_name'];
            $all_course[$all['sn']]=$all;
        }
        $this->tea_course = $tea_course;
        $this->dep2course = $dep2course;
        $this->courese_chn = $courese_chn;
        $this->all_course = $all_course;
    }
    
    // get 學期資料
    private function get_semester(){
        global $xoopsDB;
        $tbl = $xoopsDB->prefix('yy_semester');
        $sql            = "SELECT * FROM $tbl Where `activity`='1'";
        $result         = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $school_year    = $xoopsDB->fetchArray($result);
        $this->sem_sn   = $school_year['sn'];
        $this->sem_year = $school_year['year'];
        $this->sem_term = $school_year['term'];

        $sql            = "SELECT * FROM $tbl";
        $result         = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $sem_all=[];
        while($all= $xoopsDB->fetchArray($result)){
            $sem_all[] = $all;
        }
        $this->all_sems = $sem_all;
    }
    // get 教師資料含處室
    private function get_teachers_data(){
        global $xoopsDB;
        // get all users
        $tb1 = $xoopsDB->prefix('users');
        $tb2 = $xoopsDB->prefix('yy_teacher');
        $tb3 = $xoopsDB->prefix('yy_dept_school');
        $sql = "SELECT 
                    $tb1.uid,$tb1.name,$tb1.uname,$tb1.email,
                    $tb2.dep_id,$tb2.sex,$tb2.phone,$tb2.cell_phone,$tb2.enable,$tb2.isteacher,
                    $tb3.dept_name
                FROM $tb1 LEFT JOIN $tb2 ON $tb1.uid=$tb2.uid
                    LEFT JOIN $tb3 ON $tb2.dep_id=$tb3.sn 
                    WHERE $tb1.uid !='1'
                ";
        // echo($sql);
        $sqlall=$sql." ORDER BY {$tb2}.sort";
        $result      = $xoopsDB->query($sqlall) or Utility::web_error($sql, __FILE__, __LINE__);
        $all=$uid2data=[];
        while($user= $xoopsDB->fetchArray($result)){
            $all[] = $user;
        }
        $this->users=$all;

        // get all teachers 
        $sql.= " AND $tb2.isteacher='1' ORDER BY {$tb2}.sort";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all    = [];
        while($tch= $xoopsDB->fetchArray($result)){
            $all[] = $tch;
        }
        $this->teachers=$all;
    }

    // get 班級資料
    private function get_class(){
        global $xoopsDB;
        $tb1 = $xoopsDB->prefix('yy_class');
        $tb2 = $xoopsDB->prefix('users');
        $sql = "SELECT * FROM $tb1 
                LEFT JOIN $tb2 ON $tb1.tutor_sn=$tb2.uid
        WHERE class_status='1'";
        // echo($sql);
        $result      = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all=[];
        while($class= $xoopsDB->fetchArray($result)){
            $all[] = $class;
        }
        $this->class=$all;
    }
    //get 學程資料
    private function get_dept(){
        global $xoopsDB;
        $tb1 = $xoopsDB->prefix('yy_department');
        $sql = "SELECT * FROM $tb1 WHERE dep_status='1'";
        // echo($sql);
        $result      = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all=$major_ary=[];
        while($rut= $xoopsDB->fetchArray($result)){
            $major_ary[$rut['sn']]=$rut['dep_name'];
            $all[$rut['sn']] = $rut;
        }
        $this->depsnname=$major_ary;
        $this->dept=$all;
    }
    //get 學校處室
    private function get_deptofsch(){
        global $xoopsDB;
        $tb1 = $xoopsDB->prefix('yy_dept_school');
        $sql = "SELECT * FROM $tb1 WHERE enable='1'";
        // echo($sql);
        $result      = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all=[];
        while($rut= $xoopsDB->fetchArray($result)){
            $all[] = $rut;
        }
        $this->deptofsch=$all;
    }

    // get 社工師及輔導老師 $a['uid']=value;
    private function get_social_guidance(){
        global $xoopsDB;
        $tb1 = $xoopsDB->prefix('users');
        $tb2 = $xoopsDB->prefix('yy_teacher');
        $tb3 = $xoopsDB->prefix('yy_dept_school');
        $sql = "SELECT 
                    $tb1.uid,$tb1.name,$tb1.uname,$tb1.email,
                    $tb2.dep_id,$tb2.sex,$tb2.phone,$tb2.cell_phone,$tb2.enable,$tb2.isteacher,
                    $tb3.dept_name
                FROM $tb1 LEFT JOIN $tb2 ON $tb1.uid=$tb2.uid
                    LEFT JOIN $tb3 ON $tb2.dep_id=$tb3.sn
                ";
        $sql_1 =$sql." WHERE $tb2.isguidance='1'";
        $result      = $xoopsDB->query($sql_1) or Utility::web_error($sql, __FILE__, __LINE__);
        $all=[];
        while($user= $xoopsDB->fetchArray($result)){
            $all[$user['uid']] = $user['name'];
        }
        $this->isguidance=$all;

        $sql_2 =$sql." WHERE $tb2.issocial='1'";
        $result      = $xoopsDB->query($sql_2) or Utility::web_error($sql, __FILE__, __LINE__);
        $all=[];
        while($user= $xoopsDB->fetchArray($result)){
            $all[$user['uid']] = $user['name'];
        }
        $this->issocial=$all;
    }

    // $a[uid]=name
    private function get_uid_name($cat='user'){
        $all=$this->users;
        $data=[];
        foreach ($all as $k=>$v){
            $data[$v['uid']]=$v['name'];
        }
        $this->uid2name=$data;

    }

    // get 學程 map 學生sn $a['dep_id']=stu_sn
    // get 學生sn map 中文姓名;
    private function get_stu_data(){
        global $xoopsDB;
        $tb1 = $xoopsDB->prefix('yy_student');
        $sql = "SELECT * FROM $tb1 
                WHERE `status` !='2'
                ORDER BY `sort`
                ";
        $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $stu_name=$major_stu=[];
        while($user= $xoopsDB->fetchArray($result)){
            $major_stu[$user['major_id']][] = $user['sn'];
            $stu_name[$user['sn']] = $user['stu_name'];
        }
        $this->major_stu=$major_stu;
        $this->stu_name=$stu_name;
    }

    // 部門名稱->user
    public function get_depts_user($cat='user'){
        if($cat=='user'){
            $all=$this->users;
        }else{
            $all=$this->teachers;
        }
        $data=[];
        foreach ($all as $k=>$v){
            $v['dep_id']=$v['dep_id']??'0';
            $v['dept_name']=$v['dept_name']??'未設定';
            $data[$v['dept_name']][$v['uid']]=$v['name'];
        }
        return $data;
    }




    // php 單例模式 https://tw511.com/a/01/5633.html?fbclid=IwAR3TcfPeQaJslVc49aMbVbIN1pP8iXN8McbFUSv9KJNSFZPM0z8y9x-WAlM
    public static function aaa()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

}
