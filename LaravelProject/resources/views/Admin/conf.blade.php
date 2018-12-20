@extends('layouts.app')
@section('content')

    <h3>雇用形態別料率変更</h3>

    <?php
     
    foreach ($status as $value){
    echo '<font size="5">','<a href="/manager/',$value->id,'">',$value->employment_status,'</font>','</a>','<br>'; 
    }
    ?>
@endsection
