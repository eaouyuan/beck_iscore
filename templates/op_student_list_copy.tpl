
<div class="">
    <h2>學生列表</h2>
    <div class="row">
        <{foreach from=$all key=i item=students}>
            <div class="col-sm-4">
                <a href="index.php?sn=<{$students.sn}>&op=student_show">
                    <div class="new-article top-shadow bottom-shadow">
                        <{if $students.cover}>
                            <img src="<{$students.cover}>" alt="<{$students.stu_name}>" class="cover img-thumbnail">    
                        <{else}>
                            <img src="https://picsum.photos/200/200?image=<{$i}>" alt="<{$students.stu_sn}>" class="cover img-thumbnail">
                        <{/if}>
                        <div class="latest-post">
                            <h4><{$students.stu_name}></h4>
                        </div>
                        <p>學號：<{$students.stu_sn}></p>
                    </div>    
                </a>
                
            </div>  
            <hr>

        <{foreachelse}>
            <div class="alert alert-danger col-12">
                尚無內容
            </div>
        <{/foreach}>
    </div>
</div>
<{$bar}>
<{*
<{if $smarty.session.beck_iscore_adm}>
    <div class="text-center">
        <a href="<{$xoops_url}>/modules/beck_iscore/admin/student.php?op=student_form" class="btn btn-primary">新增學生</a>
    </div>
<{/if}>
*}>