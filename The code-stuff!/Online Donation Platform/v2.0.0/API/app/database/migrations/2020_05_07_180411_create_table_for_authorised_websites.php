<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableForAuthorisedWebsites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorised_websites', function (Blueprint $table) {
            $table->increments('id');
			$table->timestamp('date_generated')->useCurrent();
			$table->integer('charity_id');
			$table->string('website_url');
			$table->boolean('is_enabled')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authorised_websites');
    }
}
