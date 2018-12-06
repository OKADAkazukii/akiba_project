@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>設定変更ページ</title>
    </head>
    <body>
        <h3>管理者ページ</h3>
            <a href="/holyday">休日設定</a><br>
            <a href="/overtime">残業発生時間変更</a><br>
            <a href="/conf">設定</a><br>
            <a href="/detail">ユーザ詳細</a><br>
    <div>ユーザ情報を表示させる</div>
    </body>
</html>

@endsection    
