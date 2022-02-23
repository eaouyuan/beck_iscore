<{$formValidator_code}>

<form name="exam_keyindate_form" id="exam_keyindate_form" action="school_affairs.php" method="post" enctype='multipart/form-data'>
    <h3><{$form_title}></h3>
    <table class="table table-sm">
        <tbody>
            <tr>
                <th class="table-info" scope="row">學年度</th>
                <td>
                    <select class="custom-select validate[required]" name="exam_year" id="exam_year"><{$exam_year_htm}></select>
                </td>
                <th class="table-info" scope="row">學期</th>
                <td>
                    <select class="custom-select validate[required]" name="exam_term" id="exam_term"><{$exam_term_htm}></select>
                </td>
            </tr>
            <tr>
                <th  class="table-info" scope="row">成績登錄考試類型</th>
                <td>
                    <select class="custom-select validate[required]" name="exam_name" id="exam_name"><{$exam_name_htm}></select>
                </td>
                <th  class="table-info" scope="row">狀態</th>
                <td>
                    <select class="custom-select validate[required]" name="status" id="status"><{$status_htm}></select>
                </td>
            </tr>
            <tr>
                <th class="table-info" scope="row">開放日期</th>
                <td>
                    <input class="form-control" type="text" name="start_date" id="start_date" value="<{$exam_date.start_date}>">
                </td>
                <th class="table-info" scope="row">結束日期</th>
                <td>
                    <input class="form-control validate[required]" type="text" name="end_date" id="end_date" 
                    value="<{$exam_date.end_date}>">
                </td>
            </tr>
        </tbody>
    </table>   

    <div>
        <input name="uid" id="uid" value="<{$uid}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <{if $sn}> <input name="sn" id="sn" value="<{$sn}>" type="hidden"> <{/if}>
        <{$XOOPS_TOKEN}>
    </div>

    <div class="col-md-12 text-center mb-3">
        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button>
        <a class="btn btn-secondary" href="javascript:history.back()">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
        <!-- <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=course_list"><i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a> -->
        <a href="javascript:cos_del(<{$sn}>)" class="btn btn-danger">
                <i class="fa fa-trash-o mr-2" aria-hidden="true"></i>刪除</a>
    </div>

</form>


<script type="text/javascript">
    $(document).ready(function($){
        $('#start_date ,#end_date').datetimepicker({
            format: 'L', // date
            // format: 'LT', //time
            locale: 'zh-tw',
            // stepping: 5,
        });

    });



</script>

<style>

.table > tbody > tr > th ,.table > tbody > tr > td{
    vertical-align:middle;
    text-align:center;
    border: 1px solid #000;
}
input , select{
    /* width:auto; */
    position: relative;
}
input[type=radio]{
    transform:scale(1.5);
}


</style>

