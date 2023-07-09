<script type="text/javascript" src="js/tableExport.jquery.plugin-master/bootstrap-table.min.js"></script>
<link rel="stylesheet" href="<{$xoops_url}>/modules/beck_iscore/css/bootstrap-table.min.css" type="text/css"/>


<h2 class="mb-3">段考成績 ─ 批次刪除</h2>

<div class="col">
<form name="stage_score_batch" id="stage_score_batch" action="tchstu_mag.php" method="get">
    <div class="form-group row">
        <label for="ssb_year" class="col-0.5 col-form-label px-0">學年度：</label>
        <div class="col-1 text-left px-0 mr-3">
            <select class="custom-select" name="ssb_year" id="ssb_year">
                <{$sems_year_htm}>
            </select>
        </div>
        <label for="ssb_term" class="col-0.5 col-form-label text-center px-0">學期：</label>
        <div class="col-1 text-left px-0 mr-3">
            <select class="custom-select" name="ssb_term" id="ssb_term">
                <{$sems_term_htm}>
            </select>
        </div>
        <label for="ssb_stu_id" class="col-1.5 col-form-label text-sm-right px-0">學號：</label>
        <div class="col-2 text-left px-0 mr-3">
            <input type="text" class="form-control" id="ssb_stu_id" name="ssb_stu_id" placeholder="" value="<{$ssb_stu_id}>">
        </div>

        <div>
            <input name="op" id="op" value="<{$op}>" type="hidden">
            <button type="submit" class="btn btn-outline-primary mb-2 mr-1">搜尋</button>
            <button type="button" id="clear" class="btn btn-outline-dark col-0.5 mb-2 mr-3">清空</button>
            <button type="button" id="ac_smes" class="btn btn btn-success col-0.5 mb-2 mr-3">最新學期</button>
        </div>
    </div>

</form>
</div> 

<{if $all}>
    <div id="toolbar" class="mb-3">
        <button id="remove" class="btn btn-danger" disabled><i class="fa fa-trash"></i> Delete</button>
    </div>
    <table class="table table-sm table-hover table-shadow"
        id="mytable"
        data-toggle="table"
        data-click-to-select="true"
        >
        <thead class="table-info">
            <tr>
                <th data-field = "state" data-checkbox    = "true"></th>
                <th data-field = "id"       class         = "text-center" data-sortable = "true">編號</th>
                <th data-field = "year"    class          = "text-center">學年度</th>
                <th data-field = "term"    class          = "text-center">學期</th>
                <th data-field = "stu_id" class           = "text-center">學號</th>
                <th data-field = "stu_name" class         = "text-center">學生</th>
                <th data-field = "dep_name"     class     = "text-center">學程</th>
                <th data-field = "cos_name"   class       = "text-center">課程名稱</th>
                <th data-field = "exam_stage"   class     = "text-center">第幾次段考</th>
                <th data-field = "score" class            = "text-center">成績</th>
                <th data-field = "tea_name" class         = "text-center">教師</th>
                <th data-field = "update_user" class      = "text-center">建立者</th>
                <th data-field = "update_date" class      = "text-center">修改日期</th>
                <th data-field = "usual_average_sn" class = "text-center">期末總成績sn</th>
                <th data-field = "student_sn">學生流水號</th>
                <th data-field = "course_id">課程id</th>
            </tr>
        </thead>
        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr> 
            <td></td>
            <th class="text-center"><{$its.sn}></th>
            <th class="text-center"><{$its.year}></th>
            <td class="text-center"><{$its.term}></td>
            <td class="text-center"><{$its.stu_id}></td>
            <td class="text-center"><{$its.stu_name}></td>
            <td class="text-center"><{$its.dep_name}></td>
            <td class="text-center"><{$its.cos_name}></td>
            <td class="text-center"><{$its.usual_exam_name}></td>
            <td class="text-center"><{$its.score}></td>
            <td class="text-center"><{$its.tea_name}></td>
            <td class="text-center"><{$its.update_user}></td>
            <td class="text-center"><{$its.update_date}></td>
            <td class="text-center"><{$its.final_score_sn}></td>
            <td>                    <{$its.student_sn}></td>
            <td>                    <{$its.course_id}></td>
        </tr>
    <{/foreach}>
        </tbody>
    </table>
<{else}>
    <div class="alert alert-danger">
        尚無內容
    </div>
<{/if}>

<{$bar}>



<script src="<{$xoops_url}>/modules/tadtools/sweet-alert/sweet-alert.js" type="text/javascript"></script>
<link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/sweet-alert/sweet-alert.css" type="text/css"/>

<script type="text/javascript">
    $(document).ready(function($){
        $("#clear").click(function() {
            $('#ssb_year').val('');
            $('#ssb_term').val('');
            $('#ssb_stu_id').val('');
            document.forms["stage_score_batch"].submit();
        });
        $("#ac_smes").click(function() {
            $('#ssb_year').val('<{$sem_year}>');
            $('#ssb_term').val('<{$sem_term}>');
            $('#ssb_stu_id').val('');
            document.forms["stage_score_batch"].submit();
        });

        $('#ssb_year , #ssb_term').change(function(e){
            document.forms["stage_score_batch"].submit();
        });
    });
    
    var $table = $('#mytable')
    var $remove = $('#remove')

    // Get Selections
    $(function() {
        $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
            $remove.prop('disabled', !$table.bootstrapTable('getSelections').length)
        })
        $table.bootstrapTable('hideColumn', 'student_sn');
        $table.bootstrapTable('hideColumn', 'course_id');

        $remove.click(function () {
            swal({
                title: '確定要刪除此批段考成績嗎？',
                text: '刪除之前，建議照像備份！',
                type: 'warning',
                showCancelButton: 1,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: '確定刪除！',
                closeOnConfirm: true ,
                allowOutsideClick: true
            },
            function(){
                // 取得所有選取欄位資料
                // var getsel_val=$table.bootstrapTable('getSelections');
                // alert('getSelections: ' + JSON.stringify($table.bootstrapTable('getSelections')));
                // console.log(getsel_val);
                let urlv='other_action.php';
                let opv='stage_score_batch';
                let ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                    return row.id
                })

                $.ajax ({
                    url: urlv,
                    method: 'POST',
                    dataType: 'json',
                    data: ({
                        op:opv,
                        ids:ids,
                        // Selections_data:JSON.stringify($table.bootstrapTable('getSelections'))
                    }),
                    success: function(response){
                        // console.log(response);
                        if(response.code=='1'){
                            // 刪除所選之列
                            $table.bootstrapTable('remove', {
                                field: 'id',
                                values: ids
                            });
                            $remove.prop('disabled', true);
                            alert(response.msg);
                    
                            location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=stage_score_batch&ssb_year=<{$sem_year}>&ssb_term=<{$sem_term}>&ssb_stu_id=<{$ssb_stu_id}>';

                            // 是否再跳出「刪除成功後，再轉向」
                            // swal({
                            //     title: "刪除成功",
                            //     text: response.msg,
                            //     icon: "success",
                            // },
                            // function(){
                            //     location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=stage_score_batch&ssb_year=<{$sem_year}>&ssb_term=<{$sem_term}>&ssb_stu_id=<{$ssb_stu_id}>';
                            // });
                        }else if(response.code=='0'){
                            sweetAlert("刪除錯誤",response.msg, "error");
                            // swal("刪除成功",response.msg, "success")

                        }
                    },
                    error: function (msg) {
                        alert(msg);
                    }
                });
            });
        })
    })
</script>

<style type="text/css">
    [data-href] { cursor: pointer; }
    .select, #locale {
        width: 100%;
    }
    .like {
        margin-right: 10px;
    }
    tr.selected {
        background-color: #fcdede;
    }
    .table > tbody > tr:hover{
        text-decoration: none;
        color: #000000;
        background-color: #fcdede;
    }
    
</style>