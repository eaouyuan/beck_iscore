<{$formValidator_code}>

<form name="deptpart_school_form" id="deptpart_school_form" action="index.php" method="post">
    <h3><{$form_title}></h3>

    <div class="form-group row">
        <label for="ann_class_name" class="col-lg-2 col-form-label text-sm-right">處室名稱</label>
        <div class="col-lg-10">
            <input class="form-control validate[required] " type="text" name="dept_name" title="處室名稱" id="dept_name" value="<{$dept_name}>">
        </div>
    </div>
    <div class="form-group row">
        <label for="enable" class="col-lg-2 col-form-label text-sm-right">啟用</label>
        <div class="col-lg-10"><{$enable_option}></div>
    </div>
    <div class="col-md-12 text-center mb-3">
        <button class="btn btn-primary" type="submit">儲存</button>
        <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/index.php?op=dept_school_list">取消</a>
    </div>

    <div>
        <input name="uid" id="uid" value="<{$uid}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <{if $sn}> <input name="sn" id="sn" value="<{$sn}>" type="hidden"> <{/if}>
        <{$XOOPS_TOKEN}>
    </div>
</form>




