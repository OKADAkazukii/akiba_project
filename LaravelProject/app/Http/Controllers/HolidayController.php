<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class HolidayController extends Controller
{
	public function updataholiday(){
		$data = file_get_contents('http://www8.cao.go.jp/chosei/shukujitsu/syukujitsu_kyujitsu.csv');
		$data = mb_convert_encoding($data, "UTF-8", "SJIS");
		$ex_lines = explode("\r\n", $data);
		$count=0;
		$current_year = date('Y');
		foreach($ex_lines as $line){
			$holiday = explode(",", $line);
			$count++;
			//たまに,の無い説明書きがあるのでそれを除外＆count!=1 の部分で余計なデータを除外している
			if($holiday[0] && $holiday[1] && $count!=1){
				$uniquecheck = DB::table("holidays")->where("holiday","=",$holiday[0])->count();
				$csv_year = explode("-",$holiday[0]);
				if($csv_year[0] == $current_year && $uniquecheck == 0){
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

        return redirect("/holiday")->with('addholiday','休日設定完了！');
        }else{
        return redirect("/holiday")->with('addholiday',"$date はすでに休日に設定されております！");
        }
    }
    public function holiget()
    {
        $holiget = DB::table('holidays')->select('holiday')->get();
        return view ('Admin.holiday',compact('holiget'));
   }

    public function calendar(Request $request, $t)
    {

    }
}

