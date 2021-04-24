<h2 style="float:left" class="mb-3">學生─基本資料列表</h2>
<div class="col row"></div>
<button type="button" class="btn btn-primary btn-sm mb-2" onclick="self.location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=student_form';" style="float:right">
    <img src="http://localhost/modules/system/images/icons/transition/add.png" alt="新增學生">新增學生
</button>
<form name="student_list" id="student_list" action="tchstu_mag.php" method="get">
    <div class="form-group row">
        <label for="status" class="col-1.5 col-form-label text-sm-right px-0">狀態：</label>
        <div class="col-2 text-left px-0 mr-3">
            <select class="custom-select" name="status" id="status">
                <{$status_htm}>
            </select>
        </div>

        <label for="major_id" class="col-1.5 col-form-label text-sm-right px-0">學程：</label>
        <div class="col-2 text-left px-0 mr-2">
            <select class="custom-select" name="major_id" id="major_id">
                <{$major_htm}>
            </select>
        </div>


        <label class="col-1 col-form-label text-sm-right px-0" for="search">姓名</label>
        <div class="mx-sm-3 col-3 text-left px-0">
            <input type="text" class="form-control" id="search" name="search" placeholder="search" value="<{$search}>">
        </div>
        <div>
            <input name="op" id="op" value="<{$op}>" type="hidden">
        </div>
        <button type="submit" id="cmdsubmit" class="btn btn-outline-primary col-0.5 mr-1">搜尋</button>
        <button type="button" id="clear" class="btn btn-outline-dark col-0.5">清空</button>

    </div>
</form>
<{$XOOPS_TOKEN}>


<{if $all}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead class="table-info">
            <tr>
                <th scope="col" class="text-center">編號</th>
                <th scope="col" class="text-center">學號</th>
                <th scope="col" class="text-center">姓名</th>
                <th scope="col" class="text-center">生日</th>
                <th scope="col" class="text-center">班級</th>
                <th scope="col" class="text-center">學程</th>
                <!-- <th scope="col" class="text-center">導師</th> -->
                <th scope="col" class="text-center">社工師</th>
                <th scope="col" class="text-center">輔導老師</th>
                <!-- <th scope="col" class="text-center">認輔教師</th> -->
                <{if $can_edit}>
                <th scope="col" class="text-center">功能</th>
                <{/if}>

            </tr>
        </thead>
        

        <tbody id="sort">
    <{foreach from=$all key=i item=its}>
        <tr id="odr_<{$its.uid}>" <{if $its.status=='0'}> class="text-danger"<{/if}>> 
            <th class="text-center" scope="row"><{$its.i}></th>
            <td class="text-center"><{$its.stu_id}></td>
            <td class="text-center"><{$its.stu_name}></td>
            <td class="text-center"><{$its.birthday}></td>
            <td class="text-center"><{$its.class_name}></td>
            <td class="text-center"><{$its.dep_name}></td>
            <!-- <td class="text-center"><{$its.tutor_name}></td> -->
            <td class="text-center"><{$its.social_id}></td>
            <td class="text-center"><{$its.guidance_id}></td>
            <!-- <td class="text-center"><{$its.rcv_guidance_id}></td> -->
            <{if $can_edit}>
            <td class="text-center">
                <a href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=student_form&sn=<{$its.sn}>" class="btn btn-warning btn-sm mr-2">編輯</a>
                <a href="javascript:stu_del(<{$its.sn}>)" class="btn btn-danger btn-sm">刪除</a>
            </td>
            <{/if}>
        </tr>
    <{/foreach}>
        </tbody>
    </table>
<{else}>
    <div class="alert alert-danger row">
        尚無內容
    </div>
<{/if}>

<{$bar}>

<script type="text/javascript">
    $(document).ready(function($){
        $("#clear").click(function() {
            $('#search').val('');
            $("#status option:selected").prop("selected", false);
            $("#major_id option:selected").prop("selected", false);
            document.forms["student_list"].submit();
        });

        $('#status').change(function(e){
            // 方法一 php form表單按下submit
            // $(this).closest('form').trigger('submit');
            // 方法二 php form表單按下submit
            document.forms["student_list"].submit();
        });
        $('#major_id').change(function(e){
            // 方法一 php form表單按下submit
            // $(this).closest('form').trigger('submit');
            // 方法二 php form表單按下submit
            document.forms["student_list"].submit();
        });




    })
</script>
<style type="text/css">
    [data-href] { cursor: pointer; }
</style>

