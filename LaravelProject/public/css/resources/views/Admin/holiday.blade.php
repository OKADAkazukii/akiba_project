
<link href="{{ asset('css/emp.css') }}" rel="stylesheet">
 
@extends('layouts.app')
@section('content')
<body>
  @if (session('addholiday'))
    <div align="center" class="alert alert-success">{{ session('addholiday') }}</div>
  @endif
  @if (session('alerdeyholiday'))
    <div align="center" class="alert alert-danger">{{ session('alerdeyholiday') }}</div>
  @endif
  @if (session('delholiday'))
    <div align="center" class="alert alert-success">{{ session('delholiday') }}</div>
  @endif
  @if (session('notholiday'))
    <div align="center" class="alert alert-danger">{{ session('notholiday') }}</div>
  @endif
  @if (session('message'))
      <div align="center" class="alert alert-success">{{ session('message') }}</div>
  @endif
  </div>
  <br>
  <div>
    <div id="aaa"><h3>休日設定</h3></div>
    <form action="/addholiday" method="post">
      {{ csrf_field() }}
      <label>日付 :<input type="date" name="date" ></label>
      <input type="submit" value="送信">
    </form>
  </div>
  <div>
    <h3>休日削除</h3>
    <form action="/deleteholiday" method="post">
      {{ csrf_field() }}
      <label>日付 :<input type="date" name="delete" ></label>
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
            echo '<div>',$holisets->holiday.$holisets->holiday_name,'</div>','<br>'; 
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
            echo '<div>',$holigets->holiday.$holigets->holiday_name,'</div>','<br>';
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
