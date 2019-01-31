<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//
class CreateSumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('sums', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('emp_id');
            $table->integer('year');
            $table->integer('month');
            $table->integer('sum_worktime');
            $table->integer('sum_in_overtime');
            $table->integer('sum_outover_time');
            $table->integer('sum_latework_time');
            $table->integer('sum_lateover_time');
            $table->integer('sum_holiwork_time');
            $table->integer('sum_holilate_time');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sums');
    }
}
//