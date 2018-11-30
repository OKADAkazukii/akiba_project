<style>
.container-fluid {
 margin-right: auto;
 margin-left: auto;
}	
.time-area{
 height:230px;
 border:solid 1px #778899;
}
.sum-area{
 height:300px;
 border:solid 1px #778899;
 margin-top:40px;
}
.main-time-area{
 width:100%;
 height:40px;
 background: linear-gradient(#3296ff,#1D62F0);
 display:inline-block;
 text-align:center;
 border-bottom:solid 1px #778899;
 margin-bottom:20px;
 font-size:18px;
 color:white;
 padding-top:8px;
}
.rest-text{
 margin:40px 5px 0 5px;
 display:inline-block;
}
.excel{
 border-right:solid 1px gray;
 display:inline-block;
 text-align:center;
 width:75px;
}
</style>

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
                            <input type="text" size="20" style="width:60px;" maxlength="8" value="1:00"></input>
                            <input type="submit" value="更新"></input>
                        <form>
                    </div>
                </div>
            </div>
                <div class="sum-area">
                    <div class="main-time-area">集計勤務時間</div>
                </div>


        </div>            
        <div class="col-md-8">
            <div class="main-time-area" style="margin-bottom:0;width:944px;">
                <?php
                    $countdate = date("t");
                    $now_year = date("Y");
                    $now_month = date("n");
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
                @for($day=1;$day<=$countdate;$day++)
                    <div style="border-bottom:solid 1px gray;"> 
                        <div 
                            <?php
                                $w = date("w", mktime( 0, 0, 0, $now_month, $day, $now_year ));
                                switch($w){
                                    case 0:
                                        echo 'class="excel" style="color:red;border-left:solid 1px gray;">'.$now_month.'/'.$day.'('.$week[date("$w")].')';
                                        break;
                                    case 6:
                                        echo 'class="excel" style="color:#3366FF;border-left:solid 1px gray;">'.$now_month.'/'.$day.'('.$week[date("$w")].')';
                                        break;
                                    default:
                                        echo 'class="excel" style="border-left:solid 1px gray";>'.$now_month.'/'.$day.'('.$week[date("$w")].')';
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
