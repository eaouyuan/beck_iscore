<{$formValidator_code}>
<h2 class="mb-3 notprint">段考成績登錄</h2>
<form name="stage_score_list" id="stage_score_list" action="tchstu_mag.php" method="post">

    <div class="col">
        <div class="form-group row">
        
            <label for="dep_id" class="col-1.5 col-form-label text-sm-right px-0">學程名稱：</label>
            <div class="col-2 text-left px-0 mr-3">
                <select class="custom-select validate[required]" name="dep_id" id="dep_id">
                    <{$course.major_htm}>
                </select>
            </div>
            <label for="dep_id" class="col-1.5 col-form-label text-sm-right px-0">課程名稱：</label>
            <div class="col-2 text-left px-0 mr-3">
                <select class="custom-select validate[required]" name="course_id" id="course_id">
                    <{$course.course_htm}>
                </select>
            </div>
            <label for="dep_id" class="col-1.5 col-form-label text-sm-right px-0">教師姓名：</label>
            <div class="col-2 text-left px-0 mr-3">
                <input type="text" class="form-control" readonly value="<{$sscore.tea_name}>">
            </div>
        </div>
    </div>
<{if $showtable}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead>
            <tr class="table-info">
                
                <th style="border: 2px solid #000000;"class="text-center" width="10%" >姓名</th>
                <{foreach from=$exam_name key=exam_sn item=exam_chnname}>
                    <th scope="col" class="text-center" width="8%"><{$exam_chnname}></th>
                <{/foreach}>
                <th scope="col" class="text-center" width="8%">平時成績<br>(<{$course.normal_exam_rate}>%)</th>
                <th scope="col" class="text-center" width="8%">段考成績<br>(<{$course.section_exam_rate}>%)</th>
                <th scope="col" class="text-center" width="10%">總成績</th>
                <th scope="col" class="text-center" width="16%">質性<br>描述</th>
            </tr>
        </thead>

        <tbody>
            <{foreach from=$all key=stu_sn item=v1}>
            <tr class=""> 
                <th class="text-center"><{$v1.name}></th>
                <{foreach from=$v1.score key=k item=score}>
                    <{if $addEdit.$k}>
                    <th class="text-center">
                        <input type="text" class="form-control validate[required,min[0],max[100]] score_jug" name="stu_score[<{$stu_sn}>][score][<{$k}>]" id="stu_<{$stu_sn}>" value="<{$score}>">
                    </th>
                    <{else}>
                        <th class="text-center"><{$score}></th>
                    <{/if}>

                <{/foreach}>
                <th class="text-center"><{$v1.f_usual}></th>
                <th class="text-center"><{$v1.f_stage}></th>
                <th class="text-center"><{$v1.f_sum}></th>
                <th class="text-center">
                    <{if $desc_addEdit}>
                        <input type="text" class="form-control validate[required]" name="stu_score[<{$stu_sn}>][desc]" id="stu_<{$stu_sn}>" value="<{$v1.desc}>">
                    <{else}>
                        <{$v1.desc}>
                    <{/if}>

                </th>
            </tr>
            <{/foreach}>
        </tbody>
    </table>
    <br>
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

</form>

<div id="printArea">
    <h1 class="mb-3" align="center">段考成績登錄</h1>
    <br>
    <h3><{$sscore.year}>學年度 第<{$sscore.term}>學期</h3>
    <h3>學程名稱：<{$sscore.dep_name}>／課程名稱：<{$sscore.course_name}>／教師姓名：<{$sscore.tea_name}></h3>
    <hr>
    <!-- <table border=3 cellpadding="10"; width="100%" border-color="black"> -->
    <table style="font-family:serif;"  cellpadding="5">
        <thead>
            <tr>
                <th class="text-center" width="14%"><font size="6">姓  名</font></th>
                <{foreach from=$exam_name key=exam_sn item=exam_chnname}>
                    <th class="text-center" width="7%"><{$exam_chnname}></th>
                <{/foreach}>
                <th class="text-center" width="7%">平時成績(<{$course.normal_exam_rate}>%)</th>
                <th class="text-center" width="7%">段考成績(<{$course.section_exam_rate}>%)</th>
                <th class="text-center" width="7%">總成績</th>
                <th class="text-center" width="18%">質性描述</th>
                
            </tr>
        </thead>
        <tbody>
            <{foreach from=$all key=stu_sn item=v1}>
            <tr> 
                <th class="text-center"><font size="6"><{$v1.stu_anonymous}></font></th>
                <{foreach from=$v1.score key=k item=score}>
                    <th class="text-center"><{$score}></th>
                <{/foreach}>
                <th class="text-center"><{$v1.f_usual}></th>
                <th class="text-center"><{$v1.f_stage}></th>
                <th class="text-center"><{$v1.f_sum}></th>
                <th class="text-center"><{$v1.desc}></th>
            </tr>
            <{/foreach}>
        </tbody>
    </table>
    <hr>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <h3>教師簽名:_______________________</h3>

</div>

<script type="text/javascript">
    $(document).ready(function($){
        $('#dep_id').change(function(e){
            $('#course_id').val('');
            let dep_id=$('#dep_id').val();
            location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=stage_score_list&dep_id='+dep_id;

        });
        $('#course_id').change(function(e){
            let dep_id=$('#dep_id').val();
            let course_id=$('#course_id').val();
            // console.log('<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=stage_score_list&dep_id='+dep_id+'&course_id='+course_id);
            location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=stage_score_list&dep_id='+dep_id+'&course_id='+course_id;
        });
        // 判斷表單是否有改變，沒變才能按列印
        var dataformInit = $("#stage_score_list").serializeArray();
        var jsonTextInit = JSON.stringify({ dataform: dataformInit });
        $("#print_web").click(function(){
            var dataform = $("#stage_score_list").serializeArray();
            var jsonText = JSON.stringify({ dataform: dataform });
            if(jsonTextInit==jsonText) {
                onprint();
                return false;
            }else{
                alert("表單改變，請先按儲存！");
                return false;
            }
        })

    })
    function printHtml(html) {
        var bodyHtml = document.body.innerHTML;
        document.body.innerHTML = html;
        window.print();
        document.body.innerHTML = bodyHtml;
    }

    function onprint() {
        // var html =$("#printArea").html();
        // printHtml(html);
        // let dep_id=$('#dep_id').val();
        // let course_id=$('#course_id').val();
        // location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=stage_score_list&dep_id='+dep_id+'&course_id='+course_id;
        window.print();
        return false;
    }

    function check_num(){
        let formstatus=true;
        // $('input[type=text]').each(function(i){

        let validat=$("#stage_score_list").validationEngine('validate');
        // console.log(validat);
        if(validat==true){
            $(".score_jug").each(function(i){ //取得開頭name=student_sn
                if((isNaN($(this).val())|| ($(this).val()<0) || ($(this).val()>100)) && ($(this).val()!='-'))
                {
                    alert("成績格式有錯，請確認！");
                    formstatus=false;
                    return false;
                }
            })
            if(formstatus==true){document.forms["stage_score_list"].submit();}
        }
    }




</script>

<style type="text/css">
@media screen 
{
    table th, .table th ,.table td, table.table-bordered > thead > tr > th{
        vertical-align:middle;
        text-align:center;
        border: 2px solid #000000;
        line-height:2.5em;
        /* width:auto; */
        /* border-bottom: 2px solid #000000; */
    }

    input , select{
        /* width:auto; */
        position: relative;
        vertical-align:middle;
        text-align:center;
    }
}
@page  {
    size:A4;
    margin:10mm;

   
}
@media print 
{

    #printArea { 
        font-size: 24px;

    }
    table th, th, td {
        vertical-align:middle;
        text-align:center;
        border: 4px solid black;
    }   


}
</style>
<!-- link, style可用media="mediaType"宣告適用時機 -->
<style type="text/css" media="screen">
    /* 顯示時隱藏 */
    #printArea { display: none; }
</style>
<style type="text/css" media="print">
    /* 列印時隱藏 */
    #stage_score_list,.notprint,#footer-container-display { display: none; }
</style>





