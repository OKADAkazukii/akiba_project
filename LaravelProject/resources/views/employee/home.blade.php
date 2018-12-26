<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
<script type="text/javascript">
function submitcheck() {
    var check = confirm('退勤処理をすると、休憩時間の変更ができなくなります');
    return check;
}
function display_income(num)
{
  if (num == 0){
    document.getElementById("disp").style.display="block";
    document.getElementById("disp-show").style.display="none";
    document.getElementById("disp-hidden").style.display="block";
  }else{
    document.getElementById("disp").style.display="none";
    document.getElementById("disp-show").style.display="block";
    document.getElementById("disp-hidden").style.display="none";
  }
}
</script>
<?php
    function minutes_change_to_time($m){
        $minutes = str_pad(floor($m % 60), 2, 0, STR_PAD_LEFT);
        $hours = str_pad(floor($m / 60), 2, 0, STR_PAD_LEFT);
        $time = $hours.":".$minutes;
        return $time;
    }

    function seconds_rm($time){
        $time = explode(":",$time);
        $time = $time[0].":".$time[1];
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
$ip_address = $_SERVER["REMOTE_ADDR"];
echo '訪問者IPアドレス : '.$ip_address;
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
                                <button type="submit" class="btn btn-default" style="padding:10px 20px;font-size:30px;color:gray;margin-right:15px;" disabled>出勤</button>
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
                                <button type="submit" class="btn btn-default" style="padding:10px 20px;font-size:30px; color:gray;" disabled>退勤</button>
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
                        <div>勤務形態：{{$emp_status->employment_status}}</div>
                        <div>給与締日：{{$emp_status->closing_day}}日</div>
                        <?php
                            $view_time = $current_employee->basic_work_time*60;
                            $minutes = str_pad(floor(($view_time/60)%60), 1, 0, STR_PAD_LEFT);
                            $hours = str_pad(floor($view_time/3600), 1, 0, STR_PAD_LEFT);
                        ?>
                        <div>基本勤務：{{$hours}}時間{{$minutes}}分</div>
                        <form>
                            <div id="disp">基本月給：{{$current_employee->basic_salary}}円</div>
                            <input id="disp-show" type="button" value="月収を表示する" onclick="display_income(0)">
                            <input id="disp-hidden" type="button" value="月収を非表示" onclick="display_income(1)">
                        </form>
                    </div>
                </div>
        </div>
        <div class="col-md-8">
            <div class="main-box">
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
            ?>

            <?php
            //--↓カレンダーの記述↓--
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
                        foreach ($db_view as $attendance){
                            if($attendance->day != $d){
                                continue;
                            }
                            //--↓出勤時間↓--
                            $samedays++;
                            if($samedays>1){
                                echo '<div style="position: relative; left: 80px; bottom: 24px; margin-bottom:-23px; border-bottom:solid 1px gray;width:675px;">';
                                echo '<br><div class="excel">'.seconds_rm($attendance->start_time).'</div>';
                            }else{
                                echo '<div style="position: relative; left: 80px; bottom: 24px; margin-bottom:-23px;">';
                                echo '<div class="excel">'.seconds_rm($attendance->start_time).'</div>';
                            }

                            //--↓退勤時間↓--
                            if($attendance->finish_time != "00:00:01"){
                                echo '<div class="excel">'.seconds_rm($attendance->finish_time).'</div>';
                            }else{
                                echo '<div class="excel">00:00</div>';
                            }

                            //--↓休憩時間↓--
                            echo '<div class="excel">'.minutes_change_to_time($attendance->rest_time).'</div>';

                            //--↓実働時間↓--
                            if($attendance->finish_time != "00:00:01"){
                                if($attendance->worktime>=0){
                                    $sum_worktime += $attendance->worktime;
                                    echo '<div class="excel">'.minutes_change_to_time($attendance->worktime).'</div>';
                                }else{
                                    echo '<div class="excel">Error</div>';
                                }
                            }else{
                                echo '<div class="excel">00:00</div>';
                            }

                            //--↓所定内残業↓--
                            if($attendance->finish_time != "00:00:01" && $attendance->in_overtime > 0){
                                $sum_inover += $attendance->in_overtime;
                                echo '<div class="excel">'.minutes_change_to_time($attendance->in_overtime).'</div>';
                            }else{
                                echo '<div class="excel">00:00</div>';
                            }

                            //--↓所定外残業↓--
                            if($attendance->finish_time != "00:00:01" && $attendance->out_overtime > 0){
                                $sum_outover += $attendance->out_overtime;
                                echo '<div class="excel">'.minutes_change_to_time($attendance->out_overtime).'</div>';
                            }else{
                                echo '<div class="excel">00:00</div>';
                            }

                            //--↓深夜勤務↓--
                            if($attendance->finish_time != "00:00:01" && $attendance->late_work > 0){
                                $sum_latework += $attendance->late_work;
                                echo '<div class="excel">'.minutes_change_to_time($attendance->late_work).'</div>';
                            }else{
                                echo '<div class="excel">00:00</div>';
                            }

                            //--↓深夜残業↓--
                            if($attendance->finish_time != "00:00:01" && $attendance->late_overtime > 0){
                                $sum_lateover += $attendance->late_overtime;
                                echo '<div class="excel">'.minutes_change_to_time($attendance->late_overtime).'</div>';
                            }else{
                                echo '<div class="excel">00:00</div>';
                            }

                            //--↓深夜休憩の表示↓--
                            echo '<div class="excel">'.minutes_change_to_time($attendance->late_rest_time).'</div>';

                            //--↑各時間の表示ここまで↑--
                            echo '</div>';
                        }
                    ?>
                @endfor

            </div>
            <div class="container-fluid">
                <div class="row sum-box">
                    <div class="col-md-4 sub-cl">
                        <h4>合計</h4>
                        <div>勤務時間
                            <?php echo minutes_change_to_time($sum_worktime) ?>
                        </div>
                        <div>所定内残業時間
                            <?php echo minutes_change_to_time($sum_inover) ?>
                        </div>
                        <div>所定外残業時間
                            <?php echo minutes_change_to_time($sum_outover) ?>
                        </div>
                        <div>深夜勤務時間
                            <?php echo minutes_change_to_time($sum_latework) ?>
                        </div>
                        <div>深夜残業時間
                            <?php echo minutes_change_to_time($sum_lateover) ?>
                        </div>
                    </div>
                    <div class="col-md-4 sub-cl">
                        <h4>給料計算</h4>
                    </div>
                    <div class="col-md-4 sub-cl">
                        <h4>未定</h4>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection