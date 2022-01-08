
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
<!-- <{if $show_add_button=='0'}></div><{/if}> -->



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
            <th class="text-center"><{$its.i}></th>
            <th class="text-center"><{$its.exam_year}></th>
            <th class="text-center"><{$its.exam_term}></td>
            <th class="text-center"><{$its.exam_name}></td>
            <th class="text-center"><{$its.start_date}></td>
            <th class="text-center"><{$its.end_date}></td>
            <th class="text-center"><{$its.status}></td>
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

<{$bar}>

<script type="text/javascript">
    $(document).ready(function($){
        $('#sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable('serialize')+'&op=exam_keyindate_sort';
            // console.log(order);
            $.post('other_action.php',  order, function(theResponse){
                // console.log(theResponse);
                $('#save_msg').html(theResponse);
            });
            }
        });
    });
    
</script>

<style type="text/css">
    /* [data-href] { cursor: pointer; } */
</style>