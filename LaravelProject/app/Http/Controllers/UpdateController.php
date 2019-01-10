<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UpdateController extends Controller
{
    public function update()
    {
        $empl = DB::table('employstatus')->where('id','>','0')->count();
    if($empl>0){
        $status = DB::table('employstatus')->get();

        return view ('Admin.conf',compact('status'));
    }else{
        return redirect('/employ')->with('result', '雇用形態を登録してください');
        }
    }
     public function employ($id){

     $emp_status = DB::table("employstatus")->where("id","=",$id)->get();

     return view('Admin.manager',compact("emp_status"));
    }

    public function editempstatus(Request $req){

    $test = DB::table("employstatus")->where("closing_day",'>=',28)->get();






    $status = $req->input('emp');
    $id = $req->input('id');
    $in = $req->input('in_overtime');
    $out = $req->input('out_overtime');
    $late_work = $req->input('late_worktime');
    $late_over = $req->input('late_overtime');
    $holi = $req->input('holiday_work');
    $late_holi = $req->input('late_holiday');
    $closing = $req->input('closing');
    $check = $req->input('check');

    if(!empty($closing)){
        $clo = $closing;
    }elseif($closing == "" && empty($check)){
        return redirect("/manager/$id")->with('else','締め日が未入力です');
    }else{
        $clo = date('d' , mktime(0,0,0,date('m')+1,0,date('Y')));
    }

    DB::table('employstatus')->where("id","=",$id)->update(['employment_status' => $status]);
    DB::table('employstatus')->where("id","=",$id)->update(['in_overtime' => $in]);
    DB::table('employstatus')->where("id","=",$id)->update(['out_overtime' => $out]);
    DB::table('employstatus')->where("id","=",$id)->update(['late_worktime' => $late_work]);
    DB::table('employstatus')->where("id","=",$id)->update(['late_overtime' => $late_over]);
    DB::table('employstatus')->where("id","=",$id)->update(['holiday_work' => $holi]);
    DB::table('employstatus')->where("id","=",$id)->update(['late_holiday_work' => $late_holi]);
    DB::table('employstatus')->where("id","=",$id)->update(['closing_day' => $clo]);

    $clos = date('d', mktime(0,0,0,date('m')+1,0,date('Y'))) ;
    $eom = DB::table('employstatus')->where("id","=",$id)->where("closing_day",'>=',28)->count();
    if($eom == 1){
        DB::table('employstatus')->where("id","=",$id)->update(['closing_day' => $clos]);
        }
    return redirect("/admin/home/")->with('empupdate','更新完了');
     }
 }