<!-- <link rel="stylesheet" href="../beck_iscore/css/jquery-ui.css">
<script src="<{$xoops_url}>/modules/beck_iscore/js/jquery-ui.js"></script> -->

<{$formValidator_code}>

<form name="course_form" id="course_form" action="tchstu_mag.php" method="post" enctype='multipart/form-data'>
    <h3><{$form_title}></h3>
    <table class="table table-bordered table-sm">
        <tbody>
            <tr>
                <th class="table-info" scope="row">學年度</th>
                <td><input type="text" class="form-control" name="cos_year" id="cos_year" value="<{$cour.cos_year}>" readonly></td>
                <th class="table-info" scope="row">學期</th>
                <td><input type="text" class="form-control" name="cos_term" id="cos_term" value="<{$cour.cos_term}>" readonly></td>
            </tr>
            <tr>
                <th class="table-info" scope="row">學程</th>
                <td><select class="custom-select validate[required]" name="dep_id" id="dep_id"><{$cour.major_htm}></select></td>

                <th class="table-info" scope="row">教師</th>
                <td >
                    <select class="custom-select validate[required]" name="tea_id" id="tea_id"><{$cour.teacher_htm}></select>
                </td>
            </tr>

            <tr>
                <th  class="table-info" scope="row">課程名稱</th>
                <td><input type="text" class="form-control validate[required]" name="cos_name" id="cos_name" value="<{$cour.cos_name}>"></td>
                <th  class="table-info" scope="row">課程群組</th>
                <td><input type="text" class="form-control validate[required]" name="cos_name_grp" id="cos_name_grp" value="<{$cour.cos_name_grp}>"></td>
            </tr>
            <tr>
                <th  class="table-info" scope="row">第一次段考</th>
                <td id="ftest">
                    <label class="switch m-1">
                        <input type="checkbox" name="first_test" id="first_test" value='1' <{$cour.ftest_htm}>>
                        <span class="slider round"></span></label>
                </td>
                <th  class="table-info" scope="row">第二次段考</th>
                <td id="stest">
                    <label class="switch m-1">
                        <input type="checkbox" name="second_test" id="second_test" value='1' <{$cour.stest_htm}>>
                        <span class="slider round"></span></label>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered table-sm">
        <tbody>
            <tr>
                <th class="table-info" scope="row">學分數</th>
                <td><input class="form-control validate[required,custom[onlyNumber],maxSize[1]
                    ]" type="text" name="cos_credits" id="cos_credits" value="<{$cour.cos_credits}>"></td>
                <th  class="table-info" scope="row">是否計分</th>
                <td id="isscore">
                    <label class="switch m-1">
                        <input type="checkbox" name="scoring" id="scoring" value='1' <{$cour.score_htm}>>
                        <span class="slider round"></span>
                    </label>
                </td>
                <th class="table-info" scope="row">課程狀態</th>
                <td>
                    <select class="custom-select" name="status" id="status"><{$cour.status_htm}></select>
                </td>
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
        <a class="btn btn-secondary" href="javascript:history.back()">
            <i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a>
        <!-- <a class="btn btn-secondary" href="<{$xoops_url}>/modules/beck_iscore/tchstu_mag.php?op=course_list"><i class="fa fa-undo mr-2" aria-hidden="true"></i>取消</a> -->
        <a href="javascript:cos_del(<{$sn}>)" class="btn btn-danger">
                <i class="fa fa-trash-o mr-2" aria-hidden="true"></i>刪除</a>
    </div>

</form>


<script type="text/javascript">
    $(document).ready(function($){
        $('#ftest').click(function(){
            sw_ch('first_test');
        });
        $('#stest').click(function(){
            sw_ch('second_test');
        });
        $('#isscore').click(function(){
            sw_ch('scoring');
        });

        $("input , select").addClass( "font-weight-bold text-center" );
        $("tr").addClass( "font-weight-bold" );

        // 群組名稱自動填入
        $( "#cos_name" ).blur(function(e){
            if($('#cos_name_grp').val()==''){
                $('#cos_name_grp').val($("#cos_name" ).val());
            }
        });

    });
    function sw_ch(val){
        if($('#'+val).prop('checked')){　　
            $('#'+val).prop('checked',false);
        }else{ 
            $('#'+val).prop('checked',true);
        }
    }


</script>

<style>

.table th ,.table td{
    vertical-align:middle;
    text-align:center;
    border: 1px solid #000000;
    /* width:auto; */
    /* border-bottom: 2px solid #000000; */
}
input , select{
    /* width:auto; */
    position: relative;
}
input[type=radio]{
    transform:scale(1.5);
}

#ftest ,#stest ,#isscore { 
    cursor: pointer; 
} 

/* 以下是switch start */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  border-style:10px;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;

}

.slider.round:before {
  border-radius: 50%;
}

/* switch end */

</style>

