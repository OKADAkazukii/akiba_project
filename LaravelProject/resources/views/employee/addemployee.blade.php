<title>ユーザー作成</title>
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
<script type="text/javascript" src="/js/style.js"></script>

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
            <div class="form_text">基本給</div>
                <input type="text" name="basic_salary" onblur="test(this)" size="19" maxlength="7" style="text-align: right"/>
                <div>※半角数値以外を入力するとアラートが表示されます。</div>
            <div class="form_text">時給</div>
                <input type="text" name="time_salary" onblur="test(this)" size="19" maxlength="7" style="text-align: right"/>

                <select name="basic_or_time" style="width:30%;">
                    <option value="" selected disabled hidden>--計算給与の選択--</option>
                    <option value="0">基本給</option>
                    <option value="1">時給（アルバイト等）</option>
                </select>

            <div class="form_text">基本勤務時間(日)</div>
                <input class="form" type="time" name="basic_work_time"　style="width:100px;font-size:18px;text-align:center;"/><br>
            <br>
                <input type="submit" value="作成" class="button1">
         </div>
     </form>
</div>
@endsection