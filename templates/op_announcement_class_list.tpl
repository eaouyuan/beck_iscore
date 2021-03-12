
<div class="container">
    <h2 style="float:left">公告分類 ─ 列表</h2>
   
        <button type="button" class="btn btn-primary btn-sm" style="float:right" 
            onclick="self.location.href='index.php?op=announcement_class_form';">
            <img src="http://localhost/modules/system/images/icons/transition/add.png" alt="新增分類"> 新增分類
        </button>


</div>

<{if $all}>
<table class="table table-bordered">
    <thead class="table-info">
        <tr>
            <th scope="col">編號</th>
            <th scope="col">公告分類名稱</th>
            <th scope="col">啟用</th>
            <th scope="col">建立日期</th>
            <th scope="col">最近修改日期</th>
            <th scope="col">編輯</th>
        </tr>
    </thead>
    <tbody>
<{/if}>

<{foreach from=$all key=i item=its}>
    <tr>    
        <th scope="row"><{$its.sn}></th>
        <td><{$its.ann_class_name}></td>
        <td><{$its.enable}></td>
        <td><{$its.create_time}></td>
        <td><{$its.update_time}></td>
        <td>
            <a href="<{$xoops_url}>/modules/beck_iscore/index.php?op=announcement_class_form&sn=<{$its.sn}>" class="btn btn-warning btn-sm "><i class="fa fa-pencil"></i> 編輯</a>

            <a href="javascript:announcement_class_del(<{$its.sn}>)" class="btn btn-danger btn-sm"><i class='fa fa-times'>刪除</i></a>


        </td>
    </tr>
<{/foreach}>

<{if $all}>

    </tbody>
    </table>   
<{else}>
    <div class="alert alert-danger col-12">
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