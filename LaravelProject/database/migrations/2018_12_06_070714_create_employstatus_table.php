<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//
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
            $table->decimal('in_overtime');
            $table->decimal('out_overtime');
            $table->decimal('late_overtime');
            $table->decimal('holiday_work');
            $table->decimal('late_holiday_work');
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
//