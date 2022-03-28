<?php
use XoopsModules\Tadtools\Utility;

//其他自訂的共同的函數
if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php")) {
    redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50", 3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php";
// require_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;

// 算出日期區間
function date_range($first, $last){
    $dates  = array();
    $period = new DatePeriod(
        new DateTime($first),
        new DateInterval('P1D'),
        // new DateTime($last)
        new DateTime($last.'+1 days')
    );
    foreach ($period as $date) {
        // var_dump($period,$date);
        $dates[] = $date->format('Y-m-d');
    }
    return $dates;
}
function endKey($array){
    end($array);
    return key($array);
}
// 計算日間及夜間時數
function Calculation_days_off($sdate_time,$edate_time){
    $date_data=$date_result=[];
    // $sdate_time='2022-01-03 08:30';
    // $edate_time='2022-01-06 00:00';
    $daterange=date_range(date('Y-m-d',strtotime($sdate_time)),date('Y-m-d',strtotime($edate_time)));
    // var_dump($sdate_time,$edate_time);
    // 判斷是否連續一整天 
    foreach($daterange as $k=>$v) {
        if($k==0){
            $date_data[]['head']=$v;
        }elseif($k==endkey($daterange)){
            $date_data[]['tail']=$v;
        }else{
            $date_data[]['body']=$v;
        }
    }
    // var_dump($date_data);
    $s=strtotime($sdate_time);
    $e=strtotime($edate_time);

    $i=0;
    foreach($date_data as $vue){
        foreach($vue as $period=>$datetime_v){
            $a_str=$datetime_v.' 00:00';
            $b_str=$datetime_v.' 08:30';
            $c_str=$datetime_v.' 16:30';
            $d_str=date('Y-m-d H:i',strtotime($datetime_v.' 00:00 +1 day'));
            $a=strtotime($a_str);
            $b=strtotime($b_str);
            $c=strtotime($c_str);
            $d=strtotime($d_str);
            // var_dump($a_str,$b_str,$c_str,$d_str);
            // var_dump($a,$b,$c,$d);die();
            if($period=='head'){
                if($s<$b){
                    $date_result[$i]['period']='before';
                    $date_result[$i]['s']=$sdate_time;
                    if($e<=$b){
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$s)/3600;
                        $i++;
                    }elseif($e<=$c){
                        $date_result[$i]['e']=$b_str;
                        $date_result[$i]['hours']=($b-$s)/3600;
                        $i++;
                        $date_result[$i]['period']='day';
                        $date_result[$i]['s']=$b_str;
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$b)/3600;
                        $i++;
                    }elseif($e<=$d){
                        $date_result[$i]['e']=$b_str;
                        $date_result[$i]['hours']=($b-$s)/3600;
                        $i++;
                        $date_result[$i]['period']='day';
                        $date_result[$i]['s']=$b_str;
                        $date_result[$i]['e']=$c_str;
                        $date_result[$i]['hours']=($c-$b)/3600;
                        $i++;
                        $date_result[$i]['period']='night';
                        $date_result[$i]['s']=$c_str;
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$c)/3600;
                        $i++;
                    }else{
                        $date_result[$i]['e']=$b_str;
                        $date_result[$i]['hours']=($b-$s)/3600;
                        $i++;
                        $date_result[$i]['period']='day';
                        $date_result[$i]['s']=$b_str;
                        $date_result[$i]['e']=$c_str;
                        $date_result[$i]['hours']=($c-$b)/3600;
                        $i++;
                        $date_result[$i]['period']='night';
                        $date_result[$i]['s']=$c_str;
                        $date_result[$i]['e']=$d_str;
                        $date_result[$i]['hours']=($d-$c)/3600;
                        $i++;
                    }
                }elseif($s>=$b && $s<$c){
                    $date_result[$i]['period']='day';
                    $date_result[$i]['s']=$sdate_time;
                    if($e<=$c){
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$s)/3600;
                        $i++;
                    }elseif($e<$d){
                        $date_result[$i]['e']=$c_str;
                        $date_result[$i]['hours']=($c-$s)/3600;
                        $i++;
                        $date_result[$i]['period']='night';
                        $date_result[$i]['s']=$c_str;
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$c)/3600;
                        $i++;
                    }else{
                        $date_result[$i]['e']=$c_str;
                        $date_result[$i]['hours']=($c-$s)/3600;
                        $i++;
                        $date_result[$i]['period']='night';
                        $date_result[$i]['s']=$c_str;
                        $date_result[$i]['e']=$d_str;
                        $date_result[$i]['hours']=($d-$c)/3600;
                        $i++;
                    }

                }elseif($s>=$c && $s<$d){
                    $date_result[$i]['period']='night';
                    $date_result[$i]['night']['s']=$sdate_time;
                    if($e<$d){
                        $date_result[$i]['night']['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$s)/3600;
                        $i++;
                    }else{
                        $date_result[$i]['night']['e']=$d_str;
                        $date_result[$i]['hours']=($d-$s)/3600;
                        $i++;
                    }
                }
            }
            if($period=='body'){
                $date_result[$i]['period']='before';
                $date_result[$i]['s']=$datetime_v.' 00:00';
                $date_result[$i]['e']=$datetime_v.' 08:30';
                $date_result[$i]['hours']=8.5;
                $i++;
                $date_result[$i]['period']='day';
                $date_result[$i]['s']=$datetime_v.' 08:30';
                $date_result[$i]['e']=$datetime_v.' 16:30';
                $date_result[$i]['hours']=8;
                $i++;
                $date_result[$i]['period']='night';
                $date_result[$i]['s']=$datetime_v.' 16:30';
                $date_result[$i]['e']=date('Y-m-d H:i',strtotime($datetime_v.' 00:00 +1 day'));
                $date_result[$i]['hours']=7.5;
                $i++;
            }
            if($period=='tail'){
                if($s<$a){
                    $date_result[$i]['period']='before';
                    $date_result[$i]['s']=$a_str;
                    if($e<=$b){
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$a)/3600;
                        $i++;
                    }elseif($e<=$c){
                        $date_result[$i]['e']=$b_str;
                        $date_result[$i]['hours']=($b-$a)/3600;
                        $i++;
                        $date_result[$i]['period']='day';
                        $date_result[$i]['s']=$b_str;
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$b)/3600;
                        $i++;
                    }else{
                        $date_result[$i]['e']=$b_str;
                        $date_result[$i]['hours']=($b-$a)/3600;
                        $i++;
                        $date_result[$i]['period']='day';
                        $date_result[$i]['s']=$b_str;
                        $date_result[$i]['e']=$c_str;
                        $date_result[$i]['hours']=($c-$b)/3600;
                        $i++;
                        $date_result[$i]['period']='night';
                        $date_result[$i]['s']=$c_str;
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$c)/3600;
                        $i++;
                    }
                }elseif($s>=$a && $s<$b){
                    $date_result[$i]['period']='before';
                    $date_result[$i]['s']=$sdate_time;
                    if($e<=$b){
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$s)/3600;
                        $i++;
                    }elseif($e<=$c){
                        $date_result[$i]['e']=$b_str;
                        $date_result[$i]['hours']=($b-$s)/3600;
                        $i++;
                        $date_result[$i]['period']='day';
                        $date_result[$i]['s']=$b_str;
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$b)/3600;
                        $i++;
                    }else{
                        $date_result[$i]['e']=$b_str;
                        $date_result[$i]['hours']=($b-$s)/3600;
                        $i++;
                        $date_result[$i]['period']='day';
                        $date_result[$i]['s']=$b_str;
                        $date_result[$i]['e']=$c_str;
                        $date_result[$i]['hours']=($c-$b)/3600;
                        $i++;
                        $date_result[$i]['period']='night';
                        $date_result[$i]['s']=$c_str;
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$c)/3600;
                        $i++;
                    }
                }elseif($s>=$b && $s<$c){
                    $date_result[$i]['period']='day';
                    $date_result[$i]['s']=$sdate_time;
                    if($e<=$c){
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$s)/3600;
                        $i++;
                    }elseif($e<=$d){
                        $date_result[$i]['e']=$c_str;
                        $date_result[$i]['hours']=($c-$s)/3600;
                        $i++;
                        $date_result[$i]['period']='night';
                        $date_result[$i]['s']=$c_str;
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$c)/3600;
                        $i++;
                    }
                }elseif($s>=$c && $s<=$d){
                    $date_result[$i]['period']='night';
                    $date_result[$i]['s']=$sdate_time;
                    $date_result[$i]['e']=$edate_time;
                    $date_result[$i]['hours']=($e-$s)/3600;
                    $i++;
                }
            }

        }
    }
    // var_dump($date_result);

    $return=[];
    foreach($date_result as $key=>$val){
        if($val['period']=='before' or $val['period']=='night'){
            $return['night_hr_sum']=$return['night_hr_sum']+round($val['hours'],2);
        }
        if($val['period']=='day'){
            $return['day_hr_sum']=$return['day_hr_sum']+round($val['hours'],2);
        }
    }
    $return['night_hr_sum']=$return['night_hr_sum']??0;
    $return['day_hr_sum']= $return['day_hr_sum']??0;

    // print_r($return);
    return($return);
    // die();
}
// 晨 日 夜
function Calculation_days_off1($sdate_time,$edate_time){
    $date_data=$date_result=[];
    // $sdate_time='2022-01-03 08:30';
    // $edate_time='2022-01-06 00:00';
    $daterange=date_range(date('Y-m-d',strtotime($sdate_time)),date('Y-m-d',strtotime($edate_time)));
    var_dump($sdate_time,$edate_time);
    // 判斷是否連續一整天 
    foreach($daterange as $k=>$v) {
        if($k==0){
            $date_data[]['head']=$v;
        }elseif($k==endkey($daterange)){
            $date_data[]['tail']=$v;
        }else{
            $date_data[]['body']=$v;
        }
    }
    // var_dump($date_data);
    $s=strtotime($sdate_time);
    $e=strtotime($edate_time);
    $i=0;
    foreach($date_data as $vue){
        foreach($vue as $period=>$datetime_v){
            $a_str=$datetime_v.' 00:00';
            $b_str=$datetime_v.' 08:30';
            $c_str=$datetime_v.' 16:30';
            $d_str=date('Y-m-d H:i',strtotime($datetime_v.' 00:00 +1 day'));
            $a=strtotime($a_str);
            $b=strtotime($b_str);
            $c=strtotime($c_str);
            $d=strtotime($d_str);
            // var_dump($a_str,$b_str,$c_str,$d_str);
            // var_dump($a,$b,$c,$d);die();
            if($period=='head'){
                if($s<$b){
                    $date_result[$i]['period']='before';
                    $date_result[$i]['s']=$sdate_time;
                    if($e<=$b){
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$s)/3600;
                        $i++;
                    }elseif($e<=$c){
                        $date_result[$i]['e']=$b_str;
                        $date_result[$i]['hours']=($b-$s)/3600;
                        $i++;
                        $date_result[$i]['period']='day';
                        $date_result[$i]['s']=$b_str;
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$b)/3600;
                        $i++;
                    }elseif($e<=$d){
                        $date_result[$i]['e']=$b_str;
                        $date_result[$i]['hours']=($b-$s)/3600;
                        $i++;
                        $date_result[$i]['period']='day';
                        $date_result[$i]['s']=$b_str;
                        $date_result[$i]['e']=$c_str;
                        $date_result[$i]['hours']=($c-$b)/3600;
                        $i++;
                        $date_result[$i]['period']='night';
                        $date_result[$i]['s']=$c_str;
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$c)/3600;
                        $i++;
                    }else{
                        $date_result[$i]['e']=$b_str;
                        $date_result[$i]['hours']=($b-$s)/3600;
                        $i++;
                        $date_result[$i]['period']='day';
                        $date_result[$i]['s']=$b_str;
                        $date_result[$i]['e']=$c_str;
                        $date_result[$i]['hours']=($c-$b)/3600;
                        $i++;
                        $date_result[$i]['period']='night';
                        $date_result[$i]['s']=$c_str;
                        $date_result[$i]['e']=$d_str;
                        $date_result[$i]['hours']=($d-$c)/3600;
                        $i++;
                    }
                }elseif($s>=$b && $s<$c){
                    $date_result[$i]['period']='day';
                    $date_result[$i]['s']=$sdate_time;
                    if($e<=$c){
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$s)/3600;
                        $i++;
                    }elseif($e<$d){
                        $date_result[$i]['e']=$c_str;
                        $date_result[$i]['hours']=($c-$s)/3600;
                        $i++;
                        $date_result[$i]['period']='night';
                        $date_result[$i]['s']=$c_str;
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($c-$e)/3600;
                        $i++;
                    }else{
                        $date_result[$i]['e']=$c_str;
                        $date_result[$i]['hours']=($c-$s)/3600;
                        $i++;
                        $date_result[$i]['period']='night';
                        $date_result[$i]['s']=$c_str;
                        $date_result[$i]['e']=$d_str;
                        $date_result[$i]['hours']=($c-$d)/3600;
                        $i++;
                    }
                }elseif($s>=$c && $s<$d){
                    $date_result[$i]['period']='night';
                    $date_result[$i]['night']['s']=$sdate_time;
                    if($e<$d){
                        $date_result[$i]['night']['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$s)/3600;
                        $i++;
                    }else{
                        $date_result[$i]['night']['e']=$d_str;
                        $date_result[$i]['hours']=($d-$s)/3600;
                        $i++;
                    }
                }
            }
            if($period=='body'){
                $date_result[$i]['period']='before';
                $date_result[$i]['s']=$datetime_v.' 00:00';
                $date_result[$i]['e']=$datetime_v.' 08:30';
                $date_result[$i]['hours']=8.5;
                $i++;
                $date_result[$i]['period']='day';
                $date_result[$i]['s']=$datetime_v.' 08:30';
                $date_result[$i]['e']=$datetime_v.' 16:30';
                $date_result[$i]['hours']=8;
                $i++;
                $date_result[$i]['period']='night';
                $date_result[$i]['s']=$datetime_v.' 16:30';
                $date_result[$i]['e']=date('Y-m-d H:i',strtotime($datetime_v.' 00:00 +1 day'));
                $date_result[$i]['hours']=7.5;
                $i++;
            }
            if($period=='tail'){
                if($s<$a){
                    $date_result[$i]['period']='before';
                    $date_result[$i]['s']=$a_str;
                    if($e<=$b){
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$a)/3600;
                        $i++;
                    }elseif($e<=$c){
                        $date_result[$i]['e']=$b_str;
                        $date_result[$i]['hours']=($b-$a)/3600;
                        $i++;
                        $date_result[$i]['period']='day';
                        $date_result[$i]['s']=$b_str;
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$b)/3600;
                        $i++;
                    }else{
                        $date_result[$i]['e']=$b_str;
                        $date_result[$i]['hours']=($b-$a)/3600;
                        $i++;
                        $date_result[$i]['period']='day';
                        $date_result[$i]['s']=$b_str;
                        $date_result[$i]['e']=$c_str;
                        $date_result[$i]['hours']=($c-$b)/3600;
                        $i++;
                        $date_result[$i]['period']='night';
                        $date_result[$i]['s']=$c_str;
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$c)/3600;
                        $i++;
                    }
                }elseif($s>=$a && $s<$b){
                    $date_result[$i]['period']='before';
                    $date_result[$i]['s']=$sdate_time;
                    if($e<=$b){
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$s)/3600;
                        $i++;
                    }elseif($e<=$c){
                        $date_result[$i]['e']=$b_str;
                        $date_result[$i]['hours']=($b-$s)/3600;
                        $i++;
                        $date_result[$i]['period']='day';
                        $date_result[$i]['s']=$b_str;
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$b)/3600;
                        $i++;
                    }else{
                        $date_result[$i]['e']=$b_str;
                        $date_result[$i]['hours']=($b-$s)/3600;
                        $i++;
                        $date_result[$i]['period']='day';
                        $date_result[$i]['s']=$b_str;
                        $date_result[$i]['e']=$c_str;
                        $date_result[$i]['hours']=($c-$b)/3600;
                        $i++;
                        $date_result[$i]['period']='night';
                        $date_result[$i]['s']=$c_str;
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$c)/3600;
                        $i++;
                    }
                }elseif($s>=$b && $s<$c){
                    $date_result[$i]['period']='day';
                    $date_result[$i]['s']=$sdate_time;
                    if($e<=$c){
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$s)/3600;
                        $i++;
                    }elseif($e<=$d){
                        $date_result[$i]['e']=$c_str;
                        $date_result[$i]['hours']=($c-$s)/3600;
                        $i++;
                        $date_result[$i]['period']='night';
                        $date_result[$i]['s']=$c_str;
                        $date_result[$i]['e']=$edate_time;
                        $date_result[$i]['hours']=($e-$c)/3600;
                        $i++;
                    }
                }elseif($s>=$c && $s<=$d){
                    $date_result[$i]['period']='night';
                    $date_result[$i]['s']=$sdate_time;
                    $date_result[$i]['e']=$edate_time;
                    $date_result[$i]['hours']=($e-$s)/3600;
                    $i++;
                }
            }

        }
    }
    print_r($date_result);
    // die();
}

//判斷進步獎
function progress_award($score=0){
    $number=(int)(round($score,2));
    if($number>=10){
        $msg = "｢進步獎｣獎狀一張、白鴿3支。";
    } elseif($number>=9){
        $msg = "｢進步獎｣:白鴿3支。";
    } elseif($number>=6){
        $msg = "｢進步獎｣:白鴿2支。";
    } elseif($number>=3){
        $msg = "｢進步獎｣:白鴿1支。";
    } else {
        $msg = "";
    }
    
    return $msg;
}

//判斷成績等弟
function score_range($score=0,$exam_stage='2'){
    $number=(int)(round($score,0));

    if($exam_stage=='8'){
        if($number>=90){
            $msg = "｢狀元獎｣獎狀一張、嘉獎一支。";
        } elseif($number>=85){
            $msg = "｢榜眼獎｣獎狀一張、嘉獎一支。";
        } elseif($number>=80){
            $msg = "｢探花獎｣獎狀一張、白鴿3支。";
        } else {
            $msg = "";
        }
    }else{
        if($number>=90){
            $msg = "｢狀元獎｣獎狀一張、嘉獎一支。";
        } elseif($number>=85){
            $msg = "｢榜眼獎｣獎狀一張、白鴿3支。";
        } elseif($number>=80){
            $msg = "｢探花獎｣獎狀一張、白鴿2支。";
        } else {
            $msg = "";
        }
    }
    return $msg;
}

// 姓名改為匿名
function name_substr_cut($user_name){
    $strlen     = mb_strlen($user_name, 'utf-8');
    $firstStr     = mb_substr($user_name, 0, 1, 'utf-8');
    $lastStr     = mb_substr($user_name, -1, 1, 'utf-8');
    return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
}

// Get text color radio html
function color_radio_htm($ary=[],$name,$value='0',$condition='1',$br='0'){
    $htm='';
    foreach ($ary as $k=>$v){
        $chk= ($value==$k)?'checked':'';
        $color= ($k<=(int)$condition)?'text-success':'text-danger';
        if($br=='0'){
            $br_sign='';
        }else{
            $br_sign= ($k==(int)$condition)?'<br>':'';
        }
        $htm.=<<<HTML
        <div class="form-check form-check-inline m-2">
            <input class="form-check-input" type="radio" name="{$name}" id="{$name}_{$k}" title="{$v}" value="{$k}" {$chk}>
            <label class="form-check-label {$color}" for="{$name}_{$k}">{$v}</label>
        </div>
        {$br_sign}
    HTML;
    }
    return $htm;
}

// Get radio html
function radio_htm($ary=[],$name,$value='0'){
    $htm='';
    foreach ($ary as $k=>$v){
        $chk= ($value==$k)?'checked':'';
        $htm.=<<<HTML
        <div class="form-check form-check-inline my-2">
            <input class="form-check-input" type="radio" name="{$name}" id="{$name}_{$k}" title="{$v}" value="{$k}" {$chk}>
            <label class="form-check-label" for="{$name}_{$k}">{$v}</label>
        </div>
    HTML;
    }
    return $htm;
}



function checkbox_htm($ary=[],$name,$value=[],$size=2){
    $htm='';
    foreach ($ary as $k=>$v){
        // $chk= ($value==$k)?'checked':'';
        if(in_array($k,$value)){
            $chk='checked';
        }else{
            $chk='';
        }
        $htm.=<<<HTML
            <div class="form-check form-check-inline col-{$size}">
                <input class="form-check-input" type="checkbox" name="{$name}" id="{$name}_{$k}" value="{$k}" {$chk}>
                <label class="form-check-label" for="{$name}_{$k}">{$v}</label>
            </div>
    HTML;
    }
    return $htm;
}

//取得select option htm
function Get_select_grp_opt_htm($ary=[],$value='',$show_space='1')
{
    if($show_space=='1'){
        $return_htm='<option></option>';
    }else{
        $return_htm='';
    }
    foreach ($ary as $grp_name=>$v1){
        $return_htm.="<optgroup label='{$grp_name}'>";
        foreach ($v1 as $k=>$v){
            $selected= ($value==strval($k))?'selected':'';
            $return_htm.="<option value='{$k}' {$selected}>{$v}</option>";
        }
    }
    return ($return_htm);
}


function Get_select_opt_color_htm($ary=[],$value='',$show_space='1',$sel_val=[])
{
    if($show_space=='1'){
        $return_htm='<option></option>';
    }else{
        $return_htm='';
    }
    foreach ($ary as $k=>$v){
        $selected= ($value==strval($k))?'selected':'';
        $color=(in_array(strval($k),$sel_val))?"class='tea_list sel_exist'":"class='tea_list'";
        $return_htm.="<option {$color} value='{$k}' {$selected}>{$v}</option>";
    }
    return ($return_htm);
}

//取得select option htm
function Get_select_opt_htm($ary=[],$value='',$show_space='1')
{
    if($show_space=='1'){
        $return_htm='<option></option>';
    }else{
        $return_htm='';
    }
    foreach ($ary as $k=>$v){
        $selected= ($value==strval($k))?'selected':'';
        $return_htm.="<option value='{$k}' {$selected}>{$v}</option>";
    }
    return ($return_htm);
}

//get bootstrap custom-switch
function Get_bootstrap_switch_opt_htm($name,$sn='',$value='')
{
    $checked= ($value=='1')?'checked':'';
    $return_htm=
        "<input type='checkbox' class='custom-control-input' name='sw_{$name}' id='{$name}_{$sn}' value='{$sn}' {$checked}>
        <label class='custom-control-label' for='{$name}_{$sn}'></label>";
    return ($return_htm);
}


// 取得使用者資料
function users_data($uid){
    global $xoopsDB;
    $tbl      = $xoopsDB->prefix('users');
    $sql      = "SELECT `uid`,`name`,`uname`,`email` FROM $tbl Where `uid`='{$uid}'";
    $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $user = $xoopsDB->fetchArray($result);//fetchrow
    // var_dump($user);die();
    return $user;
}

// 取得使用者群組
function users_group($uid){
    global $xoopsDB;
    $tbl      = $xoopsDB->prefix('groups_users_link');
    $sql      = "SELECT * FROM $tbl Where `uid`='{$uid}'";
    $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    while($group= $xoopsDB->fetchArray($result)){
        $groups[]=$group['groupid'];
    }
    return $groups;
}
    //更新群組
function update_group($uid){
    global $xoopsDB;
    // die(var_dump($_POST['group']));
    $sql = "delete from " . $xoopsDB->prefix("groups_users_link") . "  where uid='$uid'";
    $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    foreach ($_POST['group'] as $group_id) {
        $group_id = (int) $group_id;
        $sql = "insert into " . $xoopsDB->prefix("groups_users_link") . " (`groupid` , `uid`) values('$group_id','$uid')";
        $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    }

}

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
 


if (!function_exists('word_cut')) {
    function word_cut($string, $limit, $pad = "...")
    {
        $len = mb_strlen($string, 'UTF-8');
        if ($len <= $limit) {
            return $string;
        }

        //先找出裁切後的字串有多少英文字
        $tmp_content = mb_substr($string, 0, $limit, 'UTF-8');
        preg_match_all('/(\w)/', $tmp_content, $match);
        $eng = count($match[1]);
        $add = round($eng / 2, 0);
        $limit += $add;
        $string = mb_substr($string, 0, $limit, 'UTF-8');
        return $string . $pad;
    }
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

/* <select class="form-select" aria-label="Default select example">
    <optgroup label="asdf">
    <option selected>Open this select menu</option>
    <option value="1">One</option>
    <option value="2">Two</option>
    <option value="3">Three</option>
    </optgroup>
  </select> */

/*  shift alt + a
if(!($stu['tea_uid']==$xoopsUser->uid() OR $xoopsUser->isAdmin())){
    redirect_header('tchstu_mag.php?op=counseling_list', 3, '非填報人員，無權限 !error:2106131027');
}
 */


/* 權限控管，傳到樣版判斷顯示刪除、修改
if(power_chk("beck_iscore", "1")){
    $xoopsTpl->assign('student_post', true);
}
if(power_chk("beck_iscore", "2")){
    $xoopsTpl->assign('student_delete', true);
}
if(power_chk("read", "1")){$xoopsTpl->assign('', true);}
 */


/* 取得目前使用者的群組編號
if (!isset($_SESSION['groups']) or $_SESSION['groups'] === '') {
    $_SESSION['groups'] = ($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
}
var_dump($_SESSION['groups']);
 */

//         http://localhost/beck_iscore/index.php?op=announcement_class_list
// http://localhost/modules/beck_iscore/index.php?op=announcement_class_list
// a1234567




//上傳附檔
// $TadUpFiles=new TadUpFiles("beck_iscore","/student",$file="/file",$image="/image",$thumbs="/image/.thumbs");
// $TadUpFiles->set_col('stu_file',$sn); //若 $show_list_del_file ==true 時一定要有
// $upform=$TadUpFiles->upform(true,'stu_file');
// $form->addElement(new XoopsFormLabel('附檔', $upform));



    // $ann_class_id = $myts->htmlSpecialChars($_POST['ann_c']);
// $dept_id      = $myts->htmlSpecialChars($_POST['dept_c']);
// $title        = $myts->htmlSpecialChars($_POST['title']);
// $content      = $myts->displayTarea($_POST['content'], 1, 0, 0, 0, 0);
// // 過濾到期日
// if (validateDate($_POST['end_date'],$format = 'Y-m-d')){
//     $end_date=$_POST['end_date'];
// }else{
//     echo('公告到期日錯誤');
// }
// $top       = $myts->htmlSpecialChars($_POST['top']);
// $uid       = $myts->htmlSpecialChars($_POST['uid']);
// echo "<p>\$ann_class_id={$ann_class_id}</p>";
// echo "<p>\$dept_id={$dept_id}</p>";
// echo "<p>\$title={$title}</p>";
// echo "<p>\$content={$content}</p>";
// echo "<p>\$end_date={$end_date}</p>";
// echo "<p>\$top={$top}</p>";
// die();