
<div class="col">
    <form name="course_list" id="course_list" action="tchstu_mag.php" method="get">
        <div class="form-group row">
            
            <h2 class="mb-3">成績登入時間 ─ 列表</h2>

            <div class="ml-auto">
                <button type="button" class="btn btn-primary btn-sm mb-2" onclick="self.location.href='school_affairs.php?op=exam_keyindate_form';">
                <img src="<{$xoops_url}>/modules/system/images/icons/transition/add.png" alt="新增成績登入時間">新增成績登入時間
                </button>
            </div>

        </div>

</form>
</div> 



<{if $all}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead class="table-info">
            <tr>
                <th scope="col" class="text-center">編號</th>
                <th scope="col" class="text-center">學年度</th>
                <th scope="col" class="text-center">學期</th>
                <th scope="col" class="text-center">考試階段</th>
                <th scope="col" class="text-center">起始日期</th>
                <th scope="col" class="text-center">結束日期</th>
                <th scope="col" class="text-center">輸入</th>
                <th scope="col" class="text-center">功能</th>
            </tr>
        </thead>
        <tbody id="sort">
    <{foreach from=$all key=i item=its}>
        <tr id="odr_<{$its.sn}>"> 
            <th class = "text-center"><{$its.i}></th>
            <th class = "text-center"><{$its.exam_year}></th>
            <th class = "text-center"><{$its.exam_term}></th>
            <th class = "text-center"><{$its.exam_name}></th>
            <th class = "text-center"><{$its.start_date}></th>
            <th class = "text-center"><{$its.end_date}></th>
            <td class = "text-center">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" name="sw_examkeyindate" id="keyin_<{$its.sn}>" value="<{$its.sn}>" <{$its.status}>>
                    <label class="custom-control-label" for="keyin_<{$its.sn}>"></label>
                </div>
            </td>
            <th class="text-center">
                <a href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=exam_keyindate_form&sn=<{$its.sn}>" class="btn btn-warning btn-sm mr-2">編輯</a>
                <a href="javascript:examdate_del(<{$its.sn}>)" class="btn btn-danger btn-sm">刪除</a>
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
<{$XOOPS_TOKEN}>
<{$bar}>

<script type="text/javascript">
    $(document).ready(function($){

        $('input[name=sw_examkeyindate]').change(function(e){
            if($(this).prop('checked')) {
                var chk='1';
            } else {
                var chk='0';
            }
            var keyindate_id=  $(this).val();;
            var XOOPS_TOKEN_REQUEST=  $('#XOOPS_TOKEN_REQUEST').val();;
            // console.log(XOOPS_TOKEN_REQUEST);
            // console.log(chk);
            // console.log(keyindate_id);
            $.ajax ({
                url: 'other_action.php',
                method: 'POST',
                dataType: 'json',
                data: ({
                    op:'sw_examkeyindate',
                    check_status:chk,
                    sn:keyindate_id,
                    // token沒有用
                    XOOPS_TOKEN_REQUEST:XOOPS_TOKEN_REQUEST
                }),

                success: function(response){
                    // alert(response.msg.success);
                    // console.log('response');
                    // swal("修改成功!", "請點選ok離開!", "success");
                    swal({
                            title: "修改成功!",
                            text: "視窗外點選->離開!",
                            icon: "success",
                            button: "Aww yiss!",
                            allowOutsideClick:true,
                    });
                },
                error: function (error) {
                    // console.log(error);
                    alert(error);
                }
            });
        });
    
        // 排序功能拿掉
        // $('#sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
        //     var order = $(this).sortable('serialize')+'&op=exam_keyindate_sort';
        //     // console.log(order);
        //     $.post('other_action.php',  order, function(theResponse){
        //         // console.log(theResponse);
        //         $('#save_msg').html(theResponse);
        //     });
        //     }
        // });
    });

    
</script>

<style type="text/css">
    /* [data-href] { cursor: pointer; } */
</style>