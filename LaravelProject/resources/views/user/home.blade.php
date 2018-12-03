<link rel="stylesheet" href="{{ asset('/css/style.css') }}">

@extends('layouts.app')
@section('content')
<div class="container-fluid" style="margin-top:30px;">
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
                        <form>
                            <button type="button" class="btn btn-info" style="padding:10px 20px;font-size:30px;color:white;margin-right:15px;">出勤</button>
                        </form>
                        <form>
                            <button type="button" class="btn btn-success" style="padding:10px 20px;font-size:30px;">退勤</button>
                        </form>
                    </div>
                    <div class="row justify-content-center">
                        <form>
                            <p class="rest-text">休憩時間 :</p>
                            <input type="text" size="20" class="rest-text-form" maxlength="8" value="1:00"></input><br>
                            <p class="rest-text2">深夜休憩 :</p>
                            <input type="text" size="20" class="rest-text-form" maxlength="8" value="0:00"></input>
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
                        <br><div>勤務時間：</div>
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
                    //一ヶ月前日時取得の場合の記述→  $countdate = date("t", strtotime("-1 month"));
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
                    $data = file_get_contents('http://www8.cao.go.jp/chosei/shukujitsu/syukujitsu_kyujitsu.csv');
                    $data = mb_convert_encoding($data, "UTF-8", "SJIS");
                    $ex_lines = explode("\r\n", $data);
                    $holidays = [];
                    foreach($ex_lines as $line){
                        $parts = explode(",", $line);
                        $holidays[]= [trim($parts[0])];
                    }
                    //--↓年末休みの定義↓--
                    $currentYear = intval(date('Y'));
                    for ($i = 0; $i < 1; $i++) { // 1年分取得、変更可
                        $y = $currentYear + $i;
                        $date = date("Y-m-d", mktime(0,0,0,12,29,$y)); // 12月29日の取得、いつから休みなのか再度確認必要一応今の実装では30〜3日
                            for ($j = 0; $j < 5; $j++) { // 5日間
                                $date = date("Y-m-d", strtotime("$date +1 day"));
                                $holidays[] = $date;
                            }
                    }
                    //--↑年末休みの定義↑--
                    $holidays = array_flatten($holidays);
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
                            <div>09:55</div>
                        </div>
                        <div class="excel">
                            <div>19:15</div>
                        </div>
                        <div class="excel">
                            <div>01:00</div>
                        </div>
                        <div class="excel">
                            <div>08:20</div>
                        </div>
                        <div class="excel">
                            <div>00:00</div>
                        </div>
                        <div class="excel">
                            <div>00:20</div>
                        </div>
                        <div class="excel">
                            <div>00:00</div>
                        </div>
                        <div class="excel">
                            <div>00:00</div>
                        </div>
                        <div class="excel">
                            <div>00:00</div>
                        </div>
                        <div class="excel">
                            <div>00:00</div>
                        </div>
                        <div class="excel">
                            <div>00:00</div>
                        </div>
                    </div>
                @endfor

            </div>
        <div>
    </div>
</div>
@endsection
