<h2 class="mb-3">學期總成績 ─ 列表</h2>

<form name="course_list" id="course_list" action="tchstu_mag.php" method="post">
    <div class="col">
        <div class="form-group row">
            <label for="cos_year" class="col-0.5 col-form-label px-0">學年度：</label>
            <div class="col-1 text-left px-0 mr-3">
                <select class="custom-select" name="cos_year" id="cos_year">
                    <{$sems_year_htm}>
                </select>
            </div>
            <label for="cos_term" class="col-0.5 col-form-label text-center px-0">學期：</label>
            <div class="col-1 text-left px-0 mr-3">
                <select class="custom-select" name="cos_term" id="cos_term">
                    <{$sems_term_htm}>
                </select>
            </div>
            <label for="dep_id" class="col-1.5 col-form-label text-sm-right px-0">學程名稱：</label>
            <div class="col-2 text-left px-0 mr-3">
                <select class="custom-select" name="dep_id" id="dep_id">
                    <{$major_htm}>
                </select>
            </div>

            <div class="ml-auto row">
                <{if $show_ac}><button type="button" id="re_clu" class="btn btn-outline-primary col-0.5 mb-2 mr-3">重新計算</button><{/if}>
                <input name="op" id="op" value="<{$op}>" type="hidden">
                <button type="button" id="clear" class="btn btn-outline-dark col-0.5 mb-2 mr-3">清空</button>
                <button type="button" id="ac_smes" class="btn btn btn-success col-0.5 mb-2 mr-3">目前學期</button>
            </div>


        </div>
    </div> 

</form>




<{if $all}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead class="table-info">
            <tr>
                <th scope="col" class="text-center">編號</th>
                <th scope="col" class="text-center">學年度/學期</th>
                <th scope="col" class="text-center">學程</th>
                <th scope="col" class="text-center">課程名稱</th>
                <th scope="col" class="text-center">教師</th>
                <th scope="col" class="text-center">課程群組</th>
                <th scope="col" class="text-center">學分</th>
                <th scope="col" class="text-center">段考一</th>
                <th scope="col" class="text-center">段考二</th>
                <{if $can_edit}>
                <th scope="col" class="text-center">功能</th>
                <{/if}>

            </tr>
        </thead>
        <tbody id="sort">
    <{foreach from=$all key=i item=its}>
        <tr id="odr_<{$its.sn}>"> 
            <th class="text-center"><{$its.i}></th>
            <th class="text-center"><{$its.year_term}></th>
            <td class="text-center"><{$its.dep_name}></td>
            <td class="text-center"><{$its.cos_name}></td>
            <td class="text-center"><{$its.teacher_name}></td>
            <td class="text-center"><{$its.cos_name_grp}></td>
            <td class="text-center"><{$its.cos_credits}></td>
            <{if $can_edit}>
            <td class="text-center"><div class="custom-control custom-switch"><{$its.first_chk}></div></td>
            <td class="text-center"><div class="custom-control custom-switch"><{$its.second_chk}></div></td>
            <td class="text-center">
                <a href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=course_form&sn=<{$its.sn}>" class="btn btn-warning btn-sm mr-2">編輯</a>
                <a href="javascript:cos_del(<{$its.sn}>)" class="btn btn-danger btn-sm">刪除</a>
            </td>
            <{else}>
            <td class="text-center"><{$its.f_icon}></td>
            <td class="text-center"><{$its.s_icon}></td>
            <{/if}>

        </tr>
    <{/foreach}>
        </tbody>
    </table>
    <div>
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <input name="year" id="year" value="<{$sscore.year}>" type="hidden">
        <input name="term" id="term" value="<{$sscore.term}>" type="hidden">
        <input name="update_user" id="update_user" value="<{$uid}>" type="hidden">
        <{$XOOPS_TOKEN}>
    </div>

    <div class="col-md-12 text-center mb-3">
        <button class="btn btn-primary" type="button" onclick="check_num()"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button>
        <!-- <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button> -->
        <a class="btn btn-secondary" href="javascript:history.back()">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
        <button type="button" class="btn btn-success" id="print_web"><i class="fa fa-print  mr-2" aria-hidden="true"></i>列印</button>
    </div>
<{else}>
    <div class="alert alert-danger">
        尚無內容
    </div>
<{/if}>
<h4 class="mb-3 text-center">------ 學分數總計:<{$credit_sun}> -----</h4>

<{$bar}>

<script type="text/javascript">
    $(document).ready(function($){
        $("#clear").click(function() {
            $('#cos_year').val('');
            $('#cos_term').val('');
            $('#dep_id').val('');
            r=get_pars();
            location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=term_total_score_list';
        });
        $("#ac_smes").click(function() {
            $('#cos_year').val('<{$sem_year}>');
            $('#cos_term').val('<{$sem_term}>');
            $('#dep_id').val('');
            r=get_pars();
            location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=term_total_score_list&cos_year='+r.year+'&cos_term='+r.term;
        });
        $("#re_clu").click(function() {
            r=get_pars();
            location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=term_total_score_list&cos_year='+r.year+'&cos_term='+r.term+'&dep_id='+r.dep+'&ac=calculate';
        });
        $('#cos_year , #cos_term , #dep_id').change(function(e){
            r=get_pars();
            location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=term_total_score_list&cos_year='+r.year+'&cos_term='+r.term+'&dep_id='+r.dep;
        });

    });
    function get_pars(){
        let re=[];
        re['year']=$('#cos_year').val();
        re['term']=$('#cos_term').val();
        re['dep']=$('#dep_id').val();
        return re;
    }



</script>

<style type="text/css">
    [data-href] { cursor: pointer; }
</style>