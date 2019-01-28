<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{
	public function home(){
		$employees = DB::table("employees")->get();
		$emp_status = DB::table("employstatus")->groupBy('status_id')->get();
		$settinges = DB::table("settinges")->get();
        return view('Admin.signin',compact("employees","emp_status"));
    }

	public function index($id){
		$employees = DB::table("employees")->where("emp_status_id","=",$id)->get();
		$emp_status = DB::table("employstatus")->where("status_id","=",$id)->first(["employment_status"]);
		return view('Admin.empindex',compact("employees","emp_status"));
    }

    public function search(Request $req){
    	$validated_search = $req->validate([
			'search' => 'required'
		]);
		$employees = DB::table("employees")->where("name","like","%{$validated_search["search"]}%")->get();
		$emp_status = DB::table("employstatus")->groupBy('status_id')->get();
        return view('Admin.signin',compact("employees","emp_status","validated_search"));
    }

    public function show($id){
		$employee = DB::table("employees")->where("id","=",$id)->first();
		$emp_status = DB::table("employstatus")->where("status_id","=",$employee->emp_status_id)->first();
		$employee->emp_status_id = $emp_status->employment_status;
		$employee->basic_work_time = floor($employee->basic_work_time/60)."時間".($employee->basic_work_time%60)."分";
		$attendances = DB::table("attendances")->where("emp_id","=",$employee->id)->orderBy('day', 'DESC')->get();
        $salaries = DB::table("salaries")->where("emp_id","=",$employee->id)->orderBy('salary_year', 'DESC')->get();
        return view('Admin.show',compact("employee","attendances","salaries"));
    }

    public function edit($id){
		$employee = DB::table("employees")->where("id","=",$id)->first();
		$employee->basic_work_time = str_pad(floor($employee->basic_work_time/60), 2, 0, STR_PAD_LEFT).":".str_pad(floor($employee->basic_work_time%60), 2, 0, STR_PAD_LEFT).":00";
		$emp_status = DB::table("employstatus")->get();
        return view('Admin.edit',compact('employee'),compact('emp_status'));
    }

    public function updata(Request $req){
    	$post_data = $req->validate([
                     'id' => 'required',
                     'name' => 'required',
                     'basic_salary' => 'required',
                     'time_salary' => 'required',
                     'basic_work_time' => 'required',
                     'retirement_day' => 'nullable'
        ]);
        $basic_work_time_ex = explode(":",$post_data['basic_work_time']);
        $post_data['basic_work_time'] = ($basic_work_time_ex[0]*60)+($basic_work_time_ex[1]);
		DB::table("employees")->where("id","=",$post_data["id"])->update([
			'name' => $post_data['name'],
			'basic_salary' => $post_data['basic_salary'],
			'time_salary' => $post_data['time_salary'],
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
        return redirect("/admin/show/{$post_data["id"]}")->with('message',"雇用者情報を変更しました");
    }

    public function timesearch($id ,Request $req){
    	$employee = DB::table("employees")->where("id","=",$id)->first();
		$emp_status = DB::table("employstatus")->where("id","=",$employee->emp_status_id)->first();
		$employee->emp_status_id = $emp_status->employment_status;
		$employee->basic_work_time = floor($employee->basic_work_time/60)."時間".($employee->basic_work_time%60)."分";
		$attendances = DB::table("attendances")->where("emp_id","=",$employee->id)->orderBy('day', 'DESC')->get();
    	$day = $req->day;
    	$serch_attendances = DB::table("attendances")->where("emp_id","=",$id)->where("day","=",$day)->get();
        $salaries = DB::table("salaries")->where("emp_id","=",$employee->id)->orderBy('salary_month', 'DESC')->orderBy('salary_year', 'DESC')->get();
    	return view('Admin.show',compact("serch_attendances","employee","attendances","salaries"));
    }

    public function timeedit($id){
    	$attendance = DB::table("attendances")->where("id","=",$id)->first();
    	$attendance->rest_time = str_pad(floor($attendance->rest_time/60), 2, 0, STR_PAD_LEFT).":".str_pad(floor($attendance->rest_time%60), 2, 0, STR_PAD_LEFT).":00";
    	$attendance->late_rest_time = str_pad(floor($attendance->late_rest_time/60), 2, 0, STR_PAD_LEFT).":".str_pad(floor($attendance->late_rest_time%60), 2, 0, STR_PAD_LEFT).":00";
    	return view('Admin.timeedit',compact("attendance"));
    }

    public function attendanceupdata(Request $req){
    	$validated_data = $req->validate([
                     'id' => 'required',
                     'emp_id' => 'required',
                     'start_time' => 'required',
                     'finish_time' => 'required',
                     'rest_time' => 'required',
                     'late_rest_time' => 'required'
        ]);
        $rest_ex = explode(":",$validated_data['rest_time']);
        $validated_data['rest_time'] = ($rest_ex[0]*60)+$rest_ex[1];
        $late_rest_ex = explode(":",$validated_data['late_rest_time']);
        $validated_data['late_rest_time'] = ($late_rest_ex[0]*60)+$late_rest_ex[1];
    	DB::table("attendances")->where("id","=",$validated_data["id"])->update([
			'start_time' => $validated_data['start_time'],
			'rest_time' => $validated_data['rest_time'],
			'finish_time' => $validated_data['finish_time'],
			'late_rest_time' => $validated_data['late_rest_time']
		]);
    	return redirect("/admin/show/{$validated_data["emp_id"]}")->with('message',"出勤情報を変更しました");
    }

    public function salary(){
        $current_year = date('Y');
        $last_year = date('Y', strtotime('-1 year'));
        $last_year_salaries = DB::table("salaries")->where("salary_year","=",$last_year)->join('employees', 'salaries.emp_id', '=', 'employees.id')
        ->join('employstatus', 'employees.emp_status_id', '=', 'employstatus.id')->orderBy("salary_month","ASC")->get();
        $current_year_salaries = DB::table("salaries")->where("salary_year","=",$current_year)->join('employees', 'salaries.emp_id', '=', 'employees.id')
        ->join('employstatus', 'employees.emp_status_id', '=', 'employstatus.id')->orderBy("salary_month","ASC")->get();
        $most_old_salary = DB::table("salaries")->orderBy("salary_year","ASC")->first();
        $most_old_year = $most_old_salary->salary_year."-01-01 00:00:00";
        $select_years = array();
        $target_year = date('Y-m-d H:i:s');
        for($year=$most_old_year; $year<$target_year; $year=date("Y-m-d H:i:s",strtotime($year."+1 year"))){
            $display_year = explode("-",$year);
            $select_years[] = $display_year[0];
        }
        return view('admin.salary',compact("last_year_salaries","current_year_salaries","select_years"));
    }

    public function reflection(){
        $salaries = DB::table("salary")->get();
        foreach($salaries as $salary){
            $salary_date = explode('-',$salary->salary_date);
            $uniquecheck = DB::table("salaries")->where("emp_id","=",$salary->emp_id)->where("salary_year","=",$salary_date[0])
                           ->where("salary_month","=",$salary_date[1])->where("salary_amount","=",$salary->salary)->count();
            $same_salary = DB::table("salaries")->where("emp_id","=",$salary->emp_id)->where("salary_year","=",$salary_date[0])
                           ->where("salary_month","=",$salary_date[1])->first();
            if($uniquecheck == 1){
                ;
            }elseif(!empty($same_salary)){
                DB::table("salaries")->where("id","=",$same_salary->id)->update([
                    'salary_amount'=>$salary->salary
                ]);
            }else{
                DB::table("salaries")->insert([
                    'emp_id'=>$salary->emp_id,
                    'allowance_id'=>1,
                    'salary_year'=>$salary_date[0],
                    'salary_month'=>$salary_date[1],
                    'salary_amount'=>$salary->salary,
                    'emp_status_id'=>$salary->emp_status_id,
                ]);
            }
        }
        return redirect('/admin/salary')->with('message',"現在の給与情報を反映しました");
    }
}