<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCharityChecklistItemsToCharityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('charities', function (Blueprint $table) {
			$table->boolean('needs_dashdonate_approval')->default(true);
			$table->boolean('needs_representative')->default(true);
			$table->boolean('needs_representative_id')->default(true);
			$table->boolean('representative_id_pending')->default(true);
			$table->boolean('needs_details_review')->default(true);
			$table->boolean('needs_staff_added')->default(true);
			$table->boolean('needs_bank_account')->default(true);
			$table->boolean('bank_account_needs_verified')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
