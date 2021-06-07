<h2 style="float:left" class="mb-3">系統變數設定─列表</h2>
<div class="col row"></div>
<button type="button" class="btn btn-primary btn-sm mb-2" onclick="self.location.href='<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=variable_form&type=n';" style="float:right">
    <img src="<{$xoops_url}>/modules/system/images/icons/transition/add.png" alt="新增系統變數">新增系統變數
</button>
<form name="variable_list" id="variable_list" action="school_affairs.php" method="get">
    <div class="form-group row">
        <label for="gpname" class="col-1.5 col-form-label text-sm-right px-0">群組名稱：</label>
        <div class="col-2.5 text-left px-0 mr-3">
            <select class="custom-select" name="gpname" id="gpname">
                <{$sel.gpname}>
            </select>
        </div>

        <label for="desc" class="col-1.5 col-form-label text-sm-right px-0">描述：</label>
        <div class="col-2.5 text-left px-0 mr-2">
            <select class="custom-select" name="desc" id="desc">
                <{$sel.desc}>
            </select>
        </div>


        <label class="col-1 col-form-label text-sm-right px-0" for="search">關鍵字</label>
        <div class="mx-sm-3 col-2 text-left px-0">
            <input type="text" class="form-control" id="search" name="search" placeholder="search" value="<{$sel.search}>">
        </div>
        <div>
            <input name="op" id="op" value="<{$op}>" type="hidden">
        </div>
        <button type="button" id="cmdsubmit" class="btn btn-outline-primary col-0.5 mr-1">搜尋</button>
        <button type="button" id="clear" class="btn btn-outline-dark col-0.5">清空</button>
        <button type="submit" style="display:none;"></button>

    </div>
</form>
<{$XOOPS_TOKEN}>


<{if $all}>
    <table class="table table-bordered table-sm table-hover table-shadow">
        <thead class="table-info">
            <tr>
                <th scope="col" class="text-center">sn</th>
                <th scope="col" class="text-center">gpname</th>
                <th scope="col" class="text-center">title</th>
                <th scope="col" class="text-center">value</th>
                <th scope="col" class="text-center">descript</th>
                <th scope="col" class="text-center">status</th>
                <th scope="col" class="text-center">日期</th>
                <th scope="col" class="text-center">排序</th>
                <th scope="col" class="text-center">功能</th>
            </tr>
        </thead>
        

        <tbody id="sort">
    <{foreach from=$all key=i item=its}>
        <tr id="odr_<{$its.sn}>"> 
            <td class="text-center"><{$its.sn}></td>
            <td class="text-center"><{$its.gpname}></td>
            <td class="text-center"><{$its.title}></td>
            <td class="text-center"><{$its.gpval}></td>
            <td class="text-center"><{$its.description}></td>
            <td class="text-center"><{$its.status}></td>
            <td class="text-center"><{$its.update_date}></td>
            <td class="text-center"><{$its.sort}></td>
            <td class="text-center">
                <a href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=variable_form&sn=<{$its.sn}>&type=e" class="btn btn-warning btn-sm mr-2">編輯</a>
                <a href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=variable_form&sn=<{$its.sn}>&type=c" class="btn btn-info btn-sm mr-2">複製</a>
                <a href="javascript:var_del(<{$its.sn}>)" class="btn btn-danger btn-sm">刪除</a>
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
    $(document).on('keypress',function(e) {
        if(e.which == 13) {
            $("#gpname option:selected").prop("selected", false);
            $("#desc option:selected").prop("selected", false);
            document.forms["variable_list"].submit();
        }
    });
    $(document).ready(function($){
        $("#clear").click(function() {
            $('#search').val('');
            $("#gpname option:selected").prop("selected", false);
            $("#desc option:selected").prop("selected", false);
            document.forms["variable_list"].submit();
        });

        $('#gpname').change(function(e){
            // 方法一 php form表單按下submit
            // $(this).closest('form').trigger('submit');
            // 方法二 php form表單按下submit
            $('#search').val('');
            $("#desc option:selected").prop("selected", false);
            document.forms["variable_list"].submit();
        });
        $('#desc').change(function(e){
            // 方法一 php form表單按下submit
            // $(this).closest('form').trigger('submit');
            // 方法二 php form表單按下submit
            $('#search').val('');
            $("#gpname option:selected").prop("selected", false);
            document.forms["variable_list"].submit();
        });
        
        $("#cmdsubmit").click(function() {
            $("#gpname option:selected").prop("selected", false);
            $("#desc option:selected").prop("selected", false);
            document.forms["variable_list"].submit();
        });

        $('#sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable('serialize')+'&op=variable_sort';
            console.log(order);
            $.post('other_action.php',  order, function(theResponse){
                console.log(theResponse);
                $('#save_msg').html(theResponse);
            });
            }
        });



    })
</script>
<style type="text/css">
    [data-href] { cursor: pointer; }
</style>
