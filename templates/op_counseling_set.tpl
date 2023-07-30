<form name="counseling_set" id="counseling_set" action="school_affairs.php" method="post">
    <h2 class="mb-3 alert alert-success text-center"> <{$pars.cos_year}> 學年度 第 <{$pars.cos_term}> 學期 ─ <{if $tea_name}>「<{$tea_name}>」<{/if}> 認輔教師設定</h2>
    <div class="form-group col row">
        <label for="cos_year" class="col-form-label px-0">學年度：</label>
        <div class="col-1 text-left px-0 mr-3">
            <select class="custom-select" name="cos_year" id="cos_year">
                <{$sems_year_htm}>
            </select>
        </div>
        <label for="cos_term" class="col-form-label text-center px-0">學期：</label>
        <div class="col-1 text-left px-0 mr-3">
            <select class="custom-select" name="cos_term" id="cos_term">
                <{$sems_term_htm}>
            </select>
        </div>
        <div>
            <input name="op" id="op" value="<{$op}>" type="hidden">
        </div>
        <button type="button" id="ac_smes" class="btn btn-outline-success col-0.5  mr-3">目前學期</button>

    </div>

    <div class="row">
        <div class="col-4">
            <h3 class="text-center bg-info">教師列表</h3>
            <select class="custom-select custom-select-lg mb-3 dropdown-menu1" size=15 name="sn" id="sn">
            <!-- onchange="location.href='<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=counseling_set&sn=' + this.value"> -->
                <{if $show_tea}><{$tea_sel}><{/if}>
            </select>
        </div>
    
        <div class="col-4">
            <h3 class="text-center bg-info">未認輔學生</h3>
            <select id="s_list" class="custom-select custom-select-lg mb-3" size=15>
                <{if $show_tea}><{$stu_sel}><{/if}>
            </select>
        </div>
        <div class="col-4">
            <h3 class="text-center bg-info">已認輔學生</h3>
            <select id="d_list" class="custom-select custom-select-lg mb-3" name="d_list[]" size=15 multiple>
                <{if $sn}><{$counseling_sel}><{/if}>
            </select>
        </div>
        
    </div>
    <div>
        <input name="uid" id="uid" value="<{$uid}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <{if $sn}> <input name="sn" id="sn" value="<{$sn}>" type="hidden"> <{/if}>
        <{$XOOPS_TOKEN}>
    </div>

    <div class="col-md-12 text-center mb-3">
        <button type="submit" style="display:none;"></button>
        <!-- <button class="btn btn-primary" type="button" onclick="selectAll();"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button> -->
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

        });
        $('#cos_year').change(function(e){
            cos_year=$('#cos_year').val();
            cos_term=$('#cos_term').val('');
            location.href='<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=counseling_set&cos_year='+cos_year;
            // document.forms["counseling_set"].submit();
        });
        $('#cos_term').change(function(e){
            cos_year=$('#cos_year').val();
            cos_term=$('#cos_term').val();
            location.href='<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=counseling_set&cos_year='+cos_year+'&cos_term='+cos_term;
            // document.forms["counseling_set"].submit();
        });
        $('#sn').click(function(e){
            sn=$(this).val();
            cos_year=$('#cos_year').val();
            cos_term=$('#cos_term').val();
            location.href='<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=counseling_set&cos_year='+cos_year+'&cos_term='+cos_term+'&sn='+sn;
            // document.forms["counseling_set"].submit();
        });
        $("#ac_smes").click(function() {
            console.log(<{$sem_term}>);
            $('#cos_year').val(<{$sem_year}>);
            $('#cos_term').val(<{$sem_term}>);
            location.href='<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=counseling_set&cos_year=<{$sem_year}>&cos_term=<{$sem_term}>';
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
    option.tea_list:checked{
        text-decoration: none;
        color: #000000;
        background-color: #d1ff9d;
    }
</style>