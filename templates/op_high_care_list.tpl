
<div class="col">
    <form name="high_care_list" id="high_care_list" action="tchstu_mag.php" method="get">
        <div class="form-group row">
            <h2 class="mb-3">高關懷名單─列表</h2>
        </div>

</form>
</div> 
<!-- <{if $show_add_button=='0'}></div><{/if}> -->



<{if $all}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead class="table-info">
            <tr>
                <th class="text-center">編號</th>
                <th class="text-center">年度</th>
                <th class="text-center">月份</th>
                <th class="text-center">事件名稱</th>
                <th class="text-center">事件日期</th>
            </tr>
        </thead>
        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr"> 
            <th class="text-center"><{$its.sn}></th>
            <th class="text-center"><{$its.year}></th>
            <th class="text-center"><{$its.month}></td>
            <th class="text-left clickable-row" data-href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=high_care_mon&year=<{$its.year}>&month=<{$its.month}>"><{$its.event}></td>
            <th class="text-center"><{$its.event_date}></td>
        </tr>
    <{/foreach}>
        </tbody>
    </table>
<{else}>
    <div class="alert alert-danger">
        尚無內容
    </div>
<{/if}>

<{$bar}>

<script type="text/javascript">
    $(document).ready(function($){
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
    
</script>

<style type="text/css">
    [data-href] { cursor: pointer; }
</style>