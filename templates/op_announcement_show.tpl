<link href="css/ann_show.css" rel="stylesheet" type="text/css">

<div class=" article">
    <h3>標題：<{$Ann.title}></h3>
    <hr>

    <div class="row">
        <div class="col-3"><span class="article-meta">發佈處室：<{$Ann.dept_name}></span></div>
        <div class="col-2"><span class="article-meta">建立人：<{$Ann.uname}></span></div>
        <div class="col-3"><span class="article-meta">發佈日期：<{$Ann.update_date}></span></div>
        <div class="col-4"><div class="fontResizer">
            <a class="" style="font-size:16px;border:0;width:5em;cursor:default;">文字大小：</a>
            <a href="javascript:void(0);" class="smallFont">小</a>
            <a href="javascript:void(0);" class="medFont">中</a>
            <a href="javascript:void(0);" class="largeFont">大</a>
        </div>
        </div>
    </div>
    <div class="fontsizebox article-content"><{$Ann.content}></div>

</div>

<!-- 內文文字大小script -->
<script type="text/javascript" src="js/fontsize.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        fontResizer('1rem', '1.4rem', '1.6rem');
    });
</script>


<h3>附件</h3>
    
<div class="col-10"><{$Ann.files}></div>
<div class="text-center mb-3">
    <{if $ann_edit_del}>
    <a href="<{$xoops_url}>/modules/beck_iscore/index.php?op=announcement_form&sn=<{$Ann.sn}>" class="btn btn-warning">
        <i class="fa fa-pencil-square-o mr-2" aria-hidden="true"></i>修改</a>
    <a href="javascript:ann_del(<{$ann.sn}>)" class="btn btn-danger">
        <i class="fa fa-trash-o mr-2" aria-hidden="true"></i>刪除</a>
    <{/if}>
    <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/index.php?op=announcement_list">
        <i class="fa fa-undo mr-2" aria-hidden="true"></i>回列表</a>
</div>


