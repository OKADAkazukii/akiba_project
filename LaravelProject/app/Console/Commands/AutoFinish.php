<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
//----

class AutoFinish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:finish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'finish and start time auto set, if employee finish work yet';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $nofinish_attendances = DB::table("attendances")->where("finish_time","=","00:00:01")->get();
        $change_date_time = DB::table("settinges")->first();
		$day = date('Y-m-d');
		if($nofinish_attendances){
			foreach ($nofinish_attendances as $attendance) {
				DB::table("attendances")->where("id","=",$attendance->id)->update([
					'finish_time' => $change_date_time->change_date_time
				]);
                $db_view_time = DB::table("work_time")->where("id","=",$attendance->id)->first();
                if($db_view_time->worktime < 0){
                    DB::table("attendances")->where("id","=",$attendance->id)->update([
                        'rest_time' => 0,
                        'late_rest_time' => 0
                    ]);
                }
				DB::table("attendances")->insert([
					'emp_id'=> $attendance->emp_id,
					'day'=> $day,
					'start_time'=> $change_date_time->change_date_time,
                    'rest_time'=> 0,
                    'auto_finish_flag'=> 1,
                    'relation_attendance_id'=> $attendance->id,
				]);
			}
		}
    }
}
//----