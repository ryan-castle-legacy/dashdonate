<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_sessions', function (Blueprint $table) {
            $table->increments('id');
			$table->string('session_token')->unique();
			$table->string('csrf_token');
			$table->timestamp('date_created')->useCurrent();
			$table->timestamp('date_updated')->nullable();
			$table->integer('user_id')->nullable();
			$table->integer('site_id')->nullable();
			$table->string('active_url');
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
        Schema::dropIfExists('donation_sessions');
    }
}
