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
        $col = $req->input('closing');
       
        $addemp = DB::table('employstatus')->where('employment_status','=',$emp)->count();
        if($addemp==0)
    { 
        DB::table('employstatus')->insert([
            'employment_status' => $emp,
            'in_overtime' => $in,
            'out_overtime' => $out,
            'late_overtime' => $late_o,
            'holiday_work' => $holi,
            'late_holiday_work' => $late_h,
            'closing_day' => $col 
        
            ]);
        }
    } 
}

