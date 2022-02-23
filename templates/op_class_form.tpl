<link href="css/module.css" rel="stylesheet" type="text/css">
<{$formValidator_code}>

<form name="class_form" id="class_form" action="school_affairs.php" method="post" enctype='multipart/form-data'>
    <h3><{$form_title}></h3>

    <div class="form-group row">
        <label for="class_name" class="col-2 col-form-label text-sm-right">班級名稱</label>
        <div class="col-lg-2">
            <input class="form-control validate[required]" type="text" name="class_name" id="class_name" value="<{$class.class_name}>">
        </div>
        <label for="status" class="col-lg-2 col-form-label text-sm-right">班級狀態</label>
        <div class="col-lg-2">
            <select class="custom-select validate[required]" name="status">
                <{$class_st_op_htm}>
            </select>
        </div>
        <label for="status" class="col-lg-2 col-form-label text-sm-right">導師名稱：<{$class.tutor_name}></label>

    </div>

    <div class="form-group row">
        <label for="tutor" class="col-lg-2 col-form-label text-sm-right">導師</label>
        <div class="col-lg-10">
            <{$tchhtm}>
        </div>
 
    </div>

    <div class="form-group row"></div>

    <div class="col-md-12 text-center mb-3">
        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button>
        <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=class_list">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
    </div>

    <div>
        <input name="operator_uid" id="operator_uid" value="<{$operator_uid}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <input name="sn" id="sn" value="<{$sn}>" type="hidden">
        <{$XOOPS_TOKEN}>
    </div>
</form>




