<div class="col">
    <h2 style="float:left">學程 ─ 列表</h2>

    <button type="button" class="btn btn-primary btn-sm" style="float:right" 
        onclick="self.location.href='school_affairs.php?op=department_form';">
        <img src="http://localhost/modules/system/images/icons/transition/add.png" alt="新增學程"> 新增學程
    </button>


</div>

<{if $all}>
    <table class="table table-bordered">
        <thead class="table-info">
            <tr>
                <th scope="col" class="text-center">編號</th>
                <th scope="col" class="text-center">學程名稱</th>
                <th scope="col" class="text-center">平時考佔比</th>
                <th scope="col" class="text-center">段考佔比</th>
                <th scope="col" class="text-center">學程狀態</th>
                <th scope="col" class="text-center">功能</th>
            </tr>
        </thead>
        <tbody>


        <{foreach from=$all key=i item=its}>
            <tr>    
                <th class="text-center" scope="row"><{$its.no}></th>
                <td class="text-center"><{$its.dep_name}></td>
                <td class="text-center"><{$its.normal_exam}></td>
                <td class="text-center"><{$its.section_exam}></td>
                <td class="text-center"><{$its.dep_status}></td>
                <td class="text-center">
                    <a href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=department_form&sn=<{$its.sn}>" class="btn btn-warning btn-sm mr-2"><i class="fa fa-pencil"></i> 編輯</a>

                    <a href="javascript:dept_del(<{$its.sn}>)" class="btn btn-danger btn-sm "><i class='fa fa-times '>刪除</i></a>


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

<{$bar}>
