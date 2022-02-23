<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/moment.min.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/moment-with-locales.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/bootstrap-datetimepicker.js"></script>
<link href="<{$xoops_url}>/modules/beck_iscore/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">

<{$formValidator_code}>

<form name="reward_punishment_form" id="reward_punishment_form" action="tchstu_mag.php" method="post" enctype='multipart/form-data'>
    <h3><{$form_title}></h3>
    <table class="table table-sm">
        <tbody>
            <tr>
                <th class="table-info">學生姓名</th>
                <th><select class="custom-select validate[required]" name="student_sn" id="student_sn">
                    <{$sel_stu}>
                </select></th>
            </tr>
            <tr>
                <th class="table-info">批示日期</th>
                <th>
                    <input type="text" class="form-control validate[required]" name="event_date" id="event_date" value="<{$RP_form.event_date}>">
                </th>
            </tr>
            <tr>    
                <th class="table-info">獎懲類別</th>
                <th colspan="3">
                    <{$rdo_RP_kind}>
                </td>
            </tr>
            <tr>
                <th class="table-info">獎懲事由</th>
                <td colspan="3">
                    <textarea class="form-control validate[required]" id="RP_content" name="RP_content" rows="6"><{$RP_form.RP_content}></textarea>
                </td>
            </tr>
            <tr>
                <th class="table-info p-2" scope="row">獎懲選項</th>
                <th colspan="3" class="p-2 text-left">
                    <{$rdo_RP_option}>
                </th>
            </tr>
            <tr>
                <th class="table-info p-2" scope="row">獎懲次數</th>
                <td><input type="text" class="form-control validate[required,custom[integer],min[1],max[15]]" name="RP_times" id="RP_times" value="<{$RP_form.RP_times}>"></td>
            </tr>
            <tr>
                <th class="table-info p-2" scope="row">獎懲單位</th>
                <th><{$rdo_RP_unit}></th>
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
        $('#event_date').datetimepicker({
            format: 'L', // date
            // format: 'LT', //time
            locale: 'zh-tw',
            // stepping: 5,
        });

        $("#AdoptionInterviewLocation_99").click(function(){
            if($(this).prop("checked") == true){
                $("#location").prop('disabled', false);
            }
            else if($(this).prop("checked") == false){
                $("#location").val('');
            }
        });
        $("#CounselingFocus_99").click(function(){
            if($(this).prop("checked") == true){
                $("#focus").prop('disabled', false);
            }
            else if($(this).prop("checked") == false){
                $("#focus").val('');
            }
        });

    });
    $('#location').on('change', function() {
        if($("#location").val()!=''){
            $("#AdoptionInterviewLocation_99").prop('checked', true);
        }
    });
    $('#focus').on('change', function() {
        if($("#focus").val()!=''){
            $("#CounselingFocus_99").prop('checked', true);
        }
    });


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


</style>