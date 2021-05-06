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
        </div>
    </div>
    <button type="submit" style="display:none;"></button>
    <input name="op" id="op" value="<{$op}>" type="hidden">

</form>
<{$XOOPS_TOKEN}>
<{if $all}>

<{foreach from=$all key=exam_stage item=v1}>

    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead>
            <tr>
                <th scope="col" colspan="<{$score_count.$exam_stage.score_count+2}>">
                    <div class="d-flex justify-content-between">
                        <div class="p-2 bd-highlight"></div>
                        <div class="p-2 bd-highlight"><{$usual_exam_name.$exam_stage}></div>
                        <div class="p-2 bd-highlight">
                            <button type="button" class="btn btn-primary btn-sm" onclick="self.location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=usual_socre_form&dep_id=<{$course.dep_id}>&course_id=<{$course.course_id}>&exam_stage=<{$exam_stage}>';">新增成績</button>
                        </div>
                    </div>
                </th>
            </tr>
            <tr  class="table-info">
                <th scope="col" class="text-center">姓名</th>
                <{foreach from=$score_count.$exam_stage.test_ary key=k item=exam_number}>
                        <th scope="col" class="text-center">第<{$exam_number}>次
                            <a href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=usual_socre_form&dep_id=<{$course.dep_id}>&course_id=<{$course.course_id}>&exam_stage=<{$exam_stage}>&exam_number=<{$exam_number}>" class="btn btn-warning btn-sm mr-2">
                                    <i class="fa fa-pencil"></i>
                            </a></th>
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
                
                <td class="text-center">
                    <a href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=student_form&sn=<{$its.sn}>" class="btn btn-warning btn-sm mr-2">編輯</a>
                    <a href="javascript:cos_del(<{$its.sn}>)" class="btn btn-danger btn-sm">刪除</a>
                </td>
                
            </tr>
            <{/foreach}>

            
            
        </tbody>
    </table>
<{/foreach}>

<{else}>
    <div class="alert alert-danger">
        尚無內容
    </div>
<{/if}>


<script type="text/javascript">
    $(document).ready(function($){
        $("#clear").click(function() {
            $('#search').val('');
            $("#status option:selected").prop("selected", false);
            $("#major_id option:selected").prop("selected", false);
            document.forms["student_list"].submit();
        });

        $('#dep_id').change(function(e){
            $('#course_id').val('');
            document.forms["usual_socre_list"].submit();
        });
        $('#course_id').change(function(e){
            document.forms["usual_socre_list"].submit();
        });

        $('#sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable('serialize')+'&op=student_sort';
            // console.log(order);
            $.post('other_action.php',  order, function(theResponse){
                // console.log(theResponse);
                $('#save_msg').html(theResponse);
            });
            }
        });



    })
</script>
<style type="text/css">
    [data-href] { cursor: pointer; }
</style>
