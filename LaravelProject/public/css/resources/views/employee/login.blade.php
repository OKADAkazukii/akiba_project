<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
<title>login form</title>

@extends('layouts.app')
@section('content')
<div class="container" style="position:relative; left:15%;">
    <div class="head_text1">ログインフォーム</div>
    <form action="/" method="post">
        <br>
        <div class="form_div">
            <div class="form_text">名前</div>
            <input class="form" type="text" name="username" maxlength="12"/><br>
            <div class="form_text">パスワード</div>
            <input class="form" type="password" name="password" maxlength="20"/><br>
            <br>
            <input type="submit" value="ログイン" class="button1">
         </div>
         <a href="/new.html">パスワードを忘れた方はコチラ</a>
     </form>
</div>
@endsection


