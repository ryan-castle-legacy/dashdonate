<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInviteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_invites', function (Blueprint $table) {
			$table->increments('id');
			$table->string('invite_token');
			$table->timestamp('date_added')->useCurrent();
			$table->timestamp('last_updated')->useCurrent();
			$table->boolean('request_approved')->nullable();
			$table->integer('charity_id');
			$table->string('email_address');
			$table->integer('user_id')->nullable();
			$table->string('role')->default('staff');
			$table->boolean('invite_to_be_representative')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_invites');
    }
}
