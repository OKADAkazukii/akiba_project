<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
<script type="text/javascript">
function submitcheck() {
    var check = confirm('退勤処理をすると、休憩時間の変更ができなくなります');
    return check;
}
</script>
<?php
    function seconds_change_to_time($seconds){
        $minutes = str_pad(floor(($seconds/60)%60), 2, 0, STR_PAD_LEFT);
        $hours = str_pad(floor($seconds/3600), 2, 0, STR_PAD_LEFT);
        $time = $hours.":".$minutes.':00';
        return $time;
    }
?>

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
                        </form>
                    </div>
                </div>
            </div>
                <div class="main-sum-area">
                    <div class="sum-area">ユーザー情報</div>
                    <div style="margin-left:10px;">
                        <div>従業員名：{{$current_employee->name}}</div>
                        <div>基本月給：{{$current_employee->basic_salary}}円</div>
                        <div>勤務形態：{{$emp_status->employment_status}}</div>
                        <div>給与締日：毎月 {{$emp_status->closing_day}}日</div>
                        <div>基本勤務：{{$current_employee->basic_work_time}}分 / 日</div>
                    </div>
                </div>
        </div>
        <div class="col-md-8">
            <div class="main-time-area" style="margin-bottom:0;width:758px;">
                <?php
                    $countdate = date("t");
                    $now_year = date("Y");
                    $now_month = date("m");
                    $before_month = date("Y-m", strtotime("-1 month"));
                    $next_month = date("Y-m", strtotime("+1 month"));
                    $now_day = date("j");
                    if($now_day > $emp_status->closing_day){
                        $closing_day = date('Y-m')."-".$emp_status->closing_day;
                        $target_day = strtotime($closing_day." "."00:00:00");
                        $closing_afterday = date('Y-m-d', strtotime('+1 day', $target_day));
                        $next_closing_day = $next_month."-".$emp_status->closing_day;
                    }else{
                        $closing_day = $before_month."-".$emp_status->closing_day;
                        $target_day = strtotime($closing_day." "."00:00:00");
                        $closing_afterday = date('Y-m-d', strtotime('+1 day', $target_day));
                        $next_closing_day = $now_year."-".$now_month."-".$emp_status->closing_day;
                    }
                    echo $closing_afterday." ~ ".$next_closing_day;
                ?>
            </div>
            <div style="border-bottom:solid 2px gray;width:758px; background-color:#FFFFDD;">
                <div class="excel" style="border-left:solid 1px gray;">日付</div>
                <div class="excel2">出勤時間</div>
                <div class="excel2">退勤時間</div>
                <div class="excel2">休憩時間</div>
                <div class="excel2">勤務時間</div>
                <div class="excel2">所定内残業</div>
                <div class="excel2">所定外残業</div>
                <div class="excel2">深夜勤務</div>
                <div class="excel2">深夜残業</div>
                <div class="excel2">深夜休憩</div>
            </div>
            <div style="width:755px;">
            <?php
                foreach($holidays_list as $holiday){
                    $holidays[] = $holiday->holiday;
                }
                 //--↓年末休みの定義 settingesテーブルにカラム作って変更できるようにしたほうが良いかも↓--
                $currentYear = intval(date('Y'));
                for ($i = 0; $i < 1; $i++) { // 1年分取得、変更可
                    $y = $currentYear + $i;
                    $date = date("Y-m-d", mktime(0,0,0,12,29,$y)); // 12月29日の取得、いつから休みなのか再度確認必要　今の実装では30日から休み開始
                        for ($j = 0; $j < 5; $j++) { // 5日間
                            $date = date("Y-m-d", strtotime("$date +1 day"));
                            $holidays[] = $date;
                        }
                }
                //--↑年末休みの定義↑--
                $sum_worktime = 0;
                $sum_inover = 0;
                $sum_outover = 0;
                $sum_latework = 0;
                $sum_lateover = 0;
            ?>

                @for($day=1;$day<=$countdate;$day++)
                    <div style="border-bottom:solid 1px gray;">
                    <?php
                        $w = date("w", mktime( 0, 0, 0, $now_month, $day, $now_year ));
                        $d = date("Y-m-d", mktime( 0, 0, 0, $now_month, $day, $now_year ));
                        switch($w){
                            case 0:
                                echo '<div class="excel" style="color:red;border-left:solid 1px gray;">'.$now_month.'/'.$day.'('.$week[date("$w")].')</div>';
                                break;
                            case 6:
                                if(in_array($d,$holidays)){
                                    echo '<div class="excel" style="color:red;border-left:solid 1px gray;">'.$now_month.'/'.$day.'('.$week[date("$w")].')</div>';
                                }else{
                                    echo '<div class="excel" style="color:#3366FF;border-left:solid 1px gray;">'.$now_month.'/'.$day.'('.$week[date("$w")].')</div>';
                                }
                                break;
                            default:
                                if(in_array($d,$holidays)){
                                    echo '<div class="excel" style="color:red;border-left:solid 1px gray;">'.$now_month.'/'.$day.'('.$week[date("$w")].')</div>';
                                }else{
                                    echo '<div class="excel" style="border-left:solid 1px gray";>'.$now_month.'/'.$day.'('.$week[date("$w")].')</div>';
                                }
                        }
                    ?>
                    </div>

                    <?php
                        $samedays = 0;
                        foreach ($attendances as $attendance){
                            if($attendance->day != $d){
                                continue;
                            }

                            //--↓出勤時間の計算・表示処理 & 同日複数出勤の場合の表示形式調整↓--
                            $samedays++;
                            if($samedays>1){
                                echo '<div style="position: relative; left: 80px; bottom: 24px; margin-bottom:-23px; border-bottom:solid 1px gray;width:675px;">';
                                echo '<br><div class="excel">'.$attendance->start_time.'</div>';
                            }else{
                                echo '<div style="position: relative; left: 80px; bottom: 24px; margin-bottom:-23px;">';
                                echo '<div class="excel">'.$attendance->start_time.'</div>';
                            }

                            //--↑おわり↑--

                            //退勤時間の表示処理↓--
                            if($attendance->finish_time != "00:00:01"){
                                echo '<div class="excel">'.$attendance->finish_time.'</div>';
                            }else{
                                echo '<div class="excel">00:00:00</div>';
                            }
                            //--↑おわり↑--

                            //休憩時間の計算・表示処理↓--
                            $minutes = str_pad($attendance->rest_time%60, 2, 0, STR_PAD_LEFT);
                            $hours = str_pad(floor($attendance->rest_time/60), 2, 0, STR_PAD_LEFT);
                            $display_rest_time = $hours.":".$minutes.":00";
                            echo '<div class="excel">'.$display_rest_time.'</div>';
                            //--↑おわり↑--

                            //実働時間の計算・表示処理↓--
                            if($attendance->finish_time != "00:00:01"){
                                $finish = strtotime("$attendance->day $attendance->finish_time");
                                $start = strtotime("$attendance->day $attendance->start_time");
                                $diff = $finish-$start;
                                if($diff<0){
                                        $diff = (24*3600)+$diff;
                                }
                                $rest = $attendance->rest_time*60;
                                $late_rest = $attendance->late_rest_time*60;
                                $diff = $diff-($rest+$late_rest);
                                if($diff>=0){
                                    $work_time = $diff;
                                    $sum_worktime += $work_time;
                                    echo '<div class="excel">'.seconds_change_to_time($diff).'</div>';
                                }else{
                                    echo '<div class="excel">Error</div>';
                                }
                            }else{
                                echo '<div class="excel">00:00:00</div>';
                            }
                            //--↑おわり↑--

                            //所定内残業の計算処理↓--
                            if($attendance->finish_time != "00:00:01"){
                                if($work_time>$current_employee->basic_work_time*60){
                                    $diff = min($work_time,480*60)-$current_employee->basic_work_time*60;
                                }else{
                                    $diff = 0;
                                }
                                $in_overtime = $diff;
                                if($diff>=0){
                                    $sum_inover += $in_overtime;
                                    echo '<div class="excel">'.seconds_change_to_time($diff).'</div>';
                                }else{
                                    echo '<div class="excel">Error</div>';
                                }
                            }else{
                                echo '<div class="excel">00:00:00</div>';
                            }
                            //--↑おわり↑--

                            //所定外残業の計算処理↓--
                            if($attendance->finish_time != "00:00:01"){
                                $diff = $finish-$start;
                                if($diff<0){
                                        $finish += 24*3600;
                                }
                                $late_overtime_time = strtotime($attendance->day." ".$settinges[0]->late_overtime_time);
                                $rest = $attendance->rest_time*60;
                                $basic_work_time =$current_employee->basic_work_time*60;
                                $diff = min($finish,$late_overtime_time)-$start-$rest-$basic_work_time-$in_overtime;
                                $overtime = $diff;
                                if($diff>=0){
                                    $sum_outover += $overtime;
                                    echo '<div class="excel">'.seconds_change_to_time($diff).'</div>';
                                }else{
                                    echo '<div class="excel">00:00:00</div>';
                                }
                            }else{
                                echo '<div class="excel">00:00:00</div>';
                            }
                            //--↑おわり↑--

                            //深夜勤務(深夜残業も求める)の計算処理↓--
                            if($attendance->finish_time != "00:00:01"){
                                $finish = strtotime("$attendance->day $attendance->finish_time");
                                $start = strtotime("$attendance->day $attendance->start_time");
                                $change_date_time = strtotime($attendance->day." ".$settinges[0]->change_date_time);
                                $late_overtime_time = strtotime($attendance->day." ".$settinges[0]->late_overtime_time);
                                $diff = $finish-$start;
                                if($diff<0){
                                    $finish += 24*3600;
                                }
                                $diff = $change_date_time-$finish;
                                if($diff<0){
                                    $change_date_time += 24*3600;
                                }
                                $diff = $change_date_time-$late_overtime_time;
                                if($diff<0){
                                    $late_overtime_time -= 24*3600;
                                }
                                $late = min($change_date_time,$finish)-max($late_overtime_time,$start)-$late_rest;
                                if($late > 0){
                                    $remain_work_time = $start+8*3600+$rest-$late_overtime_time;
                                    if($remain_work_time>0){
                                        $diff = $late - $remain_work_time;
                                        if($diff<=0){
                                            $late_overtime = 0;
                                            $late_work = $late;
                                        }else{
                                            $late_overtime = $diff;
                                            $late_work = $late - $late_overtime;
                                        }
                                    }else{
                                        $late_overtime = $late;
                                        $late_work = 0;
                                    }
                                }else{
                                    $late_overtime = 0;
                                    $late_work = 0;
                                }
                                $sum_latework += $late_work;
                                $sum_lateover += $late_overtime;
                                echo '<div class="excel">'.seconds_change_to_time($late_work).'</div>';
                            }else{
                                echo '<div class="excel">00:00:00</div>';
                            }
                            //--↑おわり↑--

                            //深夜残業の表示↓--
                            if($attendance->finish_time != "00:00:01"){
                                echo '<div class="excel">'.seconds_change_to_time($late_overtime).'</div>';
                            }else{
                                echo '<div class="excel">00:00:00</div>';
                            }
                            //--↑おわり↑--

                            //深夜休憩の表示↓--
                            $minutes = str_pad($attendance->late_rest_time%60, 2, 0, STR_PAD_LEFT);
                            $hours = str_pad(floor(($attendance->late_rest_time/60)%60), 2, 0, STR_PAD_LEFT);
                            $display_late_rest_time = $hours.":".$minutes.":00";
                            echo '<div class="excel">'.$display_late_rest_time.'</div>';
                            //--↑おわり↑--

                            echo '</div>';
                        }
                    ?>

                @endfor
                <div>合計勤務時間
                    <?php echo seconds_change_to_time($sum_worktime) ?>
                </div>
                <div>所定内残業時間
                    <?php echo seconds_change_to_time($sum_inover) ?>
                </div>
                <div>所定外残業時間
                    <?php echo seconds_change_to_time($sum_outover) ?>
                </div>
                <div>深夜勤務時間
                    <?php echo seconds_change_to_time($sum_latework) ?>
                </div>
                <div>深夜残業時間
                    <?php echo seconds_change_to_time($sum_lateover) ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection