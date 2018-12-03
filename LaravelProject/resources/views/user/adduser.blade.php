<title>ユーザー作成</title>
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
<script type="text/javascript" src="/js/style.js"></script>

@extends('layouts.app')
@section('content')
<div class="container" style="position:relative; left:15%;">
    <div class="head_text1">ユーザーの新規作成</div>
    <form action="/" method="post">
        <br>
        <div class="form_div">
            <div class="form_text">社員名</div>
                <input class="form" type="text" name="name" maxlength="12"/><br>
            <div class="form_text">勤務形態</div>          
            <select name="employ" style="width:30%;">
                <option value="" selected disabled hidden>選択してください</option>
                <option value="0">管理職</option>
                <option value="1">正社員</option>
                <option value="2">アルバイト</option>
            </select>
            <div class="form_text">基本給</div>
                <input type="text" value="" onblur="test(this)" size="19" maxlength="7" style="text-align: right"/>
                <div>※半角数値以外を入力するとアラートが表示されます。</div>
            <div class="form_text">ログインパスワード</div>
                <input class="form" type="password" name="password" maxlength="20"/><br>
            <br>
                <input type="submit" value="作成" class="button1">
         </div>
     </form>
</div>
@endsection


