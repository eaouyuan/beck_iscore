<form name="counseling_show" id="counseling_show" action="tchstu_mag.php" method="post" enctype='multipart/form-data'>
    <div class="col">
        <div class="form-group row">
            <div class="col text-center"><h3><{$info.year}> 學年度 第 <{$info.term}> 學期 <{$info.class}>班：<{$info.stu_name}> 學生認輔紀錄</h3></div>
            <div class="ml-auto">
                <button type="button" class="btn btn-primary" onclick="self.location.href='tchstu_mag.php?op=counseling_form&year=<{$info.year}>&term=<{$info.term}>&stu_sn=<{$info.stu_sn}>&tea_uid=<{$info.tea_uid}>';">
                    <i class="fa fa-plus-circle  mr-2" aria-hidden="true"></i>新增認輔學生紀錄
                </button>
                <button type="button" class="btn btn-success" onclick="onprint()"><i class="fa fa-print  mr-2" aria-hidden="true"></i>列印</button>
            </div>
        </div>
    </div>

<{if $all}>
<{foreach from=$all key=i item=its}>
    <table class="table table-bordered table-sm">
        <tbody>
            <tr>
                <th class="table-info">通報日期</th><th><{$its.notice_time}></th>
                <th class="table-info">編號</th><th><{$its.sn}></th>
                <th class="table-info">認輔教師</th><th><{$info.tea_name}></th>
                <th class="table-info">功能</th>
                <th width="20%">
                    <div class="col">
                        <a href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=counseling_form&sn=<{$its.sn}>" class="btn btn-warning mr-2"><i class="fa fa-pencil"></i> 編輯</a>
                        <a href="javascript:counseling_del(<{$its.sn}>)" class="btn btn-danger"><i class='fa fa-times '>刪除</i></a>
                    </div>
                </th>
            </tr>
            <tr>
                <th class="table-info" scope="row">面談地點</th>
                <th colspan="7" class="text-left">
                    <div class="row">
                        <{foreach from=$opt_result[$its.sn].AdoptionInterviewLocation key=ind item=optdata}>
                            <{$optdata}>
                        <{/foreach}>
                    </div>
                    <div class="col row">
                        <{$opt_other[$its.sn].AdoptionInterviewLocation}>
                    </div>
                </th>
            </tr>
            <tr>
                <th class="table-info" scope="row">輔導重點</th>
                <th colspan="7" class="text-left">
                    <div class="row">
                        <{foreach from=$opt_result[$its.sn].CounselingFocus  key=ind item=optdata}>
                            <{$optdata}>
                        <{/foreach}>
                    </div>
                    <div class="col row">
                        <{$opt_other[$its.sn].CounselingFocus}>
                    </div>
                </th>
            </tr>
            <tr>
                <th class="table-info">內容簡述</th>
                <th colspan="7" class="text-left">
                    <textarea class="form-control no-gray" id="content" name="content" rows="5" readonly><{$its.content}></textarea>
                </th>
            </tr>
            <tr>
                <th class="table-info">文件上傳</th>
                <th colspan="7"><{$Counsel[$its.sn].files}></th>
            </tr>
        </tbody>
    </table>
    <hr>
<{/foreach}>
<{else}>
    <div class="alert alert-danger">尚無內容</div>
<{/if}>
    <div>
        <input name="uid" id="uid" value="<{$uid}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <input name="student_sn" id="student_sn" value="<{$info.student_sn}>" type="hidden">
        <input name="tea_uid" id="tea_uid" value="<{$info.tea_uid}>" type="hidden">
        <{if $sn}>
            <input name="sn" id="sn" value="<{$sn}>" type="hidden">
        <{/if}>
    </div>

    <div class="col-md-12 text-center mb-3">
        <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=counseling_list">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>回上一頁</a>
    </div>
</form>

<!--------------------------- print --------------------------------->
<div id="printArea">
    <h2> <{$info.year}> 學年度 第 <{$info.term}> 學期 <{$info.class}>班：<{$info.stu_name}> 學生認輔紀錄</h2>
    <br>
<{if $all}>
<{foreach from=$all key=i item=its}>
    <table class="inonepage" style="font-family:sans-serif;">
        <tbody>
            <tr>
                <th width="15%" class="text-center">通報日期</th>
                <th class="text-center"><{$its.notice_time}></th>
                <th class="text-center">認輔教師</th>
                <th class="text-center"><{$info.tea_name}></th>
            </tr>
            <tr>
                <th class="text-center" scope="row">面談地點</th>
                <th colspan="3" class="text-left">
                    <div class="row">
                        <{foreach from=$opt_result[$its.sn].AdoptionInterviewLocation  key=ind item=optdata}>
                            <{$optdata}>
                        <{/foreach}>
                    </div>
                    <div class="mrl2">
                        <{$opt_other[$its.sn].AdoptionInterviewLocation}>
                    </div>
                </th>
            </tr>
            <tr>
                <th class="text-center" scope="row">輔導重點</th>
                <th colspan="3" class="text-left">
                    <div class="row">
                        <{foreach from=$opt_result[$its.sn].CounselingFocus  key=ind item=optdata}>
                            <{$optdata}>
                        <{/foreach}>
                    </div>
                    <div class="mrl2">
                        <{$opt_other[$its.sn].CounselingFocus}>
                    </div>
                </th>
            </tr>
            <tr>
                <th class="text-center">內容簡述</th>
                <th colspan="3" class="text-left idcontent">
                    <{$its.content_ptr}>
                </th>
            </tr>

        </tbody>
    </table>
    <hr>
<{/foreach}>
<{else}>
    <div class="alert alert-danger">尚無內容</div>
<{/if}>


</div>
<script type="text/javascript">
    $(document).ready(function($){
    });
    function onprint() {
        window.print();
        return false;
    }
</script>


<style type="text/css">

    .table th ,.table td{
        vertical-align:middle;
        text-align:center;
        border: 1px solid #000000;
        /* width:auto; */
        /* border-bottom: 2px solid #000000; */
    }
    input ,.custom-select,textarea {
        /* width:auto; */
        position: relative
    }
    .form-control[readonly].no-gray{
        background-color:white;
    }

    @media screen {
    }
    @page  {
        size:A4;
        margin:5mm;
    }
    @media print 
    {
        h2{
            text-align:center;
        }
        .idcontent {
            height: 8em;
            padding:0px 10px;
        }
        .inonepage{
            page-break-inside:avoid;
        }
        #printArea { 
            font-size: 16px;
        }
        table th, th, td{
            vertical-align:middle;
            text-align:center;
            border: 2px solid black;
        }   
        .col-2,.mrl2{
            margin-left:10px;
        }
    }
</style>
<style type="text/css" media="screen">
    /* 顯示時隱藏 */
    #printArea { display: none; }
</style>
<style type="text/css" media="print">
    /* 列印時隱藏 */
    #counseling_show,.notprint,#footer-container-display { display: none; }
</style>
