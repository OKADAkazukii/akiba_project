<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CalendarController extends Controller
{
    public function calendar
  
<?php
  //Control 日付作成処理
  // １ヶ月分の日付を格納
  $days = array();
 // １年分の日付を格納
  $cals = array();
  //今月の最終日を格納、指定した月の日数
  $lastday = date('Y-m-t');

  for ($i = 0; $i <= 365; $i++) {
   //日付を格納する
    $days[$i]['day'] = $day;

    $holi = DB::table('holidays')->where('holiday','=',$date)->get();
dd($holi);
        


    if ($day == $lastday){
      //月末日の処理
      //次の月末日で更新する
      $target_day = date("Y-m-1", strtotime($lastday));
      $lastday = date("Y-m-t",strtotime($target_day . "+1 month"));
      //月ごとに格納する
      $cals[] = $days;
      $days = array();
   }
  }
?>




  <div class="container">
    <h1>カレンダー（祝日つき）</h1>
<?php
  //View 表示処理
  //$weeklavel = array("日", "月", "火", "水", "木", "金", "土");
  //echo $weeklavel[$ww];
  foreach ($cals as $key => $mm) {
    foreach ($mm as $key => $dd) {
      //月を表示する
      $dayD = new DateTime($dd['day']);
      echo '<h3>'.$dayD->format('Y').'年'.$dayD->format('n').'月</h3>';
      break;
    }
?>
      <table class="table table-bordered">
        <thead>
            <th>月</th>
            <th>火</th>
            <th>金</th>
            <th class="info"><span class="text-info">土</span></th>
         </tr>
        </thead>
        <tbody>
          <tr>
<?php
    $j = 0;
    $first = true;
    foreach ($mm as $key => $dd) {
      $dayD = new DateTime($dd['day']);
      $ww = $dayD->format('w');

      if ($first){
        //月の初めの開始位置を設定する
        for ($j = 0; $j < $ww; $j++) {
          //$jはこの後も使用する
          echo '<td></td>';
        }
        $first = false;
      }
      if ($dd['hori']){
        //祝日
      } elseif($j == 0) {
        //日曜日
        echo '<td class="danger"><span class="text-danger">'.$dayD->format('j').'</span></td>';
      } elseif($j == 6) {
        //土曜日
        echo '<td class="info"><span class="text-info">'.$dayD->format('j').'</span></td>';
      } else {
        //その他平日
        echo '<td>'.$dayD->format('j').'</td>';
      }

      $j = $j + 1;
      if ($j >= 7){
        //土曜日で折り返す
        echo '</tr><tr>';
        $j = 0;
      }
    }  //月ごとの foreach ここまで
?>
}
