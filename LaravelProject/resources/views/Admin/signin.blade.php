<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <h3>管理者機能リンク</h3>
            <a href="/addemployee">雇用者の追加</a><br>
            <a href="/holiday">休日設定</a><br>
            <a href="/timesettingse">時間関連設定</a><br>
            <a href="/conf">設定</a><br>
            <a href="/employ">勤務形態</a><br>
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
                            @if($status->id == $employee->emp_status_id)
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
                                <div style="margin-left: 15px;">{{$status->employment_status}} 一覧...</div>
                                <?php break;?>
                            @endif
                        @endforeach
                        @if($forcount==0)
                            <div style="position: relative; left:15px;">登録 0件</div>
                        @endif
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>

<?php
//--↓ページネーション↓--
$employees_a=array();
foreach($employees as $employee){
    $employees_a[]=array('name' => $employee->name,'login_hash' => $employee->login_hash);
    $test=array();
}
define('MAX','3'); // 1ページの記事の表示数
$employees_num = count($employees_a); // トータルデータ件数
$max_page = ceil($employees_num / MAX); // トータルページ数※ceilは小数点を切り捨てる関数
if(!isset($_GET['page_id'])){ // $_GET['page_id'] はURLに渡された現在のページ数
    $now = 1; // 設定されてない場合は1ページ目にする
}else{
    $now = $_GET['page_id'];
}
$start_no = ($now - 1) * MAX; // 配列の何番目から取得すればよいか
// array_sliceは、配列の何番目($start_no)から何番目(MAX)まで切り取る関数
$disp_data = array_slice($employees_a, $start_no, MAX, true);

// データ表示
foreach($disp_data as $val){
    echo $val["name"]."<br>".$val["login_hash"]."<br>";
}

for($i = 1; $i <= $max_page; $i++){ // 最大ページ数分リンクを作成
    if ($i == $now) { // 現在表示中のページ数の場合はリンクを貼らない
        echo $now. '　';
    } else {
        echo '<a href=\'/admin/home/?page_id='. $i. '\')>'. $i. '</a>'. '　';
    }
}
//--↑ページネーション↑--
?>

@endsection
