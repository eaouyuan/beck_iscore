<h2 class="mb-3">課程 ─ 列表</h2>

<div class="col">
<form name="course_list" id="course_list" action="tchstu_mag.php" method="get">
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
            <button type="button" id="ac_smes" class="btn btn btn-success col-0.5 mb-2 mr-3">目前學期</button>
        </div>

        <div class="ml-auto">
            <button type="button" class="btn btn-primary btn-sm mb-2" onclick="self.location.href='tchstu_mag.php?op=course_form';">
            <img src="http://localhost/modules/system/images/icons/transition/add.png" alt="新增課程">新增課程
            </button>
        </div>

    </div>

</form>
</div> 
<!-- <{if $show_add_button=='0'}></div><{/if}> -->



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
            document.forms["course_list"].submit();
        });
        $("#ac_smes").click(function() {
            $('#cos_year').val('<{$sem_year}>');
            $('#cos_term').val('<{$sem_term}>');
            $('#dep_id').val('');
            document.forms["course_list"].submit();
        });

        $('#cos_year , #cos_term , #dep_id').change(function(e){
            document.forms["course_list"].submit();
        });

        $('input[name=sw_first_test]').change(function(e){
            if($(this).prop('checked')) {
                var chk='1';
            } else {
                var chk='0';
            }
            let snv=  $(this).val();
            let opv='course_ftest_sw';
            let urlv='other_action.php';
            ajax_sw(urlv,opv,chk,snv);
        });
        $('input[name=sw_second_test]').change(function(e){
            if($(this).prop('checked')) {
                var chk='1';
            } else {
                var chk='0';
            }
            let urlv='other_action.php';
            let opv='course_stest_sw';
            let snv=  $(this).val();

            ajax_sw(urlv,opv,chk,snv);
        });
        $('#sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable('serialize')+'&op=course_sort';
            // console.log(order);
            $.post('other_action.php',  order, function(theResponse){
                console.log(theResponse);
                $('#save_msg').html(theResponse);
            });
            }
        });

    });
    function ajax_sw(urlv,opv,chk,snv){
        // console.log(snv);
        $.ajax ({
            url: urlv,
            method: 'POST',
            dataType: 'json',
            data: ({
                op:opv,
                check_status:chk,
                sn:snv,
            }),
            success: function(response){
                // alert(response.msg);
                // console.log('response');
            },
            error: function (error) {
                // alert(error.msg);
                // console.log(error);
            }
        });
    }
</script>

<style type="text/css">
    [data-href] { cursor: pointer; }
</style>