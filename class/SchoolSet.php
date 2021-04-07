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
    public $sem_year; //學年度
    public $sem_term; //學期
    // public $tch_sex; //性別
 


    //建構函數
    public function __construct()
    {            
        global $xoopsDB, $xoopsTpl, $xoopsUser , $xoopsConfig;
        $tbl = $xoopsDB->prefix('yy_semester');
        $sql         = "SELECT * FROM $tbl Where `activity`='1'";
        $result      = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $school_year = $xoopsDB->fetchArray($result);
        $this->sem_sn=$school_year['sn'];
        $this->sem_year=$school_year['year'];
        $this->sem_term=$school_year['term'];
    }

    public static function aaa()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

    //Get學期 option html
    public function Get_term_htm($term='',$show_space='1')
    {
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
    public function Get_activity_htm($value='0')
    {
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
