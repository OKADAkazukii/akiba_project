@extends('layouts.app')
@section('content')
<h3>雇用形態別料率変更</h3>
    @foreach ($status as $value)
        <font size="5"><a href="/manager/{{$value->status_id}}">{{$value->employment_status}}</font></a><br>
    @endforeach    
@endsection
