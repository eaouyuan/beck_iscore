<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>
<{$formValidator_code}>

<form name="teacher_form" id="teacher_form" action="school_affairs.php" method="post" enctype='multipart/form-data'>
    <h3><{$form_title}></h3>

    <div class="form-group row">
        <label for="uname" class="col-lg-2 col-form-label text-sm-right">帳號</label>
        <div class="col-lg-4">
            <input class="form-control validate[required]" type="text" name="uname" id="uname" value="<{$tch.uname}>" readonly>
        </div>
        <label for="name" class="col-lg-2 col-form-label text-sm-right">姓名</label>
        <div class="col-lg-4">
            <input class="form-control validate[required]" type="text" name="name" id="name" value="<{$tch.name}>" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="title" class="col-lg-2 col-form-label text-sm-right">職稱</label>
        <div class="col-lg-4">
            <input class="form-control" type="text" name="title" id="title" value="<{$tch.title}>" readonly>
        </div>
        <label for="sex" class="col-lg-2 col-form-label text-sm-right">性別</label>
        <div class="col-lg-4">
            <select class="custom-select" disabled="disabled" name="sex" readonly style="color: #000000;opacity: 1;">
                <{$tch_sex_htm}>
            </select>
        </div>

    </div>


    <div class="form-group row">
        <label for="email" class="col-lg-2 col-form-label text-sm-right">email</label>
        <div class="col-lg-4">
            <input class="form-control" type="text" name="email" title="email" id="email" value="<{$tch.email}>" readonly>
        </div>

        <label for="dept_id" class="col-lg-2 col-form-label text-sm-right">處室</label>
        <div class="col-lg-4">
            <select class="custom-select" disabled="disabled" style="color: #000000; opacity: 1;" name="dept_id">
                <{$dept_c_sel_htm}>
            </select>
        </div>
    </div>


    <div class="form-group row">
        <label for="phone" class="col-lg-2 col-form-label text-sm-right">分機</label>
        <div class="col-lg-4">
            <input class="form-control" type="text" name="phone" id="phone" value="<{$tch.phone}>" readonly>
        </div>
        <label for="cell_phone" class="col-lg-2 col-form-label text-sm-right">手機</label>
        <div class="col-lg-4">
            <input class="form-control" type="text" name="cell_phone" id="cell_phone" value="<{$tch.cell_phone}>" readonly>
        </div>
    </div>

    <div class="form-group row"></div>

    <div class="col-md-12 text-center mb-3">
        <a href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=teacher_form&sn=<{$sn}>" class="btn btn-warning">
            <i class="fa fa-pencil-square-o mr-2" aria-hidden="true"></i>修改</a>
        <a class="btn btn-secondary" href="javascript:history.back()">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>回上一頁</a>
    </div>

    <div>
        <input name="create_uid" id="create_uid" value="<{$create_uid}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <input name="sn" id="sn" value="<{$sn}>" type="hidden">
        <{$XOOPS_TOKEN}>
    </div>
</form>




