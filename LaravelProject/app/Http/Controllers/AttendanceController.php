<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
	public function starttime(Request $req){
		$token = $req->all();
		$start_daytime = date('Y-m-d H:i');
		$daytime = explode(" ", $start_daytime);
		$start_day = $daytime[0];
		$start_time = $daytime[1];
		$attendance = DB::table("attendances")->where("emp_id","=",$token["emp_id"])->orderBy('id','desc')->first();
		if($attendance){
			if($attendance->finish_time !='00:00:01'){
				DB::table("attendances")->insert([
				'emp_id'=> $token["emp_id"],
				'day'=> $start_day,
				'start_time'=> $start_time,
				]);
			}else{
				return back()->with('message', '既に出勤しています');
			}
		}else{
			DB::table("attendances")->insert([
				'emp_id'=> $token["emp_id"],
				'day'=> $start_day,
				'start_time'=> $start_time,
			]);
		}
		return back();
	}

	public function finishtime(Request $req){
		$token = $req->all();
		$finish_daytime = date("Y-m-d H:i");
		$daytime = explode(" ", $finish_daytime);
		$finish_day = $daytime[0];
		$finish_time = $daytime[1];
		$attendance = DB::table("attendances")->where("emp_id","=",$token["emp_id"])->orderBy('id','desc')->first();
		if($attendance){
			if($attendance->finish_time =='00:00:01'){
				DB::table("attendances")->where("id","=",$attendance->id)->update([
					'finish_time' => $finish_time
				]);
			}else{
				return back()->with('message', '出勤していないため、退社時間の記録はできません');
			}
		}else{
			return back()->with('message', '出勤していないため、退社時間の記録はできません');
		}
		return back();
	}

	public function resttime(Request $req){
		$token = $req->all();
		$data = $req->validate([
			'rest' => 'required',
			'late_rest' => 'required',
		]);
		$rest_ex = explode(":",$data["rest"]);
		$rest_m = $rest_ex[0]*60+$rest_ex[1];
		$late_rest_ex = explode(":",$data["late_rest"]);
		$late_rest_m = $late_rest_ex[0]*60+$late_rest_ex[1];
		$attendance = DB::table("attendances")->where("emp_id","=",$token["emp_id"])->orderBy('id','desc')->first();
		if($attendance){
			if($attendance->finish_time =='00:00:01'){
				DB::table("attendances")->where("id","=",$attendance->id)->update([
					'rest_time' => $rest_m,
					'late_rest_time' => $late_rest_m
				]);
			}else{
				return back()->with('message', '出勤していないため、休憩時間を設定できません');
			}
		}else{
			return back()->with('message', '出勤していないため、休憩時間を設定できません');
		}
		return back();
	}
}
