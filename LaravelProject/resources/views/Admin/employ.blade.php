<script type="text/javascript" src="/js/style.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
@extends('layouts.app')
@section('content')
@if (session('result'))
<<<<<<< HEAD
    <div align="center" class="alert alert-success">{{ session('result') }}</div>
@endif
@if (session('elseemp'))
    <div align="center" class="alert alert-danger">{{session('elseemp')}}</div>
@endif
@if (session('return'))
    <div align="center" class="alert alert-danger">{{session('return')}}</div>
=======
    <div id="result" align="center" class="alert alert-danger">{{ session('result') }}</div>
@endif
@if (session('elseemp'))
    <div id="elseemp" align="center" class="alert alert-danger">{{session('elseemp')}}</div>
@endif
@if (session('return'))
    <div id="return" align="center" class="alert alert-danger">{{session('return')}}</div>
>>>>>>> 0aff3d8acf976050af048078ddbba170c9b97741
@endif
    <h3>雇用形態追加</h3>
    <form action="/addemp" method="post">
        {{ csrf_field() }}
        <table>
            <label>雇用形態名 ：<input type="text" name="emp" value="{{ session('emp') }}"required></label><br>
            <label>所定内残業料率 ：<input type="number" name="in_overtime" step="0.01" min="0" value="{{ session('in') }}"required></label><br>
            <label>所定外残業料率 ：<input type="number" name="out_overtime" step="0.01" min="0" value="{{ session('out') }}"required></label><br>
            <label>所定外深夜勤務料率 ：<input type="number" name="late_worktime" step="0.01" min="0" value="{{ session('late_work') }}"required></label><br>
            <label>所定外深夜残業料率 ：<input type="number" name="late_overtime" step="0.01" min="0" value="{{ session('late_over') }}"required></label><br>
            <label>法定外休日出勤料率 ：<input type="number" name="holiday_work" step="0.01" min="0" value="{{ session('holiday') }}"required></label><br>
            <label>法定外深夜残業料率 ：<input type="number" name="late_holiday" step="0.01" min="0" value="{{ session('late_holi') }}" required></label><br>
            <label>締め日 ：<input type="number" min="1" max="27" name="closing" id ="closingday"></label>
            <label>月末締め：<input type="checkbox" name="check" id="last_day"></label><br>
            <label>新料率開始日：<input type="date" name="new" value="{{ session('new') }}"required></label><br>
            <input type="submit" value="送信">
        </table>
    </form>
<script>
$(function(){
    var check = $('#closingday');
    check.on('change', function(event){
        document.getElementById('last_day').checked = false;
    });
});
$(function() {
    var lastday = $('#last_day');
    lastday.on('click',function(event){
        document.getElementById('closingday').value = ("");
    });
});
$(document).ready(function(){
    setTimeout(function(){
        $('#result').fadeOut(3000)
        $('#elseemp').fadeOut(3000)
        $('#return').fadeOut(3000)
    });
});
</script>
@endsection
