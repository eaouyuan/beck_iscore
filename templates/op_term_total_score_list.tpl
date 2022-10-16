<h2 class="mb-3 notprint">學期總成績 ─ 列表</h2>

<form name="term_total_score_list" id="term_total_score_list" action="tchstu_mag.php" method="post">
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
                <!-- <{if $show_ac}><button type="button" id="re_clu" class="btn btn-outline-primary col-0.5 mb-2 mr-3">重新計算</button><{/if}> -->
                <input name="op" id="op" value="<{$op}>" type="hidden">
                <button type="button" class="btn btn-success col-0.5 mb-2 mr-3" id="print_web"><i class="fa fa-print  mr-2" aria-hidden="true"></i>列印</button>
                <button type="button" id="clear" class="btn btn-outline-dark col-0.5 mb-2 mr-3">清空</button>
                <button type="button" id="ac_smes" class="btn btn btn-success col-0.5 mb-2 mr-3">目前學期</button>
            </div>


        </div>

    </div> 
<{if $all}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead class="table-info">
            <tr>
                <th width="2%" rowspan="2" class="text-center">序號</th>
                <th width="2%" rowspan="2" class="text-center">班級</th>
                <th width="6%"             class="text-center">姓名</th>
                <{foreach from=$course_groupname.grpname_sumcred key=grp_name item=sumcred}>
                    <th width="2%" class="text-center"><{$grp_name}></th>
                <{/foreach}>
                <th width="2%"             class="text-center">修得學分</th>
                <th width="2%" rowspan="2" class="text-center">總分</th>
                <th width="2%" rowspan="2" class="text-center">平均</th>
                <th width="10%" rowspan="2" class="text-center">獎勵方式</th>
                <th width="8%" rowspan="2" class="text-center">列印成績單</th>
            </tr>
            <tr>
                <th scope="col" class="text-center">學分</th>
                <{foreach from=$course_groupname.grpname_sumcred key=grp_name item=sumcred}>
                    <th class="text-center"><{$sumcred}></th>
                <{/foreach}>
                <th class="text-center"><{$course_groupname.total_cred}></th>
            </tr>
        </thead>


        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr> 
            <th class="text-center"><{$its.order}></th>
            <th class="text-center"><{$its.class_name}></th>
            <th class="text-center"><{$its.stu_anonymous}></th>
            <{foreach from=$its.scores key=grpname item=course_total_avg}>
                <{if $course_total_avg<60 and $course_total_avg!='-'}><th class="text-center text-danger"><{$course_total_avg}></th>
                <{else}><th class="text-center"><{$course_total_avg}></th><{/if}>
            <{/foreach}>
            <td class="text-center"><{$its.sum_credits}></td>
            <td class="text-center"><{$its.total_score}></td>
            <td class="text-center"><{$its.total_avg}></td>
            <td class="text-center"><{$its.reward_method}></td>
            <td class="text-center">
                <a target="_blank" href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=transcript&cos_year=<{$pars.cos_year}>&cos_term=<{$pars.cos_term}>&dep_id=<{$pars.dep_id}>&sn=<{$i}>" class="btn btn-success btn-sm mr-2"><i class="fa fa-print  mr-2" aria-hidden="true"></i>列印</a>
            </td>
            <!-- <td class="text-center"><{$its.comment}></td> -->
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
        <!-- <button class="btn btn-primary" type="button" onclick="check_num()"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button> -->
        <!-- <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button> -->
        <a class="btn btn-secondary"href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=term_total_score_list&cos_year=<{$pars.cos_year}>&cos_term=<{$pars.cos_term}>">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>回上一頁</a>
    </div>
<{else}>
    <div class="alert alert-danger">
        尚無內容
    </div>
<{/if}>
</form>
<div id="printArea">
    <h2 class="text-center"> <{$pars.cos_year}> 學年度 第<{$pars.cos_term}>學期 <{$pars.dep_name}> 學期總成績 </h2>
    <table>
        <thead>
            <tr>
                <th width="2%" rowspan="2" class="text-center">序號</th>
                <th width="2%" rowspan="2" class="text-center">班級</th>
                <th width="6%"             class="text-center">姓名</th>
                <{foreach from=$course_groupname.grpname_sumcred key=grp_name item=sumcred}>
                    <th width="2%" class="text-center"><{$grp_name}></th>
                <{/foreach}>
                <th width="2%"             class="text-center">修得學分</th>
                <th width="2%" rowspan="2" class="text-center">總分</th>
                <th width="2%" rowspan="2" class="text-center">平均</th>
                <th width="10%" rowspan="2" class="text-center">獎勵方式</th>
            </tr>
            <tr>
                <th scope="col" class="text-center">學分</th>
                <{foreach from=$course_groupname.grpname_sumcred key=grp_name item=sumcred}>
                    <th class="text-center"><{$sumcred}></th>
                <{/foreach}>
                <th class="text-center"><{$course_groupname.total_cred}></th>
            </tr>
        </thead>


        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr> 
            <th class="text-center"><{$its.order}></th>
            <th class="text-center"><{$its.class_name}></th>
            <th class="text-center"><{$its.stu_anonymous}></th>
            <{foreach from=$its.scores key=grpname item=course_total_avg}>
                <{if $course_total_avg<60 and $course_total_avg!='-'}><th><{$course_total_avg}></th>
                <{else}><th class="text-center"><{$course_total_avg}></th><{/if}>
            <{/foreach}>
            <th class="text-center"><{$its.sum_credits}></td>
            <th class="text-center"><{$its.total_score}></td>
            <th class="text-center"><{$its.total_avg}></td>
            <th class="text-center"><{$its.reward_method}></td>
        </tr>
    <{/foreach}>
        </tbody>
    </table>

</div>
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
        $('#cos_year').change(function(e){
            $('#cos_term').val('');
            $('#dep_id').val('');
        });
        $('#cos_term').change(function(e){
            $('#dep_id').val('');
        });
        $('#cos_year , #cos_term , #dep_id').change(function(e){
            r=get_pars();
            location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=term_total_score_list&cos_year='+r.year+'&cos_term='+r.term+'&dep_id='+r.dep;
        });
        $("#print_web").click(function(){
            onprint();
            return false;
        })

    });
    function get_pars(){
        let re=[];
        re['year']=$('#cos_year').val();
        re['term']=$('#cos_term').val();
        re['dep']=$('#dep_id').val();
        return re;
    }

    function onprint() {
        window.print();
        return false;
    }


</script>

<style type="text/css">


@media screen 
{
    table th, .table th ,.table td, table.table-bordered > thead > tr > th{
        vertical-align:middle;
        text-align:center;
        border: 2px solid #000000;
        /* line-height:2.5em; */
        /* width:auto; */
        /* border-bottom: 2px solid #000000; */
    }

    input , select{
        /* width:auto; */
        position: relative;
        vertical-align:middle;
        text-align:center;
    }
    [data-href] { cursor: pointer; }
}

@page
{
    size:A4;
    margin:10mm;
    size: landscape; 
}


@media print 
{

    #printArea { 
        font-size: 10px;
    }
    table th, th, td {
    /* table,table th,table td,th,td{ */
        vertical-align:middle;
        text-align:center;
        border: 1px solid black;
    }   


}



    
</style>

<style type="text/css" media="screen">
    /* 顯示時隱藏 */
    #printArea { display: none; }
    /* #term_total_score_list,.notprint,#footer-container,#nav-container-sticky-wrapper { display: none; } */

</style>
<style type="text/css" media="print">
    /* 列印時隱藏 */
    #term_total_score_list,.notprint,#footer-container,#nav-container-sticky-wrapper { display: none; }
</style>