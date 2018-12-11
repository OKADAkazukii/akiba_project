<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{

    public function addholyday(Request $req)
    {
        $postholyday = $req->all();
        $date = $postholyday["date"]; 

        DB::table('holyday')->
        
    }
}
