<{$formValidator_code}>
<h2 class="mb-3">段考成績登錄</h2>
<form name="stage_score_list" id="stage_score_list" action="tchstu_mag.php" method="post">
   
    <div class="col">
        <div class="form-group row">
        
            <label for="dep_id" class="col-1.5 col-form-label text-sm-right px-0">學程名稱：</label>
            <div class="col-2 text-left px-0 mr-3">
                <select class="custom-select validate[required]" name="dep_id" id="dep_id">
                    <{$course.major_htm}>
                </select>
            </div>
            <label for="dep_id" class="col-1.5 col-form-label text-sm-right px-0">課程名稱：</label>
            <div class="col-2 text-left px-0 mr-3">
                <select class="custom-select validate[required]" name="course_id" id="course_id">
                    <{$course.course_htm}>
                </select>
            </div>
            <label for="dep_id" class="col-1.5 col-form-label text-sm-right px-0">教師姓名：</label>
            <div class="col-2 text-left px-0 mr-3">
                <input type="text" class="form-control" readonly value="<{$sscore.tea_name}>">
            </div>
        </div>
    </div>

<{if $showtable}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead>
            <tr class="table-info">
                
                <th class="text-center">姓名</th>
                <{foreach from=$exam_name key=exam_sn item=exam_chnname}>
                    <th scope="col" class="text-center"><{$exam_chnname}></th>
                <{/foreach}>
                <th scope="col" class="text-center">平時成績<br>(<{$course.normal_exam_rate}>%)</th>
                <th scope="col" class="text-center">段考成績<br>(<{$course.section_exam_rate}>%)</th>
                <th scope="col" class="text-center">總成績</th>
                <th scope="col" class="text-center">質性描述</th>
            </tr>
        </thead>
        <tbody>
            <{foreach from=$all key=stu_sn item=v1}>
            <tr> 
                <th class="text-center"><{$v1.name}></th>
                <{foreach from=$v1.score key=k item=score}>
                    <{if $addEdit.$k}>
                    <th class="text-center">
                        <input type="text" class="form-control validate[required]" name="stu_score[<{$stu_sn}>][score][<{$k}>]" id="stu_<{$stu_sn}>" value="<{$score}>">
                    </th>
                    <{else}>
                        <th class="text-center"><{$score}></th>
                    <{/if}>

                <{/foreach}>
                <th class="text-center"><{$v1.f_usual}></th>
                <th class="text-center"><{$v1.f_stage}></th>
                <th class="text-center"><{$v1.f_sum}></th>
                <th class="text-center">
                    <{if $desc_addEdit}>
                        <input type="text" class="form-control validate[required]" name="stu_score[<{$stu_sn}>][desc]" id="stu_<{$stu_sn}>" value="<{$v1.desc}>">
                    <{else}>
                        <{$v1.desc}>
                    <{/if}>

                </th>
            </tr>
            <{/foreach}>

        </tbody>
    </table>
    <br>
    <div>
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <input name="year" id="year" value="<{$sscore.year}>" type="hidden">
        <input name="term" id="term" value="<{$sscore.term}>" type="hidden">
        <input name="update_user" id="update_user" value="<{$uid}>" type="hidden">
        <{$XOOPS_TOKEN}>
    </div>

    <div class="col-md-12 text-center mb-3">
        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button>
        <a class="btn btn-secondary" href="javascript:history.back()">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
    </div>
<{else}>
    <div class="alert alert-danger">
        尚無內容
    </div>
<{/if}>
</form>
<script type="text/javascript">
    $(document).ready(function($){
        $('#dep_id').change(function(e){
            $('#course_id').val('');
            let dep_id=$('#dep_id').val();
            location.href='http://localhost/modules/beck_iscore/tchstu_mag.php?op=stage_score_list&dep_id='+dep_id;
        });
        $('#course_id').change(function(e){
            let dep_id=$('#dep_id').val();
            let course_id=$('#course_id').val();
            location.href='http://localhost/modules/beck_iscore/tchstu_mag.php?op=stage_score_list&dep_id='+dep_id+'&course_id='+course_id;
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

input , select{
    /* width:auto; */
    position: relative;
    vertical-align:middle;
    text-align:center;
}
</style>
