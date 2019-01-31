<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//
class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('emp_id');
            $table->integer('emp_status_id');
<<<<<<< HEAD
=======
            $table->integer('allowance_id');
>>>>>>> 0aff3d8acf976050af048078ddbba170c9b97741
            $table->integer('salary_year');
            $table->integer('salary_month');
            $table->decimal('salary_amount');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salaries');
    }
}
//