<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/moment.min.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/moment-with-locales.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/bootstrap-datetimepicker.js"></script>
<link href="<{$xoops_url}>/modules/beck_iscore/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">

<{$formValidator_code}>

<form name="absence_record_form" id="absence_record_form" action="tchstu_mag.php" method="post" enctype='multipart/form-data'>
    <h3><{$form_title}></h3>
    <table class="table table-sm">
        <tbody>
            <tr>
                <th colspan="4"><h4> <{$AB_form.year}> 學年度 第 <{$AB_form.term}> 學期</h4></th>
            </tr>
            <tr>
                <th class="table-info">班級</th>
                <th colspan="2">
                    <select class="custom-select" name="class_id" id="class_id"
                    onchange="location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=absence_record_form&class_id=' + this.value">
                    <{$sel.class_name}></select>
                </th>
            </tr>
            <tr>
                <th class="table-info">學生姓名</th>
                <th colspan="2"><select class="custom-select validate[required]" name="stu_id" id="stu_id">
                        <{$sel.stu}>
                    </select>
                </th>
            </tr>
            <tr>    
                <th class="table-info">缺勤種類</th>
                <th colspan="2">
                    <{$sel.AB_kind}>
                    <div></div>
                    <div class="form-check form-check-inline m-1 col">
                        <input class="form-check-input" type="radio" name="AB_kind" id="AB_kind_99" title="其他" value="99">
                        <label class="form-check-label mr-2" for="AB_kind_99">其他</label>
                        <input type="text" class="form-control col" name="AB_other_text" id="AB_other_text" value="">
                    </div>
                </th>
            </tr>
            <tr>    
                <th class="table-info">缺席日期</th>
                <th colspan="2">
                    <input type="text" class="form-control validate[required]" name="AB_date" id="AB_date" value="<{$RP_form.event_date}>">
                </th>
            </tr>

            <tr>
                <th class="table-info">缺席事由</th>
                <td colspan="2">
                    <textarea class="form-control" id="AB_content" name="AB_content" rows="2"><{$RP_form.RP_content}></textarea>
                </td>
            </tr>
            <tr>
                <th class="table-info p-2" scope="row">晨間缺席時間<br>00:00~08:30</th>
                <th class="p-2 text-left">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">日期起</span>
                        </div>
                        <input type="text" class="form-control" id="earlym_stime" name="earlym_stime" value="<{$sel.sdate}>">
                        <div class="input-group-prepend">
                            <span class="input-group-text">日期迄</span>
                        </div>
                        <input type="text" class="form-control" id="earlym_etime" name="earlym_etime" value="<{$sel.edate}>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="query">計算</button>
                        </div>
                    </div>
                </th>
                <th>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">總計</span>
                        </div>
                        <div class="form-control" id="earlym_hour">aaaa</div>
                        <div class="input-group-prepend">
                            <span class="input-group-text">小時</span>
                        </div>
                    </div>
                </th>
            </tr>
            <tr>
                <th class="table-info p-2" scope="row">日間缺席時間<br>08:30~16:30</th>
                <th class="p-2 text-left">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">日期起</span>
                        </div>
                        <input type="text" class="form-control" id="morning_stime" name="morning_stime" value="<{$sel.sdate}>">
                        <div class="input-group-prepend">
                            <span class="input-group-text">日期迄</span>
                        </div>
                        <input type="text" class="form-control" id="morning_etime" name="morning_etime" value="<{$sel.edate}>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="query">計算</button>
                        </div>
                    </div>
                </th>
                <th colspan="2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">總計</span>
                        </div>
                        <div class="form-control" id="morning_hour">aaaa</div>
                        <div class="input-group-prepend">
                            <span class="input-group-text">小時</span>
                        </div>
                    </div>
                </th>
            </tr>
            <tr>
                <th class="table-info p-2" scope="row">夜間缺席時間<br>16:30~00:00</th>
                <th class="p-2 text-left">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">日期起</span>
                        </div>
                        <input type="text" class="form-control" id="night_stime" name="night_stime" value="<{$sel.sdate}>">
                        <div class="input-group-prepend">
                            <span class="input-group-text">日期迄</span>
                        </div>
                        <input type="text" class="form-control" id="night_etime" name="night_etime" value="<{$sel.edate}>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="query">計算</button>
                        </div>
                    </div>
                </th>
                <th colspan="2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">總計</span>
                        </div>
                        <div class="form-control" id="night_hour">aaaa</div>
                        <div class="input-group-prepend">
                            <span class="input-group-text">小時</span>
                        </div>
                    </div>
                </th>
            </tr>

        </tbody>
    </table>


    <div>
        <input name="uid" id="uid" value="<{$uid}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <input name="year" id="year" value="<{$RP_form.year}>" type="hidden">
        <input name="term" id="term" value="<{$RP_form.term}>" type="hidden">
        <{if $sn}>
            <input name="sn" id="sn" value="<{$sn}>" type="hidden">
        <{/if}>
        <{$XOOPS_TOKEN}>
    </div>

    <div class="col-md-12 text-center mb-3">
        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button>
        <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=reward_punishment_list">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
    </div>
    
</form>


<script type="text/javascript">
    $(document).ready(function($){

        // A 下拉選單 改變 B 下拉選單
        $('#stu_id').change(function(e){
                let stu_sn_classid=<{$stu_sn_classid}>;
                let stu_id=$("#stu_id").val();
                let calss_val=stu_sn_classid[stu_id];

                $('#class_id').find('option').attr("selected",false) ;
                // $('#class_id').find('option').prop("selected",false) ;

                $('#class_id option[value='+calss_val+']').attr('selected',true);
                // $('#class_id option[value='+calss_val+']').attr('selected','selected');
                // $('#class_id option[value='+calss_val+']').prop('selected',true);
        });

        $('#AB_date').datetimepicker({
            format: 'L', // date
            // format: 'LT', //time
            locale: 'zh-tw',
            // stepping: 5,
        });
        $('#earlym_stime,#earlym_etime,#morning_stime,#morning_etime,#night_stime,#night_etime').datetimepicker({
            // format: 'L', // date
            format: 'LT', //time
            locale: 'zh-tw',
            stepping: 5,
            // disabledHours:[8,9],
            enabledHours:[8,9],

        });

    });
    $('#earlym_stime,#earlym_etime').datepicker().on("dp.hide", function () {
        $('#ui-datepicker-div').hide();
        datediff();
    });
    $('#edate').datepicker().on("dp.hide", function () {
        $('#ui-datepicker-div').hide();
        datediff();
    });

    function datediff() {
        let sdate=$('#earlym_stime').val();
        let edate=$('#earlym_etime').val();
        console.log(sdate);
        
        let sdval=sdate.replace(/-/g, "/");
        let edval=edate.replace(/-/g, "/");
        console.log(Date.parse(sdate).valueOf());


        if(Date.parse(sdval).valueOf() > Date.parse(edval).valueOf()){
            sweetAlert("注意開始時間不能晚於結束時間！", "日期輸入錯誤","error");
            // $('#edate').val(sdate);
            return false;
        }
    }


</script>

<style>
    input ,.custom-select,textarea {
        position: relative
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

</style>