<!DOCTYPE html>
<head>
  <meta chareset="utf-8">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <title>カレンダー</title>
</head>
<body>
  <div>
    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
</div>
 <div class="container">
    <div class="row">
        <div class="col-md-8">
        <h3>休日設定</h3>
        <br><br>
        <form action="/test" method="post">
        {{ csrf_field() }}
        <label>日付 :<input type="date" name="date" required></label>
        <input type="submit" value="送信">
        </form>
  <?php




    $conf_horiday = true;
    $cals = array();
    $res = file_get_contents('http://www8.cao.go.jp/chosei/shukujitsu/syukujitsu_kyujitsu.csv');
    $res = mb_convert_encoding($res, "UTF-8", "SJIS");
    $pieces = explode("\r\n", $res);
    $dummy = array_shift($pieces);
    $dummy = array_pop($pieces);


    foreach ($pieces as $key => $value) {
     $temp = explode(',', $value);
      $horidays[] = $temp[0];
      $horiname[] = $temp[1];
    }





    $ym_now = date("Ym");
    $y = substr($ym_now,0,4);
    $m = substr($ym_now,4,2);
    ?>
    <div class="table-responsive">
      <!-- table class="table table-bordered" style="table-layout:fixed;" -->
      <table class="table table-bordered">
        <thead>
         <tr>
           <th class="danger"><span class="text-danger">日</span></th>
           <th>月</th>
           <th>火</th>
           <th>水</th>
           <th>木</th>
           <th>金</th>
           <th class="info"><span class="text-info">土</span></th>
         </tr>
        </thead>
        <tbody>
          <tr>
    <?php

  $wd1 = date("w",mktime(0,0,0,$m,1,$y));
  for ($i = 1; $i <= $wd1; $i++) {
      echo "<td> </td>";
      }
  $day = date('Y-m-d', mktime(0, 0, 0, date('m'), date('1') + $i, date('Y')));

  $lastday = $day;

  $days[$i]['day'] = $day;

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
       if ($day == $lastday){

      $target_day = date("Y-m-1", strtotime($lastday));
      $lastday = date("Y-m-t",strtotime($target_day . "+1 month"));
      $cals[] = $days;
      $days = array();
      }
  $d = 1;
   while(checkdate($m,$d,$y)){
       echo "<td>$d</td>";
     if (date("w",mktime(0,0,0,$m,$d,$y)) == 6 ) {
         echo "</tr>";
     if (checkdate($m,$d +1,$y)) {
         echo "<tr>";
         }
       }
        $d++;
      }
    $wdx = date("w",mktime(0,0,0,$m +1,0,$y));
    for ($i = 1; $i < 7 - $wdx; $i++) {
        echo "<td> </td>";
        }

    ?>



<form action="/holidayupdate" method="post">
  {{ csrf_field() }}
  <button style="position:relative; top:600px;" type="submit" class="btn btn-success">祝日更新</button>
</form>