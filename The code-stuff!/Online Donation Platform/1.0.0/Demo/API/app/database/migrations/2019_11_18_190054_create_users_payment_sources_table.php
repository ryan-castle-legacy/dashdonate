<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPaymentSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_payment_sources', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamp('date_added')->useCurrent();
            $table->integer('user_id');
			$table->longText('stripe_source_id');
			$table->timestamp('expiry_date');
			$table->string('last_four_digits');
			$table->boolean('is_valid')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_payment_sources');
    }
}
