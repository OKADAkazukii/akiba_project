<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;


class HolidayController extends Controller
{
	public function updataholiday(){
		$data = file_get_contents('http://www8.cao.go.jp/chosei/shukujitsu/syukujitsu_kyujitsu.csv');
		$data = mb_convert_encoding($data, "UTF-8", "SJIS");
		$ex_lines = explode("\r\n", $data);
		$count=0;
		foreach($ex_lines as $line){
			$holiday = explode(",", $line);
			$count++;
			//たまに,の無い説明書きがあるのでそれを除外＆count!=1 の部分で余計なデータを除外している
			if($holiday[0] && $holiday[1] && $count!=1){
				$uniquecheck = DB::table("holidays")->where("holiday","=",$holiday[0])->count();
				if($uniquecheck == 0){
					DB::table("holidays")->insert([
						'holiday'=> $holiday[0],
						'holiday_name'=> $holiday[1]
					]);
				}
			}
		}
	return redirect("/holiday")->with('message', 'CSVファイルを読み込み、カレンダーに反映しました');
	}

    public function addholiday(Request $req)
    {
        $date = $req->input('date');

        $shd = DB::table('holidays')->where('holiday','=',$date)->count();
        if($shd==0) {
            DB::table('holidays')->insert([
                'holiday' =>  $date ,
                'holiday_name' => '会社指定休日'
            ]);

        return redirect("/holiday")->with('addholiday',"$date を休日に設定しました");
        }else{
        return redirect("/holiday")->with('addholiday',"$date はすでに休日です");
        }
        
    }
    public function holiget()
    {
        $datetime = new DateTime();
        $year = $datetime->format('Y');//今年を取得
        $yearmodify = $datetime->modify('next year ');   
        $nextyear = $yearmodify->format('Y');    

        $holiget = DB::table('holidays')->select('holiday','holiday_name')->orderBy('holiday','asc')->get();//DBの祝日を取得 
            

        return view ('Admin.holiday',compact('holiget','year','nextyear'));
   }

    public function calendar(Request $request, $t)
    {

    }
}

