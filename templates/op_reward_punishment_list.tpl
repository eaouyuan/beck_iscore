<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/moment.min.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/moment-with-locales.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/bootstrap-datetimepicker.js"></script>
<link href="<{$xoops_url}>/modules/beck_iscore/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">


<form name="reward_punishment_list" id="reward_punishment_list" action="tchstu_mag.php" method="get">
    <h2 class="mb-3">學生獎懲管理</h2>
    <div class="col">
    <div class="form-group row">
        <label for="ann_class_id" class="col-form-label text-sm-left px-0 mb-3">類別：</label>
        <div class="text-left px-0 mr-3">
            <select class="custom-select" name="RP_kind" id="RP_kind">
                <{$sel.RP_kind}>
            </select>
        </div>

        <label for="dept_id" class="col-form-label text-sm-right px-0">學程：</label>
        <div class="text-left px-0 mr-3">
            <select class="custom-select" name="dep_id" id="dep_id">
                <{$sel.major_htm}>
            </select>
        </div>
        <label for="ann_class_id" class="col-form-label text-sm-left px-0">班級：</label>
        <div class="col-1 text-left px-0 mr-3">
            <select class="custom-select" name="class_id" id="class_id">
                <{$sel.class_name}>
            </select>
        </div>

        <label for="dept_id" class="col-form-label text-sm-right px-0">學生：</label>
        <div class="col-1 text-left px-0 mr-3">
            <select class="custom-select" name="stu_sn" id="stu_sn">
                <{$sel.stu_anonymous}>
            </select>
        </div>
        <div class="input-group mb-3 col-5 ml-auto row">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">日期起</span>
            </div>
            <input type="text" class="form-control" id="sdate" name="sdate" value="<{$sel.sdate}>">

            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">日期迄</span>
            </div>
            <input type="text" class="form-control" id="edate" name="edate" value="<{$sel.edate}>">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" id="query">送出</button>
            </div>
        </div>

        <div>
            <input name="op" id="op" value="<{$op}>" type="hidden">
        </div>
    
        <div class="ml-auto">
            <button type="button" class="btn btn-secondary mr-2" onclick="self.location.href='tchstu_mag.php?op=reward_punishment_list';">清空條件</button>
            <button type="button" class="btn btn-primary mr-2" onclick="self.location.href='tchstu_mag.php?op=reward_punishment_form';">
                <i class="fa fa-plus-circle " aria-hidden="true"></i>新增獎懲
            </button>
            <button type="button" class="btn btn-success mr-2" onclick="onprint()"><i class="fa fa-print  mr-2" aria-hidden="true"></i>列印</button>
            <button type="button" class="btn btn-primary" onclick="self.location.href='tchstu_mag.php?op=reward_punishment_sum';">
                <i class="fa fa-list mr-2" aria-hidden="true"></i>獎懲總表
            </button>
        </div>
    </div>
    </div>

<{if $all}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead class="table-info">
            <tr>
                <th scope="col" class="text-center text-nowrap">編號</th>
                <th scope="col" class="text-center">類別</th>
                <th scope="col" class="text-center">獎懲日期</th>
                <th scope="col" class="text-center">學生</th>
                <th scope="col" class="text-center">獎懲事由</th>
                <th scope="col" class="text-center text-nowrap">獎懲內容</th>
                <th scope="col" class="text-center">功能</th>
            </tr>
        </thead>
        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr> 
            <th class="text-center text-nowrap"><{$its.rpsn}></th>
            <th class="text-center text-nowrap <{$its.color}>"><{$its.RP_kind_name}></th>
            <th class="text-center text-nowrap"><{$its.event_date}></th>
            <th class="text-center text-nowrap"><{$its.stu_info}></th>
            <th class="text-center"><{$its.RP_content}></th>
            <th class="text-center text-nowrap <{$its.color}>"><{$its.RP_item}></th>
            <th class="text-center text-nowrap">
                <a href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=reward_punishment_form&sn=<{$its.rpsn}>" class="btn btn-warning btn-sm mr-2">編輯</a>
                <a href="javascript:RP_del(<{$its.rpsn}>)" class="btn btn-danger btn-sm">刪除</a>
            </th>
        </tr>
    <{/foreach}>
        </tbody>
    </table>
    <h3 class="text-center"><{$summary_text}></h3>
<{else}>
    <div class="alert alert-danger">尚無內容</div>
<{/if}>
</form>

<div id="printArea">
    <h2 align="center"> 學生獎懲管理</h2>
    <br>
<{if $all}>
    <table style="font-family:sans-serif;">
        <thead>
            <tr>
                <th class="text-center text-nowrap">編號</th>
                <th class="text-center">類別</th>
                <th class="text-center">獎懲日期</th>
                <th class="text-center">學生</th>
                <th class="text-center">獎懲事由</th>
                <th class="text-center">獎懲內容</th>
            </tr>
        </thead>
        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr> 
            <th class="text-center text-nowrap"><{$its.rpsn}></th>
            <th class="text-center text-nowrap"><{$its.RP_kind_name}></th>
            <th class="text-center text-nowrap"><{$its.event_date}></th>
            <th class="text-center text-nowrap"><{$its.stu_info}></th>
            <th class="text-left"><{$its.RP_content}></th>
            <th class="text-center text-nowrap"><{$its.RP_item}></th>
        </tr>
    <{/foreach}>
        </tbody>
    </table>
    <h3 class="text-center"><{$summary_text}></h3>

<{else}>
    <div class="alert alert-danger">尚無內容</div>
<{/if}>

</div>
<!-- <script src="<{$xoops_url}>/modules/tadtools/sweet-alert/sweet-alert.js" type="text/javascript"></script> -->
<!-- <link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/sweet-alert/sweet-alert.css" type="text/css" /> -->
<script type="text/javascript">
    $(document).ready(function($){
        $('#sdate').datetimepicker({
            format: 'L', // date
            // format: 'LT', //time
            locale: 'zh-tw',
            // stepping: 5,
        });
        $('#edate').datetimepicker({
            format: 'L', // date
            // format: 'LT', //time
            locale: 'zh-tw',
            // stepping: 5,
        });     
        $('#RP_kind').change(function(e){
            document.forms["reward_punishment_list"].submit();
        })
        $('#dep_id').change(function(e){
            document.forms["reward_punishment_list"].submit();
        })
        $('#class_id').change(function(e){
            document.forms["reward_punishment_list"].submit();
        })
        $('#stu_sn').change(function(e){
            document.forms["reward_punishment_list"].submit();
        })

    });
    
    $('#sdate,#edate').datepicker().on("dp.hide", function () {
        $('#ui-datepicker-div').hide();
        datediff();
    });
    $('#sdate,#edate').datepicker().on("dp.show", function () {
        $('#ui-datepicker-div').hide();
        datediff();
    });

    function datediff() {
        let sdate=$('#sdate').val();
        let edate=$('#edate').val();
        let sdval=sdate.replace(/-/g, "/");
        let edval=edate.replace(/-/g, "/");
        if(Date.parse(sdval).valueOf() > Date.parse(edval).valueOf()){
            sweetAlert("注意開始時間不能晚於結束時間！", "日期輸入錯誤","error");
            $('#edate').val(sdate);
            return false;
        }
    }
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
    #reward_punishment_list,.notprint,#footer-container-display,#nav-container { display: none; }
</style>