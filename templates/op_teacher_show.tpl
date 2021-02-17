<h1><{$teachers.sn}></h1>
<h1><{$teachers.tea_name}></h1>
<h1>uid:<{$teachers.uid}></h1>
<{$teachers.cover}>
<{$teachers.files}>


<h1 class="text-center"><{$snews.title}></h1>
 
<p class="text-center"><{$snews.username}></p>
 


<{$snews.content}>
 
<{$snews.cover}>
<{$snews.files}>
 
<{if $smarty.session.snewsAdmin}>
    <div class="text-center">
        <a href="#" class="btn btn-danger">刪除</a>
        <a href="<{$xoops_url}>/modules/snews/admin/main.php?op=snews_form&sn=<{$snews.sn}>" class="btn btn-warning">修改</a>
    </div>
<{/if}>