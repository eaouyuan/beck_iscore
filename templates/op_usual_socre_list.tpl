<{$formValidator_code}>
<h2 class="mb-3">平時成績登錄</h2>
<form name="usual_socre_list" id="usual_socre_list" action="tchstu_mag.php" method="get">
   
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
            <{if $show_select}>
            <div class="input-group col-5 mb-1 ml-auto row">
                <div class="input-group-prepend">
                    <span class="input-group-text">新增平時成績</span>
                </div>
                <select class="custom-select validate[required]" name="exam_number" id="exam_number">
                    <{$course.exam_number_htm}>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" id="add_uscore">確定</button>
                </div>
            </div>
            <{/if}>

        </div>
    </div>
    <button type="submit" style="display:none;"></button>
    <input name="op" id="op" value="<{$op}>" type="hidden">

</form>
<{$XOOPS_TOKEN}>
<{if $showtable}>

<{foreach from=$all key=exam_stage item=v1}>

    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead>
            <tr class="table-success">
                <th scope="col" colspan="<{$score_count.$exam_stage.score_count+2}>">
                    <div class="p-2 text-center"><{$usual_exam_name.$exam_stage}></div>
                </th>
            </tr>
            <tr class="table-info" style="border:2px 2px 3px 4px solid #000000;">
                <th class="text-center">姓名</th>
                <{foreach from=$score_count.$exam_stage.test_ary key=k item=exam_number}>
                        <th scope="col" class="text-center">第<{$exam_number}>次
                            <{if $addEdit.$exam_stage}>
                            <a href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=usual_socre_form&dep_id=<{$course.dep_id}>&course_id=<{$course.course_id}>&exam_stage=<{$exam_stage}>&exam_number=<{$exam_number}>" class="btn btn-warning btn-sm mr-2">
                            <i class="fa fa-pencil"></i>
                            </a>
                            <{/if}>
                        </th>
                <{/foreach}>
                <th scope="col" class="text-center">平均</th>
            </tr>
        </thead>
        

        <tbody id="sort">
            <{foreach from=$v1 key=student_sn item=v2}>
            <tr id="odr_<{$its.sn}>"> 

                <th class="text-center"><{$v2.name}></th>

                <{foreach from=$v2.score key=k item=score}>
                <th class="text-center"><{$score}></th>
                <{/foreach}>
                
                <th class="text-center"><{$v2.avg}></th>
                
            </tr>
            <{/foreach}>

            
            
        </tbody>
    </table>
    <br>
<{/foreach}>

<{else}>
    <div class="alert alert-danger">
        尚無內容
    </div>
<{/if}>


<script type="text/javascript">
    $(document).ready(function($){
        $('#dep_id').change(function(e){
            $('#course_id').val('');
            document.forms["usual_socre_list"].submit();
        });
        $('#course_id').change(function(e){
            document.forms["usual_socre_list"].submit();
        });

        $("#add_uscore").click(function() {
            let exam_number_val=$("#exam_number option:selected").val();
            if(exam_number_val==''){
                alert("請選擇成績階段或目前非成績輸入時間!");
            }else{
                let url="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=usual_socre_form&dep_id=<{$course.dep_id}>&course_id=<{$course.course_id}>&exam_stage="+exam_number_val;
                location.href=url;
            }
            
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
