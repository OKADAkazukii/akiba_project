@extends('layouts.app')
@section('content')
<div align="center"><h3>{{ session('result') }}</h3></div>
<div align="center"><h3>{{session('elseemp')}}</h3></div>
<div align="center"><h3>{{session('return')}}</h3></div>
     <h3>雇用形態追加</h3>
</div>
       <form action="/addemp" method="post">
           {{ csrf_field() }}
               <table>
                   <label>雇用形態名 ：<input type="text" name="emp" value="{{ session('emp') }}"required></label><br>
                   <label>所定内残業料率 ：<input type="number" name="in_overtime" step="0.01" min="0" value="{{ session('in') }}"required></label><br>
                   <label>所定外残業料率 ：<input type="number" name="out_overtime" step="0.01" min="0" value="{{ session('out') }}"required></label><br>
                   <label>所定外深夜勤務料率 ：<input type="number" name="late_worktime" step="0.01" min="0" value="{{ session('late_work') }}"required></label><br>
                   <label>所定外深夜残業料率 ：<input type="number" name="late_overtime" step="0.01" min="0" value="{{ session('late_over') }}"required></label><br>
                   <label>法定外休日出勤料率 ：<input type="number" name="holiday_work" step="0.01" min="0" value="{{ session('holiday') }}"required></label><br>
                   <label>法定外深夜残業料率 ：<input type="number" name="late_holiday" step="0.01" min="0" value="{{ session('late_holi') }}"required></label><br>
                   <label>締め日 ：<input type="number" min="1" max="27" name="closing" ></label>
                   <label>(末日)<input type="checkbox" name="check"></label><br>
                   <input type="submit" value="送信">
               </table>
@endsection
