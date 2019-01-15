<title>ユーザー作成</title>
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
<script type="text/javascript" src="/js/style.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment.min.js"></script>

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
            <div>
                <div class="form_text" >基本給</div>
                <input type="text" name="basic_salary" onblur="test(this)" size="19" maxlength="7" style="text-align: right" id="s_form" value=""/>
                <div>※半角数値以外を入力するとアラートが表示されます。</div>
                <div>※基本給または時給を入力し基本勤務時間を選択すると、もう一方の値が自動計算されます。</div> 
            </div> 
            <div style="position:relative; left:210px;bottom:120px; ">        
            <div class="form_text">時給</div>
                <input type="text" name="time_salary" onblur="test(this)" size="19" maxlength="7" style="text-align: right" id="t_form" value=""/>
            </div>
           
                <select name="basic_or_time" style="width:30%;position:relative; bottom:35px;" id="changeSelect"  onchange="salarychange();">
                    <option value="" selected disabled hidden>--計算給与の選択--</option>
                    <option value="0">基本給</option>
                    <option value="1">時給（アルバイト等）</option>
                </select>

            <div class="form_text">基本勤務時間(日)</div>
                <input class="form" type="time" name="basic_work_time" id="basic_work_time"　style="width:100px;font-size:18px;text-align:center;" value="00:00"/><br>
            <br>
                <input type="submit" value="作成" class="button1">
        </div>
     </form>
</div>
<script>

$(function() {
  var $input = $('#s_form'); 
  var basic_work_time = $('#basic_work_time');
   $input.on('input', function(event){
     document.getElementById('changeSelect').value = ('0');
   basic_work_time.on('input', function(event){
     var basic = $('#basic_work_time').val();
     var numberHh = Number(moment(basic, 'HH:mm').format('H'));
     var numberHm = Number(moment(basic, 'HH:mm').format('m'));
     var time = eval(numberHh * 60 + numberHm) / eval(60);
     var times= time.toFixed(2);
     var val = eval($input.val()) / eval(20.33 * times );
     var result= Math.ceil(val);
    document.getElementById('t_form').value = (result);
    });
  });
});

$(function(){
  var $tms = $('#t_form');
  var basic_work_time = $('#basic_work_time');
  $tms.on('change', function(event){
    document.getElementById('changeSelect').value = ('1');
  basic_work_time.on('change', function(event){
    var time = $('#basic_work_time').val();
    var numberHh = Number(moment(time, 'HH:mm').format('H'));
    var numberHm = Number(moment(time, 'HH:mm').format('m'));
    var basic = eval(numberHh * 60 + numberHm) / eval(60);
    var basics= basic.toFixed(2);
    var value = eval($tms.val()) * eval(20.33* basics);
    var result = Math.ceil(value);
    document.getElementById('s_form').value =(result);
    });
  });
});

function salarychange(){
  if(document.getElementById('changeSelect')){
    id = document.getElementById('changeSelect').value;

    if(id == '0'){
      document.getElementById('s_form').readOnly = false;
      document.getElementById('t_form').readOnly = true;
    }else if (id == '1'){
      document.getElementById('s_form').readOnly = true;
      document.getElementById('t_form').readOnly = false;
     };
   };
};
window.onload = salarychange();

</script>
@endsection
