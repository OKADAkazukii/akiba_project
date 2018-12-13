<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{
	public function home(){
		$employees = DB::table("employees")->get();
		$emp_status = DB::table("employstatus")->get();
        return view('Admin.signin',compact("employees"),compact("emp_status"));
    }

    public function search(Request $req){
    	$validated_search = $req->validate([
			'search' => 'required'
		]);
		$employees = DB::table("employees")->where("name","like","%{$validated_search["search"]}%")->get();
		$emp_status = DB::table("employstatus")->get();
        return view('Admin.signin',compact("employees","emp_status","validated_search"));
    }

    public function show($id){
		$employee = DB::table("employees")->where("id","=",$id)->first();
		$emp_status = DB::table("employstatus")->where("id","=",$employee->emp_status_id)->first();
		$employee->emp_status_id = $emp_status->employment_status;
        return view('Admin.show',compact("employee"));
    }

    public function edit($id){
		$employee = DB::table("employees")->where("id","=",$id)->first();
		$emp_status = DB::table("employstatus")->get();
        return view('Admin.edit',compact('employee'),compact('emp_status'));
    }

    public function updata(Request $req){
    	$post_data = $req->all();
		DB::table("employees")->where("id","=",$post_data["id"])->update([
			'name' => $post_data['name'],
			'basic_salary' => $post_data['basic_salary'],
			'basic_work_time' => $post_data['basic_work_time']
		]);
		if($post_data['retirement_day'] == 1){
			$login_hash = sha1(uniqid(rand(),1));
			DB::table("employees")->where("id","=",$post_data["id"])->update([
				'login_hash' => $login_hash,
				'retirement_day' => "0000-00-00"
			]);
		}
		elseif($post_data['retirement_day'] == 2){
			$day = date('Y-m-d');
			DB::table("employees")->where("id","=",$post_data["id"])->update([
				'login_hash' => "",
				'retirement_day' => $day
			]);
		}
        return redirect("/admin/show/{$post_data["id"]}");
    }
}