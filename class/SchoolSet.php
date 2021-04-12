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

//TadNews物件
/*



 */
class SchoolSet
{
    private static $_instance;
    public $sem_sn; //學年度編號
    public $sem_year; //目前學年度
    public $sem_term; //目前學期
    public $users; //使用者資料
    public $teachers; //教師資料
    public $class; //班級資料
    public $dept; //學程資料
    public $deptofsch; //處室資料
    public $isguidance; //輔導老師
    public $issocial; //社工師
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

    }
    // get 學期資料
    private function get_semester(){
        global $xoopsDB;
        $tbl = $xoopsDB->prefix('yy_semester');
        $sql         = "SELECT * FROM $tbl Where `activity`='1'";
        $result      = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $school_year = $xoopsDB->fetchArray($result);
        $this->sem_sn=$school_year['sn'];
        $this->sem_year=$school_year['year'];
        $this->sem_term=$school_year['term'];
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
        $result      = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all=[];
        while($user= $xoopsDB->fetchArray($result)){
            $all[] = $user;
        }
        $this->users=$all;

        // get all teachers 
        $sql.= " AND $tb2.isteacher='1' ";
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

    // UID->name
    public function get_uid_name($cat='user'){
        $all=$this->users;
        $data=[];
        foreach ($all as $k=>$v){
            $data[$v['uid']]=$v['name'];
        }
        return $data;
    }




    public static function aaa()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

    //Get學期 option html
    public function Get_term_htm($term='',$show_space='1'){
        global $xoopsDB, $xoopsTpl, $xoopsUser;

        $terms=['1','2'];
        if($show_space=='0'){
            $return_htm='';
        }else{
            $return_htm='<option></option>';
        }
        foreach ($terms as $v){
            $selected= ($term==$v)?'selected':'';
            $return_htm.="<option value='{$v}' {$selected}>{$v}</option>";
        }

        // $tbl     = $xoopsDB->prefix('yy_dept_school');
        // $sql     = "SELECT * FROM $tbl WHERE `enable` ='1' ORDER BY `sn`";
        // $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        // if($space=='0'){
        //     $htm='<option selected></option>';
        // }else{
        //     $htm='';
        // }

        // while($Dept_cls= $xoopsDB->fetchArray($result)){
        //     $selected= ($Dept_c_id==$Dept_cls['sn'])?'selected':'';
        //     $htm.='<option value="'.$Dept_cls['sn'].'" '.$selected.'  >'.$Dept_cls['dept_name'].'</option>';
        // }

        // var_dump($htm);die();
        return ($return_htm);
    }

     //Get現在學年度 option html
    public function Get_activity_htm($value='0'){
        global $xoopsDB, $xoopsTpl, $xoopsUser;
        // 是否: 現在學年度
        $default = (!isset($default)) ? '0' : $default;
        $opt_ary=['0'=>'否','1'=>'是'];
        $yn_option='';
        foreach ($opt_ary as $k=>$v){
            $chk= ($value==$k)?'checked':'';
            $yn_option.=<<<HTML
            <div class="form-check form-check-inline  m-2">
                <input class="form-check-input" type="radio" name="activity" id="activity{$k}" title="{$v}" value="{$k}" {$chk}>
                <label class="form-check-label" for="activity{$k}">{$v}</label>
            </div>
        HTML;
        }
        // die(var_dump($yn_option));
        return ($yn_option);
    }




}
