@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7">
        	<form action="/admin/show/{{ $attendance->id }}/attendanceupdata" method="post">
			@csrf
				<input type="hidden" name="id" value="{{$attendance->id}}">
				<input type="hidden" name="emp_id" value="{{$attendance->emp_id}}">
				<div>
					<h5>日付</h5>
					<input type="date" name="day" value="{{$attendance->day}}">
				</div>
				<div>
					<h5>出勤時間</h5>
					<input type="time" name="start_time" value="{{$attendance->start_time}}">
				</div>
				<div>
					<h5>退勤時間</h5>
					<input type="time" name="finish_time" value="{{$attendance->finish_time}}">
				</div>
				<div>
					<h5>休憩時間</h5>
					<input type="time" name="rest_time" value="{{$attendance->rest_time}}">
				</div>
				<div>
					<h5>深夜休憩</h5>
					<input type="time" name="late_rest_time" value="{{$attendance->late_rest_time}}">
				</div>
				<div>
					<input type="submit" value="更新">
				</div>
			</form>
        </div>
    </div>
</div>
@endsection