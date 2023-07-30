<{$formValidator_code}>

<form name="department_form" id="class_form" action="school_affairs.php" method="post" enctype='multipart/form-data'>
    <h3><{$form_title}></h3>

    <div class="form-group row">
        <label for="dep_name" class="col-2 col-form-label text-sm-right">學程名稱</label>
        <div class="col-lg-4">
            <input class="form-control validate[required]" type="text" name="dep_name" id="dep_name" value="<{$department.dep_name}>">
        </div>
        <label for="dep_status" class="col-lg-2 col-form-label text-sm-right">學程狀態</label>
        <div class="col-lg-4">
            <select class="custom-select validate[required]" name="dep_status">
                <{$department_st_op_htm}>
            </select>

        </div>
    </div>
    <div class="form-group row">
        <label for="dep_name" class="col-2 col-form-label text-sm-right">平時考佔比</label>
        <div class="col-lg-4">
            <input class="form-control validate[required]" type="text" name="normal_exam" id="normal_exam" value="<{$department.normal_exam}>">
        </div>
        <label for="dep_status" class="col-lg-2 col-form-label text-sm-right">段考佔比</label>
        <div class="col-lg-4">
            <input class="form-control validate[required]" type="text" name="section_exam" id="section_exam" value="<{$department.section_exam}>">
        </div>
    </div>

    <div class="form-group row"></div>

    <div class="col-md-12 text-center mb-3">
        <!-- <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button> -->
        <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=department_list">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
    </div>

    <div>
        <input name="operator_uid" id="operator_uid" value="<{$operator_uid}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <input name="sn" id="sn" value="<{$sn}>" type="hidden">
        <{$XOOPS_TOKEN}>
    </div>
</form>




