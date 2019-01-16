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
            $table->decimal('overtime_a');
            $table->decimal('late_overtime_a');
            $table->integer('tardiness');
            $table->decimal('absence');
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
