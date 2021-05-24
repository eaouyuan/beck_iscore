<h2 class="mb-3">公告消息 ─ 列表</h2>

<div class="col">
<form name="announcement_list" id="announcement_list" action="index.php" method="get">
    <div class="form-group row">
        <label for="ann_class_id" class="col-1.5 col-form-label text-sm-right px-0">分類：</label>
        <div class="col-1.5 text-center px-0 mr-3">
            <select class="custom-select" name="ann_class_id" id="ann_class_id">
                <{$ann_c_sel_htm}>
            </select>
        </div>

        <label for="dept_id" class="col-1.5 col-form-label text-sm-right px-0">發佈處室：</label>
        <div class="col-1.5 text-left px-0 mr-3">
            <select class="custom-select" name="dept_id" id="dept_id">
                <{$dept_c_sel_htm}>
            </select>
        </div>

        <label class="col-1 col-form-label text-sm-right px-0" for="search">關鍵字</label>
        <div class="mx-sm-3 col-2 text-left px-0">
            <input type="text" class="form-control" id="search" name="search" placeholder="search" value="<{$search}>">
        </div>
        <div>
            <input name="op" id="op" value="<{$op}>" type="hidden">
        </div>
        <button type="submit"            class="btn btn-outline-primary col-0.5 mb-3 mr-3">搜尋</button>
        <button type="button" id="clear" class="btn btn-outline-dark col-0.5 mb-3 mr-3">清空</button>
        <{if $show_add_button=='1'}>
        <div class="ml-auto">
            <button type="button" class="btn btn-primary btn-sm mb-2" onclick="self.location.href='index.php?op=announcement_form';">
            <img src="http://localhost/modules/system/images/icons/transition/add.png" alt="新增公告">新增公告
            </button>
        </div>
        <{/if}>
    </div>

</form>
</div>
<!-- <{if $show_add_button=='0'}></div><{/if}> -->



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
            <th class="text-center clickable-row" data-href="<{$xoops_url}>/modules/beck_iscore/index.php?op=announcement_show&sn=<{$its.sn}>"scope="row"><{$its.sn}></th>
            <td class="text-center clickable-row" data-href="<{$xoops_url}>/modules/beck_iscore/index.php?op=announcement_show&sn=<{$its.sn}>"><{$its.ann_class_id}></td>
            <td class="text-center clickable-row" data-href="<{$xoops_url}>/modules/beck_iscore/index.php?op=announcement_show&sn=<{$its.sn}>"><{$its.dept_id}></td>
            <td width="40%" class="text-left clickable-row" data-href="<{$xoops_url}>/modules/beck_iscore/index.php?op=announcement_show&sn=<{$its.sn}>">
                <{if $its.top=='1'}><span class="badge" style="background-color:blue;font-weight:normal;color:white;text-shadow:none;">置頂</span><{/if}>
                <{$its.title}>
            </td>
            <td class="text-center clickable-row" data-href="<{$xoops_url}>/modules/beck_iscore/index.php?op=announcement_show&sn=<{$its.sn}>"><{$its.start_date}></td>
            <!-- <td class="text-center"><{$its.end_date}></td> -->
            <td class="text-center clickable-row" data-href="<{$xoops_url}>/modules/beck_iscore/index.php?op=announcement_show&sn=<{$its.sn}>"><{$its.hit_count}></td>

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
    <div class="alert alert-danger">
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
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
        $("#clear").click(function() {
            $('#search').val('');
            $("#ann_class_id option:selected").prop("selected", false)
            $("#dept_id option:selected").prop("selected", false)
        });
    });
</script>

<style type="text/css">
    [data-href] { cursor: pointer; }
</style>