<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EmployController extends Controller
{
    public function addemp(Request $req)
    {

        $emp = $req->input('emp');
        $in = $req->input('in_overtime');
        $out = $req->input('out_overtime');
        $late_o = $req->input('late_overtime');
        $holi = $req->input('holiday_work');
        $late_h = $req->input('late_holiday');
        $check = $req->input('check');
        $closing = $req->input('closing');
        $newrates = $req->input('new');
        //雇用形態IDを今あるものを降順にして一件取得し、+1したものを新たな雇用形態に加える、既存のものはバリデーションで弾く                        
        $id_count = DB::table('employstatus')->count();
        if($id_count > 0){
        $emp_id = DB::table('employstatus')->orderBy('status_id','desc')->take(1)->get(); 
        $plus_id = $emp_id[0]->status_id+1;
        }else{
        $plus_id = 1;
        }


        if(!empty($closing)){
            $clo = $closing;
        }elseif($closing == "" && empty($check)){
            return redirect("/employ")->with('emp',"$emp")
                                      ->with('in',"$in")
                                      ->with('out',"$out")
                                      ->with('late_over',"$late_o")
                                      ->with('holiday',"$holi")
                                      ->with('late_holi',"$late_h")
                                      ->with('new',"$newrates")
                                      ->with('return','締め日を入力してください!');
        }else{
            $clo = date('d' , mktime(0,0,0,date('m')+1,0,date('Y')));
        }


        $addemp = DB::table('employstatus')->where('employment_status','=',$emp)->count();
    if($addemp==0) {
        DB::table('employstatus')->insert([
            'employment_status' => $emp,
            'in_overtime' => $in,
            'out_overtime' => $out,
            'late_overtime' => $late_o,
            'holiday_work' => $holi,
            'late_holiday_work' => $late_h,
            'closing_day' => $clo,
            'apply_start' => $newrates,
            'status_id' => $plus_id
        ]);       
        return redirect("/admin/home")->with('insertemp','登録完了!');
    }else{
        return redirect("/employ")->with('elseemp',"$emp はすでに登録されています！");
        }   
    }       
}

