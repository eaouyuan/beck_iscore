<{$formValidator_code}>

<form name="counseling_form" id="counseling_form" action="tchstu_mag.php" method="post" enctype='multipart/form-data'>
    <h3><{$form_title}> ─  <{$info.year}> 學年度 第 <{$info.term}> 學期
    </h3>
    <table class="table table-sm">
        <tbody>
            <tr>
                <th class="table-info">晤談日期</th>
                <th class="col-3">
                    <input class="form-control" type="text" name="notice_time" id="notice_time" value="<{$info.notice_time}>">
                </th>
                <th class="table-info">學生姓名</th><th><{$info.stu_name}></th>
                <th class="table-info">班級</th>    <th><{$info.class}></th>
                <th class="table-info">認輔教師</th><th><{$info.tea_name}></th>
            </tr>
            <tr>
                <th class="table-info p-2" scope="row">面談地點</th>
                <th colspan="7" class="p-2 text-left">
                    <{$chk.location}>
                    <div></div>
                    <div class="form-check form-check-inline col">
                        <input class="form-check-input" type="radio" name="AdoptionInterviewLocation" id="AdoptionInterviewLocation_99" value="99"<{$chk_99.AdoptionInterviewLocation}>>
                        <label class="form-check-label mr-2" for="AdoptionInterviewLocation_99">其他</label>
                        <input type="text" class="form-control col" name="location" id="location" value="<{$info.location}>">
                    </div>
                </th>
            </tr>
            <tr>
                <th class="table-info p-2" scope="row">輔導重點</th>
                <th colspan="7" class="p-2 text-left">
                    <{$chk.focus}>
                    <div></div>
                    <div class="form-check form-check-inline col">
                        <input class="form-check-input" type="checkbox" name="CounselingFocus[]" id="CounselingFocus_99" value="99"
                        <{$chk_99.CounselingFocus}>>
                        <label class="form-check-label mr-2" for="CounselingFocus_99">其他</label>
                        <input type="text" class="form-control col" name="focus" id="focus" value="<{$info.focus}>">
                    </div>
                </th>
            </tr>
            <tr>
                <th class="table-info">內容簡述</th>
                <th colspan="7" >
                    <textarea class="form-control validate[required]" id="content" name="content" rows="10"><{$info.content}></textarea>
                </th>
            </tr>
            <tr>
                <th class="table-info">文件上傳</th>
                <th colspan="7"><{$upform}></th>
            </tr>
        </tbody>
    </table>


    <div>
        <input name="uid" id="uid" value="<{$uid}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <input name="student_sn" id="student_sn" value="<{$info.student_sn}>" type="hidden">
        <input name="tea_uid" id="tea_uid" value="<{$info.tea_uid}>" type="hidden">
        <input name="year" id="year" value="<{$info.year}>" type="hidden">
        <input name="term" id="term" value="<{$info.term}>" type="hidden">
        <{if $sn}>
            <input name="sn" id="sn" value="<{$sn}>" type="hidden">
        <{/if}>
        <{$XOOPS_TOKEN}>
    </div>

    <div class="col-md-12 text-center mb-3">
        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button>
        <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=counseling_show&year=<{$info.year}>&term=<{$info.term}>&stu_sn=<{$info.student_sn}>&tea_uid=<{$info.tea_uid}>">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
    </div>
    
</form>


<script type="text/javascript">
    $(document).ready(function($){
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
        $('#notice_time').datetimepicker({
            // format: 'L', // date
            // format: 'LT', //time
            locale: 'zh-tw',
            // stepping: 5,
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
    .table > tbody > tr > th > .form-check {
        text-align:left;
    }
    /* #counseling_form > table > tbody > tr:nth-child(2) > th:nth-child(2) */
    .table > tbody > tr > th,.table > thead > tr > th {
        vertical-align:middle;
        text-align:center;
        border: 1px solid #000000;
    }
    input ,.custom-select,textarea {
        /* width:auto; */
        position: relative
    }
</style>