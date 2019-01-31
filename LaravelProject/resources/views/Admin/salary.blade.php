<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
@extends('layouts.app')
@section('content')

@if (session('message'))
  <div class="alert alert-success">{{ session('message') }}</div>
@endif
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div>
				<h4>給与情報の反映</h4>
				<form action="/admin/salary/reflection"　method="post">
					{{ csrf_field() }}
					<button type="submit" class="btn btn-success">反映を開始する</button>
				</form>
			</div>
			<div style="margin-top:40px;">
				<h4>給与情報ダウンロード</h4>
				<form action="/admin/salary/download"　method="post">
					{{ csrf_field() }}
					<select name="year" style="margin-bottom:10px;">
						<option value="" selected disabled hidden>--選択--</option>
						@if(isset($select_years))
							@foreach($select_years as $select_year)
								<option value="{{$select_year}}">{{$select_year}}</option>
							@endforeach
						@endif
					</select>年
					<select name="month" style="margin-bottom:5px;">
						<option value="" selected disabled hidden>--選択--</option>
						@for($i=1; $i<=12; $i++)
							<option value="{{$i}}">{{$i}}</option>
						@endfor
					</select>月
					<button style="color: white;" type="submit" class="btn btn-info">CSV形式ダウンロード</button>
				</form>
			</div>
		</div>
		<div class="col-md-9">
			<div style="overflow: hidden;">
				<h4>今年分の給与情報</h4>
				@foreach($current_year_salaries as $current_year_salary)
					<div style="float: left; margin-right: 10px; width:150px;">
						<li>No.{{$loop->iteration}}</li>
						<div>支払い月 : {{$current_year_salary->salary_month}}月</div>
						<div>雇用者名 : {{$current_year_salary->name}}</div>
						<div>給与金額 : {{ceil($current_year_salary->salary_amount)}}円</div>
					</div>
				@endforeach
			</div>
			<div style="margin-top: 20px; overflow: hidden;">
				<h4>昨年分の給与情報</h4>
				@foreach($last_year_salaries as $last_year_salary)
					<div style="float: left; margin-right: 10px; width:150px;">
						<li>No.{{$loop->iteration}}</li>
						<div>支払い月 : {{$last_year_salary->salary_month}}月</div>
						<div>雇用者名 : {{$last_year_salary->name}}</div>
						<div>給与金額 : {{ceil($last_year_salary->salary_amount)}}円</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>

@endsection