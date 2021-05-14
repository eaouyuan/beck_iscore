<{$formValidator_code}>
<h2 class="mb-3">段考成績查詢</h2>
<form name="query_stage_score" id="query_stage_score" action="tchstu_mag.php" method="get">
   
    <div class="col">
        <div class="form-group row">
        
            <label for="dep_id" class="col-1.5 col-form-label text-sm-right px-0">學程名稱：</label>
            <div class="col-2 text-left px-0 mr-3">
                <select class="custom-select validate[required]" name="dep_id" id="dep_id">
                    <{$course.major_htm}>
                </select>
            </div>
            <label for="dep_id" class="col-1.5 col-form-label text-sm-right px-0">段考名稱：</label>
            <div class="col-2 text-left px-0 mr-3">
                <select class="custom-select validate[required]" name="exam_stage" id="exam_stage">
                    <{$course.exam_number_htm}>
                </select>
            </div>
        </div>
    </div>
    <button type="submit" style="display:none;"></button>
    <input name="op" id="op" value="<{$op}>" type="hidden">

</form>
<{$XOOPS_TOKEN}>
<{if $showtable}>



    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead>
            <tr class="table-info">
                <th scope="col" class="text-center">項次</th>
                <th scope="col" class="text-center">班級</th>
                <th scope="col" class="text-center">姓名</th>
                <{foreach from=$dep_exam_course key=k item=v}>
                    <th scope="col" class="text-center"><{$v}></th>
                <{/foreach}>
                <th scope="col" class="text-center">總分</th>
                <th scope="col" class="text-center">平均</th>
                <th scope="col" class="text-center">獎勵方式</th>
                <th scope="col" class="text-center">進步分</th>
                <th scope="col" class="text-center">備註</th>
            </tr>
        </thead>
        <tbody>
            <{foreach from=$all key=stu_sn item=v1}>
            <tr> 
                <th class="text-center" width="3%"><{$v1.order}></th>
                <th class="text-center" width="4%"><{$v1.class_name}></th>
                <th class="text-center" width="5%"><{$v1.stu_anonymous}></th>
                <{foreach from=$v1.scores key=course_id item=vscore}>
                    <th class="text-center" width="3%"><{$vscore}></th>
                <{/foreach}>
                <th class="text-center" width="3%"><{$v1.sum}></th>
                <th class="text-center" width="3%"><{$v1.avg}></th>
                <th class="text-left" width="12%">
                    <label name="reward_method[<{$stu_sn}>]"><{$v1.reward_method}></label>    
                </th>
                <th class="text-center" width="4%">
                    <label name="progress_score[<{$stu_sn}>]">進步分</label>    
                </th>
                <th class="text-center" width="12%">
                    <input type="text" class="form-control" name="comment[<{$stu_sn}>]" value="備註">
                </th>
            </tr>
            <{/foreach}>

            
            
        </tbody>
    </table>
    <br>

<{else}>
    <div class="alert alert-danger">
        尚無內容
    </div>
<{/if}>


<script type="text/javascript">
    $(document).ready(function($){
        $('#dep_id').change(function(e){
            $('#exam_stage').val('');
            let dep_id=$('#dep_id').val();
            location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=query_stage_score&dep_id='+dep_id;
        });
        $('#exam_stage').change(function(e){
            let dep_id=$('#dep_id').val();
            let exam_stage=$('#exam_stage').val();
            location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=query_stage_score&dep_id='+dep_id+'&exam_stage='+exam_stage;
        });


    })
</script>
<style type="text/css">
.table th ,.table td, table.table-bordered > thead > tr > th{
    vertical-align:middle;
    text-align:center;
    border: 1px solid #000000;
    /* width:auto; */
    /* border-bottom: 2px solid #000000; */
}

/* table.table-bordered > thead > tr > th{
  border:1px solid rgb(0, 0, 0);
} */
    [data-href] { cursor: pointer; }
</style>
