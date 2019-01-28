@extends('layouts.app')
@section('content')
@if (session('message'))
  <div class="alert alert-success">{{ session('message') }}</div>
@endif
<div class="container">

    <div class="row">
        <div class="col-md-3">
            <div>出勤情報を検索</div>
            <form action="/admin/show/{{ $employee->id }}/timesearch" method="get">
            @csrf
                <input type="date" name="day">
                <input type="submit" value="検索">
            </form>
            @if(isset($serch_attendances))
                @if(isset($serch_attendances["0"]))
                    <h4 style="margin-top: 30px;">{{$serch_attendances[0]->day}}の出勤状況</h4>
                    @foreach($serch_attendances as $attendance)
                        <?php
                            $start_time_ex = explode(":", $attendance->start_time);
                            $start_time = $start_time_ex[0].":".$start_time_ex[1];
                            $finish_time_ex = explode(":", $attendance->finish_time);
                            $finish_time = $finish_time_ex[0].":".$finish_time_ex[1];
                        ?>
                        <div style="margin-top: 10px;">
                            <div>出勤時間：{{$start_time}}</div>
                            <div>退勤時間：{{$finish_time}}</div>
                            <div>休憩時間：{{$attendance->rest_time}}分</div>
                            <div>深夜休憩：{{$attendance->late_rest_time}}分</div>
                            <a href="/admin/show/{{ $attendance->id }}/timeedit">この出勤情報を修正する</a>
                            <br>
                            <a href="/admin/show/{{ $employee->id }}">一覧に戻す</a>
                        </div>
                    @endforeach
                @else
                    <h4 style="margin-top: 15px; color: red;">該当なし</h4>
                    <a href="/admin/show/{{ $employee->id }}">一覧に戻す</a>
                @endif
            @else
                @if(isset($attendances["0"]))
                <h4 style="margin-top: 30px;">出勤情報一覧</h4>
                <?php
                    //--↓ページネーション↓--
                    $attendance_max = 3;
                    $attendences_a=array();
                    foreach($attendances as $attendance){
                        $start_time_ex = explode(":", $attendance->start_time);
                        $start_time = $start_time_ex[0].":".$start_time_ex[1];
                        $finish_time_ex = explode(":", $attendance->finish_time);
                        $finish_time = $finish_time_ex[0].":".$finish_time_ex[1];
                        $attendences_a[] = array('id' => $attendance->id, 'day' => $attendance->day,'start_time' => $start_time,
                                          'finish_time' => $finish_time,'rest_time' => $attendance->rest_time,'late_rest_time' => $attendance->late_rest_time);
                    }
                    $attendances_num = count($attendences_a);
                    $max_page = ceil($attendances_num / $attendance_max);
                    if(!isset($_GET['page_id'])){
                        $now = 1;
                    }else{
                        $now = $_GET['page_id'];
                    }
                    $start_no = ($now - 1) * $attendance_max;
                    $disp_data = array_slice($attendences_a, $start_no, $attendance_max, true);
                ?>
                    @foreach($disp_data as $disp)
                        <div style="margin-top: 10px;">
                            <div style="font-weight: bold;">{{ $disp["day"] }}</div>
                            <div> 勤務時間 : {{ $disp["start_time"] }}~{{ $disp["finish_time"] }}</div>
                            <div> 休憩時間 : {{ $disp["rest_time"] }}分</div>
                            <div> 深夜休憩 : {{ $disp["late_rest_time"] }}分</div>
                            <a href='/admin/show/{{ $disp["id"] }}/timeedit'>この出勤情報を修正する</a>
                        </div>
                    @endforeach
                    <br>
                <?php
                    for($i = 1; $i <= $max_page; $i++){
                        if ($i == $now) {
                            echo $now. '　';
                        } else {
                            echo '<a href=\'/admin/show/'.$employee->id.'/?page_id='. $i. '\')>'. $i. '</a>'. '　';
                        }
                    }
                    //--↑ページネーション↑--
                ?>
                @endif
            @endif
        </div>
        <div class="col-md-9">
            <div style="margin-top: 20px;">
                <h4>雇用者情報</h4>
                <div>雇用者名：{{$employee->name}}</div>
                <div>勤務形態：{{$employee->emp_status_id}}</div>
                @if($employee->basic_or_time == 0)
                    <div>基本月給：<?php echo floor($employee->basic_salary) ?>円</div>
                @else
                    <div>基本時給：<?php echo floor($employee->time_salary) ?>円</div>
                @endif
                <div>勤務時間：{{$employee->basic_work_time}} / 日</div>
                @if($employee->retirement_day != "0000-00-00")
                    <div style="color: red">退職処理済み</div>
                    <div style="color: red">退職処理日 -> {{$employee->retirement_day}}</div>
                @else
                    <div>ログインURL：http://localhost:8000/home/{{$employee->login_hash}}</div>
                @endif
                <a href="/admin/show/{{ $employee->id }}/edit">登録情報変更</a>
                <br><br>
            </div>
            <div style="overflow: hidden; margin-top: 10px;">
                <h4>給与情報</h4>
                @foreach($salaries as $salary)
                    <div style="float: left; width: 150px;">
                        <div style="margin-top: 10px; font-weight:bold;">支払日　{{ $salary->salary_year }}年{{ $salary->salary_month }}月</div>
                        <div style="position: relative; left: 20px;">給与額　{{ ceil($salary->salary_amount) }}円</div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection