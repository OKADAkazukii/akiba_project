@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<h3>{{$emp_status->employment_status}}一覧</h3>
			<?php
			//--↓ページネーション↓--
			define('MAX','1'); // 1ページの記事の最大表示数
			$employees_a=array();
			foreach($employees as $employee){
			    $employees_a[] = array('id' => $employee->id,'name' => $employee->name,'login_hash' => $employee->login_hash);
			}
			$employees_num = count($employees_a);
			$max_page = ceil($employees_num / MAX); //ceilは小数点を切り捨てる関数
			if(!isset($_GET['page_id'])){
			    $now = 1;
			}else{
			    $now = $_GET['page_id'];
			}
			$start_no = ($now - 1) * MAX;
			//array_sliceは、配列の何番目($start_no)から何番目(MAX)まで切り取る関数
			$disp_data = array_slice($employees_a, $start_no, MAX, true);

			//--↓データ表示↓--
			foreach($disp_data as $val){
			    echo $val["name"]."<br>".$val["login_hash"]."<br>";
			    echo '<a href=\'/admin/show/'.$val["id"].'\'>詳細</a><br>';
			}
			//--↑データ表示おわり↑--
			echo "<br>";
			for($i = 1; $i <= $max_page; $i++){
			    if ($i == $now) {
			        echo $now. '　';
			    } else {
			        echo '<a href=\'/admin/home/empindex/'.$employees[0]->emp_status_id.'/?page_id='. $i. '\')>'. $i. '</a>'. '　';
			    }
			}
			//--↑ページネーション↑--
			?>
		</div>
	</div>
</div>
@endsection