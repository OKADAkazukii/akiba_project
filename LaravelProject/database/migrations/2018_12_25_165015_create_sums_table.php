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
            $table->timestamps();
            $table->date('y_m');
            $table->integer('total_basic_worktime');
            $table->integer('total_overtime');
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