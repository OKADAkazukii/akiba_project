@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
<?php
function h($s){
  return htmlspecialchars($s,ENT_QUOTES,'UTF-8');
}

try{
  if(!isset($_GET{$t})|| !preg_match('/\A\d{4}-\d{2}\z/',$_GET{$t})){
    throw new Exception();
  }
  $thisMonth = new DateTime($_GET{$t});
} catch (Exception $e){
  $thisMonth = new DateTime('first day of this month');
}

$dt = clone $thisMonth;
$prev = $dt->modify('-1 month')->format('Y m');
$dt = clone $thisMonth;
$next = $dt->modify('+1 month')->format('Y m');

$yearMonth = $thisMonth->format('F Y');



$tail = '';
$lastDayOfPrevMonth = new DateTime('last day of '.$yearMonth.'-1 month');
while ($lastDayOfPrevMonth->format('w') < 6){
  $tail =sprintf('<td class="gray">%d</td>',$lastDayOfPrevMonth->format('d')).$tail;
  $lastDayOfPrevMonth->sub(new DateInterval('P1D'));
}

$body = '';
$period = new DatePeriod(
  new DateTime('first day of '.$yearMonth),
  new DateInterval('P1D'),
  new DateTime('first day of '.$yearMonth.'+1 month')
);

$holidays ='';
$holi ='';
//土曜日で折り返す処理,曜日に色を付ける処理
foreach ($period as $day){
  if($day->format('w') % 7=== 0){ $body .= '</tr><tr>';}
  $body .= sprintf('<td class="youbi_%d">%d</td>',$day->format('w'),$day->format('d'));         
}

foreach ($period as $days){
  $holidays = $days->format('Y-m-d');
  foreach ($holiget as $holigets){
      if($holigets->holiday == $holigets){
      $holi = sprintf('<td class="holiday">%d</td>',$days->format('Y-m-d')); 
    }
  }
}

//来月1たちの曜日から月末の土曜まで表示
$head = '';
$firstDayOfNextMonth = new DateTime('first day of'.$yearMonth.'+1 month');
while ($firstDayOfNextMonth->format('w')>0){
  $head .= sprintf('<td class="gray">%d</td>',$firstDayOfNextMonth->format('d'));
  $firstDayOfNextMonth->add(new DateInterval('P1D'));
}
?>
<body>
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
      <th><a href="holiday/?t=<?php echo h($prev);?>">&laquo;</a></th>
      <th colspan="5"><?php echo h($yearMonth); ?></th>
      <th><a href="holiday/?t=<?php echo h($next);?>">&raquo;</a></th>
    </tr>   
  </thead>
  <tbody>
    <tr>
    <td>Sun</td>
    <td>Mon</td>
    <td>The</td>
    <td>Wed</td>
    <td>Thu</td>
    <td>Fri</td>
    <td>Sat</td>
    </tr>
    <tr>
    <?php echo $tail .$body .$holi .$head ;?> 
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <th colspan="7"><a href="/holiday">Today</a></th>
    </tr>
  </tfoot>       
  </table>
</body>
@endsection
