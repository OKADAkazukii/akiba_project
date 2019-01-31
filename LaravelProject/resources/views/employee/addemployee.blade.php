<title>ユーザー作成</title>
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
<script type="text/javascript" src="/js/style.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment.min.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>

@extends('layouts.app')
@section('content')
<div class="container" style="position:relative; left:15%;">
    <div class="head_text1">ユーザーの新規作成</div>
    <form action="/create/employee" method="post">
        @csrf
        <br>
        <div class="form_div">
            <div class="form_text">社員名</div>
            <input class="form" type="text" name="name" maxlength="12"/><br>
            <div class="form_text">勤務形態</div>
            <select name="emp_status_id" style="width:30%;">
                <option value="" selected disabled hidden>--選択する--</option>
                <?php
                    $status_count = 0;
                    foreach($emp_status as $status){
                        $status_count++ ;
                        echo "<option value=".$status_count.">".$status->employment_status."</option>";
                    }
                ?>
            </select>
            <input type="hidden" value="1" name="admin_id"/>
                <?php
                $login_hash = sha1(uniqid(rand(),1));
                ?>
            <input type="hidden" value="{{$login_hash}}" name="login_hash"/>
            <div style="position:relative;">
                <div class="form_text">基本勤務時間(日)</div>
                <input class="form" type="time" name="basic_work_time" id="basic_work_time"　style="width:100px;font-size:18px;text-align:center;" value="00:00"/>
                <br>
            </div>
            <div style="position:relative; ">
                <div class="form_text">計算給与</div>
                <select name="basic_or_time"  id="changeselect" onchange="salarychange();">
                    <option value="" selected disabled hidden>--計算給与--</option>
                    <option value="0">基本給</option>
                    <option value="1">時給（アルバイト等）</option>
                </select>   
            </div>    
            <div style="position:relative;" id="s_div">
                <div class="form_text" >基本給</div>
                <input type="text" name="basic_salary" onblur="test(this)" size="19" maxlength="7" style="text-align: right" id="s_form" value="" readonly/>
            </div> 
            <div style="position:relative;left:50px;" id="t_div">        
                <div class="form_text">時給</div>
                <input type="text" name="time_salary" onblur="test(this)" size="19" maxlength="7" style="text-align: right" id="t_form" value="" readonly/>
            </div>
            <div id="auto"></div>
            <br>
            <input type="button" value="クリア"　id="salary_reset"/>
            <br>
            <input type="submit" value="作成" class="button1">
            <div id="test"></div>
        </div>
    </form>
</div>
<script>
var work_time;

$(function work(){
    var basic_work_time = $('#basic_work_time');
    basic_work_time.on('input', function(event){
        work_time = $('#basic_work_time').val();
        document.getElementById('changeselect').readOnly = false;
    });
});

function salarychange(){
    if (typeof work_time == 'undefined') {
        alert('基本勤務時間を入力してください');
        $('#changeselect').val("");  
    }else{  
        var id = $('#changeselect').val();
        var $basic_s = $('#s_form');
        var $time_s = $('#t_form');
        $('#s_form').val("");
        $('#t_form').val("");
        if(id == '0'){
            $('#s_div').css('color','black');
            $('#s_form').css('color','black');
            $('#t_div').css('color','ccc');
            $('#t_form').css('color','ccc');
            document.getElementById('s_form').readOnly = false;
            document.getElementById('t_form').readOnly = true;
            $basic_s.on('input', function(event){
                var numberh = Number(moment(work_time, 'HH:mm').format('H'));
                var numberm = Number(moment(work_time, 'HH:mm').format('m'));
                var time = eval(numberh * 60 + numberm) / eval(60);
                var times= time.toFixed(2);
                var val = eval($basic_s.val()) / eval(20.33 * times );
                var result= Math.ceil(val);
                $('#t_form').val(result);
            });
        }else{
            if(id == '1'){
                $('#t_div').css('color','black');
                $('#t_form').css('color','black');
                $('#s_div').css('color','ccc');
                $('#s_form').css('color','ccc');
                document.getElementById('t_form').readOnly = false;
                document.getElementById('s_form').readOnly = true;
                $time_s.on('input', function(event){
                    $('#t_form').readOnly = false;
                    var numberh = Number(moment(work_time, 'HH:mm').format('H'));
                    var numberm = Number(moment(work_time, 'HH:mm').format('m'));
                    var basic = eval(numberh * 60 + numberm) / eval(60);
                    var basics= basic.toFixed(2);
                    var value = eval($time_s.val()) * eval(20.33* basics);
                    var result = Math.ceil(value);
                    $('#s_form').val(result);
                });
            };        
        };
    };
};

$(function salaryreset(){
    var reset = $('#salary_reset');
    reset.on('click',function(){
        $('#s_form').val("");
        $('#t_form').val("");
        $('#changeselect').val("");
        $('#t_div').css('color','black');
        $('#t_form').css('color','black');
        $('#s_div').css('color','black');
        $('#s_form').css('color','black');
        document.getElementById('s_form').readOnly = true;
        document.getElementById('t_form').readOnly = true;
    });
});
</script>
@endsection
