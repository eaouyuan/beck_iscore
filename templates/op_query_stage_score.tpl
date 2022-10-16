<{$formValidator_code}>
<form name="query_stage_score" id="query_stage_score" action="tchstu_mag.php" method="post">
    <h2 class="mb-3">考科成績查詢</h2>
    <div class="col">
        <div class="form-group row">
            <label for="dep_id" class="col-1.5 col-form-label text-sm-right px-0">學程名稱：</label>
            <div class="col-2 text-left px-0 mr-3">
                <select class="custom-select validate[required]" name="dep_id" id="dep_id">
                    <{$course.major_htm}>
                </select>
            </div>
            <label for="dep_id" class="col-1.5 col-form-label text-sm-right px-0">段考名稱：</label>
            <div class="col-2 text-left px-0 mr-3">
                <select class="custom-select validate[required]" name="exam_stage" id="exam_stage">
                    <{$course.exam_number_htm}>
                </select>
            </div>
            <{if $showtable}>
                <button type="button" class="btn btn-success" id="print_web"><i class="fa fa-print" aria-hidden="true"></i>列印</button>
            <{/if}>
        </div>
    </div>
<{if $showtable}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead>
            <tr class="table-info">
                <th scope="col" class="text-center">項次</th>
                <th scope="col" class="text-center">班級</th>
                <th scope="col" class="text-center">姓名</th>
                <{foreach from=$dep_exam_course key=k item=v}>
                    <th scope="col" class="text-center"><{$v}></th>
                <{/foreach}>
                <th scope="col" class="text-center">總分</th>
                <th scope="col" class="text-center">平均</th>
                <{if $pars.exam_stage=='4'}>
                <th scope="col" class="text-center">第一次段考</th>
                <th scope="col" class="text-center">進步分</th>
                <{/if}>
                <{if $pars.exam_stage!='6'}>
                <th scope="col" class="text-center">獎勵方式</th>
                <{/if}>
                <th scope="col" class="text-center">備註</th>
            </tr>
        </thead>
        <tbody>
            <{foreach from=$all key=stu_sn item=v1}>
            <tr> 
                <th class="text-center" width="3%"><{$v1.order}></th>
                <th class="text-center" width="4%"><{$v1.class_name}></th>
                <th class="text-center" width="5%"><{$v1.stu_anonymous}></th>
                <{foreach from=$v1.scores key=course_id item=vscore}>
                    <th class="text-center" width="3%"><{$vscore}></th>
                <{/foreach}>
                <th class="text-center" width="3%" name="qscore_sum[<{$stu_sn}>]"><{$v1.sum}></th>
                <th class="text-center" width="3%" name="qscore_avg[<{$stu_sn}>]"><{$v1.avg}></th>
                <{if $pars.exam_stage=='4'}>
                <th class="text-center" width="4%" name="frist_exam_score[<{$stu_sn}>]"><{$v1.frist_exam_score}></th>
                <th class="text-center" width="4%" name="progress_score[<{$stu_sn}>]"><{$v1.progress_score}></th>
                <{/if}>
                <{if $pars.exam_stage!='6'}>
                <th class="text-left" width="12%" name="reward_method[<{$stu_sn}>]"><{$v1.reward_method}></th>
                <{/if}>
                <{if $ps_edit}>
                    <th class="text-center" width="12%"><input type="text" class="form-control" name="comment[<{$stu_sn}>]" value="<{$v1.comment}>"></th>
                <{else}>
                    <th class="text-center" width="12%" name="comment[<{$stu_sn}>]"><{$v1.comment}></th>
                <{/if}>
            </tr>
            <{/foreach}>
        </tbody>
    </table>
    <br>
    <div class="col-md-12 text-center mb-3">
        <{if $ps_edit}>
            <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>修改備註</button>
        <{/if}>
        <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=query_stage_score&dep_id=<{$course.dep_id}>"><i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
    </div>

    <input name="op" id="op" value="<{$op}>" type="hidden">
    <input name="update_user" id="update_user" value="<{$uid}>" type="hidden">
    <input name="year" id="year" value="<{$course.year}>" type="hidden">
    <input name="term" id="term" value="<{$course.term}>" type="hidden">
    <{$XOOPS_TOKEN}>
</form>
<{else}>
    <div class="alert alert-danger">
        尚無內容
    </div>
<{/if}>
<div id="printArea">
    <h2 class="text-center"> <{$course.year}> 學年度 第<{$course.term}>學期  <{$course.dep_name}> <{$course.stage_exam_name}> 成績表 </h2>
    <table>
        <thead>
            <tr>
                <th scope="col" class="text-center">項次</th>
                <th scope="col" class="text-center">班級</th>
                <th scope="col" class="text-center">姓名</th>
                <{foreach from=$dep_exam_course key=k item=v}>
                    <th scope="col" class="text-center"><{$v}></th>
                <{/foreach}>
                <th scope="col" class="text-center">總分</th>
                <th scope="col" class="text-center">平均</th>
                <{if $pars.exam_stage=='4'}>
                <th scope="col" class="text-center">第一次段考</th>
                <th scope="col" class="text-center">進步分</th>
                <{/if}>
                <{if $pars.exam_stage!='6'}>
                <th scope="col" class="text-center">獎勵方式</th>
                <{/if}>
            </tr>
        </thead>
        <tbody>
            <{foreach from=$all key=stu_sn item=v1}>
            <tr> 
                <th class="text-center" width="3%"><{$v1.order}></th>
                <th class="text-center" width="4%"><{$v1.class_name}></th>
                <th class="text-center" width="5%"><{$v1.stu_anonymous}></th>
                <{foreach from=$v1.scores key=course_id item=vscore}>
                    <th class="text-center" width="3%"><{$vscore}></th>
                <{/foreach}>
                <th class="text-center" width="3%" name="qscore_sum[<{$stu_sn}>]"><{$v1.sum}></th>
                <th class="text-center" width="3%" name="qscore_avg[<{$stu_sn}>]"><{$v1.avg}></th>
                <{if $pars.exam_stage=='4'}>
                <th class="text-center" width="4%" name="frist_exam_score[<{$stu_sn}>]"><{$v1.frist_exam_score}></th>
                <th class="text-center" width="4%" name="progress_score[<{$stu_sn}>]"><{$v1.progress_score}></th>
                <{/if}>
                <{if $pars.exam_stage!='6'}>
                <th class="text-left" width="12%" name="reward_method[<{$stu_sn}>]"><{$v1.reward_method}></th>
                <{/if}>
            </tr>
            <{/foreach}>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function($){
        $('#dep_id').change(function(e){
            $('#exam_stage').val('');
            let dep_id=$('#dep_id').val();
            location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=query_stage_score&dep_id='+dep_id;
        });
        $('#exam_stage').change(function(e){
            let dep_id=$('#dep_id').val();
            let exam_stage=$('#exam_stage').val();
            location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=query_stage_score&dep_id='+dep_id+'&exam_stage='+exam_stage;
        });
        $("#print_web").click(function(){
            window.print();
            return false;
        })
    })
</script>
<style type="text/css">
@media screen 
{
    .table th ,.table td, table.table-bordered > thead > tr > th{
        vertical-align:middle;
        text-align:center;
        border: 1px solid #000000;
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
        font-size: 18px;
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
    #query_stage_score,.notprint,#footer-container,#nav-container-sticky-wrapper { display: none; }
</style>