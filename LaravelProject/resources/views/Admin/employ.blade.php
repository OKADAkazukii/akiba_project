<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
        <body>
            <div class="container">
            <div class="row">
            <div class="col-md-8">
                <h3>雇用形態追加</h3>
                <form action="/addemp" method="post">
                {{ csrf_field() }}
                    <table>
                     
                    <label>雇用形態名 ：<input type="text" name="emp" required></label><br>
                    <label>所定内残業料率 ：<input type="double" name="in_overtime" required></label><br>
                    <label>所定外残業料率 ：<input type="doble" name="out_overtime" required></label><br>
                    <label>所定外深夜残業料率 ：<input type="double" name="late_overtime" required></label><br>
                    <label>法定外休日出勤料率 ：<input type="double" name="holiday_work" required></label><br>
                    <label>法定外深夜残業料率 ：<input type="double" name="late_holiday" required></label><br>
                    <label>締め日 ：<input type="int" name="closing" required></label><br>
                    <input type="submit" value="送信"> 
                    </table>
            </div>
            </div>
            </div>
        </body>
</html>     
           
