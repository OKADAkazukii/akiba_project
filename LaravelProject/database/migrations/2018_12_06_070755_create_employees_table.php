<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('emp_status_id');
            $table->integer('admin_id');
            $table->string('name');
            $table->string('login_hash');
            $table->decimal('basic_salary');
            $table->decimal('timesalary');
            $table->integer('basic_work_time');
            $table->date('retirement_day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
