<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>
<{$formValidator_code}>

<form name="semester_form" id="semester_form" action="school_affairs.php" method="post" enctype='multipart/form-data'>
    <h3><{$form_title}></h3>

    <div class="form-group row">
        <label for="year" class="col-lg-2 col-form-label text-sm-right">學年度</label>
    
        <div class="col-lg-4">
            <input class="form-control validate[required] " type="text" name="year" id="year" value="<{$Sems.year}>"<{if $is_new=='0'}>readonly<{/if}>>
        </div>

        <label for="term" class="col-lg-2 col-form-label text-sm-right">學期</label>
        <div class="col-lg-4">
            <{if $is_new=='0'}>
                <input class="form-control" type="text" name="term" id="term" value="<{$Sems.term}>" readonly>
            <{else}>
                <select class="custom-select validate[required]" name="term">
                    <{$Sems.term_htm}>
                </select>
            <{/if}>
        </div>
    </div>

    <div class="form-group row">
        <label for="start_date" class="col-lg-2 col-form-label text-sm-right">開始時間</label>
        <div class="col-lg-4">
            <input class="form-control validate[required]" type="text" name="start_date" id="start_date"  value="<{$Sems.start_date}>"
            onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'<{$start_date}>'})">
        </div>
        <label for="end_date" class="col-lg-2 col-form-label text-sm-right">結束時間</label>
        <div class="col-lg-4">
            <input class="form-control validate[required]" type="text" name="end_date" id="end_date"  value="<{$Sems.end_date}>"
            onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'<{$end_date}>'})">
        </div>
    </div>
    


    <div class="form-group row">
        <label for="activity" class="col-lg-2 col-form-label text-sm-right">現在學年度</label>
        <div class="col-lg-10"><{$Sems.activity}>(其餘學年度則自動設為非現在學年度)</div>
    </div>


    <div class="col-md-12 text-center mb-3">
        <button class="btn btn-primary mr-3" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button>
        <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=semester_list">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
    </div>

    <div>
        <input name="uid" id="uid" value="<{$uid}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <{if $sn}> <input name="sn" id="sn" value="<{$sn}>" type="hidden"> <{/if}>
        <{$XOOPS_TOKEN}>
    </div>
</form>




