@extends('layouts.app')
@section('content')

<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <title>ログイン</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div align="center">
                        <table border="0">
                            <h3>管理者ログイン</h3>
                                <br><br>
                                    <form action="Admin/signin" method = "post">
                                    {!! csrf_field() !!}
                                        <tr>
                                            <th>
                                    User_name
                                            </th> 
                                            <td>    
                                    <input type = "text" name ="name" value = "">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>       
                                    Password
                                            </th>
                                            <td>
                                    <input type = "password" name = "password" value = "">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"> 
                                   <input type = "submit" name = "login" value = "ログイン">
                                            </td>
                                        </tr>
                                    </form>
                        </table>  
                </div>
            </div>
        <div>  
    </body>
</html>






@endsection
