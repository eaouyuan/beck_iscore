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

</style>
