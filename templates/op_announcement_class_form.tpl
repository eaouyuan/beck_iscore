<{$formValidator_code}>

<form name="announcement_class_form" id="announcement_class_form" action="index.php" method="post">
    <h3><{$form_title}></h3>

    <div class="form-group row">
        <label for="ann_class_name" class="col-lg-2 col-form-label text-sm-right">公告分類名稱</label>
        <div class="col-lg-10">
            <input class="form-control validate[required] " type="text" name="ann_class_name" title="公告分類名稱" id="ann_class_name" value="<{$ann_class_name}>">
        </div>
    </div>
    <div class="form-group row">
        <label for="enable" class="col-lg-2 col-form-label text-sm-right">啟用</label>
        <div class="col-lg-10"><{$enable_option}></div>
    </div>
    <div class="col-md-12 text-center mb-3">
        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button>
        <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/index.php?op=announcement_class_list">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
    </div>

    <div>
        <input name="uid" id="uid" value="<{$uid}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <{if $sn}> <input name="sn" id="sn" value="<{$sn}>" type="hidden"> <{/if}>
        <{$XOOPS_TOKEN}>
    </div>
</form>




