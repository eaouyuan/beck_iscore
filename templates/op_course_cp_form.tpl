<{$formValidator_code}>
<form name="course_cp_form" id="course_cp_form" action="school_affairs.php" method="get">
    <h2 class="mb-3">全學期課程複製</h2>
    <br>
    <div class="col">
        <div class="form-group row">
            <label for="syear" class="col-form-label">來源學年度：</label>
            <div class="col-1 text-left">
                <select class="custom-select validate[required]" name="syear" id="syear">
                    <{$dropmenu.syear}>
                </select>
            </div>
            <label for="sterm" class="col-form-label text-center ">來源學期：</label>
            <div class="col-1 text-left mr-3">
                <select class="custom-select validate[required]" name="sterm" id="sterm">
                    <{$dropmenu.sterm}>
                </select>
            </div>

            <button type="button" class="btn btn-secondary col-2 mr-3 nonpointer">複製到 <i class="fa fa-arrow-right" aria-hidden="true"></i></button>

            <label for="dyear" class="col-form-label">目的學年度：</label>
            <div class="col-1 text-left">
                <select class="custom-select" name="dyear" id="dyear">
                    <{$dropmenu.dyear}>
                </select>
            </div>
            <label for="dterm" class="col-form-label text-center">目的學期：</label>
            <div class="col-1 text-left mr-3">
                <select class="custom-select" name="dterm" id="dterm">
                    <{$dropmenu.dterm}>
                </select>
            </div>
            <input name="op" id="op" value="<{$op}>" type="hidden">
            <input name="update_user" id="update_user" value="<{$uid}>" type="hidden">
            <{$XOOPS_TOKEN}>
            <{if $show_submit_btn=='1'}>
                <button type="submit" class="btn btn-primary col-1">確定</button>
            <{/if}>

        </div>
    </div>
<br>
</form>
<{if $show_submit_btn=='0'}>
    <div class="alert alert-danger" role="alert">
        錯誤!！ 目的學年度、學期，已有學生「成績資料」，故無法複製整學期課程！！
    </div>
<{/if}>

<script type="text/javascript">
    $(document).ready(function($){
        $('#syear').change(function(e){
            $('#sterm').val('');
        });
        $('#dyear').change(function(e){
            $('#dterm').val('');
        });
        $('#syear , #sterm , #dyear ,#dterm').change(function(e){
            r=get_pars();
            location.href='<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=course_cp_form&syear='+r.syear+'&sterm='+r.sterm+'&dyear='+r.dyear+'&dterm='+r.dterm;
        });
    });
    function get_pars(){
        let re=[];
        re['syear']=$('#syear').val();
        re['sterm']=$('#sterm').val();
        re['dyear']=$('#dyear').val();
        re['dterm']=$('#dterm').val();
        return re;
    }
    
</script>

<style type="text/css">
    .nonpointer{
        pointer-events: none;
    }
</style>