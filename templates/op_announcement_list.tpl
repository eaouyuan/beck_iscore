
<div class="container">
    <h2 style="float:left">公告消息 ─ 列表</h2>
   
        <button type="button" class="btn btn-primary btn-sm" style="float:right" 
            onclick="self.location.href='index.php?op=announcement_class_form';">
            <img src="http://localhost/modules/system/images/icons/transition/add.png" alt="新增分類"> 新增分類
        </button>


</div>
<!-- <div class=""> -->
<{if $all}>
    <table class="table table-bordered table-sm table-hover">
        <thead class="table-info">
            <tr>
                <th scope="col" class="text-center">編號 　</th>
                <th scope="col" class="text-center">table-sm公告分類名稱</th>
                <th scope="col" class="text-center">啟用</th>
                <th scope="col" class="text-center">建立日期</th>
                <th scope="col" class="text-center">最近修改日期</th>
                <th scope="col" class="text-center">編輯</th>
            </tr>
        </thead>
        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr>    
            <th class="text-center" scope="row"><{$its.sn}></th>
            <td class="text-center"><{$its.ann_class_name}></td>
            <td class="text-center"><{$its.enable}></td>
            <td class="text-center"><{$its.create_time}></td>
            <td class="text-center"><{$its.update_time}></td>
            <td class="text-center">
                <a href="<{$xoops_url}>/modules/beck_iscore/index.php?op=announcement_class_form&sn=<{$its.sn}>" class="btn btn-warning btn-sm mr-2"><i class="fa fa-pencil"></i> 編輯</a>

                <a href="javascript:announcement_class_del(<{$its.sn}>)" class="btn btn-danger btn-sm "><i class='fa fa-times '>刪除</i></a>


            </td>
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