<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmploystatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employstatus', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('employment_status');
            $table->double('in_overtime');
            $table->double('out_overtime');
            $table->double('late_overtime');
            $table->double('holiday_work');
            $table->double('late_holiday_work');
            $table->integer('closing_day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employstatus');
    }
}
