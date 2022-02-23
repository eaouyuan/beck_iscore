<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/moment.min.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/moment-with-locales.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/bootstrap-datetimepicker.js"></script>
<link href="<{$xoops_url}>/modules/beck_iscore/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
<{$formValidator_code}>

<form name="leave_day_form" id="leave_day_form" action="tchstu_mag.php" method="post" enctype='multipart/form-data'>
    <h3><{$form_title}></h3>
    <table class="table table-sm">
        <tbody>
            <tr>
                <th colspan="4"><h4> <{$data.LD_year}> 學年度 第 <{$data.LD_term}> 學期</h4></th>
            </tr>
        
            <tr>
                <th class="table-info">班級</th>
                <th class="p-2" colspan="2">
                    <{if $sn}>      
                        <{$data.class_name}>班
                    <{else}>
                        <select class="custom-select" name="class_id" id="class_id"><{$sel.class_name}></select>
                    <{/if}>
                </th>
            </tr>
            <tr>
                <th class="table-info">學生姓名</th>
                <th class="p-2" colspan="2">
                <{if $sn}>      
                    <{$data.stu_name}>
                <{else}>
                    <select class="custom-select validate[required]" name="LD_stu_sn" id="LD_stu_sn">
                        <{$sel.stu}>
                    </select>
                <{/if}>
                </th>
            </tr>
            <tr>    
                <th class="table-info">缺勤種類</th>
                <th colspan="2">
                    <{$sel.AB_kind}>
                    <div class="form-check form-check-inline col">
                        <input class="form-check-input" type="radio" name="LD_kind" id="LD_kind_99" title="其他" <{$sel.LD_kind_99}> value="99">
                        <label class="form-check-label mr-2" for="LD_kind_99">其他</label>
                        <input type="text" class="form-control col" name="LD_other_text" id="LD_other_text" value="<{$data.LD_other_text}> ">
                    </div>
                </th>
            </tr>
            <tr>
                <th class="table-info p-2" scope="row">請假日期起迄</th>
                <th class="p-2 text-left">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">日期開始</span>
                        </div>
                        <input type="text" class="form-control" id="LD_sdate" name="LD_sdate" value="<{$data.LD_sdate}>">
                        <div class="input-group-prepend">
                            <span class="input-group-text">日期結束</span>
                        </div>
                        <input type="text" class="form-control" id="LD_edate" name="LD_edate" value="<{$data.LD_edate}>">
                    </div>
                </th>
        
            </tr>
            <tr>
                <th class="table-info p-2" scope="row">請假時數統計</th>
                <th class="p-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">日間時數</span>
                        </div>
                        <div class="form-control" id="LD_day_div"><{$data.LD_day_hours}></div>

                        <div class="input-group-prepend">
                            <span class="input-group-text">夜間時數</span>
                        </div>
                        <div class="form-control" id="LD_night_div"><{$data.LD_night_hours}></div>

                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="calculate_hrs">計算</button>
                            <!-- <button class="btn btn-secondary" type="button" id="clear_early">清空</button> -->
                        </div>
                    </div>
                </th>
            </tr>
            

            <tr>
                <th class="table-info">請假事由</th>
                <td colspan="2">
                    <textarea class="form-control" id="LD_content" name="LD_content" rows="4"><{$data.LD_content}></textarea>
                </td>
            </tr>
            
        </tbody>
    </table>


    <div>

        <input name="uid" id="uid" value="<{$uid}>" type="hidden">
        <input name="LD_year" id="LD_year" value="<{$data.LD_year}>" type="hidden">
        <input name="LD_term" id="LD_term" value="<{$data.LD_term}>" type="hidden">
        <input name="LD_day_hours" id="LD_day_hours" value="<{$data.LD_day_hours}>" type="hidden">
        <input name="LD_night_hours" id="LD_night_hours" value="<{$data.LD_night_hours}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">

        <{if $sn}>
            <input name="sn" id="sn" value="<{$sn}>" type="hidden">
            <input name="AB_period" value="<{$ru.AB_period}>" type="hidden">
        <{/if}>
        <{$XOOPS_TOKEN}>
    </div>

    <div class="col-md-12 text-center mb-3">
        <button class="btn btn-primary"  id="save_data" type="button"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button>
        <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=leave_day_list">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
    </div>
    
</form>
<script src="<{$xoops_url}>/modules/tadtools/sweet-alert/sweet-alert.js" type="text/javascript"></script>
<link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/sweet-alert/sweet-alert.css" type="text/css" />

<script type="text/javascript">


    $(document).ready(function($){
        // A 下拉選單 改變 B 下拉選單
        $('#LD_stu_sn').change(function(e){
            let stu_sn_classid=<{$stu_sn_classid}>;
            let stu_id=$("#LD_stu_sn").val();
            let calss_val=stu_sn_classid[stu_id];

            $('#class_id').find('option').attr("selected",false) ;
            $('#class_id option[value='+calss_val+']').attr('selected',true);
        });

        $('#class_id').change(function(e){
            let year=$("#LD_year").val();
            let term=$("#LD_term").val();
            let class_id=$(this).val();
            location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=leave_day_form&year='+year+'&term='+term+'&class_id=' + class_id
        });

        $('#LD_sdate ,#LD_edate').datetimepicker({
            // format: 'L', // date
            // format: 'LT', //time
            locale: 'zh-tw',
            useCurrent:true,
            // stepping: 5,
        });
     
        // 晨間

        $("#calculate_early").click(function(){
            compute('earlym_stime','earlym_etime','earlym_hour');
        });
        // 日間

        $("#calculate_morning").click(function(){
            compute('morning_stime','morning_etime','morning_hour');
        });
        // 夜間
        $("#calculate_night").click(function(){
            compute('night_stime','night_etime','night_hour');
        });
        
        // 按儲存鈕
        $("#save_data").click(function(){
            let formstatus=true;
            let validat=$("#leave_day_form").validationEngine('validate');
            // console.log(validat);
            if(validat==false){
                sweetAlert("學生姓名或日期未輸入！", "輸入錯誤","error");
                return false;
            }

            var input_finish='0';
            var error =new Array;
            if($("#earlym_stime")[0]){
                if( $("#earlym_stime").val()!='' &&  $("#earlym_etime").val()!=''){
                    error.push(timerange('earlym_stime'));
                    error.push(timerange('earlym_etime'));
                    compute('earlym_stime','earlym_etime','earlym_hour');
                    input_finish='1';
                }
            }
            if($("#morning_stime")[0]){
                if($("#morning_stime").val()!='' &&  $("#morning_etime").val()!=''){
                    error.push(timerange('morning_stime'));
                    error.push(timerange('morning_etime'));
                    compute('morning_stime','morning_etime','morning_hour');
                    input_finish='1';
                }
            }
            if($("#night_stime")[0]){
                if($("#night_stime").val()!='' &&  $("#night_etime").val()!=''){
                    error.push(timerange('night_stime'));
                    error.push(timerange('night_etime'));
                    compute('night_stime','night_etime','night_hour');
                    input_finish='1';
                }
            }
            DateRangeError=error.includes('1');
            // console.log(error);
            // console.log(DateRangeError);
            if(input_finish=='1'){
                if(DateRangeError){
                    sweetAlert("請檢查時間是否在區段內", "時間錯誤","error");
                    return false;
                }else{
                    document.forms["leave_day_form"].submit();
                }
            }else{
                sweetAlert("未輸入缺席時間！", "時間輸入錯誤","error");
                return false;
            }
        });
    });

    // 當結束日期改變時，計算時數
    $('#LD_edate').datepicker().on("dp.change", function () {
        if($("#LD_sdate").val()!='' && $("#LD_edate").val()!=''){
            console.log('sadfsd');
            $('#ui-datepicker-div').hide();

        }
    });


    $('#earlym_stime,#earlym_etime,#morning_stime,#morning_etime,#night_stime,#night_etime').datepicker().on("dp.hide", function (e) {
        event_date=document.getElementById("AB_date").value;
        if(event_date==''){
            sweetAlert("請輸入缺席日期！", "日期未輸入錯誤","error");
            false;
        }else{
            idname=$(this).prop('id');
            timerange(idname);
        }
    });
    $('#earlym_stime,#earlym_etime,#morning_stime,#morning_etime,#night_stime,#night_etime').datepicker().on("dp.show", function () {
        $('#ui-datepicker-div').hide();
    });


    // $(document).on('click','input', function(){
    //     $('#ui-datepicker-div').hide();//出現醜的datepicker
    // });
    // time range
    function timerange(a) {
        event_date=document.getElementById("AB_date").value;
        a_time=document.getElementById(a).value; //開始時間
        let a_datetime = event_date+' '+a_time;

        if(event_date==''){
            sweetAlert("請輸入缺席日期！", "日期未輸入錯誤","error");
            return '1';
        }

        switch (a) {
        case 'earlym_stime':
        case 'earlym_etime':
            if(Date.parse(a_datetime).valueOf() > Date.parse(event_date+' 08:30').valueOf()){
                sweetAlert("晨間時間未在區段內", "時間錯誤","error");
                return '1';
            }
            break;
        case 'morning_stime':
        case 'morning_etime':
            if(Date.parse(a_datetime).valueOf() < Date.parse(event_date+' 08:30').valueOf() | Date.parse(a_datetime).valueOf() > Date.parse(event_date+' 16:30').valueOf()){
                sweetAlert("日間時間未在區段內", "時間錯誤","error");
                return '1';
            }
            break;
        case 'night_stime':
        case 'night_etime':
            if(Date.parse(a_datetime).valueOf() < Date.parse(event_date+' 16:30').valueOf() && 
                Date.parse(a_datetime).valueOf() != Date.parse(event_date+' 00:00').valueOf())
            {
                sweetAlert("夜間時間未在區段內", "時間錯誤","error");
                return '1';
            }
            break;
        default:
            // console.log(`Sorry, we are out of ${expr}.`);
        }
        return '0';

    }

    //計算小時
    function compute(a,b,h) {
        datediff(a,b,h);
        let hour = Date.parse(end_datetime)-Date.parse(start_datetime);
        // let hour = new Date(Date.parse(b_date.replace(/-/g, "/")))-new Date(Date.parse(a_date.replace(/-/g, "/")));
        // console.log(Date.parse(start_datetime));
        hour = Math.ceil(Math.round(hour/3600000*100)/100);
        document.getElementById(h).innerHTML = hour;
        $('[name='+h+']').val(hour);
        // if(hour == 0){hour++; }

    }
    // 比較時間
    function datediff(a,b,h) {
        // console.log(a,b,h);
        a_time=document.getElementById(a).value; //開始時間
        b_time=document.getElementById(b).value; //結束時間
        event_date=document.getElementById("AB_date").value;

        if(a_time!='' && b_time!=''){
            if(event_date==''){
                sweetAlert("請輸入缺席日期！", "日期未輸入錯誤","error");
            }else{
                a_datetime = event_date+' '+a_time;
                b_datetime = event_date+' '+b_time;
                start_datetime=new Date(a_datetime);
                end_datetime=new Date(b_datetime);

                if(h=='night_hour' && b_time=='00:00'){
                    end_datetime.setDate(end_datetime.getDate()+1); 
                }
                // console.log('s:'+start_datetime);
                // console.log('e:'+end_datetime);
                // if(Date.parse(a_date).valueOf() > Date.parse(b_date).valueOf()){
                if(Date.parse(start_datetime) > Date.parse(end_datetime)){
                    sweetAlert("注意開始時間不能晚於結束時間！", "日期輸入錯誤(error:datediff)","error");
                    $('#'+b).val(a_time);
                    return false;
                }
            }
        }
    }


</script>

<style>
    input ,.custom-select,textarea {
        position: relative;
    }
    .table > tbody > tr >th:nth-child(even){
        text-align:left;
    }
    .table > tbody > tr >th:nth-child(odd){
        text-align:center;
    }
    .table > tbody > tr > th ,.table > tbody > tr > td{
    vertical-align:middle;
    /* text-align:center; */
    border: 1px solid #000;
    }
    #event_date{
        border:0px;
    }
    #ui-datepicker-div{
	    display: none;
    }
</style>