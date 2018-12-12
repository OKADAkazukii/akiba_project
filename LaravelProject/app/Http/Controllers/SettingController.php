<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
	public function edit(){
    	return view('/Admin.overtime');
	}

	public function changedatetime(Request $req){
		$validated_time = $req->validate([
			'change_date_time' => 'required',
		]);
		$count_check = DB::table("settinges")->count();
		if($count_check == 0){
			DB::table("settinges")->insert([
				'change_date_time' => $validated_time["change_date_time"]
			]);
		}elseif($count_check == 1){
			$setting = DB::table("settinges")->first();
			DB::table("settinges")->where("id","=",$setting->id)->update([
				'change_date_time' => $validated_time["change_date_time"]
			]);
		}
		return back();
	}

	public function lateovertimetime(Request $req){
		$validated_time = $req->validate([
			'late_overtime_time' => 'required',
		]);
		$count_check = DB::table("settinges")->count();
		if($count_check == 0){
			DB::table("settinges")->insert([
				'late_overtime_time' => $validated_time["late_overtime_time"]
			]);
		}elseif($count_check == 1){
			$setting = DB::table("settinges")->first();
			DB::table("settinges")->where("id","=",$setting->id)->update([
				'late_overtime_time' => $validated_time["late_overtime_time"]
			]);
		}
		return back();
	}
}
