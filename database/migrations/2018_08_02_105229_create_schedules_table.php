<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 255)->nullable();
			$table->string('description', 6400)->nullable();
			$table->integer('order_pos')->nullable();
			$table->string('resource_ids', 255)->nullable();
			$table->string('permission_ids', 255)->nullable();
			$table->dateTime('created_at')->nullable();
			$table->dateTime('updated_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
