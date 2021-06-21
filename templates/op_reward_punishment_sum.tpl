<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/moment.min.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/moment-with-locales.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/beck_iscore/js/bootstrap-datetimepicker.js"></script>
<link href="<{$xoops_url}>/modules/beck_iscore/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">


<form name="reward_punishment_sum" id="reward_punishment_sum" action="tchstu_mag.php" method="get">
    <h2 class="mb-3">學生獎懲總表</h2>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">日期起</span>
            </div>
            <input type="text" class="form-control" id="sdate" name="sdate" value="<{$sel.sdate}>">

            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">日期迄</span>
            </div>
            <input type="text" class="form-control" id="edate" name="edate" value="<{$sel.edate}>">
            <div class="input-group-append mr-3">
                <button class="btn btn-outline-secondary" type="submit" id="query">送出</button>
            </div>
            <div class="ml-auto">
                <button type="button" class="btn btn-secondary mr-2" onclick="self.location.href='tchstu_mag.php?op=reward_punishment_sum';">清空</button>
                <button type="button" class="btn btn-outline-success" onclick="cur_term()">目前學年度</button>
            </div>
        </div>
        <div>
            <input name="op" id="op" value="<{$op}>" type="hidden">
        </div>
    


<{if $all}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead class="table-info">
            <tr>
                <th scope="col" class="text-center">學生</th>
                <{foreach from=$RP_option key=opv item=opna}>
                <th scope="col" class="text-center text-nowrap"><{$opna}></th>
                <{/foreach}>
            </tr>
        </thead>
        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr> 
            <th class="text-center text-nowrap"><{$its.title}></th>
            <{foreach from=$RP_option key=opv item=opna}>
                <th scope="col" class="text-center text-nowrap"><{$its.$opv}></th>
            <{/foreach}>
        </tr>
    <{/foreach}>
        </tbody>
    </table>
<{else}>
    <div class="alert alert-danger">尚無內容</div>
<{/if}>

    <div class="col-md-12 text-center mb-3">
        <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=reward_punishment_list">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>回上一頁</a>
    </div>
</form>


<script src="<{$xoops_url}>/modules/tadtools/sweet-alert/sweet-alert.js" type="text/javascript"></script>
<link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/sweet-alert/sweet-alert.css" type="text/css" />
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

    });
    
    $('#sdate').datepicker().on("dp.hide", function () {
        $('#ui-datepicker-div').hide();
        datediff();
    });
    $('#edate').datepicker().on("dp.hide", function () {
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
    function cur_term(){
        $('#sdate').val('<{$sem_term_sdate}>');
        $('#edate').val('<{$sem_term_edate}>');
        document.forms["reward_punishment_sum"].submit();

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

</style>
