<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        AttendanceController::autofinish();
    }
}
