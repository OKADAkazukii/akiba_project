@extends('layouts.app')
@section('content')
<div align="center"><h3>{{session('else')}}</h3></div>
<div>
    <?php
    echo $emp_status[0]->employment_status,'の料率変更ページ';
    ?>
</div>
<div>
    <form action="/status/update" method="post">
    @csrf

        <input type="hidden" name="id" value=<?php echo $emp_status[0]->id; ?>>
        <label>雇用形態名変更：<input type="text" name="emp" value=<?php echo $emp_status[0]->employment_status; ?>></label><br>
        <label>所定内残業料率：<input type="number" name="in_overtime" step="0.01" min="0" value=<?php echo $emp_status[0]->in_overtime; ?>></label><br>
        <label>所定外残業料率：<input type="number" name="out_overtime" step="0.01" min="0" value=<?php echo $emp_status[0]->out_overtime; ?>></label><br>
        <label>所定外深夜勤務料率：<input type="number" name="late_worktime" step="0.01" min="0" value=<?php echo $emp_status[0]->late_worktime; ?>></label><br>
        <label>所定外深夜残業料率：<input type="number" name="late_overtime" step="0.01" min="0" value=<?php echo $emp_status[0]->late_overtime; ?>></label><br>
        <label>法定外休日出勤料率：<input type="number" name="holiday_work" step="0.01" min="0" value=<?php echo $emp_status[0]->holiday_work; ?>></label><br>
        <label>法定外休日残業料率：<input type="number" name="late_holiday" step="0.01" min="0" value=<?php echo $emp_status[0]->late_holiday_work; ?>></label><br>
        <label>締め日：<input type="number" name="closing" min="1" max="27" value=<?php echo $emp_status[0]->closing_day; ?>></label>
        <label>月末締め <input type="checkbox" name="check"></label><br>
        <input type="submit" value="更新">
    </form>
</div>






@endsection
