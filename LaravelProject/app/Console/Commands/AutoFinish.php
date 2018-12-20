<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
		$start_daytime = date('Y-m-d H:i');
		$daytime = explode(" ", $start_daytime);
		$day = $daytime[0];
		$time = $daytime[1];
		if($nofinish_attendances){
			foreach ($nofinish_attendances as $attendance) {
				DB::table("attendances")->where("id","=",$attendance->id)->update([
					'finish_time' => $time
				]);
				DB::table("attendances")->insert([
					'emp_id'=> $attendance->emp_id,
					'day'=> $day,
					'start_time'=> $time,
				]);
			}
		}
    }
}
