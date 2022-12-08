<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/moment.min.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/moment-with-locales.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/bootstrap-datetimepicker.js"></script>
<link href="<{$xoops_url}>/modules/beck_iscore/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">


<form name="leave_day_list" id="leave_day_list" action="tchstu_mag.php" method="get">
    <h2 class="mb-3">新版─學生出缺勤管理</h2>
    <div class="col">
    <div class="form-group row">
        <label for="year" class="col-form-label text-sm-left px-0 mb-3">學年度：</label>
        <div class="text-left px-0 mr-3">
            <select class="custom-select" name="year" id="year">
                <{$sel.year}>
            </select>
        </div>

        <label for="term" class="col-form-label text-sm-right px-0">學期：</label>
        <div class="text-left px-0 mr-3">
            <select class="custom-select" name="term" id="term">
                <{$sel.term}>
            </select>
        </div>
        <label for="major_id" class="col-form-label text-sm-left px-0">學程：</label>
        <div class="text-left px-0 mr-3">
            <select class="custom-select" name="major_id" id="major_id">
                <{$sel.major_htm}>
            </select>
        </div>

        <label for="stu_sn" class="col-form-label text-sm-right px-0">學生：</label>
        <div class="text-left px-0 mr-3">
            <select class="custom-select" name="stu_sn" id="stu_sn">
                <{$sel.stu_sn}>
            </select>
        </div>

        <label for="period" class="col-form-label text-sm-right px-0">時段：</label>
        <div class="text-left px-0 mr-3">
            <select class="custom-select" name="period" id="period">
                <{$sel.period}>
            </select>
        </div>

        <div>
            <input name="op" id="op" value="<{$op}>" type="hidden">
        </div>
    
        <div class="ml-auto">
            <button type="button" class="btn btn-outline-success mr-2" onclick="self.location.href='tchstu_mag.php?op=leave_day_list';">目前學期</button>
            <button type="button" class="btn btn-primary mr-2" onclick="self.location.href='tchstu_mag.php?op=leave_day_form';">
                <i class="fa fa-plus-circle " aria-hidden="true"></i>新增缺勤紀錄
            </button>
            <button type="button" class="btn btn-success mr-2" onclick="onprint()"><i class="fa fa-print  mr-2" aria-hidden="true"></i>列印</button>
        </div>
    </div>
    </div>

<{if $all}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead class="table-info">
            <tr>
                <th scope="col" class="text-center">編號</th>
                <th scope="col" class="text-center">學生</th>
                <th scope="col" class="text-center">缺席類別</th>
                <th scope="col" class="text-center">開始時間</th>
                <th scope="col" class="text-center">結束時間</th>
                <th scope="col" class="text-center">日間請假時數</th>
                <th scope="col" class="text-center">夜間請假時數</th>
                <th scope="col" class="text-center">功能</th>
            </tr>
        </thead>
        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr> 
            <th class="text-center text-nowrap"><{$its.LD_sn}></th>
            <th class="text-center text-nowrap"><{$its.stu_info}></th>
            <th class="text-center text-nowrap"><{$its.LD_kind_name}></th>
            <th class="text-center text-nowrap"><{$its.LD_sdate}></th>
            <th class="text-center text-nowrap"><{$its.LD_edate}></th>
            <th class="text-center text-nowrap"><{$its.LD_day_hours}></th>
            <th class="text-center text-nowrap"><{$its.LD_night_hours}></th>
            <th class="text-center text-nowrap">
                <a href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=leave_day_form&sn=<{$its.LD_sn}>" class="btn btn-warning btn-sm mr-2">編輯</a>
                <a href="javascript:LD_del(<{$its.LD_sn}>)" class="btn btn-danger btn-sm">刪除</a>
            </th>
        </tr>
    <{/foreach}>
        </tbody>
    </table>
    <h3 class="text-center mb-3"><{$summary_text}></h3>
<{else}>
    <div class="alert alert-danger">尚無內容</div>
<{/if}>
</form>

<div id="printArea">
    <h2 align="center"> 學生出缺勤管理
    </h2>
    <br>
<{if $all}>
    <table style="font-family:sans-serif;">
        <thead>
            <tr>
                <th class="text-center">編號</th>
                <th class="text-center">學生</th>
                <th class="text-center">缺席類別</th>
                <th class="text-center">開始時間</th>
                <th class="text-center">結束時間</th>
                <th class="text-center">日間請假時數</th>
                <th class="text-center">夜間請假時數</th>
            </tr>
        </thead>
        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr> 
            <th class="text-center text-nowrap"><{$its.LD_sn}></th>
            <th class="text-center text-nowrap"><{$its.stu_info}></th>
            <th class="text-center text-nowrap"><{$its.LD_kind_name}></th>
            <th class="text-center text-nowrap"><{$its.LD_sdate}></th>
            <th class="text-center text-nowrap"><{$its.LD_edate}></th>
            <th class="text-center text-nowrap"><{$its.LD_day_hours}></th>
            <th class="text-center text-nowrap"><{$its.LD_night_hours}></th>
        </tr>
    <{/foreach}>
        </tbody>
    </table>
    <hr>
    <h3 class="text-center"><{$summary_text}></h3>

<{else}>
    <div class="alert alert-danger">尚無內容</div>
<{/if}>

</div>
<!-- <script src="<{$xoops_url}>/modules/tadtools/sweet-alert/sweet-alert.js" type="text/javascript"></script> -->
<!-- <link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/sweet-alert/sweet-alert.css" type="text/css" /> -->
<script type="text/javascript">
    $(document).ready(function($){ 
        $('#year,#term,#major_id,#stu_sn,#period').change(function(e){
            document.forms["leave_day_list"].submit();
        })

    });
    function onprint() {
        window.print();
        return false;
    }

    
</script>



<style type="text/css">
@media screen 
{
    .table > tbody > tr > th,.table > thead > tr > th {
        vertical-align:middle;
        text-align:center;
        border: 1px solid #000;
        /* line-height:1em; */
    }
    /* input , select{
        position: relative;
        vertical-align:middle;
        text-align:center;
    }  */
}
@page  {
    size:A4;
    margin:5mm;
}
@media print 
{
    #printArea { 
        font-size: 16px;

    }
    table tr th, th, td{
        vertical-align:middle;
        text-align:center;
        border: 2px solid black;
    }   

    td,th { 
        padding: 10px;
    }

}
</style>
<style type="text/css" media="screen">
    /* 顯示時隱藏 */
    #printArea { display: none; }
</style>
<style type="text/css" media="print">
    /* 列印時隱藏 */
    #leave_day_list,.notprint,#footer-container-display,#nav-container-sticky-wrapper { display: none; }
</style>