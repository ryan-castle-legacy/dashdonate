<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentStatusToDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
			$table->string('payment_status')->nullable();
            $table->string('paymentIntent_id')->nullable();
			$table->boolean('is_anonymous_donation')->default(false);
			$table->boolean('is_guest_donation')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
			$table->dropColumn('payment_status');
			$table->dropColumn('paymentIntent_id');
			$table->dropColumn('is_anonymous_donation');
			$table->dropColumn('is_guest_donation');
        });
    }
}
