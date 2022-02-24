<{$formValidator_code}>

<form name="announcement_form" id="announcement_form" action="index.php" method="post" enctype='multipart/form-data'>
    <h3><{$form_title}></h3>

    <div class="form-group row">
        <label for="ann_class_id" class="col-lg-2 col-form-label text-sm-right">分類</label>
        <div class="col-lg-4">
            <select class="custom-select validate[required]" name="ann_class_id">
                <{$ann_c_sel_htm}>
            </select>
        </div>

        <label for="dept_id" class="col-lg-2 col-form-label text-sm-right">發佈處室</label>
        <div class="col-lg-4">
            <label class="form-control"><{$Ann.dept_name}></label>
        </div>
    </div>



    <div class="form-group row">
        <label for="ann_class_name" class="col-lg-2 col-form-label text-sm-right">標題</label>
        <div class="col-lg-10">
            <input class="form-control validate[required] " type="text" name="title" title="標題" id="title" value="<{$Ann.title}>">
        </div>
    </div>
    <div class="form-group row">
        <label for="ann_class_name" class="col-lg-2 col-form-label text-sm-right">內容</label>
        <div class="col-lg-10">
            <{$content}>
        </div>
    </div>
    <div class="form-group row">
        <label for="ann_class_name" class="col-lg-2 col-form-label text-sm-right">公告到期日</label>
        <div class="col-lg-10">
            <input class="form-control" type="text" name="end_date" id="end_date"  value="<{$end_date}>">
        </div>
    </div>

    <div class="form-group row">
        <label for="enable" class="col-lg-2 col-form-label text-sm-right">置頂</label>
        <div class="col-lg-10"><{$top_option}></div>
    </div>

    <!-- 上傳附檔 -->
    <div class="form-group row">
        <label for="enable" class="col-lg-2 col-form-label text-sm-right">上傳附檔</label>
        <div class="col-lg-10"><{$upform}></div>
    </div>

    <div class="col-md-12 text-center mb-3">
        <!-- <button class="btn btn-primary" type="submit" style="display:none;"></button> -->
        <button class="btn btn-success" id="upload_files" type="button"><i class="fa fa-file" aria-hidden="true"></i> 上傳附檔</button>
        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button>

        <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/index.php?op=announcement_list">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
    </div>

    <div>
        <input name="uid" id="uid" value="<{$uid}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <input name="fileup" id="fileup" value="0" type="hidden">
        <input name="dept_id" id="dept_id" value="<{$Ann.dept_id}>" type="hidden">
        <{if $sn}> <input name="sn" id="sn" value="<{$sn}>" type="hidden"> <{/if}>
        <{$XOOPS_TOKEN}>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function($){
        $("#upload_files").click(function() {
            let fileup=$('#fileup').val("1");
            document.forms["announcement_form"].submit();
        });
        $('#end_date').datetimepicker({
            format: 'L', // date
            // format: 'LT', //time
            locale: 'zh-tw',
            // stepping: 5,
        });
    });
    function onprint() {
        window.print();
        return false;
    }
</script>


