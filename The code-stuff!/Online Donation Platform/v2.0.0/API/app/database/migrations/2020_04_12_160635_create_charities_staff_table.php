<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharitiesStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charities_staff', function (Blueprint $table) {
            $table->increments('id');
			$table->timestamp('date_added')->useCurrent();
			$table->timestamp('last_updated')->useCurrent();
			$table->timestamp('date_requested')->useCurrent();
			$table->boolean('request_approved')->nullable();
			$table->integer('charity_id');
			$table->integer('user_id');
			$table->string('role')->default('staff');
			$table->boolean('is_owner')->default(false);
			$table->boolean('is_representative')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charities_staff');
    }
}
