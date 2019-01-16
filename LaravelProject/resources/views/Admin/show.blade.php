@extends('layouts.app')
@section('content')
@if (session('message'))
  <div class="alert alert-success">{{ session('message') }}</div>
@endif
<div class="container">

    <div class="row">
        <div class="col-md-7">
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
            @if(isset($attendances["0"]))
                <?php $count=0 ?>
                <h4>直近の出勤状況を3件まで表示</h4>
                @foreach($attendances as $current_attendance)
                    <?php
                        $count++;
                        $start_time_ex = explode(":", $current_attendance->start_time);
                        $start_time = $start_time_ex[0].":".$start_time_ex[1];
                        $finish_time_ex = explode(":", $current_attendance->finish_time);
                        $finish_time = $finish_time_ex[0].":".$finish_time_ex[1];
                    ?>
                    <div>{{$count}}件目</div>
                    <div style="margin-bottom: 20px; border: solid gray 1px;">
                        <div>出勤日付：{{$current_attendance->day}}</div>
                        <div>勤務時間：{{$start_time}}~{{$finish_time}}</div>
                        <div>休憩時間：{{$current_attendance->rest_time}}分</div>
                        <div>深夜休憩：{{$current_attendance->late_rest_time}}分</div>
                        <a href="/admin/show/{{ $current_attendance->id }}/timeedit">この出勤情報を修正する</a>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-md-5">
            <div>編集日付を検索</div>
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
                        </div>
                    @endforeach
                @else
                    <h4 style="margin-top: 15px; color: red;">該当なし</h4>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection