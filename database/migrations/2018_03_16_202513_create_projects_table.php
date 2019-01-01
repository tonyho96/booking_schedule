<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->string('code', 255)->nullable();
            $table->string('description', 6400)->nullable();
            $table->integer('status_id')->nullable();
            $table->string('start_timestamp', 255)->nullable();
            $table->string('end_timestamp', 255)->nullable();
            $table->enum('private', array('Yes', 'No'));
            $table->integer('parent_folder_id')->nullable();
            $table->integer('client_person_id')->nullable();
            $table->integer('client_organization_id')->nullable();
            $table->string('project_order', 255)->nullable();
            $table->string('color_background', 255)->nullable();
            $table->string('color_text', 255)->nullable();
            $table->integer('created_id');
            $table->string('created', 255)->nullable();
            $table->integer('updated_id');
            $table->string('updated', 255)->nullable();
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('projects');
    }
}
