<div id="printArea">
    <h2 class="mb-3" align="center">高雄市立楠梓特殊學校 瑞平分校 <{$pars.cos_year}>學年度 第<{$pars.cos_term}>學期 學期成績單</h2>
    <!-- <h2 class="mb-3" align="center"></h2> -->
    <div class="row">
        <div class="col-4"><h4>學程名稱：<{$stu.dep_name}></h4></div>
        <div class="col-4"><h4>學生姓名：<{$stu.name}></h4></div>
        <div class="col-4"><h4>學生學號：<{$stu.stu_id}></h4></div>
    </div>
    <!-- <hr> -->
    <!-- <table border=3 cellpadding="10"; width="100%" border-color="black"> -->
    <table style="font-family:sans-serif;"  cellpadding="5">
        <thead>
            <tr>
                <th class = "text-center" width = "5%"><font size  = "4">序號</font></th>
                <th class = "text-center" width = "20%"><font size = "4">科目</font></th>
                <th class = "text-center" width = "8%"><font size  = "4">學分</font></th>
                <th class = "text-center" width = "8%"><font size  = "4">成績</font></th>
                <th class = "text-center" width = "9%"><font size  = "4">總分</font></th>
                <th class = "text-center" width = "25%"><font size = "4">備註</font></th>
                
                
                <{foreach from=$all key=i item=data}>

                <{/foreach}>
            
                
            </tr>
        </thead>
        <tbody>
            <{foreach from=$all key=i item=data}>
                <tr> 
                    <th class = "text-center"><font size = "4"><{$data.order}></font></th>
                    <th class = "text-center"><font size = "4"><{$data.grp_name}></font></th>
                    <th class = "text-center"><font size = "4"><{$data.credit}></font></th>
                    <th class = "text-center"><font size = "4"><{$data.score}></font></th>
                    <th class = "text-center"><font size = "4"><{$data.total_score}></font></th>
                    <th class = "text-center"><font size = "4"><{$data.comment}></font></th>
                </tr>
            <{/foreach}>
        </tbody>
    </table>
    <br>
    <div class="row">
        <div class="col"><h5>導師評語：<b><{$stu.mentor_comment}></b></h5></div>
    </div>
    <div class="row">
        <div class="col-4"><h5>總修得學分：<{$stu.sum_credits}>  </h5></div>
        <div class="col-4"><h5>加權總分：<{$stu.total_score}>      </h5></div>
        <div class="col-4"><h5>學期總平均：<{$stu.total_avg}>    </h5></div>
    </div>
    <hr>
    <br>
    <h3 id="buton">教務處:_______________________</h3>

</div>

<script type="text/javascript">
    $(document).ready(function($){
        window.onafterprint = window.close;
        window.print();
        false;
    })
</script>

<style type="text/css">
@media screen 
{
    table th, .table th ,.table td, table.table-bordered > thead > tr > th{
        vertical-align:middle;
        text-align:center;
        border: 2px solid #000000;
        line-height:1em;
        /* width:auto; */
        /* border-bottom: 2px solid #000000; */
    }

    input , select{
        /* width:auto; */
        position: relative;
        vertical-align:middle;
        text-align:center;
    }
}
@page  {
    size:A4;
    margin:5mm;
    margin-bottom:15mm;

}
@media print 
{

    #printArea { 
        font-size: 15px;
    }

    table th, th, td {
        vertical-align:middle;
        text-align:center;
        border: 2px solid black;
        /* font-size: 2em; */
    }   
    #buton {
        position: fixed;
        bottom: 0;
   }


}
</style>
<!-- link, style可用media="mediaType"宣告適用時機 -->
<style type="text/css" media="screen">
    /* 顯示時隱藏 */
    #printArea { display: none; }
</style>
<style type="text/css" media="print">
    /* 列印時隱藏 */
    #stage_score_list,.notprint,#footer-container-display ,#nav-container{ display: none; }
</style>





