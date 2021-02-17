<h1>sn:<{$students.sn}></h1>
<h1>stu_name:<{$students.stu_name}></h1>
<h1>arrival_date:<{$students.arrival_date}></h1>
<h1>uid:<{$students.uid}></h1>
<{$students.cover}>
<{$students.files}>



<{if $smarty.session.beck_iscore_adm}>
    <div class="text-center">
        <a href="javascript:studnet_del(<{$students.sn}>)" class="btn btn-danger">刪除</a>
        <a href="<{$xoops_url}>/modules/beck_iscore/index.php?op=student_form&sn=<{$students.sn}>" class="btn btn-warning">修改</a>
    </div>
<{/if}>
