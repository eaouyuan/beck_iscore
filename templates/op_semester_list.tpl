
<div class="col">
    <h2 style="float:left" class="mb-3">學年度 ─ 列表</h2>
    <button type="button" class="btn btn-primary btn-sm mb-3" 
    onclick="self.location.href='school_affairs.php?op=semester_form';"style="float:right">
    <img src="<{$xoops_url}>/modules/system/images/icons/transition/add.png" alt="新增學年度"> <span class="vertical-align:middle">新增學年度</span>
    </button>
</div>


<{if $all}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead class="table-info">
            <tr>
                <th scope="col" class="text-center">編號</th>
                <th scope="col" class="text-center">學年度</th>
                <th scope="col" class="text-center">學期</th>
                <th scope="col" class="text-center">開始時間</th>
                <th scope="col" class="text-center">結束時間</th>
                <th scope="col" class="text-center">目前年度</th>
                <th scope="col" class="text-center">編輯</th>
            </tr>
        </thead>
        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr> 
            <th class="text-center" scope="row"><{$its.sn}></th>
            <td class="text-center"><{$its.year}></td>
            <td class="text-center"><{$its.term}></td>
            <td class="text-center"><{$its.start_date}></td>
            <td class="text-center"><{$its.end_date}></td>
            <td class="text-center">
                <{if $its.activity=='1'}><i class="fa fa-check" aria-hidden="true"></i><{/if}></td>
            <td class="text-center">
                <a href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=semester_form&sn=<{$its.sn}>" class="btn btn-warning btn-sm mr-2">編輯</a>
                <a href="javascript:sems_del(<{$its.sn}>)" class="btn btn-danger btn-sm">刪除</a>
            </td>
        

        </tr>
    <{/foreach}>
        </tbody>
    </table>
<{else}>
    <div class="alert alert-danger">
        尚無內容
    </div>
<{/if}>
