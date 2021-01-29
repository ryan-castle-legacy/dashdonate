<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationTaskListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations_task_list', function (Blueprint $table) {
            $table->increments('id');
			$table->string('task_token')->unique();

			$table->timestamp('date_created')->useCurrent();
			$table->timestamp('date_to_process');
			$table->timestamp('date_processed')->nullable();
			$table->timestamp('date_updated')->nullable();

			$table->integer('user_id');
			$table->integer('charity_id');

			$table->integer('amount');
			$table->boolean('amount_includes_fees')->default(false);

			$table->boolean('recurring')->default(false);
			$table->integer('recurring_interval')->nullable();
			$table->string('recurring_duration')->nullable();
			$table->string('recurring_anchor')->nullable();

			$table->boolean('processing')->default(false);
			$table->boolean('reminder_sent')->default(false);
			$table->boolean('reminder_needed')->default(true);

			$table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donations_task_list');
    }
}
