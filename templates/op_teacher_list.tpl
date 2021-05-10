<!-- <link href="js/bootstrap-switch-3.3.4/dist/css/bootstrap3/bootstrap-switch.css" rel="stylesheet" type="text/css">
<script src="js/bootstrap-switch-3.3.4/dist/js/bootstrap-switch.js"></script> -->
<h2 style="float:left" class="mb-3">教師─基本資料列表</h2>
<div class="col row"></div>
<button type="button" class="btn btn-primary btn-sm mb-2" onclick="self.location.href='../system/admin.php?fct=users';" style="float:right">
    <img src="<{$xoops_url}>/modules/system/images/icons/transition/add.png" alt="新增教師">新增教師
</button>
<form name="teacher_list" id="teacher_list" action="school_affairs.php" method="get">
    <div class="form-group row">
        <label for="dep_id" class="col-1.5 col-form-label text-sm-right px-0">部門：</label>
        <div class="col-3 text-left px-0 mr-3">
            <select class="custom-select" name="dep_id" id="dep_id">
                <{$dept_c_sel_htm}>
            </select>
        </div>

        <label class="col-1 col-form-label text-sm-right px-0" for="search">關鍵字</label>
        <div class="mx-sm-3 col-3 text-left px-0">
            <input type="text" class="form-control" id="search" name="search" placeholder="search" value="<{$search}>">
        </div>
        <div>
            <input name="op" id="op" value="<{$op}>" type="hidden">
        </div>
        <button type="submit" id="search" class="btn btn-outline-primary col-0.5 mr-1">搜尋</button>
        <button type="button" id="clear" class="btn btn-outline-dark col-0.5">清空</button>

    </div>
</form>
<{$XOOPS_TOKEN}>



<{if $all}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead class="table-info">
            <tr>
                <th scope="col" class="text-center">編號</th>
                <th scope="col" class="text-center">帳號</th>
                <th scope="col" class="text-center">姓名</th>
                <th scope="col" class="text-center">處室</th>
                <th scope="col" class="text-center">職稱</th>
                <th scope="col" class="text-center">分機</th>
                <th scope="col" class="text-center">教師</th>
                <th scope="col" class="text-center">輔導師</th>
                <th scope="col" class="text-center">社工師</th>
                <th scope="col" class="text-center">功能</th>

            </tr>
        </thead>

       
        <tbody id="sort">
    <{foreach from=$all key=i item=its}>
        <tr id="odr_<{$its.uid}>"> 
            <th class="text-center clk-tbrow" data-href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=teacher_show&sn=<{$its.uid}>" scope="row"><{$its.sn}></th>
            <td class="text-center clk-tbrow" data-href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=teacher_show&sn=<{$its.uid}>"><{$its.uname}></td>
            <td class="text-center clk-tbrow" data-href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=teacher_show&sn=<{$its.uid}>"><{$its.name}></td>
            <td class="text-center clk-tbrow" data-href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=teacher_show&sn=<{$its.uid}>"><{$its.dep_id}></td>
            <td class="text-center clk-tbrow" data-href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=teacher_show&sn=<{$its.uid}>"><{$its.title}></td>
            <td class="text-center clk-tbrow" data-href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=teacher_show&sn=<{$its.uid}>"><{$its.phone}></td>
            <td class="text-center"> 
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" name="switch_tch" id="tch_<{$its.uid}>" value="<{$its.uid}>" <{$its.istch_chk}>>
                    <label class="custom-control-label" for="tch_<{$its.uid}>"></label>
                </div>
            </td>
            <td class="text-center"> 
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" name="switch_gdc" id="gdc_<{$its.uid}>" value="<{$its.uid}>" <{$its.isgdc_chk}>>
                    <label class="custom-control-label" for="gdc_<{$its.uid}>"></label>
                </div>
            </td>
            <td class="text-center"> 
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" name="switch_scl" id="scl_<{$its.uid}>" value="<{$its.uid}>" <{$its.isscl_chk}>>
                    <label class="custom-control-label" for="scl_<{$its.uid}>"></label>
                </div>
            </td>
            
            <td class="text-center">
                <a href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=teacher_form&sn=<{$its.uid}>" class="btn btn-warning btn-sm mr-2">編輯</a>
                <a href="javascript:tch_del(<{$its.uid}>)" class="btn btn-danger btn-sm">刪除</a>
            </td>
            
        

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

<script type="text/javascript">
    $(document).ready(function($){
        $("#clear").click(function() {
            $('#search').val('');
            $("#dep_id option:selected").prop("selected", false)
        });
        $('#sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable('serialize')+'&op=teacher_sort';
            // console.log(order);
            $.post('other_action.php',  order, function(theResponse){
                // console.log(theResponse);
                $('#save_msg').html(theResponse);
            });
            }
        });

        $('#dep_id').change(function(e){
            // 方法一 php form表單按下submit
            // $(this).closest('form').trigger('submit');
            // 方法二 php form表單按下submit
            document.forms["teacher_list"].submit();
        });

        $(".clk-tbrow").click(function() {
            window.location = $(this).data("href");
        });
    
        $('input[name=switch_tch]').change(function(e){
            if($(this).prop('checked')) {
                var chk='1';
            } else {
                var chk='0';
            }
            var teacher_id=  $(this).val();;
            var XOOPS_TOKEN_REQUEST=  $('#XOOPS_TOKEN_REQUEST').val();;
            // console.log(XOOPS_TOKEN_REQUEST);
            // console.log(chk);
            // console.log(teacher_id);

            $.ajax ({
            url: 'other_action.php',
            method: 'POST',
            dataType: 'json',
            data: ({
                op:'teacher_istch_edit',
                check_status:chk,
                sn:teacher_id,
                XOOPS_TOKEN_REQUEST:XOOPS_TOKEN_REQUEST
            }),

            success: function(response){
                // alert(response.msg);
                // console.log('response');
            },
            error: function (error) {
                // console.log(error);
                // alert(error);
            }
            });
        });

        $('input[name=switch_gdc]').change(function(e){
            if($(this).prop('checked')) {
                var chk='1';
            } else {
                var chk='0';
            }
            var teacher_id=  $(this).val();;
            var XOOPS_TOKEN_REQUEST=  $('#XOOPS_TOKEN_REQUEST').val();;
            // console.log(XOOPS_TOKEN_REQUEST);
            // console.log(chk);
            // console.log(teacher_id);

            $.ajax ({
            url: 'other_action.php',
            method: 'POST',
            dataType: 'json',
            data: ({
                op:'teacher_isgdc_edit',
                check_status:chk,
                sn:teacher_id,
                XOOPS_TOKEN_REQUEST:XOOPS_TOKEN_REQUEST
            }),

            success: function(response){
                // alert(response.msg);
                // console.log('response');
            },
            error: function (error) {
                // console.log(error);
                // alert(error);
            }
            });
        });

        $('input[name=switch_scl]').change(function(e){
            if($(this).prop('checked')) {
                var chk='1';
            } else {
                var chk='0';
            }
            var teacher_id=  $(this).val();;
            var XOOPS_TOKEN_REQUEST=  $('#XOOPS_TOKEN_REQUEST').val();;
            // console.log(XOOPS_TOKEN_REQUEST);
            // console.log(chk);
            // console.log(teacher_id);

            $.ajax ({
            url: 'other_action.php',
            method: 'POST',
            dataType: 'json',
            data: ({
                op:'teacher_isscl_edit',
                check_status:chk,
                sn:teacher_id,
                XOOPS_TOKEN_REQUEST:XOOPS_TOKEN_REQUEST
            }),

            success: function(response){
                // alert(response.msg);
                // console.log('response');
            },
            error: function (error) {
                // console.log(error);
                // alert(error);
            }
            });
        });



    })
</script>
<style type="text/css">
    [data-href] { cursor: pointer; }
</style>

