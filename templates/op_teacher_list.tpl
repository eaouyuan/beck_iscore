<div class="container">
    <h2 style="float:left" class="mb-3">教師一覽表</h2>
    <div class="col row"></div>
        <button type="button" class="btn btn-primary btn-sm mb-2" onclick="self.location.href='school_affairs.php?op=teacher_form';" style="float:right">
        <img src="http://localhost/modules/system/images/icons/transition/add.png" alt="新增教師">新增教師
        </button>
    <form name="teacher_list" id="teacher_list" action="school_affairs.php" method="get">
        <div class="form-group row">

            <label for="dept_id" class="col-1.5 col-form-label text-sm-right px-0">部門：</label>
            <div class="col-2 text-left px-0 mr-3">
                <select class="custom-select" name="dept_id" id="dept_id">
                    <{$dept_c_sel_htm}>
                </select>
            </div>

            <label class="col-1 col-form-label text-sm-right px-0" for="search">關鍵字</label>
            <div class="mx-sm-3 col-3 text-left px-0">
                <input type="text" class="form-control" id="search" name="search" placeholder="search" value="<{$search}>">
            </div>
            <div>
                <input name="op" id="op" value="<{$op}>" type="hidden">
            </div>
            <button type="submit" class="btn btn-outline-dark col-0.5 mr-1">搜尋</button>
            <button type="button" id="clear" class="btn btn-outline-dark col-0.5">清空</button>
        </div>



    </form>



</div>
<!-- <div class=""> -->
<{if $all}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead class="table-info">
            <tr>
                <th scope="col" class="text-center">編號</th>
                <th scope="col" class="text-center">類別</th>
                <th scope="col" class="text-center">單位</th>
                <th scope="col" class="text-center">標題</th>
                <th scope="col" class="text-center">建立日期</th>
                <!-- <th scope="col" class="text-center">結束日期</th> -->
                <th scope="col" class="text-center">點閱數</th>
                <{if $is_admin}>
                <th scope="col" class="text-center">功能</th>
                <{/if}>

            </tr>
        </thead>
        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr> 
            <th class="text-center"scope="row"><{$its.sn}></th>
            <td class="text-center"><{$its.ann_class_id}></td>
            <td class="text-center"><{$its.dept_id}></td>
            <td class="text-left">
                <{if $its.top=='1'}><span class="badge" style="background-color:blue;font-weight:normal;color:white;text-shadow:none;">置頂</span><{/if}>
                <{$its.title}>
            </td>
            <td class="text-center "><{$its.start_date}></td>
            <!-- <td class="text-center"><{$its.end_date}></td> -->
            <td class="text-center "><{$its.hit_count}></td>

            <{if $is_admin}>
            <td class="text-center">
                <a href="<{$xoops_url}>/modules/beck_iscore/index.php?op=announcement_form&sn=<{$its.sn}>" class="btn btn-warning btn-sm mr-2">編輯</a>
                <a href="javascript:ann_del(<{$its.sn}>)" class="btn btn-danger btn-sm">刪除</a>
            </td>
            <{/if}>

        </tr>
    <{/foreach}>
        </tbody>
    </table>
<!-- </div>    -->
<{else}>
    <div class="alert alert-danger row col-12">
        尚無內容
    </div>
<{/if}>

<{$bar}>
<{*
<{if $smarty.session.beck_iscore_adm}>
    <div class="text-center">
        <a href="<{$xoops_url}>/modules/beck_iscore/admin/student.php?op=student_form" class="btn btn-primary">新增學生</a>
    </div>
<{/if}>
*}>

<script type="text/javascript">
    $(document).ready(function($){
        $("#clear").click(function() {
            $('#search').val('');
            $("#ann_class_id option:selected").prop("selected", false)
            $("#dept_id option:selected").prop("selected", false)
        });
    });
</script>

