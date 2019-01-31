<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
 <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
@extends('layouts.app')
@section('content')
<body>
    @if (session('addholiday'))
        <div id="addholiday" align="center" class="alert alert-success">{{ session('addholiday') }}</div>
    @endif
    @if (session('alerdeyholiday'))
        <div id="alerdeyholiday" align="center" class="alert alert-danger">{{ session('alerdeyholiday') }}</div>
    @endif
    @if (session('delholiday'))
        <div id="delholiday" align="center" class="alert alert-success">{{ session('delholiday') }}</div>
    @endif
    @if (session('notholiday'))
        <div id="notholiday" align="center" class="alert alert-danger">{{ session('notholiday') }}</div>
    @endif
    @if (session('message'))
        <div id="message" align="center" class="alert alert-success">{{ session('message') }}</div>
    @endif
    </div>
    <div>
        <div><h4>休日設定</h4></div>
        <form action="/addholiday" method="post">
            {{ csrf_field() }}
            <label>日付 :<input type="date" name="date" ></label>
            <input type="submit" value="送信">
        </form>
    </div>
    <div>
        <h4>指定休日の削除</h4>
        <form action="/deleteholiday" method="post">
            {{ csrf_field() }}
            <label>日付 :<input type="date" name="delete" ></label>
            <input type="submit" value="送信">
        </form>
    </div>
    <div>
        <form action="/holidayupdate" method="post">
            {{ csrf_field() }}
            <button style="position:relative; top:20px;margin-bottom: 30px;" type="submit" class="btn btn-success">祝日更新</button>
        </form>
    </div>
    <div class= row>
        <div class="col-md-4">
            <div class="会社指定休日"><h4>---今年の休日---</h4></div>
                    @foreach ($holiget as $holisets)
                        <?php $yyyy = date('Y',strtotime(($holisets->holiday)));?>
                        @if($year == $yyyy)
                            <div>{{$holisets->holiday.$holisets->holiday_name}}</div><br> 
                        @endif
                    @endforeach
            </div> 
            <div class="col-md-4">
                <div><h4>--来年の休日---</h4></div>
                        @foreach ($holiget as $holigets)
                            <?php $nextyyyy = date('Y',strtotime(($holigets->holiday)));?>
                            @if($nextyear == $nextyyyy)
                                <div>{{$holigets->holiday.$holigets->holiday_name}}</div><br>
                            @endif
                        @endforeach
                </div>
            </div>
        </div>
    </div>
</body>
<script>
$(document).ready(function(){
    setTimeout(function(){
        $('#addholiday').fadeOut(3000)
        $('#alerdeyholiday').fadeOut(3000)
        $('#delholiday').fadeOut(3000)
        $('#notholiday').fadeOut(3000)
        $('#message').fadeOut(3000)
    });
});
</script>
@endsection
