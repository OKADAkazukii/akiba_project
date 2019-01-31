<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllowanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allowance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('emp_id');
            $table->integer('t_year');
            $table->integer('t_month');
            $table->decimal('t_inover');
            $table->decimal('t_outover');
            $table->decimal('t_latework');
            $table->decimal('t_lateover');
            $table->decimal('t_holiwork');
            $table->decimal('t_holilate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allowance');
    }
}
