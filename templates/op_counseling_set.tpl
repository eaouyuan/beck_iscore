<form name="counseling_set" id="counseling_set" action="school_affairs.php" method="post">
    <h2 class="mb-3 alert alert-success text-center"> <{$sem_year}> 學年度 第 <{$sem_term}> 學期 ─ <{if $tea_name}>「<{$tea_name}>」<{/if}> 認輔教師設定</h2>
    <div class="row">
        <div class="col-4">
            <h3 class="text-center bg-info">教師列表</h3>
            <select class="custom-select custom-select-lg mb-3 dropdown-menu1" size=15
            onchange="location.href='<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=counseling_set&sn=' + this.value">
                <{$tea_sel}>
            </select>
        </div>
    
        <div class="col-4">
            <h3 class="text-center bg-info">學生列表</h3>
            <select id="s_list" class="custom-select custom-select-lg mb-3" size=15>
                <{if $sn}><{$stu_sel}><{/if}>
            </select>
        </div>
        <div class="col-4">
            <h3 class="text-center bg-info">認輔學生</h3>
            <select id="d_list" class="custom-select custom-select-lg mb-3" name="d_list[]" size=15 multiple>
                <{if $sn}><{$counseling_sel}><{/if}>
            </select>
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
        <button class="btn btn-primary" type="button" onclick="selectAll();"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button>
        <a class="btn btn-secondary" href="javascript:history.back()">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>回上一頁</a>
    </div>


</form>



<script type="text/javascript">
    $(document).ready(function($){
        $("#s_list").dblclick(function() {
            var s = document.getElementById("s_list");
            var d = document.getElementById("d_list");
            while(s.selectedIndex!=-1){
                //產生一個option元件
                var opt = document.createElement("option");
                //把opt加到目標List裡
                d.options.add(opt);
                //指定opt的value及text
                opt.text = s.options[s.selectedIndex].text;
                opt.value = s.options[s.selectedIndex].value;
                // opt.selected = true;//選取
                //加入到目標List後，移除來源List中的選項
                s.remove(s.selectedIndex);     
            }           
        });
        $("#d_list").dblclick(function() {
            var s = document.getElementById("s_list");
            var d = document.getElementById("d_list");
            while(d.selectedIndex!=-1){
                //產生一個option元件
                var opt = document.createElement("option");
                //把opt加到目標List裡
                s.options.add(opt);
                //指定opt的value及text
                opt.text = d.options[d.selectedIndex].text;
                opt.value = d.options[d.selectedIndex].value;
                opt.selected = true;//選取
                //加入到目標List後，移除來源List中的選項
                d.remove(d.selectedIndex);     
            }           

            // var text_val = $('option:selected', this).text(); //to get selected text
            // var id = $(this).val();
            // $('#s_list').append($('<option>', {
            //     value: id,
            //     text: text_val,
            //     selected:true
            // }));
            // var x = document.getElementById("d_list");
            // x.remove(x.selectedIndex);
        });
    });
    function selectAll(){
        $('#d_list option').prop('selected', true);
        document.forms["counseling_set"].submit();

    }
    // -----------------------------------
    // 在html 如下
    // <input type="button" value="-->" onclick="insertList('list2','list1');">
    // -----------------------------------

    // function insertList(tarL,srcL){
    //     var tarObj = document.getElementById(tarL);
    //     var srcObj = document.getElementById(srcL);
    //     //判斷來源List的選項是否有被選取
    //     while(srcObj.selectedIndex!=-1){
    //         //產生一個option元件
    //         var opt = document.createElement("option");
    //         //把opt加到目標List裡
    //         tarObj.options.add(opt);
    //         //指定opt的value及text
    //         opt.text = srcObj.options[srcObj.selectedIndex].text;
    //         opt.value = srcObj.options[srcObj.selectedIndex].value;
    //         opt.selected = true;//選取
    //         //加入到目標List後，移除來源List中的選項
    //         srcObj.remove(srcObj.selectedIndex);     
    //     }
    // }
</script>
<style type="text/css">

    select > option:hover{
    text-decoration: none;
    color: #ffffff;
    background-color: #f3969a;
    }

    .sel_exist{
        text-decoration: none;
        color: #000;
        background-color: #abccfc;
    }
</style>