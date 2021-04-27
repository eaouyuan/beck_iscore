<!-- <{$all|@var_dump}> 樣版除錯-->
<div class="container-fluid">
    <h2>滑動列表</h2>
    <div id="save_msg"></div>

    <div class="row" id="sort">
        <{foreach from=$all key=i item=students}>
            <div class="col-sm-4" id="sn_<{$students.sn}>">
                <a href="index.php?sn=<{$students.sn}>&op=student_show" style="cursor: move;"
                    >
                    <div class="new-article top-shadow bottom-shadow">
                        <{if $students.cover}>
                            <img src="<{$students.cover}>" alt="<{$students.stu_name}>" class="cover img-thumbnail">    
                        <{else}>
                            <img src="https://picsum.photos/200/200?image=<{$i}>" alt="<{$students.stu_sn}>" class="cover img-thumbnail">
                        <{/if}>
                        <div class="latest-post">
                            <h4><{$students.stu_name}></h4>
                        </div>
                        <p>學號：<{$students.stu_sn}></p>
                    </div>    
                </a>
                
            </div>  
            <hr>

        <{foreachelse}>
            <div class="alert alert-danger col-12">
                尚無內容
            </div>
        <{/foreach}>
    </div>
</div>

<!-- <script type="text/javascript">
    $(document).ready(function(){
        $('#sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable('serialize');
            console.log(order);
            $.post('save_sort.php', ({
                order,
                action:'nzsmr_student'
            }), function(theResponse){
                $('#save_msg').html(theResponse);
            });
        }
        });
    });
</script> -->

<script type="text/javascript">
    $(document).ready(function(){
        $('#sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable('serialize')+'&action=nzsmr_student';
            // console.log(sorted);
            $.post('save_sort.php',  order, function(theResponse){
                $('#save_msg').html(theResponse);
            });
        }
        });
    });
</script>
