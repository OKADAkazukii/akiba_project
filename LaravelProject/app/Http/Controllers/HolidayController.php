<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HolidayController extends Controller
{

    public function addholiday(Request $req)
    {
        $date = $req->input('date');
        
        $shd = DB::table('holidays')->where('holiday','=',$date)->count();
        if($shd==0)
    {
        DB::table('holidays')->insert([
        'holiday' =>  $date ,
        'holiday_name' => '会社指定休日'
            ]);
        }
    }
}
