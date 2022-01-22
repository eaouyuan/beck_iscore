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
    public $sem_term_sdate; //目前學期 起始日期
    public $sem_term_edate; //目前學期 起始日期
    public $all_sems; //所有學年度資料
    public $users; //使用者資料
    public $en_users; //啟用狀態的使用者
    public $uid2name; // uid map 中文姓名
    public $teachers; //教師資料
    public $isguidance; //輔導老師
    public $issocial; //社工師
    public $dept; //學程資料 enable
    public $depsnname; //['4'=>'資料處理科']學程中文名稱 sn map name
    public $all_dept;
    public $all_depsnname; //所有學程
    public $deptofsch; //處室資料
    public $exam_name; //考試名稱
    public $usual_exam_name; //平時考名稱
    public $stage_exam_name; //段考名稱
    public $dep2course; //學程對課程
    public $dep_exam_course; //[學程id][段考ID][課程id] = [課程中文名]
    public $major_stu; // [學程id][]= stu sn 
    public $all_course; //所有課程 sn-> data
    public $tea_course; //本學期教師課表 教師  學程 課程
    public $courese_chn; //課程中文名稱
    public $class_name; //['1'=>'友仁']班級sn -> name
    public $class_name_all; //['1'=>'友仁']班級sn -> name
    public $tutorid_classid; // 導師 id -> 班級id 
    public $class_tutorid; // 班級sn -> tutor_id 
    public $class_tutor_name; // ['1'=>'黃淑滿']班級sn -> 導師名稱
    public $classname_stuid; //[友仁][1]=王小明
    public $classid_stuid; //[class id][stu id]=王小明
    public $stu_name; //  [stu sn]=name   , 學生sn map name
    public $stu_name_all; //  [stu sn]=name   ,所有學生sn map name
    public $stu_anonymous; //  ['390'=>'王*明'] stu_anonymous , 學生sn map 學生匿名
    public $stu_anonymous_all; //  ['390'=>'王*明'] stu_anonymous , 學生sn map 所有學生匿名
    public $stu_grade; //  ['390'=>'1'] 學生sn map 年級
    public $stu_sn_classid; //  [stu sn]=class id  , 學生sn map 班級id
    public $stu_sn_classid_all; //  [stu sn]=class id  , 學生sn map 班級id  所有學生對班級ID
    public $stu_dep; //[stu sn]= dep id 學生 學程
    public $stu_id; // 學生 學號
    public $stu_id_all; // 學生 學號
    public $month_ary; // 月份陣列
    public $sys_config; // config
    public $sys_var; // config
    public $RP_kind; 
    public $RP_option; 
    public $RP_unit; 
    public $AB_kind;  //請假種類
    public $AB_kind_anther;  //請假種類(含其他)
    public $AB_period;  //請假時段
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
        $this->dep2exam()    ;// 學程瓶段考科目
        $this->get_config_data()    ;// config
        $this->exam_name = ['1'=>'第一次段考前平時考','2'=>'第一次段考','3'=>'第二次段考前平時考','4'=>'第二次段考','5'=>'第三次段考前平時考','6'=>'期末考'];
        $this->usual_exam_name=['1'=>'第一次段考前平時考','3'=>'第二次段考前平時考','5'=>'第三次段考前平時考'];
        $this->stage_exam_name=['2'=>'第一次段考','4'=>'第二次段考','6'=>'期末考'];
        $this->month_ary=['01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12'];
        $this->RP_kind=['1'=>'獎勵','2'=>'懲罰']; 
        $this->RP_option=['1'=>'白鴿','2'=>'嘉獎','3'=>'小功','4'=>'大功','5'=>'榮譽假時數','6'=>'警告','7'=>'小過','8'=>'大過','9'=>'減少榮舉假','10'=>'罰勤'];          
        $this->RP_unit=['1'=>'次','2'=>'小時','3'=>'支']; 
        $this->AB_kind=['A'=>'公假','B'=>'事假','C'=>'病假','D'=>'喪假','E'=>'曠課','G'=>'晤談']; 
        $this->AB_kind_anther=['A'=>'公假','B'=>'事假','C'=>'病假','D'=>'喪假','E'=>'曠課','G'=>'晤談','99'=>'其他']; 
        $this->AB_period=['1'=>'晨間','2'=>'日間','3'=>'夜間']; 
        $this->MentorCommentA=
            ['1'=>'熱心公益','3'=>'急公好義','2'=>'誠懇篤實','4'=>'行為端正','5'=>'品行端正','6'=>'秀外慧中','7'=>'溫良恭儉','8'=>'擇善固執','9'=>'性情溫良','10'=>'忠厚勤勞','11'=>'安份守己','12'=>'和藹可親','13'=>'忠厚穩重','14'=>'性情直爽','15'=>'克己助人','16'=>'敬友樂群','17'=>'有領導力','18'=>'多才多藝','19'=>'天真善良','20'=>'敦厚善良','21'=>'開朗樂觀','22'=>'遇事樂觀','23'=>'心思敏捷','24'=>'勤誠穩重','25'=>'熱誠和藹','26'=>'活潑進取','27'=>'富正義感','28'=>'誠篤守分','29'=>'氣宇軒昂','30'=>'誠懇樸實','31'=>'思想純正','32'=>'體格健全','33'=>'有責任心','34'=>'捨己為群','35'=>'明識大體','36'=>'一諾千金','37'=>'性凌欺人','38'=>'斤斤計較','39'=>'暮氣沈沈','40'=>'任性妄為','41'=>'目中無人','42'=>'自私自利','43'=>'自命不凡','44'=>'言不由衷','45'=>'憤世嫉俗','46'=>'口無擇言','47'=>'多愁善感','48'=>'血氣方剛','49'=>'志切上進','50'=>'勤勉不懈','51'=>'敬業樂群','52'=>'刻苦自勵','53'=>'專心向學','54'=>'孜孜不倦','55'=>'努力求知','56'=>'學業優良','57'=>'進取有為','58'=>'努力課業','59'=>'刻苦好學','60'=>'力學不倦','61'=>'精敏學勤','62'=>'勤學敦品','63'=>'勵志篤學','64'=>'虛心學習','65'=>'沉著努力','66'=>'勤儉向學','67'=>'沉靜好學','68'=>'頗知進取','69'=>'潛力深厚','70'=>'力圖自強','71'=>'有始有終','72'=>'不可限量','73'=>'不恥下問','74'=>'突飛猛進','75'=>'競競業業','76'=>'腳踏實地','77'=>'捨己為人','78'=>'即知即行','79'=>'實事求是','80'=>'拾金不昧','81'=>'知過能改','82'=>'尚能自治','83'=>'好管閒事','84'=>'行為隨便','85'=>'外務太多','86'=>'行為放蕩','87'=>'好生是非','88'=>'頑迷不改','89'=>'頑皮成性','90'=>'擾亂秩序','91'=>'屢戒屢犯','92'=>'行為不檢','93'=>'過失屢犯','94'=>'性情乖僻','95'=>'言語傲慢','96'=>'惹事招非','97'=>'缺乏朝氣','98'=>'得過且過','99'=>'屢犯小過','100'=>'行為隨便','101'=>'言行欠慎','102'=>'不知自檢','103'=>'遇事敷衍','104'=>'處事馬虎']; 
        $this->MentorCommentB=
            ['105'=>'不切實際','106'=>'時犯小錯','107'=>'做事迷糊','108'=>'不修邊幅','109'=>'玩世不恭','110'=>'好逸務勞','111'=>'驕生慣養','112'=>'浮華不實','113'=>'不屈不撓','114'=>'不卑不亢','115'=>'仗義執言','116'=>'光明磊落','117'=>'出類拔萃','118'=>'堂堂正正','119'=>'堅苦卓絕','120'=>'大公無私','121'=>'寬大仁愛','122'=>'從善如流','123'=>'心地光明','124'=>'忠厚待人','125'=>'文質彬彬','126'=>'樂天知命','127'=>'精明強幹','128'=>'胸襟寬大','129'=>'開誠佈公','130'=>'功成不居','131'=>'謙沖自牧','132'=>'樂善好施','133'=>'樂於助人','134'=>'秀外慧中','135'=>'落落大方','136'=>'蕙質蘭心','137'=>'曲直分明','138'=>'誠意正心','139'=>'明禮知恥','140'=>'嫻淑文雅','141'=>'大家風範','142'=>'任勞任怨','143'=>'剛毅木訥','144'=>'古道熱腸','145'=>'天真爛漫','146'=>'奉公守法','147'=>'宅心仁厚','148'=>'心平氣和','149'=>'潔身自好','150'=>'文思泉湧','151'=>'力爭上游','152'=>'博學多聞','153'=>'專心致志','154'=>'才思敏捷','155'=>'精益求精','156'=>'見多識廣','157'=>'鍥而不捨','158'=>'循序漸進','159'=>'困知勉行','160'=>'手不釋卷','161'=>'見賢思齊','162'=>'漸入佳境','163'=>'虛心求教','164'=>'追根究柢','165'=>'以勤補拙','166'=>'大器晚成','167'=>'自強不息','168'=>'資質甚佳','169'=>'尚知勤學','170'=>'學行尚佳','171'=>'不知勤學','172'=>'忽作忽輟','173'=>'不知努力','174'=>'學習不專','175'=>'不安於學','176'=>'精神不振','177'=>'精神散漫','178'=>'稍欠學習','179'=>'懶散不振','180'=>'尚知努力','181'=>'尚知努力','182'=>'稍欠學習','183'=>'不知上進','184'=>'用心不專','185'=>'心欠沈靜','186'=>'心有外騖','187'=>'學習尚佳','188'=>'差強人意','189'=>'慢條斯理','190'=>'不拘小節','191'=>'假公濟私','192'=>'出言不遜','193'=>'吹毛求疵','194'=>'喋喋不休','195'=>'因循自誤','196'=>'執迷不悟','197'=>'大言不慚','198'=>'強辭奪理','199'=>'意氣用事','200'=>'我行我素','201'=>'揮攉無度','202'=>'操之過急','203'=>'故態復萌','204'=>'旁若無人','205'=>'明知故犯','206'=>'有己無人','207'=>'不知自愛','208'=>'臨事而懼']; 
        $this->MentorCommentC=
            ['209'=>'臨渴掘井','210'=>'避重就輕','211'=>'怨天尤人','212'=>'畏首畏尾','213'=>'畫地自限','214'=>'丟三落四','215'=>'敷衍塞責','216'=>'虎頭蛇尾','217'=>'大而化之','218'=>'目無尊長','219'=>'優游自得','220'=>'勞而不怨','221'=>'中規中矩','222'=>'聞過即改','223'=>'任勞任願','224'=>'禮節週到','225'=>'謙和有禮','226'=>'虛懷若谷','227'=>'刻苦耐勞','228'=>'心直口快','229'=>'獨善其身','230'=>'質純性懦','231'=>'多言好動','232'=>'性情浮躁','233'=>'陽奉陰違','234'=>'精於應付','235'=>'自暴自棄','236'=>'性情溫和','237'=>'性情保守','238'=>'性情倔強','239'=>'性情直率','240'=>'損人害己','241'=>'天真好動','242'=>'心情沉靜','243'=>'性情偏狹','244'=>'平庸自守','245'=>'活潑好動','246'=>'聰明好辯','247'=>'俠義心腸','248'=>'能言善道','249'=>'沉默寡言','250'=>'好勝心強','251'=>'明哲保身','252'=>'行為自私','253'=>'性情懦弱','254'=>'好大喜功','255'=>'時生爭執','256'=>'不夠謙虛','257'=>'不知輕重','258'=>'優柔寡斷','259'=>'匹夫之勇','260'=>'因循茍且','261'=>'心猿意馬','262'=>'恃才傲物','263'=>'不知用功','264'=>'表面敷衍','265'=>'心神不定','266'=>'漫不經心','267'=>'不得要領','268'=>'囫圇吞棗','269'=>'捨本逐末','270'=>'玩歲愒時','271'=>'一知半解','272'=>'眼高手低','273'=>'投機取巧','274'=>'守規勤學','275'=>'循規蹈矩','276'=>'服務熱心','277'=>'做事敏捷','278'=>'遵守校規','279'=>'誠實守規','280'=>'勤謹自守','281'=>'敬師愛友','282'=>'勤奮負責','283'=>'處事勤敏','284'=>'謙恭有禮','285'=>'勤勉有為','286'=>'恪守校規','287'=>'合群守法','288'=>'行為端正','289'=>'守法知禮','290'=>'守己樂群','291'=>'守分自治','292'=>'樂於助人','293'=>'活潑合群','294'=>'做事細心','295'=>'一絲不茍','296'=>'井井有條','297'=>'以身作則','298'=>'克盡厥職','299'=>'改過自新','300'=>'克勤克儉','301'=>'勇於負責','302'=>'謹言慎行','303'=>'自重自愛','304'=>'加倍努力','305'=>'更求用心','306'=>'尚待努力','307'=>'更待進取','308'=>'更待加強','309'=>'請嚴加督導','310'=>'再求踏實','311'=>'更上層樓','312'=>'注意交友','313'=>'交友謹慎']; 
    }

    // get config
    private function get_config_data(){
        global $xoopsDB;
        $tbl = $xoopsDB->prefix('yy_config');
        $sql            = "SELECT distinct `gpname` , `title` ,`gpval`
                        FROM $tbl where `status` ='1' ORDER BY `gpname` , `gpval`";
        // echo($sql);die();
        $result         = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $config_gpname=$config_desc=[];
        while($all= $xoopsDB->fetchArray($result)){
            // $sys_config['gpname'][$all['gpname']]=$all['gpname'];
            $sys_config[$all['gpname']][$all['gpval']]=$all['title'];
        }
        $this->sys_config = $sys_config;


        $sql            = "SELECT distinct `description` FROM $tbl";
        $result         = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $config_gpname=$config_desc=[];
        while($all= $xoopsDB->fetchArray($result)){
            $sys_var['desc'][$all['description']]=$all['description'];
        }

        $sql            = "SELECT distinct `gpname` FROM $tbl";
        $result         = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $config_gpname=$config_desc=[];
        while($all= $xoopsDB->fetchArray($result)){
            $sys_var['gpname'][$all['gpname']]=$all['gpname'];
        }
        $this->sys_var = $sys_var;
    }


    // get 學期資料
    public function get_termarray($year=''){
        global $xoopsDB;
        $tbl = $xoopsDB->prefix('yy_semester');
        $sql = "SELECT * FROM $tbl 
                Where `year`={$year}
                ORDER BY term
                ";
        $result         = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all=[];
        while($data= $xoopsDB->fetchArray($result)){
            $all[$data['term']]= $data['term'];
        }
        return $all;
    }

    // 列出群組科目名稱及總學份
    public function query_course_groupname($year='',$term='',$depid=''){
        global $xoopsDB ,$xoopsUser;
        $tbl = $xoopsDB->prefix('yy_course');
        $sql = "SELECT cos_name_grp , sum(cos_credits) as sum_cred FROM $tbl  
                Where `cos_year`='{$year}' 
                AND `cos_term`='{$term}' 
                AND `dep_id`='{$depid}' 
                AND `scoring`='1'
                AND `status`='1'
                GROUP BY cos_name_grp
                ORDER BY `sort`
                        ";
        // echo($sql);die();
        $result         = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all=[];
        $sum=0;
        while($data= $xoopsDB->fetchArray($result)){
            $all['grpname_sumcred'][$data['cos_name_grp']] = $data['sum_cred'];
            $sum+= $data['sum_cred'];
        }
        $all['total_cred']=$sum;

        // die(var_dump($all));
        return $all;
    }

    // 查詢學期成績
    public function query_term_total_score($year='',$term='',$depid=''){
        global $xoopsDB ,$xoopsUser;
        $tbl = $xoopsDB->prefix('yy_term_total_score');
        $sql = "SELECT * FROM $tbl  
                Where `year`='{$year}' 
                AND `term`='{$term}' 
                AND `dep_id`='{$depid}' 
                ORDER BY `student_sn`
                        ";
        $result         = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all=[];
        while($data= $xoopsDB->fetchArray($result)){
            $all[$data['student_sn']]['sum_credits']   = $data['sum_credits'];
            $all[$data['student_sn']]['total_score']   = $data['total_score'];
            $all[$data['student_sn']]['total_avg']     = $data['total_avg'];
            $all[$data['student_sn']]['comment']       = $data['comment'];
            $all[$data['student_sn']]['reward_method'] = $data['reward_method'];
            $all[$data['student_sn']]['grade']         = $data['grade'];
        }
        return $all;
    }

    // 查詢學期成績明細
    public function query_term_score_detail($year='',$term='',$depid=''){
        global $xoopsDB ,$xoopsUser;
        $tbl = $xoopsDB->prefix('yy_term_score_detail');
        $sql = "SELECT * FROM $tbl  
                Where `year`='{$year}' 
                AND `term`='{$term}' 
                AND `dep_id`='{$depid}' 
                ORDER BY `student_sn`,`sort`
                        ";
        $result         = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all=[];
        while($data= $xoopsDB->fetchArray($result)){
            $all[$data['student_sn']][$data['cos_name_grp']]['course_total_score'] = $data['course_total_score'];
            $all[$data['student_sn']][$data['cos_name_grp']]['course_sum_credits'] = $data['course_sum_credits'];
            $all[$data['student_sn']][$data['cos_name_grp']]['course_total_avg']   = $data['course_total_avg'];
            $all[$data['student_sn']][$data['cos_name_grp']]['comment']   = $data['comment'];
        }
        // echo($sql);die();
        // die(print_r($all));
        return $all;
    }

    // 輸入學年度 學期 學程，新增學生期末成績db
    public function year_term_score($year='',$term='',$depid=''){
        global $xoopsDB ,$xoopsUser;
        $tbl = $xoopsDB->prefix('yy_stage_sum');
        $tb2 = $xoopsDB->prefix('yy_course');
        $sql = "SELECT * FROM $tbl  LEFT JOIN $tb2 ON $tbl.course_id=$tb2.sn
                Where `cos_year`='{$year}' 
                AND `cos_term`='{$term}' 
                AND `dep_id`='{$depid}' 
                AND `scoring`='1'
                ORDER BY `student_sn`,$tb2.sort
                        ";
        $result         = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        // echo($sql);die();

        // [stu_sn][群組名稱][科目id][cos_credits]=學分
        // [stu_sn][群組名稱][科目id][tea_input_score]=教師keyin 成績
        $all=$stu_score=[];
        while($data= $xoopsDB->fetchArray($result)){
            $all[$data['student_sn']]['grp_cos_name'][$data['cos_name_grp']][$data['course_id']]['cos_credits']=$data['cos_credits'];
            $all[$data['student_sn']]['grp_cos_name'][$data['cos_name_grp']][$data['course_id']]['tea_input_score']=$data['tea_input_score'];
            $all[$data['student_sn']]['grp_cos_name'][$data['cos_name_grp']][$data['course_id']]['description']=$data['description'];
        }
        // die(var_dump($all));

        // 群組科目加總的學分、總分、平均
        foreach($all as $stu_sn=>$v1){
            foreach($v1['grp_cos_name'] as $cos_name_grp=>$v2){
                $stu_score[$stu_sn]['grp_cos_name'][$cos_name_grp]['sum_cred']='-';//群組科目總學分
                $stu_score[$stu_sn]['grp_cos_name'][$cos_name_grp]['sum_score']='-';//群組科目加權總分
                $stu_score[$stu_sn]['grp_cos_name'][$cos_name_grp]['avg_score']='-'; //群組科目除加權後總平均
                $stu_score[$stu_sn]['grp_cos_name'][$cos_name_grp]['sum_comment']=''; //群組科目描述
                $desc_temp=[]; //群組科目描述
                foreach($v2 as $course_id=>$v3){
                    if(is_numeric($v3['tea_input_score'])){
                        $stu_score[$stu_sn]['grp_cos_name'][$cos_name_grp]['sum_cred']+=$v3['cos_credits'];
                        $stu_score[$stu_sn]['grp_cos_name'][$cos_name_grp]['sum_score']+=$v3['tea_input_score']*$v3['cos_credits'];
                    }
                    if($v3['description']!='-'){
                        $desc_temp[]=$v3['description'];
                    }
                }
                if(count($desc_temp)!=0){
                    $stu_score[$stu_sn]['grp_cos_name'][$cos_name_grp]['sum_comment']=implode("；", $desc_temp).'；';
                }
                if(is_numeric($stu_score[$stu_sn]['grp_cos_name'][$cos_name_grp]['sum_score'])){
                    $stu_score[$stu_sn]['grp_cos_name'][$cos_name_grp]['avg_score']=(float) round($stu_score[$stu_sn]['grp_cos_name'][$cos_name_grp]['sum_score']/$stu_score[$stu_sn]['grp_cos_name'][$cos_name_grp]['sum_cred'],0);
                }
            }
        }

        $chn_grade=['1'=>'一年級','2'=>'二年級','3'=>'三年級','畢業或結業'=>'已畢業或結業'];
        foreach($this->stu_grade as $stusn=>$gd){
            $stugrd[$stusn]=$chn_grade[$gd];
        }
        // die(var_dump($stugrd));
        // die(var_dump($stu_score));

        // 再算出該學生的總分、總學分、總平均
        foreach($stu_score as $stu_sn=>$v1){
            $stu_score[$stu_sn]['stu_sum_score']=$stu_score[$stu_sn]['stu_sum_cred']=$stu_score[$stu_sn]['stu_avg_score']='-';
            $stu_score[$stu_sn]['grade']=$stugrd[$stu_sn]; //年級
            foreach($v1['grp_cos_name'] as $cos_name_grp=>$v2){
                if(is_numeric($v2['sum_score'])){
                    $stu_score[$stu_sn]['stu_sum_score']+=$v2['sum_score'];
                    $stu_score[$stu_sn]['stu_sum_cred']+=$v2['sum_cred'];
                }
            }
            if(is_numeric($stu_score[$stu_sn]['stu_sum_score'])){
                $stu_score[$stu_sn]['stu_avg_score']=(float) round($stu_score[$stu_sn]['stu_sum_score']/ $stu_score[$stu_sn]['stu_sum_cred'],0);
                $stu_score[$stu_sn]['reward_method']=score_range($stu_score[$stu_sn]['stu_avg_score'],'8'); //總成績獎勵
            }
        }
        // die(var_dump($stu_score));
        
        $tbl = $xoopsDB->prefix('yy_term_total_score');
        // 先將學生總成績的備註複製下來
        $sql = "SELECT * FROM $tbl
                Where `year`='{$year}' 
                AND `term`='{$term}' 
                AND `dep_id`='{$depid}' 
                ";
        $result         = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        // echo($sql);die();
        $stu_tmp_data=[];
        while($data= $xoopsDB->fetchArray($result)){
            $stu_tmp_data[$data['student_sn']]['comment']=$data['comment'];
        }

        // 刪除學生的總成績
        $sql = "DELETE FROM `$tbl` 
                WHERE `year` = '{$year}'
                    AND `term` = '{$term}'
                    AND `dep_id` = '{$depid}'
                ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        // echo($sql);die();

        // 新增學生的系統總成績
        foreach($stu_score as $stu_sn=>$v1){
            $sql = "insert into `$tbl` (
                `year`,`term`,`dep_id`,`student_sn`,`sum_credits`,
                `total_score`,`total_avg`,`comment`,`update_user`,
                `update_date`,`reward_method`,`grade`
                ) 
                values(
                '{$year}','{$term}','{$depid}','{$stu_sn}','{$v1['stu_sum_cred']}',
                '{$v1['stu_sum_score']}','{$v1['stu_avg_score']}','{$stu_tmp_data[$stu_sn]['comment']}','{$xoopsUser->uid()}',now(),
                '{$v1['reward_method']}','{$v1['grade']}'
                )";
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }

        // 群組科目成績明細
        $tbl = $xoopsDB->prefix('yy_term_score_detail');
        // 刪除學生的群組科目成績明細
        $sql = "DELETE FROM `$tbl` 
                WHERE `year` = '{$year}'
                    AND `term` = '{$term}'
                    AND `dep_id` = '{$depid}'
                ";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        // echo($sql);die();
        // 新增學生的群組科目分數明細
        foreach($stu_score as $stu_sn=>$v1){
            $i=1;
            foreach($v1['grp_cos_name'] as $gp_course_name=>$v2){
                $sql = "insert into `$tbl` (
                    `year`,`term`,`dep_id`,`student_sn`,`cos_name_grp`,
                    `course_total_score`,`course_sum_credits`,`course_total_avg`,`update_user`,`update_date`,
                    `sort`,`comment`
                    ) 
                    values(
                    '{$year}','{$term}','{$depid}','{$stu_sn}','{$gp_course_name}',
                    '{$v2['sum_score']}','{$v2['sum_cred']}','{$v2['avg_score']}','{$xoopsUser->uid()}',now(),
                    '{$i}','{$v2['sum_comment']}'
                    )";
                $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                $i++;
            }
        }
        // echo($sql);die();
        // die(var_dump($stu_score));
        // return $stu_score;
    }

    // 取出考科查詢，學生備註
    public function exam_comment($dep_id='',$exam_stage=''){
        global $xoopsDB,$xoopsUser;
        $tb1 = $xoopsDB->prefix('yy_query_stage_score');
        $sql = "SELECT * FROM $tb1 
                    Where `year` = '{$this->sem_year}'
                    AND `term` = '{$this->sem_term}'
                    AND `dep_id`='{$dep_id}' 
                    AND `exam_stage` = '{$exam_stage}'
                    ORDER BY student_sn
                ";
        // echo($sql);die();
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all=[];
        while($data= $xoopsDB->fetchArray($result)){
            $all[$data['student_sn']]=$data['comment'];
        }
        return $all;
    }
    
    // 新增考科成績
    public function add_query_stage_score($dep_id='',$exam_stage='',$stu_data=[]){
        global $xoopsDB,$xoopsUser;
        // 先把學生備註複製下來
        $stu_com=$this->exam_comment($dep_id,$exam_stage);
        // 刪除學生 目前學年度 目前學期 學程的第幾次段考
        $tbl = $xoopsDB->prefix('yy_query_stage_score');
        $sql = "DELETE FROM `$tbl` WHERE 
                `year` = '{$this->sem_year}'
            AND `term` = '{$this->sem_term}'
            AND `dep_id` = '{$dep_id}'
            AND `exam_stage` = '{$exam_stage}'
            ";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        
        // die(var_dump($stu_data));
        // 把備註給學生資料
        foreach($stu_data as $sn=>$v){
            $stu_data[$sn]['comment']=$stu_com[$sn];
        }
        // die(var_dump($stu_data));
        foreach($stu_data as $stusn => $val){
            $sql = "insert into `$tbl` (
                `year`,`term`,`dep_id`,`exam_stage`,`student_sn`,
                `qscore_sum`,`qscore_avg`,`reward_method`,`progress_score`,
                `comment`,`update_user`,`update_date`
                ) 
                values(
                '{$this->sem_year}','{$this->sem_term}','{$dep_id}','{$exam_stage}','{$stusn}',
                '{$val['sum']}','{$val['avg']}','{$val['reward_method']}','{$val['progress_score']}',
                '{$val['comment']}','{$xoopsUser->uid()}',now()
                )";
            // echo($sql);die();
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }
    }

    // 回傳第一次段考，學生平均分數。用來算進步分
    public function first_exam_avg_score($dep_id=''){
        global $xoopsDB,$xoopsUser;
        $tb1 = $xoopsDB->prefix('yy_query_stage_score');
        $sql = "SELECT * FROM $tb1 
                    Where `year` = '{$this->sem_year}'
                    AND `term` = '{$this->sem_term}'
                    AND `dep_id`='{$dep_id}' 
                    AND `exam_stage`='2'
                    ORDER BY student_sn
                ";
        // echo($sql);die();
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all=[];
        while($data= $xoopsDB->fetchArray($result)){
            $all[$data['student_sn']]=$data['qscore_avg'];
        }
        return $all;
    }

    // 學程>段考考科>科目課程>成績 [stu_sn][course id]= score
    public function dept_exam_course_score( $dep_id='',$exam_stage='',$course_id=[]){
        global $xoopsDB,$xoopsUser;
        //找出學程>段考>科目>成績
        $sql_course = '(\''.implode("','", $course_id).'\')';

        $tb1      = $xoopsDB->prefix('yy_stage_score');
        $sql      = "SELECT * FROM $tb1 
                        Where `dep_id`='{$dep_id}' 
                        AND `exam_stage`='{$exam_stage}'
                        AND `course_id` IN {$sql_course}
                        ORDER BY student_sn , course_id
                        ";
        // echo($sql);die();
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all=[];
        while($data= $xoopsDB->fetchArray($result)){
            $all[$data['student_sn']][$data['course_id']]=$data['score'];
        }
        return $all; //
    }
    // 列出一~三次段考 [學程] [段考] [課程id]=[課程中文名稱]
    private function dep2exam(){
        global $xoopsDB;
        // 第一次段考 學程 map 科目
        $tbl = $xoopsDB->prefix('yy_course');
        $sql  = "SELECT * FROM $tbl 
                Where `cos_year`='{$this->sem_year}' 
                    AND `cos_term`='{$this->sem_term}' 
                    AND `status`='1' 
                    AND `first_test`='1'
                    AND `scoring`='1'
                    order by sort ,dep_id 
                        ";
        $result         = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $dep_exam_course=[];
        while($data= $xoopsDB->fetchArray($result)){
            $dep_exam_course[$data['dep_id']]['2'][$data['sn']]=$data['cos_name'];
        }
        // 第二次段考 學程 map 科目
        $sql = "SELECT * FROM $tbl 
                Where `cos_year`='{$this->sem_year}' 
                    AND `cos_term`='{$this->sem_term}' 
                    AND `status`='1' 
                    AND `second_test`='1'
                    AND `scoring`='1'
                    order by sort ,dep_id 
        ";
        $result         = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while($data= $xoopsDB->fetchArray($result)){
            $dep_exam_course[$data['dep_id']]['4'][$data['sn']]=$data['cos_name'];
        }

        // 期末考  學程 map 科目
        $sql  = "SELECT * FROM $tbl 
                Where `cos_year`='{$this->sem_year}' 
                    AND `cos_term`='{$this->sem_term}' 
                    AND `status`='1' 
                    AND `scoring`='1'
                    order by sort ,dep_id 
        ";
        $result         = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while($data= $xoopsDB->fetchArray($result)){
            $dep_exam_course[$data['dep_id']]['6'][$data['sn']]=$data['cos_name'];
        }
        $this->dep_exam_course = $dep_exam_course;
        // die(var_dump($dep_exam_course));
    }

    // 計算段考及平時考成績 加總 平均
    public function sscore_calculate( $dep_id='',$coursid='',$stu_desc=[],$tea_keyin_score=[]){
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
                $all[$stu_sn]['uavg']=round((float)(($sum/$i)*(float)$score_rate['normal_exam']),1);
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
                $all[$stu_sn]['savg']=round((float)(($sum/$i)*(float)$score_rate['section_exam']),1);
            }
        }
        // var_dump($all);die();
        // 平時考+段考
        foreach($all as $stu_sn=>$score_ary){
            if(is_numeric($score_ary['uavg']) OR  is_numeric($score_ary['savg'])){
                $all[$stu_sn]['uavg_savg_sum']=(float)round($score_ary['uavg']+ (float)$score_ary['savg'],0);
            }else{
                $all[$stu_sn]['uavg_savg_sum']='-';
            }
        }


        // 先撈出描述，再刪除學生 總成績
        $tbl = $xoopsDB->prefix('yy_stage_sum');
        $sql = "SELECT *  FROM $tbl 
                    Where course_id = '{$coursid}'
                    ORDER BY  `student_sn`
                ";
        // echo($sql);die();
        $result     = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while($data= $xoopsDB->fetchArray($result)){
            $stu_old_desc[$data['student_sn']]['desc']= $data['description'];
        }

        $sql = "DELETE FROM `$tbl` WHERE `course_id` = '{$coursid}'";
        // echo($sql);die();
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        // die(var_dump($stu_desc));
        
        if(count($stu_desc)==0){
            $stu_desc=$stu_old_desc;
        }

        // 新增學生總成績
        $tbl = $xoopsDB->prefix('yy_stage_sum');
        foreach($all as $stusn=>$v){
            // 儲存時，系統總成績 與 教師keyin總成績 分開
            // $sql_1 = "insert into `$tbl` (
            //     `course_id`,`student_sn`,`uscore_sum`,`uscore_avg`,`sscore_sum`,
            //     `sscore_avg`,`sum_usual_stage_avg`,`update_user`,`update_date`,
            //     `description`,`tea_input_score`
            //     ) 
            //     values(
            //     '{$coursid}','{$stusn}','{$v['usum']}','{$v['uavg']}','{$v['ssum']}',
            //     '{$v['savg']}','{$v['uavg_savg_sum']}','{$xoopsUser->uid()}',now(),
            //     '{$stu_desc[$stusn]["desc"]}','{$tea_keyin_score[$stusn]}'
            //     )";

            // 儲存時，系統計算總成績 to 教師keyin總成績
            $sql_1 = "insert into `$tbl` (
                `course_id`,`student_sn`,`uscore_sum`,`uscore_avg`,`sscore_sum`,
                `sscore_avg`,`sum_usual_stage_avg`,`update_user`,`update_date`,
                `description`,`tea_input_score`
                ) 
                values(
                '{$coursid}','{$stusn}','{$v['usum']}','{$v['uavg']}','{$v['ssum']}',
                '{$v['savg']}','{$v['uavg_savg_sum']}','{$xoopsUser->uid()}',now(),
                '{$stu_desc[$stusn]["desc"]}','{$v['uavg_savg_sum']}'
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
        
        // 平時考成績欄位"final_score_sn" 對映到 yy_stage_sum  sn
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
                $all[$stu_sn]['avg']=round((float)($sum/$i),0);
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

        if($data['status']=='1'){
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
        $this->sem_term_sdate = $school_year['start_date'];
        $this->sem_term_edate = $school_year['end_date'];
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
        // echo($sql_enusr);die();
        $sqlall=$sql." ORDER BY {$tb2}.sort";
        $result      = $xoopsDB->query($sqlall) or Utility::web_error($sql, __FILE__, __LINE__);
        $all=$uid2data=[];
        while($user= $xoopsDB->fetchArray($result)){
            $all[] = $user;
        }
        $this->users=$all;

        // get all teachers 
        $sqltea = $sql." AND $tb2.isteacher='1' ORDER BY {$tb2}.sort";
        $result = $xoopsDB->query($sqltea) or Utility::web_error($sql, __FILE__, __LINE__);
        $all    = [];
        while($tch= $xoopsDB->fetchArray($result)){
            $all[] = $tch;
        }
        $this->teachers=$all;

        // get enable users 
        $sql_enusr = $sql." AND $tb2.enable !='0' ";
        $result = $xoopsDB->query($sql_enusr) or Utility::web_error($sql, __FILE__, __LINE__);
        $all    = [];
        while($en_teausers= $xoopsDB->fetchArray($result)){
            $all[] = $en_teausers;
        }
        // var_dump($all);die();

        $this->en_users=$all;
    }

    // get 班級資料
    private function get_class(){
        global $xoopsDB;
        $tb1 = $xoopsDB->prefix('yy_class');
        $tb2 = $xoopsDB->prefix('users');
        $sql = "SELECT * FROM $tb1 
                LEFT JOIN $tb2 ON $tb1.tutor_sn=$tb2.uid
        WHERE class_status='1'";
        // echo($sql);die();
        $result      = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $class_name=$class_tutor_name=[];
        while($data= $xoopsDB->fetchArray($result)){
            $class_name[$data['sn']]= $data['class_name'];
            $class_tutor_name[$data['sn']]= $data['name'];
            $class_tutorid[$data['sn']]= $data['tutor_sn'];
            $tutorid_classid[$data['tutor_sn']]= $data['sn'];
        }

        $sql = "SELECT * FROM $tb1 
                LEFT JOIN $tb2 ON $tb1.tutor_sn=$tb2.uid";
        // echo($sql);die();
        $result      = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $class_name_all=[];
        while($data= $xoopsDB->fetchArray($result)){
            $class_name_all[$data['sn']]= $data['class_name'];
        }
        // die(var_dump($all));
        $this->class_name=$class_name;
        $this->class_name_all=$class_name_all;
        $this->class_tutorid=$class_tutorid;
        $this->class_tutor_name=$class_tutor_name;
        $this->tutorid_classid=$tutorid_classid;

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


        $sql2 = "SELECT * FROM $tb1";
        // echo($sql);
        $result      = $xoopsDB->query($sql2) or Utility::web_error($sql, __FILE__, __LINE__);
        $all_dept=$all_major=[];
        while($rut= $xoopsDB->fetchArray($result)){
            $all_major[$rut['sn']]=$rut['dep_name'];
            $all_dept[$rut['sn']] = $rut;
        }
        $this->depsnname=$major_ary;
        $this->dept=$all;
        $this->all_depsnname=$all_major;
        $this->all_dept=$all_dept;
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
        $tb2 = $xoopsDB->prefix('yy_class');
        $sql = "SELECT *,$tb1.sn as stusn FROM $tb1 
                LEFT JOIN $tb2 ON $tb1.class_id =$tb2.sn
                WHERE `status` !='2'
                ORDER BY $tb1.sort
                ";
        $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $stu_name=$major_stu=$classname_stuid=[];
        while($user= $xoopsDB->fetchArray($result)){
            $major_stu[$user['major_id']][] = $user['stusn']; //[學程id][]=stu sn
            $stu_name[$user['stusn']] = $user['stu_name'];    //[stu sn]=name
            $stu_anonymous[$user['stusn']] = $user['stu_anonymous'];// [stu sn]= stu_anonymous
            $stu_sn_classid[$user['stusn']] = $user['class_id'];  // [stu sn]= class id
            $stu_dep[$user['stusn']] = $user['major_id'];  // [stu sn]= dep id
            $stu_id[$user['stusn']] = $user['stu_id'];  // [stu sn]= stu_id
            $stu_grade[$user['stusn']] = $user['grade'];  // [stu sn]= stu_id
            $classname_stuid[$user['class_name']??'未編班'][$user['stusn']]= $user['stu_anonymous'];  // $[$user['class_id']] [$user['sn']] = $user['stu_anonymous']          
            $classid_stuid[$user['class_id']??'0'][$user['stusn']]= $user['stu_anonymous'];  // $[$user['class_id']] [$user['sn']] = $user['stu_anonymous']          
        }

        $tb1 = $xoopsDB->prefix('yy_student');
        $tb2 = $xoopsDB->prefix('yy_class');
        $sql = "SELECT *,$tb1.sn as stusn FROM $tb1 
                LEFT JOIN $tb2 ON $tb1.class_id =$tb2.sn
                ORDER BY $tb1.sn DESC ";
        $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while($user= $xoopsDB->fetchArray($result)){
            $stu_anonymous_all[$user['stusn']] = $user['stu_anonymous'];// [stu sn]= stu_anonymous
            $stu_sn_classid_all[$user['stusn']] = $user['class_id'];  // [stu sn]= class id
            $stu_name_all[$user['stusn']] = $user['stu_name'];    //[stu sn]=name
            $stu_id_all[$user['stusn']] = $user['stu_id'];  // [stu sn]= stu_id
            $stu_dep_all[$user['stusn']] = $user['major_id'];  // [stu sn]= dep id

        }
        // var_dump($major_stu);die();


        $this->major_stu=$major_stu;
        $this->stu_name=$stu_name;
        $this->stu_name_all=$stu_name_all;
        $this->stu_anonymous=$stu_anonymous;
        $this->stu_anonymous_all=$stu_anonymous_all;
        $this->stu_sn_classid_all=$stu_sn_classid_all;
        $this->stu_sn_classid=$stu_sn_classid;
        $this->stu_dep=$stu_dep;
        $this->stu_dep_all=$stu_dep_all;
        $this->stu_id=$stu_id;
        $this->stu_id_all=$stu_id_all;
        $this->stu_grade=$stu_grade;
        $this->classname_stuid=$classname_stuid;
        $this->classid_stuid=$classid_stuid;
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
