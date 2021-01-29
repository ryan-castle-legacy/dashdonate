<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCronTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cron_tasks', function (Blueprint $table) {
            $table->increments('id');
			$table->string('task_token')->unique();
			$table->string('task_group_token')->nullable();

			$table->dateTime('date_created');
			$table->dateTime('date_to_process');
			$table->dateTime('date_processed')->nullable();
			$table->dateTime('date_updated')->nullable();

			$table->string('task_type');

			$table->integer('user_id')->nullable();
			$table->integer('charity_id')->nullable();
			$table->longText('meta')->nullable();

			$table->boolean('active')->default(true);
			$table->boolean('processing')->default(false);
			$table->boolean('reminder_sent')->default(false);
			$table->boolean('reminder_needed')->default(true);
			$table->boolean('auth_req_sent')->default(false);
			$table->integer('fail_count')->default(0);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cron_tasks');
    }
}
