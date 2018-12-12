<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
<script type="text/javascript">
function submitcheck() {
    var check = confirm('退勤処理をすると、休憩時間の変更ができなくなります');
    return check;
}
</script>

@extends('layouts.app')
@section('content')
<?php
$hour_check = date("H");
if($hour_check >= 5 && $hour_check <= 10){
    $hello = "おはようございます、";
}elseif($hour_check >= 11 && $hour_check <= 17){
    $hello = "こんにちは、";
}elseif($hour_check >= 18 || $hour_check <= 4){
    $hello = "こんばんは、";
}
?>
<h4 class="hello">{{$hello}}<p class="hello-name">{{$current_employee->name}}</p>さん</h4>
<div class="container-fluid">
    <div>
        @if (session('message'))
            <div class="alert alert-danger">{{ session('message') }}</div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="time-area">
                <div class="main-time-area">
                <?php
                    $week=array("日","月","火","水","木","金","土");
                    echo date('Y年m月d日');
                    echo "(".$week[date('w')].")";
                ?>
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        <form action="/starttime" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$current_employee->id}}" name="emp_id">
                            @if($start_time != "---------")
                                <button type="submit" class="btn btn-default" style="padding:10px 20px;font-size:30px;color:gray;margin-right:15px;">出勤</button>
                            @else
                                <button type="submit" class="btn btn-info" style="padding:10px 20px;font-size:30px;color:white;margin-right:15px;">出勤</button>
                            @endif
                            <div style="position:relative; left:20%;">
                                <?php
                                    if(isset($start_time)){
                                        echo $start_time;
                                    }
                                ?>
                            </div>
                        </form>
                        <form action="/finishtime" method="post">
                            <input type="hidden" value="{{$current_employee->id}}" name="emp_id">
                            {{ csrf_field() }}
                            @if($start_time == "---------")
                                <button type="submit" class="btn btn-default" style="padding:10px 20px;font-size:30px; color:gray;">退勤</button>
                            @else
                                <button type="submit" class="btn btn-success" style="padding:10px 20px;font-size:30px;" onclick="return submitcheck();">退勤</button>
                            @endif
                        </form>
                    </div>
                    <div class="row justify-content-center">
                        <form action="/resttime" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$current_employee->id}}" name="emp_id">
                            <p class="rest-text">休憩時間 :</p>
                            <input style="width:80px;" type="time" size="20" name="rest" class="rest-text-form" value="01:00"></input><br>
                            <p class="rest-text2">深夜休憩 :</p>
                            <input style="width:80px;" type="time" size="20" name="late_rest" class="rest-text-form" value="00:00"></input>
                            <div class="row justify-content-end">
                                <input type="submit" value="更新"></input>
                            </div>
                        <form>
                    </div>
                </div>
            </div>
                <div class="main-sum-area">
                    <div class="sum-area">集計勤務時間</div>
                    <div style="margin-left:10px;">
                        <div>11/21~12/20<br>(締め日の次の日〜次の月の締め日)</div>
                        <div>基本月給：{{$current_employee->basic_salary}}円</div>
                        <div>勤務時間：</div>
                        <div>勤務時間：</div>
                        <div>所定内残業：</div>
                        <div>所定外残業：</div>
                        <div>深夜勤務：</div>
                        <div>深夜残業：</div>
                        <div>休日勤務：</div>
                        <div>休日深夜：</div>
                    </div>
                </div>


        </div>
        <div class="col-md-8">
            <div class="main-time-area" style="margin-bottom:0;width:944px;">
                <?php
                    //一ヶ月前日時取得の場合の記述→  $countdate = date("m", strtotime("-1 month"));
                    $countdate = date("t");
                    $now_year = date("Y");
                    $now_month = date("m");
                    $now_day = date("j");
                    echo $now_year."年".$now_month."月"."1日〜".$countdate."日";
                ?>
            </div>
            <div style="border-bottom:solid 2px gray;width:944px; background-color:#FFFFDD;">
                <div class="excel" style="border-left:solid 1px gray;">日付</div>
                <div class="excel">出勤時間</div>
                <div class="excel">退勤時間</div>
                <div class="excel">休憩時間</div>
                <div class="excel">実働時間</div>
                <div class="excel">所定内残業</div>
                <div class="excel">所定外残業</div>
                <div class="excel">深夜勤務</div>
                <div class="excel">深夜残業</div>
                <div class="excel">深夜休憩</div>
                <div class="excel">休日勤務</div>
                <div class="excel">休日深夜</div>
            </div>
            <div style="width:944px;">
                <?php
                    foreach($holidays_list as $holiday){
                        $holidays[] = $holiday->holiday;
                    }
                     //--↓年末休みの定義↓--
                    $currentYear = intval(date('Y'));
                    for ($i = 0; $i < 1; $i++) { // 1年分取得、変更可
                        $y = $currentYear + $i;
                        $date = date("Y-m-d", mktime(0,0,0,12,29,$y)); // 12月29日の取得、いつから休みなのか再度確認必要一応今の実装では30?3日
                            for ($j = 0; $j < 5; $j++) { // 5日間
                                $date = date("Y-m-d", strtotime("$date +1 day"));
                                $holidays[] = $date;
                            }
                    }
                    //--↑年末休みの定義↑--
                ?>
                @for($day=1;$day<=$countdate;$day++)
                    <div style="border-bottom:solid 1px gray;">
                        <div 
                            <?php
                                $w = date("w", mktime( 0, 0, 0, $now_month, $day, $now_year ));
                                $d = date("Y-m-d", mktime( 0, 0, 0, $now_month, $day, $now_year ));
                                switch($w){
                                    case 0:
                                        echo 'class="excel" style="color:red;border-left:solid 1px gray;">'.$now_month.'/'.$day.'('.$week[date("$w")].')';
                                        break;
                                    case 6:
                                        if(in_array($d,$holidays)){
                                            echo 'class="excel" style="color:red;border-left:solid 1px gray;">'.$now_month.'/'.$day.'('.$week[date("$w")].')';
                                        }else{
                                            echo 'class="excel" style="color:#3366FF;border-left:solid 1px gray;">'.$now_month.'/'.$day.'('.$week[date("$w")].')';
                                        }
                                        break;
                                    default:
                                        if(in_array($d,$holidays)){
                                            echo 'class="excel" style="color:red;border-left:solid 1px gray;">'.$now_month.'/'.$day.'('.$week[date("$w")].')';
                                        }else{
                                            echo 'class="excel" style="border-left:solid 1px gray";>'.$now_month.'/'.$day.'('.$week[date("$w")].')';
                                        }
                                }
                            ?>
                        </div>
                        <div class="excel">
                            <div>
                                <?php
                                    $brank_check=0;
                                    foreach ($attendances as $attendance){
                                        if($attendance->day == $d){
                                            echo $attendance->start_time;
                                            $brank_check=1;
                                            break;
                                        }
                                    }
                                    if($brank_check==0){
                                        echo "---";
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="excel">
                            <div>
                                <?php
                                    $brank_check=0;
                                    foreach ($attendances as $attendance){
                                        if($attendance->day == $d && $attendance->finish_time != "00:00:01"){
                                            echo $attendance->finish_time;
                                            $brank_check=1;
                                            break;
                                        }
                                    }
                                    if($brank_check==0){
                                        echo "---";
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="excel">
                            <div>
                                <?php
                                    $brank_check=0;
                                    foreach ($attendances as $attendance){
                                        if($attendance->day == $d){
                                            $minutes = str_pad($attendance->rest_time%60, 2, 0, STR_PAD_LEFT);
                                            $hours = str_pad(floor(($attendance->rest_time/60)%60), 2, 0, STR_PAD_LEFT);
                                            $display_rest_time = $hours.":".$minutes.":00";
                                            echo $display_rest_time;
                                            $brank_check=1;
                                            break;
                                        }
                                    }
                                    if($brank_check==0){
                                        echo "---";
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="excel">
                            <div>
                            <?php
                                $brank_check=0;
                                foreach ($attendances as $attendance){
                                    if($attendance->day == $d && $attendance->finish_time != "00:00:01"){
                                        //退勤時間-出勤時間-休憩時間
                                        $finish = strtotime("$attendance->day $attendance->finish_time");
                                        $start = strtotime("$attendance->day $attendance->start_time");
                                        $diff = $finish-$start;
                                        if($diff<0){
                                                $diff = (24*3600)+$diff;
                                        }
                                        $rest = $attendance->rest_time*60;
                                        $diff -= $rest;
                                        $seconds = str_pad($diff%60, 2, 0, STR_PAD_LEFT);
                                        $minutes = str_pad(floor(($diff/60)%60), 2, 0, STR_PAD_LEFT);
                                        $hours = str_pad(floor($diff/3600), 2, 0, STR_PAD_LEFT);
                                        if($diff>=0){
                                            echo $hours.":".$minutes.":".$seconds;
                                        }else{
                                            echo "Error";
                                        }
                                        $brank_check=1;
                                        break;
                                    }
                                }
                                if($brank_check==0){
                                    echo "---";
                                }
                            ?>
                            </div>
                        </div>
                        <div class="excel">
                            <div>---</div>
                        </div>
                        <div class="excel">
                            <div>---</div>
                        </div>
                        <div class="excel">
                            <div>---</div>
                        </div>
                        <div class="excel">
                            <div>---</div>
                        </div>
                        <div class="excel">
                            <div>
                                <?php
                                    $brank_check=0;
                                    foreach ($attendances as $attendance){
                                        if($attendance->day == $d){
                                            $minutes = str_pad($attendance->late_rest_time%60, 2, 0, STR_PAD_LEFT);
                                            $hours = str_pad(floor(($attendance->late_rest_time/60)%60), 2, 0, STR_PAD_LEFT);
                                            $display_late_rest_time = $hours.":".$minutes.":00";
                                            echo $display_late_rest_time;
                                            $brank_check=1;
                                            break;
                                        }
                                    }
                                    if($brank_check==0){
                                        echo "---";
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="excel">
                            <div>---</div>
                        </div>
                        <div class="excel">
                            <div>---</div>
                        </div>
                    </div>
                @endfor

            </div>
        <div>
    </div>
</div>
@endsection
