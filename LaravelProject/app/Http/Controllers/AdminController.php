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
        $salaries = DB::table("salaries")->where("emp_id","=",$employee->id)->orderBy('id', 'DESC')->get();
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
        $last_year_salaries = DB::table("salaries")->where("salary_year","=",$last_year)->join('employees', 'salaries.emp_id', '=', 'employees.id')->orderBy("salaries.id","ASC")->get();
        $current_year_salaries = DB::table("salaries")->where("salary_year","=",$current_year)->join('employees', 'salaries.emp_id', '=', 'employees.id')->orderBy("salaries.id","ASC")->get();
        $most_old_salary = DB::table("salaries")->orderBy("salary_year","ASC")->first();
        if(!empty($most_old_salary)){
            $most_old_year = $most_old_salary->salary_year."-01-01 00:00:00";
            $select_years = array();
            $target_year = date('Y-m-d H:i:s');
            for($year=$most_old_year; $year<$target_year; $year=date("Y-m-d H:i:s",strtotime($year."+1 year"))){
                $display_year = explode("-",$year);
                $select_years[] = $display_year[0];
            }
        }
        return view('admin.salary',compact("last_year_salaries","current_year_salaries","select_years"));
    }

    public function reflection(){
        $current_salaries = DB::table("salary");
        $salaries = DB::table("before_salary")->union($current_salaries)->get();

        foreach($salaries as $salary){
            $salary_date = explode('-',$salary->salary_date);
            //--↓時間合計テーブルの登録および更新↓--
            $same_sum = DB::table("sums")->where("emp_id","=",$salary->emp_id)->where("year","=",$salary_date[0])
                           ->where("month","=",$salary_date[1])->first();
            if(!empty($same_sum)){
                DB::table("sums")->where("id","=",$same_sum->id)->update([
                    'sum_worktime'=>$salary->sum_worktime,
                    'sum_in_overtime'=>$salary->sum_in_overtime,
                    'sum_outover_time'=>$salary->sum_out_overtime,
                    'sum_latework_time'=>$salary->sum_late_work,
                    'sum_lateover_time'=>$salary->sum_late_overtime,
                    'sum_holiwork_time'=>$salary->holiday_worktime,
                    'sum_holilate_time'=>$salary->holiday_late_time
                ]);
            }else{
                DB::table("sums")->insert([
                    'emp_id'=>$salary->emp_id,
                    'year'=>$salary_date[0],
                    'month'=>$salary_date[1],
                    'sum_worktime'=>$salary->sum_worktime,
                    'sum_in_overtime'=>$salary->sum_in_overtime,
                    'sum_outover_time'=>$salary->sum_out_overtime,
                    'sum_latework_time'=>$salary->sum_late_work,
                    'sum_lateover_time'=>$salary->sum_late_overtime,
                    'sum_holiwork_time'=>$salary->holiday_worktime,
                    'sum_holilate_time'=>$salary->holiday_late_time
                ]);
            }
            //--↓手当テーブルの登録および更新↓--
            $same_allowance = DB::table("allowance")->where("emp_id","=",$salary->emp_id)->where("t_year","=",$salary_date[0])
                           ->where("t_month","=",$salary_date[1])->first();
            if(!empty($same_allowance)){
                DB::table("allowance")->where("id","=",$same_allowance->id)->update([
                    't_inover'=>$salary->t_inover,
                    't_outover'=>$salary->t_outover,
                    't_latework'=>$salary->t_latework,
                    't_lateover'=>$salary->t_lateover,
                    't_holiwork'=>$salary->t_holi_work,
                    't_holilate'=>$salary->t_holi_late
                ]);
            }else{
                DB::table("allowance")->insert([
                    'emp_id'=>$salary->emp_id,
                    't_year'=>$salary_date[0],
                    't_month'=>$salary_date[1],
                    't_inover'=>$salary->t_inover,
                    't_outover'=>$salary->t_outover,
                    't_latework'=>$salary->t_latework,
                    't_lateover'=>$salary->t_lateover,
                    't_holiwork'=>$salary->t_holi_work,
                    't_holilate'=>$salary->t_holi_late
                ]);
            }
            //--↓給与テーブルの登録および更新↓--
            $same_salary = DB::table("salaries")->where("emp_id","=",$salary->emp_id)->where("salary_year","=",$salary_date[0])
                           ->where("salary_month","=",$salary_date[1])->first();
            if(!empty($same_salary)){
                DB::table("salaries")->where("id","=",$same_salary->id)->update([
                    'salary_amount'=>$salary->salary
                ]);
            }else{
                DB::table("salaries")->insert([
                    'emp_id'=>$salary->emp_id,
                    'emp_status_id'=>$salary->emp_status_id,
                    'salary_year'=>$salary_date[0],
                    'salary_month'=>$salary_date[1],
                    'salary_amount'=>$salary->salary,
                ]);
            }
        }
        return redirect('/admin/salary')->with('message',"現在の給与情報を反映しました");
    }

    public function download(Request $req){
        function time($m){
            $minutes = str_pad(floor($m % 60), 2, 0, STR_PAD_LEFT);
            $hours = str_pad(floor($m / 60), 2, 0, STR_PAD_LEFT);
            $time = $hours."時間 ".$minutes."分";
            //↑Excel上では60:00以上は表現できないので上記のように時間・分と表示している
            return $time;
        }
        $data = $req->validate(['year' => 'required', 'month' => 'required',]);
        $searched_salaries = DB::table("salaries")->
        where("salary_year","=",$data['year'])->
        where("salary_month","=",$data['month'])->
        join('employees', 'salaries.emp_id', '=', 'employees.id')->
        join('allowance', function ($join) {
            $join->on('employees.id', '=', 'allowance.emp_id');
            $join->on('salaries.salary_year', '=', 'allowance.t_year');
            $join->on('salaries.salary_month', '=', 'allowance.t_month');
        })->
        join('sums', function ($join) {
            $join->on('employees.id', '=', 'sums.emp_id');
            $join->on('salaries.salary_year', '=', 'sums.year');
            $join->on('salaries.salary_month', '=', 'sums.month');
        })->get();
        $csv = $data['year']."年".$data['month']."月分"."\n".'"雇用者名","給与額","所定内残業手当","所定外残業手当","深夜勤務手当","深夜残業手当","休日勤務手当","休日深夜手当","合計勤務時間","合計所定内残業時間","合計所定外残業時間","合計深夜勤務時間","合計深夜残業時間","合計休日出勤時間","合計休日深夜時間"'."\n";
        if(!empty($searched_salaries)){
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=".$data['year']."-".$data['month']."給与情報.csv");
            header("Content-Transfer-Encoding: binary");

            foreach( $searched_salaries as $value ) {
                $csv .= '"'.$value->name.'","'.ceil($value->salary_amount).'円","'.ceil($value->t_inover).'円","'.ceil($value->t_outover).'円","'.ceil($value->t_latework).'円","'.ceil($value->t_lateover).'円","'.ceil($value->t_holiwork).'円","'.ceil($value->t_holilate).'円","'.
                time($value->sum_worktime).'","'.time($value->sum_in_overtime).'","'.time($value->sum_outover_time).'","'.time($value->sum_latework_time).'","'.time($value->sum_lateover_time).'","'.time($value->sum_holiwork_time).'","'.time($value->sum_holilate_time).'"'."\n";
            }
        }
            echo mb_convert_encoding($csv,"SJIS", "UTF-8");
            return;
    }
}