<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
@extends('layouts.app')
@section('content')
<body>
    <div class="insertholiday">{{ session('addholiday') }}</div>
    @if (session('message'))
      <div class="alert alert-success">{{ session('message') }}</div>
    @endif
  </div>
  <br>
  <div>
    <h3>休日設定</h3>
    <form action="/addholiday" method="post">
      {{ csrf_field() }}
      <label>日付 :<input type="date" name="date" ></label>
      <input type="submit" value="送信">
    </form>
  </div>
  <div class= row>
    <div class="col-md-6">
      <div><h4>---今年の休日---</h4></div>
        <?php
          foreach ($holiget as $holisets){
            $yyyy = date('Y',strtotime(($holisets->holiday)));
          if($year == $yyyy){
            echo $holisets->holiday.$holisets->holiday_name,'<br>'; 
          }
        }  
      ?>
    </div>  
    <div class="col-md-6">
      <div><h4>--来年の休日---</h4></div>
        <?php
          foreach ($holiget as $holigets){
            $nextyyyy = date('Y',strtotime(($holigets->holiday)));
          if($nextyear == $nextyyyy){
            echo $holigets->holiday.$holigets->holiday_name,'<br>';
          }
        }
      ?>
    </div>
  </div>
  <div>
    <form action="/holidayupdate" method="post">
      {{ csrf_field() }}
      <button style="position:relative; top:160px;" type="submit" class="btn btn-success">祝日更新</button>
    </form>
  </div>
</body>
@endsection
