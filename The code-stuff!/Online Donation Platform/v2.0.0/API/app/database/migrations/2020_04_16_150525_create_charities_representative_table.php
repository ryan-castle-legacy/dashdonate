<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharitiesRepresentativeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charities_representative', function (Blueprint $table) {
			$table->increments('id');
			$table->timestamp('date_added')->useCurrent();
			$table->timestamp('last_updated')->useCurrent();
			$table->integer('charity_id');
			$table->integer('user_id');
			$table->string('trustee_number')->nullable();
			$table->string('legal_firstname')->nullable();
			$table->string('legal_lastname')->nullable();
			$table->timestamp('date_of_birth')->nullable();
			$table->string('phone_number')->nullable();
			$table->string('email_address')->nullable();
			$table->longText('address_line_1')->nullable();
			$table->longText('address_line_2')->nullable();
			$table->longText('address_town_city')->nullable();
			$table->longText('address_postcode')->nullable();
			$table->string('stripe_id_front')->nullable();
			$table->string('stripe_id_back')->nullable();
			$table->string('stripe_proof_of_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charities_representative');
    }
}
