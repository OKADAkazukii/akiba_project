<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
@extends('layouts.app')
@section('content')
@if (session('empupdate'))
<div align="center"class="alert alert-success" >{{session('empupdate')}}</div>
@endif
@if (session('insertemp'))
<div align="center"class="alert alert-success" >{{session('insertemp')}}</div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <h3>管理者機能リンク</h3>
            <a href="/admin/salary">給与情報一覧</a><br>
            <a href="/addemployee">雇用者の追加</a><br>
            <a href="/holiday">休日設定</a><br>
            <a href="/timesettingse">時間関連設定</a><br>
            <a href="/conf">料率変更</a><br>
            <a href="/employ">雇用形態追加</a><br>
        </div>
        <div class="col-md-9">
            <form action="/admin/home/search" method="get">
            @csrf
                <input type="search" name="search" placeholder="名前を入力">
                <input type="submit" value="検索">
            </form>
            @if(isset($validated_search))
            <div style="margin-bottom: 30px">
                <h3>"{{$validated_search["search"]}}"の検索結果</h3>
                <a href="/admin/home">一覧へ戻す</a>
            </div>
            @else
            <h3>雇用者一覧</h3>
            @endif
            <div style="margin-left: 20px;">
            @foreach($emp_status as $status)
                <h5>{{$status->employment_status}}</h5>
                <div class="container" style="padding: 5px 10px;color: #494949; background: #FFFFCC; border-left: solid 5px #3296ff; border-bottom: solid 3px #d3d3d3; margin: 0 0 15px 5px;">
                    <div class="row">
                        <?php $forcount = 0; ?>
                        @foreach($employees as $employee)
                            @if($status->status_id == $employee->emp_status_id)
                                <?php $forcount++; ?>
                                <div class="container" style="margin-bottom: 20px;">
                                    <div>雇用者名：{{$employee->name}}</div>
                                    @if($employee->retirement_day != "0000-00-00")
                                        <div style="color: red">退職処理済み</div>
                                    @else
                                        <div>ログインURL：http://localhost:8000/home/{{$employee->login_hash}}</div>
                                    @endif
                                    <a href="/admin/show/{{ $employee->id }}">詳細</a><br>
                                </div>
                            @endif
                            @if($forcount>=2)
                                <div style="margin-left: 15px;">
                                    <a href="/admin/home/empindex/{{ $employee->emp_status_id }}">{{$status->employment_status}} 一覧へ</a>
                                </div>
                                <?php break;?>
                            @endif
                        @endforeach
                        @if($forcount==0)
                            <div style="position: relative; left:15px;">{{$status->employment_status}}の登録はありません</div>
                        @endif
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>

@endsection