<form name="counseling_list" id="counseling_list" action="tchstu_mag.php" method="get">
    <h2 class="mb-3">學生認輔紀錄列表</h2>
    <div class="col">
    <{if $counseling_manage}>
    <div class="form-group row">
        <label for="cos_year" class="col-0.5 col-form-label px-0">學年度：</label>
        <div class="col-1 text-left px-0 mr-3">
            <select class="custom-select" name="cos_year" id="cos_year">
                <{$sems_year_htm}>
            </select>
        </div>
        <label for="cos_term" class="col-0.5 col-form-label text-center px-0">學期：</label>
        <div class="col-1 text-left px-0 mr-3">
            <select class="custom-select" name="cos_term" id="cos_term">
                <{$sems_term_htm}>
            </select>
        </div>

        <div>
            <input name="op" id="op" value="<{$op}>" type="hidden">
        </div>
        <button type="button" id="ac_smes" class="btn btn-outline-success col-0.5 mb-3 mr-3">目前學期</button>

    </div>
    <{/if}>
    </div>

<{if $all}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead class="table-info">
            <tr>
                <th scope="col" class="text-center">教師</th>
                <th scope="col" class="text-center">學年度</th>
                <th scope="col" class="text-center">學期</th>
                <th scope="col" class="text-center">學生姓名</th>
                <th scope="col" class="text-center">班級</th>
                <th scope="col" class="text-center">筆數</th>
                <th scope="col" class="text-center">功能</th>
            </tr>
        </thead>
        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr> 
            <th class="text-center"><{$its.tea_name}></th>
            <th class="text-center"><{$its.year}></th>
            <th class="text-center"><{$its.term}></th>
            <th class="text-center"><{$its.stu_anonymous}></th>
            <th class="text-center"><{$its.class_name}></th>
            <th class="text-center"><{$its.record_sum}></th>
            <th class="text-center">
                <a href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=counseling_show&year=<{$its.year}>&term=<{$its.term}>&stu_sn=<{$its.student_sn}>&tea_uid=<{$its.tea_uid}>" class="btn btn-primary btn-sm mr-2">觀看</a>
            </th>
        </tr>
    <{/foreach}>
        </tbody>
    </table>
    <{$bar}>

<{else}>
    <div class="alert alert-danger">尚無內容</div>
<{/if}>
</form>

<div id="printArea">
    <h2 align="center"> 每月高關懷名單 通報時間：<{$hi_care.year}>年 <{$hi_care.month}>月   </h2>
    <br>
<{if $all}>
    <table style="font-family:sans-serif;">
        <thead>
            <tr>
                <th class="text-center">編號</th>
                <th class="text-center">學生姓名</th>
                <th class="text-center">班級</th>
                <th class="text-center">狀況說明</th>
                <th class="text-center">填報時間</th>
                <th class="text-center">填報師長</th>
            </tr>
        </thead>
        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr> 
            <th class="text-center"><{$its.sn}></th>
            <th class="text-center"><{$its.student}></th>
            <th class="text-center"><{$its.class}></th>
            <th width="60%" class="text-left"><{$its.event_desc}></th>
            <th class="text-center"><{$its.keyin_date}></th>
            <th class="text-center"><{$its.update_user}></th>
        </tr>
    <{/foreach}>
        </tbody>
    </table>
<{else}>
    <div class="alert alert-danger">尚無內容</div>
<{/if}>

</div>

<script type="text/javascript">
    $(document).ready(function($){
        $('#cos_year').change(function(e){
            document.forms["counseling_list"].submit();
        });
        $('#cos_term').change(function(e){
            document.forms["counseling_list"].submit();
        });
        $("#ac_smes").click(function() {
            $('#cos_year').val('');
            $('#cos_term').val('');
            document.forms["counseling_list"].submit();
        });
        
    });
    function onprint() {
        window.print();
        return false;
    }
</script>

<style type="text/css">
@media screen 
{
    /* table th, .table th ,.table td, table.table-bordered > thead > tr > th{
        vertical-align:middle;
        text-align:center;
        border: 2px solid #000000;
        line-height:2.5em;
        width:auto;
        border-bottom: 2px solid #000000;
    } */
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
    table th, th, td{
        vertical-align:middle;
        text-align:center;
        border: 2px solid black;
    }   

}
</style>
<style type="text/css" media="screen">
    /* 顯示時隱藏 */
    #printArea { display: none; }
</style>
<style type="text/css" media="print">
    /* 列印時隱藏 */
    #high_care_mon,.notprint,#footer-container-display { display: none; }
</style>