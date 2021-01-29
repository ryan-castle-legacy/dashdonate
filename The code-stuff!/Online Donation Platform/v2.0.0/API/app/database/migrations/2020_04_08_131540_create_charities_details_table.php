<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharitiesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charities_details', function (Blueprint $table) {
            $table->increments('id');
			$table->timestamp('date_created')->useCurrent();
			$table->timestamp('date_updated')->useCurrent();
			$table->integer('charity_id');
			$table->string('charity_name')->nullable();
			$table->string('charity_website')->nullable();
			$table->string('phone_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charities_details');
    }
}
