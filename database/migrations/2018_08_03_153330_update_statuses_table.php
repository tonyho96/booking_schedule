<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statuses', function (Blueprint $table) {
            //
			$table->string('color_background',255)->nullable();
			$table->string('color_text',255)->nullable();
			$table->dropColumn('created_at');
			$table->dropColumn('updated_at');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statuses', function (Blueprint $table) {
			$table->dropColumn('color_background');
			$table->dropColumn('color_text');

        });
    }
}
