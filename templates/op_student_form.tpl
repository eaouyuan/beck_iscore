<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>
<{$formValidator_code}>

<form name="student_form" id="student_form" action="tchstu_mag.php" method="post" enctype='multipart/form-data'>
    <h3><{$form_title}></h3>
    <table class="table table-bordered table-sm">
        <tbody>
            <tr>
                <th class="table-info" scope="row">姓名</th>
                <td><input type="text" class="form-control validate[required]" name="stu_name" id="stu_name" value="<{$stu.stu_name}>"></td>
                <th class="table-info" scope="row">身份證字號</th>
                <td><input type="text" class="form-control validate[required]" name="national_id" onblur="checkID(this)" id="national_id" value="<{$stu.national_id}>"></td>
            </tr>
            <tr>
                <th  class="table-info" scope="row">學號</th>
                <td><input type="text" class="form-control validate[required]"  name="stu_id" id="stu_id" value="<{$stu.stu_id}>"></td>
                <th  class="table-info" scope="row">入學編號</th>
                <td><input type="text" class="form-control validate[required]"  name="stu_no" id="stu_no" value="<{$stu.stu_no}>"></td>
            </tr>
            <tr>
                <th  class="table-info" scope="row">班級</th>
                <td><select class="custom-select" name="class_id" id="class_id"><{$stu.class_htm}></select></td>
                <th  class="table-info" scope="row">導師</th>
                <td  id="tutor"></td>
            </tr>
            <tr>
                <th  class="table-info" scope="row">學程</th>
                <td><select class="custom-select" name="major_id" id="major_id"><{$stu.major_htm}></select></td>
                <th  class="table-info" scope="row">年級</th>
                <td><select class="custom-select" name="grade" id="grade"><{$stu.grade_htm}></select></td>
            </tr>
            <tr>
                <th  class="table-info" scope="row">入校日期</th>
                <td><input class="form-control" type="text" name="arrival_date" id="arrival_date" value="<{$stu.arrival_date}>"onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:''})"></td>
                <th  class="table-info" scope="row">生日</th>
                <td><input class="form-control" type="text" name="birthday" id="birthday" value="<{$stu.birthday}>"onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:''})"></td>
            </tr>
            <tr>
                <th  class="table-info" scope="row">原就讀學校</th>
                <td><input type="text" class="form-control validate[required]" name="orig_school" id="orig_school" value="<{$stu.orig_school}>"></td>
                <th  class="table-info" scope="row">原就讀學校年級</th>
                <td><select class="custom-select" name="grade" id="grade"><{$stu.orig_grade_htm}></select></td>
            </tr>
            <tr>
                <th class="table-info" scope="row">戶籍地址</th>
                <td><input type="text" class="form-control" name="household_add" id="household_add" value="<{$stu.household_add}>"></td>
                <th class="table-info" scope="row"><button class="btn btn-primary btn-sm mr-1" type="button" id="copy_ghousehold">同左</button>居住地址</th>
                <td><input type="text" class="form-control"  name="address" id="address" value="<{$stu.address}>"></td>
            </tr>
            <tr>
                <th class="table-info" scope="row">外學</th>
                <td id="out_learn">
                    <{$stu.out_learn_htm}>
                </td>
                <th class="table-info" scope="row">隨班附讀</th>
                <td id="audit">
                    <{$stu.audit_htm}>
                </td>
            </tr>
            <tr>
                <th class="table-info" scope="row">目前狀況</th>
                <td><select class="custom-select" name="status" id="status"><{$stu.status_htm}></select></td>
                <th class="table-info" scope="row">學程紀錄(回歸用)</th>
                <td><input type="text" class="form-control" name="record" id="record" value="<{$stu.record}>"></td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered table-sm">
        <tbody>
            <tr>
                <th class="table-info" scope="row">社工師</th> 
                <td><select class="custom-select" name="social_id" id="social_id">
                    <{$stu.social_htm}>
                </select></td>
                <th class="table-info" scope="row">輔導老師</th>
                <td><select class="custom-select" name="guidance_id" id="guidance_id">
                    <{$stu.guidance_htm}>
                </select></td>
                <th class="table-info"  scope="row">認輔教師</th>
                <td><select class="custom-select" name="rcv_guidance_id" id="rcv_guidance_id">
                    <{$stu.rcv_guidance_htm}>
                </select></td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered table-sm">
        <tbody>
            <tr>
                <th class="table-info" scope="row">家長或監護人</th> 
                <td><input type="text" class="form-control" name="guardian1" id="guardian1" value="<{$stu.guardian1}>"></td>
                <th class="table-info" scope="row">關係</th>
                <td><input type="text" class="form-control"  name="guardian1_relationship" id="guardian1_relationship" value="<{$stu.guardian1_relationship}>"></td>
                <th class="table-info"  scope="row">電話1</th>
                <td><input type="text" class="form-control"  name="guardian1_cellphone1" id="guardian1_cellphone1" value="<{$stu.guardian1_cellphone1}>"></td>
                <th class="table-info" scope="row">電話2</th>
                <td><input type="text" class="form-control"  name="guardian1_cellphone2" id="guardian1_cellphone2" value="<{$stu.guardian1_cellphone2}>"></td>
            </tr>
            <tr>
                <th class="table-info" scope="row">緊急聯絡人<button class="btn btn-primary btn-sm" type="button" id="copy_guardian">同上</button></th> 
                <td><input type="text" class="form-control" name="emergency1_contact1" id="emergency1_contact1" value="<{$stu.emergency1_contact1}>"></td>
                <th class="table-info" scope="row">關係</th>
                <td><input type="text" class="form-control"  name="emergency1_contact_rel" id="emergency1_contact_rel" value="<{$stu.emergency1_contact_rel}>"></td>
                <th class="table-info"  scope="row">電話1</th>
                <td><input type="text" class="form-control"  name="emergency1_cellphone1" id="emergency1_cellphone1" value="<{$stu.emergency1_cellphone1}>"></td>
                <th class="table-info" scope="row">電話2</th>
                <td><input type="text" class="form-control"  name="emergency1_cellphone2" id="emergency1_cellphone2" value="<{$stu.emergency1_cellphone2}>"></td>
            </tr>
        </tbody>
    </table>

    <div>
        <input name="uid" id="uid" value="<{$uid}>" type="hidden">
        <input name="op" id="op" value="<{$op}>" type="hidden">
        <{if $sn}> <input name="sn" id="sn" value="<{$sn}>" type="hidden"> <{/if}>
        <{$XOOPS_TOKEN}>
    </div>

    <div class="col-md-12 text-center mb-3">
        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>儲存</button>
        <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=student_list">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
    </div>

</form>

<script src="<{$xoops_url}>/modules/tadtools/sweet-alert/sweet-alert.js" type="text/javascript"></script>
<link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/sweet-alert/sweet-alert.css" type="text/css"/>
<script type="text/javascript">
    $(document).ready(function($){
        let class_tutor=<{$class_tutor}>;
        let class_id=$("#class_id" ).val();
        let tutor_name=class_tutor[class_id];
        $('#tutor').text(tutor_name);

        // $('#out_learn').click(function(){
        //     if($('#out_learn_0').prop('checked')){　　
        //         $('#out_learn_1').prop('checked',true);
        //     }else{ 
        //         $('#out_learn_0').prop('checked',true);
        //     }
        // });
        // $('#audit').click(function(){
        //     if($('#audit_0').prop('checked')){　　
        //         $('#audit_1').prop('checked',true);
        //     }else{ 
        //         $('#audit_0').prop('checked',true);
        //     }
        // });

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
            let class_tutor=<{$class_tutor}>;
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
        sweetAlert("你的身份證號碼格式不對！", "格式錯誤","error");

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
input {
    /* width:auto; */
    position: relative
}
input[type=radio]{
    transform:scale(1.5);
}
</style>