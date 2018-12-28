@extends('layouts.app')
@section('content')
    <div>
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
    </div>
   <br><br>
      <form action="/holidayupdate" method="post">
        {{ csrf_field() }}
        <button style="position:relative; top:600px;" type="submit" class="btn btn-success">祝日更新</button>
      </form>
      <form action="/addholiday" method="post">
        {{ csrf_field() }}
          <label>日付 :<input type="date" name="date" required></label>
           <input type="submit" value="送信">
      </form>
      <table>
        <thead>
          <tr>
            <th>日</th>
            <th>月</th>
            <th>火</th>
            <th>水</th>
            <th>木</th>
            <th>金</th>
            <th>土</th>
          </tr>
  </thead>
      <tbody>
<?php
  $days = array();
  $cals = array();
  $now = new DateTime();

  //一日の曜日を取得してその日の一日前まで空にする
  $firstday = date('w',mktime(0,0,0,date('m'),date('1'),date('Y')));
    for ($td = 1; $td <= $firstday; $td++){
    echo "<td></td>"; 
    }

  for ($i = 0; $i <= 365; $i++ ){
  $day = date('Y-m-d', mktime(0, 0, 0, date('m'), date('1') + $i , date('Y')));
  $days[$i] = $day;
 
  $datetime = new DateTime($day);
  $formday = $datetime->format('j');
    echo "<td>$formday</td>";

   $w = (int)$datetime->format('w');
   $max = $datetime->format('Y-m-t');

    if($max == $day){
      echo "</tr>" ;
    }
    if($w == 6){
      echo "</tr>";
    if($day){
      echo "<tr>";
      }
    }
  }


    ?>
</table>

@endsection
