@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
            <div class="container" style="margin-bottom: 20px;">
                <div>雇用者名：{{$employee->name}}</div>
                <div>勤務形態：{{$employee->emp_status_id}}</div>
                <div>基本月給：{{$employee->basic_salary}}円</div>
                <div>勤務時間：{{$employee->basic_work_time}}分 / 日</div>
                @if($employee->retirement_day != "0000-00-00")
                    <div style="color: red">退職処理済み</div>
                    <div style="color: red">退職処理日 -> {{$employee->retirement_day}}</div>
                @else
                    <div>ログインURL：http://localhost:8000/home/{{$employee->login_hash}}</div>
                @endif
                <a href="/admin/show/{{ $employee->id }}/edit">登録情報変更</a>
            </div>
    </div>
</div>
@endsection