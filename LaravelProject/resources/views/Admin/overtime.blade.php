@extends('layouts.app')
@section('content')
<div>
    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10">
			<div style="margin-bottom: 30px;">
				<h4>日付変更時刻</h4>
				<form action="/timesettingse/change_date_time" method="post">
				@csrf
					<input type="time" name="change_date_time" value="{{$setting[0]->change_date_time}}">
					<input type="submit" value="適用">
				</form>
			</div>
			<div style="margin-bottom: 30px;">
				<h4>深夜残業認定時刻</h4>
				<form action="/timesettingse/late_overtime_time" method="post">
				@csrf
					<input type="time" name="late_overtime_time" value="{{$setting[0]->late_overtime_time}}">
					<input type="submit" value="適用">
				</form>
			</div>
		</div>
	</div>
</div>
@endsection