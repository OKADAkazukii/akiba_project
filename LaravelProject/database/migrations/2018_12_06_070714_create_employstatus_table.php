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
            $table->double('');
            $table->double('');
            $table->double('');
            $table->double('');
            $table->double('');
            $table->int('');
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
