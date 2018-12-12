<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{
	public function home(){
		$employees = DB::table("employees")->get();
        return view('/Admin.signin',compact("employees"));
    }
}
