@extends('layouts.app')
@section('content')
<div>
    <?php
    echo $emp_status[0]->employment_status,'の料率変更ページ';
    ?>
</div>
<div>
    <form action="/status/update" method="post">
    @csrf
        <input type="hidden" name="id" value=<?php echo $emp_status[0]->id; ?>>
        <label>所定内残業料率:<input type="number" name="emp" step="0.01" value=<?php echo $emp_status[0]->in_overtime; ?>><br>
        <input type="text" name="" value=<?php echo $emp_status[0]->employment_status; ?>><br>
        <input type="text" name="" value=<?php echo $emp_status[0]->employment_status; ?>><br>
        <input type="text" name="" value=<?php echo $emp_status[0]->employment_status; ?>><br>
        <input type="text" name="" value=<?php echo $emp_status[0]->employment_status; ?>><br>
        <input type="text" name="" value=<?php echo $emp_status[0]->employment_status; ?>><br>
        <input type="text" name="" value=<?php echo $emp_status[0]->employment_status; ?>><br>
        
        <input type="submit" value="更新">
    </form>
</div>    






@endsection
