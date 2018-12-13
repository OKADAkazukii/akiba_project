<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf8">
        <title>設定</title>
    </head>
    <body>
         <h3>管理者ページ</h3>
         <br><br>
             <form action="/manager" method="post">
                {{ csrf_field() }}
             <label>名前 :<input type="text" name="name" required></label><br>
             <input type="submit" value="送信">
             </form>
　　<br><br>　　
    </body>
</html>
