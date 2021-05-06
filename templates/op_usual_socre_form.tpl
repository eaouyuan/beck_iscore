<!-- <link rel="stylesheet" href="../beck_iscore/css/jquery-ui.css">
<script src="<{$xoops_url}>/modules/beck_iscore/js/jquery-ui.js"></script> -->
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>

<{$formValidator_code}>

<form name="usual_socre_form" id="usual_socre_form" action="tchstu_mag.php" method="post" enctype='multipart/form-data'>

    
    <div class="alert alert-primary" role="alert">
        <h4 class="text-center">學程：<{$uscore.dep_name}>學程  / 課程：<{$uscore.course_name}> / 授課教師：<{$uscore.tea_name}></h4>
    </div>
    <h3 class="text-center"><{$uscore.exam_stage_name}></h3>
    <table class="table table-bordered table-sm">
        <tbody>
            <tr class="table-info">
                <th scope="row">學生姓名</th>
                <th scope="row">第<{$uscore.exam_number}>次平時成績</th>
            </tr>
        <{foreach from=$all key=i item=its}>
            <tr id="odr_<{$its.uid}>"> 
                <th class="text-center"><{$its.name}></th>
                <td>
                    <input type="text" class="form-control validate[required]" name="student_sn[<{$i}>]" id="stu_<{$i}>" value="<{$its.score}>">
                </td>
    
            </tr>
        <{/foreach}>
            
        </tbody>
    </table>

    <div>
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <input name="year" id="year" value="<{$uscore.year}>" type="hidden">
        <input name="term" id="term" value="<{$uscore.term}>" type="hidden">
        <input name="dep_id" id="dep_id" value="<{$uscore.dep_id}>" type="hidden">
        <input name="course_id" id="course_id" value="<{$uscore.course_id}>" type="hidden">
        <input name="exam_stage" id="exam_stage" value="<{$uscore.exam_stage}>" type="hidden">
        <input name="exam_number" id="exam_number" value="<{$uscore.exam_number}>" type="hidden">
        <input name="update_user" id="update_user" value="<{$uid}>" type="hidden">
        <{$XOOPS_TOKEN}>
    </div>

    <div class="col-md-12 text-center mb-3">
        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button>
        <a class="btn btn-secondary" href="javascript:history.back()">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
        <!-- <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=course_list"><i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a> -->
        <a href="javascript:cosss_del(<{$sn}>)" class="btn btn-danger">
                <i class="fa fa-trash-o mr-2" aria-hidden="true"></i>刪除</a>
    </div>

</form>


<script type="text/javascript">
    $(document).ready(function($){
      

    });
 

</script>

<style>

.table th ,.table td{
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
input[type=radio]{
    transform:scale(1.5);
}


</style>

