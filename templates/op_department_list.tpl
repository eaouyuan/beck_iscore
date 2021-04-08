
<div class="container">
    <h2 style="float:left">班級 ─ 列表</h2>

    <button type="button" class="btn btn-primary btn-sm" style="float:right" 
        onclick="self.location.href='school_affairs.php?op=class_form';">
        <img src="http://localhost/modules/system/images/icons/transition/add.png" alt="新增處室"> 新增班級
    </button>


</div>

<{if $all}>
    <table class="table table-bordered">
        <thead class="table-info">
            <tr>
                <th scope="col" class="text-center">編號</th>
                <th scope="col" class="text-center">班級名稱</th>
                <th scope="col" class="text-center">導師</th>
                <th scope="col" class="text-center">班級狀態</th>
                <th scope="col" class="text-center">功能</th>
            </tr>
        </thead>
        <tbody>


        <{foreach from=$all key=i item=its}>
            <tr>    
                <th class="text-center" scope="row"><{$its.no}></th>
                <td class="text-center"><{$its.class_name}></td>
                <td class="text-center"><{$its.tutor_sn}></td>
                <td class="text-center"><{$its.class_status}></td>
                <td class="text-center">
                    <a href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=class_form&sn=<{$its.sn}>" class="btn btn-warning btn-sm mr-2"><i class="fa fa-pencil"></i> 編輯</a>

                    <a href="javascript:cls_del(<{$its.sn}>)" class="btn btn-danger btn-sm "><i class='fa fa-times '>刪除</i></a>


                </td>
            </tr>
        <{/foreach}>

        </tbody>
    </table>   
<{else}>
    <div class="alert alert-danger row col-12">
        尚無內容
    </div>
<{/if}>

<{$bar}>
