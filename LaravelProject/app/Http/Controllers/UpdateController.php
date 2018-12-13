<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UpdateController extends Controller
{
    public function update(Request $req)
    {
        $up = $req->input('name');
        $date = DB::table('employees')->where('name','=',$up)->count();

        if($date>0){
        $emp_id = DB::table('employees')->where('name','=',$up)->get(['emp_status_id']);
        $hash = DB::table('employees')->where('name','=',$up)->get(['login_hash']); 
        
        
        }
    }    
}

