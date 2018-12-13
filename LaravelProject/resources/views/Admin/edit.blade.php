@extends('layouts.app')
@section('content')
<div class="container">
	<form action="/admin/show/{{ $employee->id }}/updata" method="post">
	@csrf
		<input type="hidden" name="id" value="{{$employee->id}}"></input>
		<div>
			<h5>名前</h5>
			<input type="text" name="name" value="{{$employee->name}}"></input>
		</div>
		<div>
			<h5>基本給(円)</h5>
			<input type="text" name="basic_salary" value="{{$employee->basic_salary}}"></input>
		</div>
		<div>
			<h5>基本勤務時間(分)</h5>
			<input type="text" name="basic_work_time" value="{{$employee->basic_work_time}}"></input>
		</div>
		@if($employee->retirement_day != "0000-00-00")
		<div>
			<h5>復活処理</h5>
			<select name="retirement_day">
	                <option value="">しない</option>
	                <option value="1">する</option>
	        </select>
		</div>
		@else
		<div>
			<h5>退職処理</h5>
			<select name="retirement_day">
	                <option value="">しない</option>
	                <option value="2">する</option>
	        </select>
		</div>
		@endif
		<br>
		<div>
			<input type="submit" value="更新"></input>
		</div>
	</form>
</div>
@endsection