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
                    <{$sel.LD_kind}>
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
        <input name="op" id="op" value="<{$op}>" type="hidden">

        <{if $sn}>
            <input name="sn" id="sn" value="<{$sn}>" type="hidden">
        <{/if}>
        <{$XOOPS_TOKEN}>
    </div>

    <div class="col-md-12 text-center mb-3">
        <!-- <button class="btn btn-primary"  id="save_data" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button> -->
        <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=leave_day_list">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
    </div>
    
</form>
<script src="<{$xoops_url}>/modules/tadtools/sweet-alert/sweet-alert.js" type="text/javascript"></script>
<link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/sweet-alert/sweet-alert.css" type="text/css" />

<script type="text/javascript">

    // 按缺勤種類，其它種類 的文字 刪除
    document.querySelectorAll("input[name=LD_kind").forEach(function(a) {
        a.addEventListener("change", function() {
            if(this.value!=99){
                $("#LD_other_text").val('');
            }
        })
    })
    
    $('#LD_other_text').on('change', function() {
        if($("#LD_other_text").val()!=''){
            $("#LD_kind_99").prop('checked', true);
        }
    });

    $(document).ready(function($){
        // 點選學生，自動帶入班級名稱   A 下拉選單 改變 B 下拉選單
        $('#LD_stu_sn').change(function(e){
            let stu_sn_classid=<{$stu_sn_classid}>;
            let stu_id=$("#LD_stu_sn").val();
            let calss_val=stu_sn_classid[stu_id];
            $('#class_id').find('option').attr("selected",false) ;
            $('#class_id option[value='+calss_val+']').attr('selected',true);
        });

        // 點選班級 帶入學生
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
        $("#calculate_hrs").click(function(){
            let sdate=$('#LD_sdate').val();
            let edate=$('#LD_edate').val();
            $.ajax ({
                url: 'other_action.php',
                method: 'POST',
                dataType: 'json',
                data: ({
                    op:'calculate_hrs',
                    sdate:sdate,
                    edate:edate,
                }),
                success: function(response){
                    $("#LD_day_div").html(response.day_hr_sum);
                    $("#LD_night_div").html(response.night_hr_sum);
                },
                error: function (error) {
                    // console.log(error);
                    alert(error);
                }
            });
        });
    });

    // 當結束日期改變時，計算時數
    // $('#LD_edate').datepicker().on("dp.change", function () {
    //     if($("#LD_sdate").val()!='' && $("#LD_edate").val()!=''){
    //         // console.log('sadfsd');
    //         $('#ui-datepicker-div').hide();

    //     }
    // });


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