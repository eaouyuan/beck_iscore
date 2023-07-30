<h2 class="mb-3">學生─基本資料列表</h2>
<!-- <button type="button" class="btn btn-primary btn-sm mb-2 float-right" onclick="self.location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=student_form';">
    <img src="<{$xoops_url}>/modules/system/images/icons/transition/add.png" alt="新增學生">新增學生
</button> -->
<div class="col">
<form name="student_list" id="student_list" action="tchstu_mag.php" method="get">
    <div class="form-group row">
        <label for="status" class="col-1.5 col-form-label text-sm-right px-0">狀態：</label>
        <div class="col-2 text-left px-0 mr-3">
            <select class="custom-select" name="status" id="status">
                <{$status_htm}>
            </select>
        </div>

        <label for="major_id" class="col-1.5 col-form-label text-sm-right px-0">學程：</label>
        <div class="col-2 text-left px-0 mr-2">
            <select class="custom-select" name="major_id" id="major_id">
                <{$major_htm}>
            </select>
        </div>


        <label class="col-1 col-form-label text-sm-right px-0" for="search">姓名</label>
        <div class="mx-sm-3 col-3 text-left px-0">
            <input type="text" class="form-control" id="search" name="search" placeholder="search" value="<{$search}>">
        </div>
        <div>
            <input name="op" id="op" value="<{$op}>" type="hidden">
        </div>
        <button type="submit" id="cmdsubmit" class="btn btn-outline-primary col-0.5 mr-1">搜尋</button>
        <button type="button" id="clear" class="btn btn-outline-dark col-0.5">清空</button>
    </div>
</form>
</div>
<{$XOOPS_TOKEN}>

    <!-- <div id="toolbar" class="select">
        <select class="form-control">
        <option value="">Export Basic</option>
        <option value="all">Export All</option>
        <option value="selected">Export Selected</option>
        </select>
    </div> -->

<{if $all}>
    <table class="table table-bordered table-sm table-hover table-shadow" id="mytable" data-toggle="table" 
    data-show-export="true" 
    >
        <thead class="table-info">
            <tr>
                <th scope="col" class="text-center" data-sortable="true">編號</th>
                <th scope="col" class="text-center" data-sortable="true">學號</th>
                <th scope="col" class="text-center" data-sortable="true">姓名</th>
                <th scope="col" class="text-center">生日</th>
                <th scope="col" class="text-center" data-sortable="true">班級</th>
                <th scope="col" class="text-center" data-sortable="true">學程</th>
                <th scope="col" class="text-center" data-sortable="true">導師</th>
                <th scope="col" class="text-center" data-sortable="true">社工師</th>
                <th scope="col" class="text-center" data-sortable="true">輔導老師</th>
                <!-- <th scope="col" class="text-center">認輔教師</th> -->
                <{if $can_edit}>
                <th scope="col" class="text-center">功能</th>
                <{/if}>

            </tr>
        </thead>
        

        <tbody id="sort">
    <{foreach from=$all key=i item=its}>
        <tr id="odr_<{$its.sn}>" <{if $its.status=='0'}> class="text-danger"<{/if}>> 
            <td class="text-center" scope="row"><{$its.i}></td>
            <td class="text-center"><{$its.stu_id}></td>
            <td class="text-center"><{$its.stu_name}></td>
            <td class="text-center"><{$its.birthday}></td>
            <td class="text-center"><{$its.class_name}></td>
            <td class="text-center"><{$its.dep_name}></td>
            <td class="text-center"><{$its.tutor_name}></td>
            <td class="text-center"><{$its.social_id}></td>
            <td class="text-center"><{$its.guidance_id}></td>
            <!-- <td class="text-center"><{$its.rcv_guidance_id}></td> -->
            <{if $can_edit}>
            <td class="text-center">
                <a href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=student_form&sn=<{$its.sn}>" class="btn btn-warning btn-sm mr-2">編輯</a>
                <!-- <a href="javascript:stu_del(<{$its.sn}>)" class="btn btn-danger btn-sm">刪除</a> -->
            </td>
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
<br>
<{$bar}>
<script type="text/javascript" src="js/tableExport.jquery.plugin-master/libs/FileSaver/FileSaver.min.js"></script>
<script type="text/javascript" src="js/tableExport.jquery.plugin-master/libs/js-xlsx/xlsx.core.min.js"></script>
<script type="text/javascript" src="js/tableExport.jquery.plugin-master/tableExport.min.js"></script>
<script type="text/javascript" src="js/tableExport.jquery.plugin-master/bootstrap-table.min.js"></script>
<script type="text/javascript" src="js/tableExport.jquery.plugin-master/bootstrap-table-export.min.js"></script>

<script type="text/javascript">
    $(document).ready(function($){
        $("#clear").click(function() {
            $('#search').val('');
            $("#status option:selected").prop("selected", false);
            $("#major_id option:selected").prop("selected", false);
            document.forms["student_list"].submit();
        });

        $('#status').change(function(e){
            // 方法一 php form表單按下submit
            // $(this).closest('form').trigger('submit');
            // 方法二 php form表單按下submit
            document.forms["student_list"].submit();
        });
        $('#major_id').change(function(e){
            // 方法一 php form表單按下submit
            // $(this).closest('form').trigger('submit');
            // 方法二 php form表單按下submit
            document.forms["student_list"].submit();
        });

        // 移除拖拉排序功能
        // $('#sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
        //     var order = $(this).sortable('serialize')+'&op=student_sort';
        //     // console.log(order);
        //     $.post('other_action.php',  order, function(theResponse){
        //         // console.log(theResponse);
        //         $('#save_msg').html(theResponse);
        //     });
        //     }
        // });
    })
        
    $('#mytable').bootstrapTable({
    //     // {field:'checkbox', title:'選取', align:'center', width:80, visible:true, checkbox:true},    
    //     //classes:'table',
    //     toolbar: '#toolbar',
    //     uniqueId:'', //哪一個欄位是key
    //     sortName:'', //依照那個欄位排序
    //     sortOrder:'',
    //     // height : 450,
    //     pagination : false, //使否要分頁
    //     //可於ToolBar上顯示的按鈕
    //     showColumns : false, //顯示/隱藏哪些欄位
    //     showToggle : false, //名片式/table式切換
    //     showPaginationSwitch : false, //分頁/不分頁切換
    //     showRefresh : false, //重新整理
    //     search : false, //查詢

    //     onPageChange:function(currentPage, pageSize) {
    //     //console.log("目前頁數: "+currentPage+" ,一頁顯示: "+pageSize+" 筆");
    //     },
    //     pageSize : 20, //一頁顯示幾筆
    //     pageList : [ 20, 50, 100, 200], //一頁顯示幾筆的選項
    //     formatRecordsPerPage:function(pageSize) {
    //     return '&nbsp;&nbsp;每頁顯示 ' + pageSize + ' 筆';
    //     },
    //     formatShowingRows:function(fromIndex, toIndex, totalSize) {
    //     //目前第幾頁
    //     var currentPage = Math.ceil(fromIndex / this.pageSize);
    //     //總共幾頁
    //     var totalPageCount = Math.ceil(totalSize / this.pageSize);
    //     return '第 '+currentPage+' 頁&nbsp;&nbsp;共 '+totalPageCount+' 頁';
    //     }	
            exportTypes: ['csv', 'txt',  'excel']
    });
    

</script>
<style type="text/css">
    [data-href] { cursor: pointer; }
</style>
