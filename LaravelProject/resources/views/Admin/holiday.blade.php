@extends('layouts.app')
@section('content')
<div align='center'><h3>{{session('addholiday')}}</h3></div>
 <h3>休日設定</h3>
   <br><br>
      <form action="/addholiday" method="post">
        {{ csrf_field() }}
        <label>日付 :<input type="date" name="date" required></label>
        <input type="submit" value="送信">
        </form>

        <form action="/holidayupdate" method="post">
          {{ csrf_field() }}
          <button type="submit" class="btn btn-success">祝日更新</button>
        </form> 

<?php
  //Control 日付作成処理
  // １ヶ月分の日付を格納
  $days = array();
  // １年分の日付を格納
  $cals = array();
  //今月の最終日を格納
  $lastday = date('Y-m-t');

  //祝日設定処理
  $conf_horiday = true;
  if ($conf_horiday) {
    $horidays = array();
    $horiname = array();
    // 内閣府ホームページの"国民の祝日について"よりデータを取得する
    $res = file_get_contents('http://www8.cao.go.jp/chosei/shukujitsu/syukujitsu_kyujitsu.csv');
    $res = mb_convert_encoding($res, "UTF-8", "SJIS");
    $pieces = explode("\r\n", $res);
    $dummy = array_shift($pieces);
    $dummy = array_pop($pieces);

    foreach ($pieces as $key => $value) {
     $temp = explode(',', $value);
      $horidays[] = $temp[0];  //日付を設定
      $horiname[] = $temp[1];  //祝日名を設定
    }
  }

  for ($i = 0; $i <= 365; $i++) {
    //日付を１日ずつ増やしていく mktime(hour, minute, second, month, day, year)
    $day = date('Y-m-d', mktime(0, 0, 0, date('m'), date('1') + $i, date('Y')));
    //日付を格納する
    $days[$i]['day'] = $day;
    //祝日を設定する
    if ($conf_horiday) {
      $ind = array_search($day,$horidays);
      if ($ind){
        $days[$i]['hori'] = $horiname[$ind];
      } else {
        $days[$i]['hori'] = '';
      }
    } else {
      $days[$i]['hori'] = '';
    }
    //その他必要な処理をここに追加する
    //$days[$i]['hoge'] = '';

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
    <div class="table-responsive">
      <!-- table class="table table-bordered" style="table-layout:fixed;" -->
      <table class="table table-bordered">
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
  for($i = 0; $i <= 365; $i++ ){
    $day = date('Y-m-d', mktime(0, 0, 0, date('m'), date('1') + $i , date('Y')));
    $datetime = new DateTime($day);

    $days = $datetime->format('j');
    echo "<td>$days</td>"; 
    $week = array("日","月","火","水","木","金","土");
    $w = (int)$datetime->format('w');
    $aaa = $week[$w];
    if($w === 6){
      echo "</tr>";
    }
  } 
    if($day == $max){
      echo "</tr>";
    }
    $aaa = date('w',mktime(0,0,0,date('m'),date('1'),date('Y')));
    for ($td = 1; $td <= $aaa; $td++){
      echo "<td> </td>";
    } 
          
          
                 

    ?>
  </tbody>
</table>

@endsection
