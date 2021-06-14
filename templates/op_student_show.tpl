<div class="container-fluid">

    <h1>sn:<{$students.sn}></h1>
    <h1>stu_name:<{$students.stu_name}></h1>
    <h1>arrival_date:<{$students.arrival_date}></h1>
    <h1>uid:<{$students.uid}></h1>
    <{$students.cover}>
    <{$students.files}>


    <div class="text-center">
        <{if $student_delete}>
            <a href="javascript:studnet_del(<{$students.sn}>)" class="btn btn-danger">刪除</a>
        <{/if}>
        <{if $student_post}>
            <a href="<{$xoops_url}>/modules/beck_iscore/index.php?op=student_form&sn=<{$students.sn}>" class="btn btn-warning">修改</a>
        <{/if}>
        <a href="<{$xoops_url}>/modules/beck_iscore/html.php?sn=<{$students.sn}>" class="btn btn-success">下載html</a>
        <a href="<{$xoops_url}>/modules/beck_iscore/html.php?op=online&sn=<{$students.sn}>" target="_blank" class="btn btn-success">觀看html</a>
        <a href="https://www.addtoany.com/add_to/printfriendly?linkurl=<{$xoops_url}>%2Fuploads%2Fbeck_iscore%2Fstudent%2Fhtml%2F<{$students.sn}>.html" target="_blank" class="btn btn-primary">下載PDF</a>
    </div>
</div>


