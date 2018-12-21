@extends('layouts.app')
@section('content')
<div align='center'><h3>{{session('addholiday')}}</h3></div>
 <h3>休日設定</h3>
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
  $now = new DateTime();
  $max = $now->format('Y-m-t');
  $bbb = date('Y-m-d',mktime(0,0,0,date('m')+1,date('0'),date('Y')));

  //一日の曜日を取得してその日の一日前まで空にする
  $aaa = date('w',mktime(0,0,0,date('m'),date('1'),date('Y')));
  for ($td = 1; $td <= $aaa; $td++){
      echo "<td> </td>";
    }

  for($i = 0; $i <= 365; $i++ ){
    $day = date('Y-m-d', mktime(0, 0, 0, date('m'), date('1') + $i , date('Y'))); 
    $week = array("日","月","火","水","木","金","土");
  
    if($day == $max){
    }
  }
   $datetime = new DateTime($day);
   $days = $datetime->format('j');
     echo "<td>$days</td>";
   $w = (int)$datetime->format('w');
    if($w == 6){
      echo "</tr>";
    if($day);{
      echo "<tr>";
   }


    }
   $ccc = date("Y-m-1", strtotime($max));
dd($ccc);

          
          
                 
    ?>
  
</table>

@endsection
