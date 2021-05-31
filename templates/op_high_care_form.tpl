<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>
<{$formValidator_code}>

<form name="op_high_care_form" id="op_high_care_form" action="tchstu_mag.php" method="post" enctype='multipart/form-data'>
    <h3><{$form_title}></h3>
    <table class="table table-bordered table-sm">
        <tbody>
            <tr>
                <th class="table-info p-2" width="20%" scope="row">通報時間</th>
                <th>
                <{if $edit}>
                    <{$stu.year}> 年
                    <input name="year" id="year" value="<{$stu.year}>" type="hidden">
                <{else}>
                    <div class="input-group">
                        <select class="custom-select validate[required]" name="year" id="year"><{$year_sel}></select>
                        <div class="input-group-append">
                            <span class="input-group-text" id="year-addon2">年</span>
                        </div>
                    </div>
                <{/if}>
                </th>
                <th class="table-info" scope="row">月份</th>
                <th>
                <{if $edit}>
                    <{$stu.month}> 月
                    <input name="month" id="month" value="<{$stu.month}>" type="hidden">
                <{else}>
                    <div class="input-group">
                        <select class="custom-select validate[required]" name="month" id="month"><{$month_sel}></select>
                        <div class="input-group-append">
                            <span class="input-group-text" id="month-addon2">月</span>
                        </div>
                    </div>
                <{/if}>
                </th>
            </tr>
            <tr>
                <th class="table-info p-2" scope="row">學生姓名</th>
                <th>  
                <{if $edit}>
                    <{$stu.student_name}>
                <{else}>
                    <select class="custom-select validate[required]" name="student_sn" id="student_sn"><{$stu_sel}></select>
                <{/if}>
                </th>
                <th class="table-info" scope="row">填寫人員</th>
                <th><{$teacher_name}></th>
            </tr>
            <tr>
                <th class="table-info"scope="row">狀況說明</th>
                <th colspan="3" >
                    <textarea class="form-control validate[required]" id="event_desc" name="event_desc" rows="10"><{$stu.event_desc}></textarea>
                </th>
            </tr>
        </tbody>
    </table>


    <div>
        <input name="uid" id="uid" value="<{$uid}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <{if $sn}>
            <input name="sn" id="sn" value="<{$sn}>" type="hidden">
        <{/if}>
        <{$XOOPS_TOKEN}>
    </div>

    <div class="col-md-12 text-center mb-3">
        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button>
        <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=high_care_mon">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
    </div>

</form>


<script type="text/javascript">
    $(document).ready(function($){

    });


</script>

<style>

.table th ,.table td{
    vertical-align:middle;
    text-align:center;
    border: 1px solid #000000;
    /* width:auto; */
    /* border-bottom: 2px solid #000000; */
}
input ,.custom-select,textarea {
    /* width:auto; */
    position: relative
}

</style>