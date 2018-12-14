<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UpdateController extends Controller
{
    public function update()
   { 
    $status = DB::table('employstatus')->get();

    return view ('Admin.conf',compact('status'));

   }
    public function employ($id){

    $emp_status = DB::table("employstatus")->where("id","=",$id)->get();

    return view('Admin.manager',compact("emp_status"));
    }

    public function editempstatus(Request $req){
    $id = $req-> input('id');
    $inover = $req->input('emp');
    DB::table('employstatus')->where("id","=",$id)->update(['in_overtime' => $inover]);
    

    
    }    
}
