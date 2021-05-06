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
<!-- 
            <div class="input-group mb-3 col-5">
                <div class="input-group-prepend">
                    <span class="input-group-text">新增</span>
                </div>
                <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" id="button-addon2" >確定</button>
                </div>
            </div> -->

          
        </div>
    </div>
    <button type="submit" style="display:none;"></button>
    <input name="op" id="op" value="<{$op}>" type="hidden">

</form>
<{$XOOPS_TOKEN}>


    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead>
            <tr>
                <th scope="col" colspan="4" class="">
                    <div class="d-flex justify-content-between">
                        <div class="p-2 bd-highlight"></div>
                        <div class="p-2 bd-highlight"><{$usual_exam_name.1}></div>
                        <div class="p-2 bd-highlight">
                            <button type="button" class="btn btn-primary btn-sm" onclick="self.location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=usual_socre_form&dep_id=<{$course.dep_id}>&course_id=<{$course.course_id}>&exam_stage=1';">新增成績</button>
                        </div>
                    </div>
                </th>
            </tr>
            <tr  class="table-info">
                <th scope="col" class="text-center">姓名</th>
                <th scope="col" class="text-center">第幾次</th>
                <th scope="col" class="text-center">平均</th>
            </tr>
        </thead>
        

        <tbody id="sort">
        <{foreach from=$all key=i item=its}>

        <tr id="odr_<{$its.sn}>" <{if $its.status=='0'}> class="text-danger"<{/if}>> 
            <th class="text-center" scope="row"><{$its.i}></th>
            <td class="text-center"><{$its.stu_id}></td>
            <td class="text-center"><{$its.stu_name}></td>
            <td class="text-center"><{$its.birthday}></td>
            <td class="text-center"><{$its.class_name}></td>
            <td class="text-center"><{$its.dep_name}></td>
            <td class="text-center"><{$its.social_id}></td>
            <td class="text-center"><{$its.guidance_id}></td>
        
            <td class="text-center">
                <a href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=student_form&sn=<{$its.sn}>" class="btn btn-warning btn-sm mr-2">編輯</a>
                <a href="javascript:cos_del(<{$its.sn}>)" class="btn btn-danger btn-sm">刪除</a>
            </td>
        </tr>
        <{/foreach}>
  
        </tbody>
    </table>

    <div class="alert alert-danger">
        尚無內容ss
    </div>

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
