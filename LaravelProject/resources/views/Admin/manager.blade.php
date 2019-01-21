<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
@extends('layouts.app')
@section('content')
<div align="center"><h3>{{session('else')}}</h3></div>
<div>
    <?php
    echo  '---',$emp_status[0]->employment_status,'---の料率変更ページ';
    ?>
</div>
<br>
<div class= row>
    <div class="col-md-6">
    <form action="/status/update" method="post">
    @csrf
        <input type="hidden" name="emp_id" value=<?php echo $emp_status[0]->employstatus_id; ?>> 
        <input type="hidden" name="id" value=<?php echo $emp_status[0]->id; ?>>
        <label>雇用形態名：<input type="text" name="emp" value=<?php echo $emp_status[0]->employment_status; ?>></label><br>
        <label>所定内残業料率：<input type="number" name="in_overtime" step="0.01" min="0" value=<?php echo $emp_status[0]->in_overtime; ?>></label><br>
        <label>所定外残業料率：<input type="number" name="out_overtime" step="0.01" min="0" value=<?php echo $emp_status[0]->out_overtime; ?>></label><br>
        <label>所定外深夜残業料率：<input type="number" name="late_overtime" step="0.01" min="0" value=<?php echo $emp_status[0]->late_overtime; ?>></label><br>
        <label>法定外休日出勤料率：<input type="number" name="holiday_work" step="0.01" min="0" value=<?php echo $emp_status[0]->holiday_work; ?>></label><br>
        <label>法定外休日残業料率：<input type="number" name="late_holiday" step="0.01" min="0" value=<?php echo $emp_status[0]->late_holiday_work; ?>></label><br>
        <label>締め日：<input type="number" name="closing" min="1" max="27" id = closingday value=<?php echo $emp_closing_day; ?>></label>
        <label>月末締め：<input type="checkbox" name="check" id = endmonch_day <?php echo $checked; ?>></label><br>
        <label>新料率開始日：<input type="date" name="new" value=<?php echo $emp_status[0]->apply_start; ?>></label><br>
        <input type="submit" value="更新">
    </form>
</div>
<div class ="col-md-6">
　<?php
    echo '<font size="5">','<label>','---履歴---','</font>','</label>','<br>';
    $i = 0 ;
    foreach ($emp_status as $value){
      if($i==0){
        $i=1;
        continue;}
        '<div>';
        echo '<font size="3">','<label>',"～$i 回前～",'</font>','</label>','<br>'; 
        echo '<font size="3">','<label>','所定内残業料率：',$value->in_overtime,'</font>','</label>','<br>'; 
        echo '<font size="3">','<label>','所定外残業料率：',$value->out_overtime,'</font>','</label>','<br>'; 
        echo '<font size="3">','<label>','所定外深夜残業料率：',$value->late_overtime,'</font>','</label>','<br>'; 
        echo '<font size="3">','<label>','法定外休日出勤料率：',$value->holiday_work,'</font>','</label>','<br>';
        echo '<font size="3">','<label>','法定外休日残業料率：',$value->late_holiday_work,'</font>','</label>','<br>';
        $i++;
        '</div>';
      }
    ?>
</div>
</div>
<script>
  $(function(){
    var check = $('#closingday');
    check.on('change', function(event){
    document.getElementById('endmonch_day').checked = false;
    });
  });

  $(function() {
    var endmonch = $('#endmonch_day');
    endmonch.on('click',function(event){
      document.getElementById('closingday').value = ("");
    });
  }); 

</script>

@endsection
        






