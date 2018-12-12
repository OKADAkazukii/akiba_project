@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h3>管理者ページ</h3>
            <a href="/holiday">休日設定</a><br>
            <a href="/timesettingse">時間関連設定</a><br>
            <a href="/conf">設定</a><br>
            <a href="/employ">勤務形態</a><br>
        </div>
        <div class="col-md-8">
            <h3>雇用者一覧</h3>
            <div class="container">
                <div class="row">
                    @foreach($employees as $employee)
                        <div class="container">
                            <div>雇用者名：{{$employee->name}}</div>
                            <div>勤務形態：{{$employee->emp_status_id}}</div>
                            <div>基本月給：{{$employee->basic_salary}}円</div>
                            <div>勤務時間：{{$employee->basic_work_time}}分 / 日</div>
                            <div>ログインURL：http://localhost:8000/home/{{$employee->login_hash}}</div><br>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
