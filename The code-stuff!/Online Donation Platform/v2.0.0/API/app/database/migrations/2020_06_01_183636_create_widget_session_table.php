<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWidgetSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('widget_sessions', function (Blueprint $table) {
            $table->increments('id');
			$table->string('session_token')->unique();
			$table->date('date_created')->useCurrent();
			$table->date('date_updated')->useCurrent();
			$table->date('session_start')->nullable();
			$table->string('host_website');
			$table->string('host_webpage');
			$table->string('host_webpage_title');
			$table->string('referer_url');
			$table->string('user_agent');
			$table->string('csrf_token');
			$table->integer('user_id')->nullable();
			$table->integer('charity_id')->nullable();
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
        Schema::dropIfExists('widget_sessions');
    }
}
