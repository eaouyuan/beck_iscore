<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/moment.min.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/moment-with-locales.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/bootstrap-datetimepicker.js"></script>
<link href="<{$xoops_url}>/modules/beck_iscore/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/tableExport.jquery.plugin-master/bootstrap-table.min.js"></script>
<link rel="stylesheet" href="<{$xoops_url}>/modules/beck_iscore/css/bootstrap-table.min.css" type="text/css"/>

<form name="term_stu_list" id="term_stu_list" action="school_affairs.php" method="post">
    <h2 class="mb-3">學期─學生列表</h2>
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

        <div>
            <input name="op" id="op" value="<{$op}>" type="hidden">
        </div>
    
        <div class="ml-auto">
            <button type="button" class="btn btn-outline-success mr-2" onclick="self.location.href='school_affairs.php?op=term_stu_list';">目前學期</button>
            <{if $show_update_btn ==1}>
                <button id="update" class="btn btn-primary mr-2" type="button"><i class="fa fa-refresh mr-2" aria-hidden="true"></i>更新列表</button>
                <!-- <button type="button" class="btn btn-primary mr-2" onclick="self.location.href='school_affairs.php?op=term_stu_update';">
                    <i class="fa fa-refresh mr-2" aria-hidden="true"></i>更新列表</button> -->
            <{/if}>
            <!-- <button type="button" class="btn btn-success mr-2" onclick="onprint()"><i class="fa fa-print mr-2" aria-hidden="true"></i>列印</button> -->
            <{$XOOPS_TOKEN}>
        </div>
    </div>
    </div>

<{if $all}>
    <table class="table table-sm table-hover table-shadow" id="mytable">
        <thead class="table-info">
            <tr>
                <th scope="col" data-sortable="true" class="text-center">編號</th>
                <th scope="col" class="text-center">學年度/學期</th>
                <th scope="col" data-sortable="true" class="text-center">學號</th>
                <th scope="col" data-sortable="true" class="text-center">姓名</th>
                <th scope="col" data-sortable="true" class="text-center">班級</th>
                <th scope="col" data-sortable="true" class="text-center">導師</th>
                <th scope="col" data-sortable="true" class="text-center">學程</th>
                <th scope="col" data-sortable="true" class="text-center">年級</th>
                <th scope="col" class="text-center">功能</th>
            </tr>
        </thead>
        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr> 
            <th class="text-center text-nowrap"><{$its.sn}></th>
            <th class="text-center text-nowrap"><{$its.year}>/<{$its.term}></th>
            <th class="text-center text-nowrap"><{$its.stu_id}></th>
            <th class="text-center text-nowrap"><{$its.stu_name}></th>
            <th class="text-center text-nowrap"><{$its.class_name}></th>
            <th class="text-center text-nowrap"><{$its.tutor_name}></th>
            <th class="text-center text-nowrap"><{$its.dep_name}></th>
            <th class="text-center text-nowrap"><{$its.grade}></th>
            <th class="text-center text-nowrap">
            <{if $show_update_btn ==1}>
                <a href="javascript:TS_del(<{$its.sn}>)" class="btn btn-danger btn-sm">刪除</a>
            <{/if}>
            </th>
        </tr>
    <{/foreach}>
        </tbody>
    </table>
<{else}>
    <div class="alert alert-danger">尚無內容</div>
<{/if}>
</form>

<script type="text/javascript">
    $(document).ready(function($){ 
        $('#year,#term').change(function(e){
            document.forms["term_stu_list"].submit();
        })

    });
    $("#update").click(function() {
        $('#op').val('term_stu_update');
        // console.log($('#op').val());
        document.forms["term_stu_list"].submit();
    });

    $('#mytable').bootstrapTable({
    });
</script>



<style type="text/css">
@media screen 
{
    .table > tbody > tr > th,.table > thead > tr > th {
        vertical-align:middle;
        text-align:center;
        /* border: 1px solid #000; */
        /* line-height:1em; */
    }
    /* input , select{
        position: relative;
        vertical-align:middle;
        text-align:center;
    }  */
    .table > tbody > tr:hover{
        text-decoration: none;
        color: #000000;
        background-color: #fcdede;
    }
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
    #term_stu_list,.notprint,#footer-container-display,#nav-container { display: none; }
</style>