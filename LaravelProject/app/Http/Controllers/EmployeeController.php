<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
	public function home($login_hash){
		$login_hash_count = DB::table("employees")->where("login_hash","=",$login_hash)->count();
		if($login_hash_count ==1 ){
			$current_employee = DB::table("employees")->where("login_hash","=",$login_hash)->first();
			$emp_status = DB::table("employstatus")->where("id","=",$current_employee->id)->first();
			$attendances = DB::table("attendances")->where("emp_id","=",$current_employee->id)->get();
			$attendance = DB::table("attendances")->where("emp_id","=",$current_employee->id)->orderBy('id','desc')->first();
			$holidays = DB::table("holidays")->get(['holiday']);
			$holidays_list = array_flatten($holidays);
			$settinges = DB::table("settinges")->get();
			$db_view = DB::table("late6_late_overtime")->get();
			if($attendance){
				if($attendance->finish_time =='00:00:01'){
					$start_time = $attendance->start_time;
				}else{
					$start_time = "---------";
				}
			}else{
				$start_time = "---------";
			}
			return view("employee.home",compact('db_view','attendances','emp_status','holidays_list','start_time','current_employee','settinges','current_employee'));
		}else{
			return redirect("/");
		}
	}

	public function addemployee(){
		$emp_status = DB::table("employstatus")->get();
		return view("employee.addemployee",compact('emp_status'));
	}

	public function create(Request $req){
		$validated_data = $req->validate([
			'emp_status_id' => 'required',
			'admin_id' => 'required',
			'name' => 'required|max:255',
			'login_hash' => 'required',
			'basic_salary' => 'required|max:7',
			'basic_work_time' => 'required'
		]);
		$work_time_ex = explode(":", $validated_data["basic_work_time"]);
		$work_time_m = $work_time_ex[0]*60+$work_time_ex[1];
		DB::table("employees")->insert([
			'emp_status_id'=>$validated_data["emp_status_id"],
			'admin_id'=>$validated_data["admin_id"],
			'name'=>$validated_data["name"],
			'login_hash'=>$validated_data["login_hash"],
			'basic_salary'=>$validated_data["basic_salary"],
			'basic_work_time'=>$work_time_m
		]);
		return redirect('/admin/home');
	}

	public function login(){
		return view('employee.login');
	}
}
