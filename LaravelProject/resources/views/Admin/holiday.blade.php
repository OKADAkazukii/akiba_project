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
      <label>日付 :<input type="date" name="date" required></label>
      <input type="submit" value="送信">
    </form>
  </div>
  <div>
    <?php
      foreach ($holiget as $holigets){
        echo $holigets->holiday.$holigets->holiday_name,'<br>';
      }
    ?>
  </div>  
  <div>
  <?php echo $yyyy; ?>>
  </div>
  <div>
    <form action="/holidayupdate" method="post">
      {{ csrf_field() }}
      <button style="position:relative; top:160px;" type="submit" class="btn btn-success">祝日更新</button>
    </form>
  </div>
</body>
@endsection
