<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>
<{$formValidator_code}>

<form name="variable_form" id="variable_form" action="school_affairs.php" method="post" enctype='multipart/form-data'>
    <h3><{$form_title}></h3>
    <table class="table table-bordered table-sm">
        <tbody>
            

            <tr>
                <th class="table-info" scope="row">sn</th>
                <td><input name="sn" id="sn" value="<{$cfg.sn}>" type="hidden"><{$cfg.sn}></td>
                <th class="table-info" scope="row">群組名稱</th>
                <td>
                    <{if $type=='e'}><input type="hidden" name="gpname" id="gpname" value="<{$cfg.gpname}>"><{$cfg.gpname}>
                    <{else}><input type="text" class="form-control validate[required]" name="gpname" id="gpname" value="<{$cfg.gpname}>"><{/if}>
                </td>
            </tr>
            <tr>
                <th  class="table-info" scope="row">中文顯示</th>
                <td><input type="text" class="form-control validate[required]"  name="title" id="title" value="<{$cfg.title}>"></td>
                <th  class="table-info" scope="row">值</th>
                <td>
                    <!-- <{if $type=='e'}><input type="hidden" name="gpval" id="gpval" value="<{$cfg.gpval}>"><{$cfg.gpval}>
                    <{else}><{/if}> -->
                    <input type="text" class="form-control validate[required,custom[integer],min[1],max[100]]"  name="gpval" id="gpval" value="<{$cfg.gpval}>">
                </td>
            </tr>
            <tr>
                <th  class="table-info" scope="row">描述</th>
                <td><input type="text" class="form-control validate[required]"  name="description" id="description" value="<{$cfg.description}>"></td>
                <th  class="table-info" scope="row">狀態</th>
                <td id="cfg_status"><{$cfg.status}></td>
            </tr>
            <tr>
                <th  class="table-info" scope="row">人員</th>
                <td><input name="update_user" id="update_user" value="<{$cfg.update_user}>" type="hidden"><{$cfg.update_user}></td>
                <th  class="table-info" scope="row">日期</th>
                <td><input name="update_date" id="update_date" value="<{$cfg.update_date}>" type="hidden"><{$cfg.update_date}></td>
            </tr>
            <tr>
                <th class="table-info" scope="row">排序</th>
                <td colspan="3"><input type="text" name="sort" id="sort" class="form-control validate[required,custom[integer],min[1],max[1000]]" value="<{$cfg.sort}>"></td>
            </tr>

        </tbody>
    </table>

    <div>
        <input name="uid" id="uid" value="<{$uid}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <input name="type" id="type" value="<{$type}>" type="hidden">
        <{if $sn}> <input name="sn" id="sn" value="<{$sn}>" type="hidden"> <{/if}>
        <{$XOOPS_TOKEN}>
    </div>

    <div class="col-md-12 text-center mb-3">
        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button>
        <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/school_affairs.php?op=variable_list">
        <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
    </div>

</form>


<script type="text/javascript">
    $(document).ready(function($){
        // let class_tutor=<{$class_tutor}>;
        // let class_id=$("#class_id" ).val();
        // let tutor_name=class_tutor[class_id];
        // $('#tutor').text(tutor_name);

        $("#cfg_status").click(function(){
            if($('#status_0').prop('checked')){　　
                $('#status_1').prop('checked',true);
            }else{ 
                $('#status_0').prop('checked',true);
            }
        });
        $('#audit').click(function(){
            if($('#audit_0').prop('checked')){　　
                $('#audit_1').prop('checked',true);
            }else{ 
                $('#audit_0').prop('checked',true);
            }
        });

        $("#copy_guardian").click(function() {
            $('#emergency1_contact1').val($('#guardian1').val());
            $('#emergency1_contact_rel').val($('#guardian1_relationship').val());
            $('#emergency1_cellphone1').val($('#guardian1_cellphone1').val());
            $('#emergency1_cellphone2').val($('#guardian1_cellphone2').val());
        });
        $("#copy_ghousehold").click(function() {
            $('#address').val($('#household_add').val());
        });
        $( "input" ).addClass( "font-weight-bold" );

        $('#class_id').change(function(e){
            // let class_tutor=<{$class_tutor}>;
            let class_id=$("#class_id" ).val();
            let tutor_name=class_tutor[class_id];
            // console.log(class_id=='');
            if(class_id==''){
                $('#tutor').text("");
            }else{
                $('#tutor').text(tutor_name);
            }
        });
        // 學號末三碼為編號
        $( "#stu_id" ).blur(function(e){
            if($('#stu_no').val()==''){
                $('#stu_no').val($("#stu_id" ).val().substring(3, 6));
            }
        });

        //身份證字號大寫
        $('#national_id').change(function(e){
            let nastring=$('#national_id').val();
            let naidnew=nastring.replace(/^./, nastring[0].toUpperCase());
            $('#national_id').val(naidnew);
        });

    });

function checkID(formElement) {
        re = /^[A-Z]\d{9}$/;
        if (!re.test(formElement.value))
        alert("你的身份證號碼格式不對！")
};

</script>

<style>
.table th ,.table td{
    vertical-align:middle;
    text-align:center;
    border: 1px solid #000000;
    /* width:auto; */
    /* border-bottom: 2px solid #000000; */
}

input[type=radio]{
    transform:scale(1.5);
}

input , select{
        /* width:auto; */
        position: relative;
        vertical-align:middle;
        text-align:center;
    }
</style>