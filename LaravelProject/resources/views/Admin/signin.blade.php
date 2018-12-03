@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>管理者ページ</title>
    </head>
    <body>
        <h3>管理者ページ</h3>
            <a href="/holyday">休日設定</a><br>
            <a href="/user">ユーザー情報</a><br>
            <a href="/conf">設定</a><br>
            <a href="add">ユーザー新規追加</a><br>
    </body>
</html>

@endsection    
