<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAuthReqBeenSentToTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations_task_list', function (Blueprint $table) {
			$table->boolean('auth_req_sent')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donations_task_list', function (Blueprint $table) {
			$table->dropColumn('auth_req_sent');
        });
    }
}
