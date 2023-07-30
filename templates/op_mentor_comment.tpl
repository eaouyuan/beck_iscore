<form name="mentor_comment" id="mentor_comment" action="tchstu_mag.php" method="post">
    <h2 class="mb-3 alert alert-success text-center"> <{$sem_year}> 學年度 第 <{$sem_term}> 學期 ─ <{$class_name}> <{$teacher_name}> 導師評語</h2>
    <div class="row">
        <div class="col-2">
            <h3 class="text-center bg-info">學生列表</h3>
            <select class="custom-select custom-select-lg mb-3 dropdown-menu1" size=12
            onchange="location.href='<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=mentor_comment&sn=' + this.value">
                <{$stu_sel}>
            </select>
        </div>
    
        <div class="col-6">
            <h3 class="text-center bg-info">評語選擇</h3>
            <div class="row">
                <div class="col">
                    <select id="comA" class="custom-select custom-select-lg mb-3" size=12>
                        <{if $sn}><{$com.A}><{/if}>
                    </select>
                </div>
                <div class="col">
                    <select id="comB" class="custom-select custom-select-lg mb-3" size=12>
                        <{if $sn}><{$com.B}><{/if}>
                    </select>
                </div>
                <div class="col">
                    <select id="comC" class="custom-select custom-select-lg mb-3" size=12>
                        <{if $sn}><{$com.C}><{/if}>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-4">
            <h3 class="text-center bg-info">導師評語</h3>
            <textarea class="form-control" id="tea_Comment" name="tea_Comment" rows="14"><{$all.Comment}></textarea>
        </div>
        
    </div>
    <div>
        <input name="year" id="year" value="<{$sem_year}>" type="hidden">
        <input name="term" id="term" value="<{$sem_term}>" type="hidden">
        <input name="uid" id="uid" value="<{$uid}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <{if $sn}> <input name="sn" id="sn" value="<{$sn}>" type="hidden"> <{/if}>
        <{$XOOPS_TOKEN}>
    </div>

    <div class="col-md-12 text-center mb-3">
        <button type="submit" style="display:none;"></button>
        <!-- <button class="btn btn-primary mr-3" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button> -->
        <button class="btn btn-primary mr-3" type="button" onclick="clean();"></i>清空</button>
        <a class="btn btn-secondary" href="javascript:history.back()">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>回上一頁</a>
    </div>


</form>



<script type="text/javascript">
    $("#comA,#comB,#comC").on("dblclick",function() {
        var cptext=$(this).find('option:selected').text()+" ";
        var text_area;
        text_area=$("#tea_Comment").val()+cptext;
        $("#tea_Comment").val(text_area);
    });
    $(document).ready(function($){

    });
    function clean(){
        $("#tea_Comment").val("");
        // document.forms["mentor_comment"].submit();
    }
</script>
<style type="text/css">

    select > option:hover{
    text-decoration: none;
    color: #ffffff;
    background-color: #f3969a;
    }


</style>