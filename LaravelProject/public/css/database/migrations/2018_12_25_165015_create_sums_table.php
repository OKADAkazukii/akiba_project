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
            $table->date('pay_year_month');
            $table->integer('total_in_overtime');
            $table->integer('total_out_overtime');
            $table->integer('total_late_worktime');
            $table->integer('total_late_overtime');
            $table->integer('total_worktime');
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