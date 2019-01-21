<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UpdateController extends Controller
{
    public function update(){
        $employ = DB::table('employstatus')->count();
    if($employ>0){        
      $status = DB::table('employstatus')->distinct()->select('status_id','employment_status')->get();
       return view ('Admin.conf',compact('status'));
    }else{
        return redirect('/employ')->with('result', '雇用形態を登録してください');
         }
    }

    //managerに飛ぶための処理、チェックボックスにチェックを付ける
    public function employ($employstatus_id){//リミットを設ける、オフセットを１にする
    $emp_status = DB::table("employstatus")->where("status_id","=",$employstatus_id)->orderBy('id','desc')->get();
        $emp_closing_day = $emp_status[0]->closing_day;
        $checked = "" ;    
        if($emp_status[0]->closing_day > 27 ){
            $checked = 'checked';
            $emp_closing_day = "" ;
            return view('Admin.manager',compact('emp_status','checked','emp_closing_day'));  
        }else{
            return view('Admin.manager',compact('emp_status','checked','emp_closing_day'));
        }
        
    }


    public function editempstatus(Request $req){
    $status = $req->input('emp');
    $id = $req->input('id');
    $in = $req->input('in_overtime');
    $out = $req->input('out_overtime');
    $late_over = $req->input('late_overtime');
    $holi = $req->input('holiday_work');
    $late_holi = $req->input('late_holiday');
    $closing = $req->input('closing');
    $check = $req->input('check');
    $new = $req->input('new');
    $status_id = $req->input('emp_id');

    if(!empty($closing)){
        $clo = $closing;
    }elseif($closing == "" && empty($check)){
        return redirect("/manager/$employstatus_id")->with('else','締め日が未入力です');
    }else{
        $clo = date('d', mktime(0,0,0,date('m')+1,0,date('Y')));
    }
    
      $finish_day = date('Y-m-d',strtotime("$new -1 days"));
      $emp_status = DB::table("employstatus")->where("status_id","=",$status_id)->orderBy('id','desc')->take(1)->get();
      $apply_id = $emp_status[0]->id;
      $emp_status = DB::table("employstatus")->where("id","=",$apply_id)->update(['apply_finish' => $finish_day]);

    DB::table('employstatus')->insert([
            'employment_status' => $status,
            'in_overtime' => $in,
            'out_overtime' => $out,
            'late_overtime' => $late_over,
            'holiday_work' =>$holi,
            'late_holiday_work' => $late_holi,
            'closing_day' => $closing,
            'apply_start' => $new,
            'status_id' => $status_id
    ]);
    DB::table('employstatus')->where("status_id","=",$status_id)->update(['employment_status' => $status]);

    return redirect("/admin/home/")->with('empupdate','更新完了');
    }
}
