<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharityFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charity_files', function (Blueprint $table) {
			$table->increments('id');
			$table->timestamp('date_added')->useCurrent();
			$table->timestamp('last_updated')->useCurrent();
			$table->integer('charity_id');
			$table->integer('user_id');
			$table->string('stripe_file_id');
			$table->string('file_intent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charity_files');
    }
}
