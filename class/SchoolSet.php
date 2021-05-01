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
    public $dept; //學程資料
    public $deptofsch; //處室資料
    public $isguidance; //輔導老師
    public $issocial; //社工師
    public $exam_name; //段考名稱
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
        $this->exam_name=[  '第一次段考前平時考','第一次段考','第二次段考前平時考','第二次段考','第三次段考前平時考','期末考'];

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
        $all=[];
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
        $all=[];
        while($rut= $xoopsDB->fetchArray($result)){
            $all[] = $rut;
        }
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

    // $a[uid]=name
    public function get_uid_name($cat='user'){
        $all=$this->users;
        $data=[];
        foreach ($all as $k=>$v){
            $data[$v['uid']]=$v['name'];
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
