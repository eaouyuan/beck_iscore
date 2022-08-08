<!-- <script type="text/javascript" src="js/tableExport.jquery.plugin-master/libs/FileSaver/FileSaver.min.js"></script> -->
<!-- <script type="text/javascript" src="js/tableExport.jquery.plugin-master/libs/js-xlsx/xlsx.core.min.js"></script> -->
<!-- <script type="text/javascript" src="js/tableExport.jquery.plugin-master/tableExport.min.js"></script> -->
<script type="text/javascript" src="js/tableExport.jquery.plugin-master/bootstrap-table.min.js"></script>
<!-- <script type="text/javascript" src="js/tableExport.jquery.plugin-master/bootstrap-table-export.min.js"></script> -->
<link rel="stylesheet" href="<{$xoops_url}>/modules/beck_iscore/css/bootstrap-table.min.css" type="text/css"/>


<h2 class="mb-3">課程 ─ 批次刪除</h2>

<div class="col">
<form name="course_batch" id="course_batch" action="tchstu_mag.php" method="get">
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

        <div>
            <input name="op" id="op" value="<{$op}>" type="hidden">
            <button type="submit" class="btn btn-outline-primary mb-2 mr-1">搜尋</button>
            <button type="button" id="clear" class="btn btn-outline-dark col-0.5 mb-2 mr-3">清空</button>
            <button type="button" id="ac_smes" class="btn btn btn-success col-0.5 mb-2 mr-3">最新學期</button>
        </div>

        <div class="ml-auto">
            <button type="button" class="btn btn-primary btn-sm mb-2" onclick="self.location.href='tchstu_mag.php?op=course_form';">
            <img src="<{$xoops_url}>/modules/system/images/icons/transition/add.png" alt="新增課程">新增課程
            </button>
        </div>

    </div>

</form>
</div> 

<{if $all}>
    <div id="toolbar" class="mb-3">
        <button id="remove" class="btn btn-danger" disabled><i class="fa fa-trash"></i> Delete</button>
    </div>
    <table class="table table-sm table-hover table-shadow" id="mytable"
        data-toggle="table"
        data-click-to-select="true"
    >
        <thead class="table-info">
            <tr>
                <th data-field="state" data-checkbox="true"></th>
                <th data-field="id"       class="text-center" data-sortable="true">編號</th>
                <th data-field="sterm"    class="text-center">學年度/學期</th>
                <th data-field="dept"     class="text-center">學程</th>
                <th data-field="course"   class="text-center">課程名稱</th>
                <th data-field="teacher"  class="text-center">教師</th>
                <th data-field="course_g" class="text-center">課程群組</th>
                <th data-field="score"    class="text-center">學分</th>
            </tr>
        </thead>
        <tbody>
    <{foreach from=$all key=i item=its}>
        <tr> 
            <td></td>
            <th class="text-center"><{$its.sn}></th>
            <th class="text-center"><{$its.year_term}></th>
            <td class="text-center"><{$its.dep_name}></td>
            <td class="text-center"><{$its.cos_name}></td>
            <td class="text-center"><{$its.teacher_name}></td>
            <td class="text-center"><{$its.cos_name_grp}></td>
            <td class="text-center"><{$its.cos_credits}></td>

        </tr>
    <{/foreach}>
        </tbody>
    </table>
<{else}>
    <div class="alert alert-danger">
        尚無內容
    </div>
<{/if}>
<h4 class="mb-3 text-center">------ 學分數總計:<{$credit_sun}> -----</h4>

<{$bar}>



<script src="<{$xoops_url}>/modules/tadtools/sweet-alert/sweet-alert.js" type="text/javascript"></script>
<link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/sweet-alert/sweet-alert.css" type="text/css"/>

<script type="text/javascript">
    $(document).ready(function($){
        $("#clear").click(function() {
            $('#cos_year').val('');
            $('#cos_term').val('');
            $('#dep_id').val('');
            document.forms["course_batch"].submit();
        });
        $("#ac_smes").click(function() {
            $('#cos_year').val('<{$sem_year}>');
            $('#cos_term').val('<{$sem_term}>');
            $('#dep_id').val('');
            document.forms["course_batch"].submit();
        });

        $('#cos_year , #cos_term , #dep_id').change(function(e){
            document.forms["course_batch"].submit();
        });
    });
    
    var $table = $('#mytable')
    var $remove = $('#remove')

    // Get Selections
    $(function() {
        $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
            $remove.prop('disabled', !$table.bootstrapTable('getSelections').length)
        })

        $remove.click(function () {
            swal({
                title: '確定要刪除此批課程嗎？',
                text: '有登記成績之課程，不得刪除！',
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

                let urlv='other_action.php';
                let opv='course_batch_del';
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
                    }),
                    success: function(response){
                        console.log(response);
                        if(response.code==1){
                            // 刪除所選之列
                            $table.bootstrapTable('remove', {
                                field: 'id',
                                values: ids
                            })
                            $remove.prop('disabled', true);
                            location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=course_batch&cos_year=<{$sem_year}>&cos_term=<{$sem_term}>&dep_id=<{$dep_id}>';

                            // 是否再跳出「刪除成功後，再轉向」
                            // swal({
                            //     title: "刪除成功",
                            //     text: response.msg,
                            //     icon: "success",
                            // },
                            // function() {
                            //     location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=course_batch&cos_year=<{$sem_year}>&cos_term=<{$sem_term}>&dep_id=<{$dep_id}>';
                            // });
                        }else if(response.code==0){
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