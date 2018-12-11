<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
	public function home(){
		$attendances = DB::table("attendances")->where("emp_id","=",1)->get();
		$attendance = DB::table("attendances")->where("emp_id","=",1)->orderBy('id','desc')->first();
		if($attendance){
			if($attendance->finish_time =='00:00:00'){
				$start_time = $attendance->start_time;
			}else{
				$start_time = "---------";
			}
		}else{
			$start_time = "---------";
		}
        return view("user.home",compact('attendances'),compact('start_time'));
    }

    public function createuser(){
        return view("user.adduser");
    }
}
