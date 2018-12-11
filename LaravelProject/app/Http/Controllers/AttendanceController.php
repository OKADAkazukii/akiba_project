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
		$attendance = DB::table("attendances")->where("emp_id","=",1)->orderBy('id','desc')->first();
		if($attendance){
			if($attendance->finish_time !='00:00:00'){
				DB::table("attendances")->insert([
				'emp_id'=> 1,
				'day'=> $start_day,
				'start_time'=> $start_time,
				]);
			}else{
				return Redirect('/home')->with('message', '既に出勤しています');
			}
		}else{
			DB::table("attendances")->insert([
				'emp_id'=> 1,
				'day'=> $start_day,
				'start_time'=> $start_time,
			]);
		}
		return Redirect('/home');
	}

	public function finishtime(Request $req){
		$token = $req->all();
		$finish_daytime = date("Y-m-d H:i");
		$daytime = explode(" ", $finish_daytime);
		$finish_day = $daytime[0];
		$finish_time = $daytime[1];
		$attendance = DB::table("attendances")->where("emp_id","=",1)->orderBy('id','desc')->first();
		if($attendance){
			if($attendance->finish_time =='00:00:00'){
				DB::table("attendances")->where("id","=",$attendance->id)->update([
					'finish_time' => $finish_time
				]);
			}else{
				return Redirect('/home')->with('message', '出勤していないため、退社時間の記録はできません');
			}
		}else{
			return Redirect('/home')->with('message', '出勤していないため、退社時間の記録はできません');
		}
		return Redirect('/home');
	}

	public function resttime(Request $req){
		$token = $req->all();
		$attendance = DB::table("attendances")->where("emp_id","=",1)->orderBy('id','desc')->first();
		if($attendance){
			if($attendance->finish_time =='00:00:00'){
				DB::table("attendances")->where("id","=",$attendance->id)->update([
					'rest_time' => $token["rest"],
					'late_rest_time' => $token["late_rest"]
				]);
			}else{
				return Redirect('/home')->with('message', '出勤していないため、休憩時間を設定できません');
			}
		}else{
			return Redirect('/home')->with('message', '出勤していないため、休憩時間を設定できません');
		}
		return Redirect('/home');
	}
}
