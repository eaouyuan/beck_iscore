<form name="high_care_mon" id="high_care_mon" action="tchstu_mag.php" method="get">
    <h2 class="mb-3">每月高關懷名單</h2>
    <div class="col">
    <div class="form-group row">
        <label for="ann_class_id" class="col-1.5 col-form-label text-sm-right px-0">通報時間：</label>
        <div class="col-1.5 text-center px-0 mr-3">
            <select class="custom-select" name="year" id="year">
                <{$year_sel}>
            </select>
        </div>

        <label for="dept_id" class="col-1.5 col-form-label text-sm-right px-0">月份：</label>
        <div class="col-1.5 text-left px-0 mr-3">
            <select class="custom-select" name="month" id="month">
                <{$month_sel}>
            </select>
        </div>


        <div>
            <input name="op" id="op" value="<{$op}>" type="hidden">
        </div>
        <button type="submit" class="btn btn-outline-primary col-0.5 mb-3 mr-3">搜尋</button>
        <button type="button" class="btn btn-outline-success col-0.5 mb-3 mr-3" onclick="self.location.href='tchstu_mag.php?op=high_care_mon';">目前月份</button>
        <div class="ml-auto">
            <button type="button" class="btn btn-primary" onclick="self.location.href='tchstu_mag.php?op=high_care_form';">
                <i class="fa fa-plus-circle  mr-2" aria-hidden="true"></i>新增關懷學生
            </button>
            <button type="button" class="btn btn-success" onclick="onprint()"><i class="fa fa-print  mr-2" aria-hidden="true"></i>列印</button>
            <button type="button" class="btn btn-primary" onclick="self.location.href='tchstu_mag.php?op=high_care_list';">
                <i class="fa fa-list mr-2" aria-hidden="true"></i>回高關懷名單列表
            </button>
        </div>
    </div>
    </div>

<{if $all}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead class="table-info">
            <tr>
                <th scope="col" class="text-center">編號</th>
                <th scope="col" class="text-center">學生姓名</th>
                <th scope="col" class="text-center">班級</th>
                <th scope="col" class="text-center">狀況說明</th>
                <th scope="col" class="text-center">填報時間</th>
                <th scope="col" class="text-center">填報師長</th>
                <th scope="col" class="text-center">功能</th>
            </tr>
        </thead>
        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr> 
            <th class="text-center"><{$its.sn}></th>
            <th class="text-center"><{$its.student}></th>
            <th class="text-center"><{$its.class}></th>
            <th width="50%" class="text-left"><{$its.event_desc}></th>
            <th class="text-center"><{$its.keyin_date}></th>
            <th class="text-center"><{$its.update_user}></th>
            <td  class="text-center">
                <{if $its.edit}>
                <a href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=high_care_form&sn=<{$its.sn}>" class="btn btn-warning btn-sm mr-2">編輯</a>
                <a href="javascript:hi_care_del(<{$its.sn}>)" class="btn btn-danger btn-sm">刪除</a>
                <{/if}>
            </td>
        </tr>
    <{/foreach}>
        </tbody>
    </table>
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