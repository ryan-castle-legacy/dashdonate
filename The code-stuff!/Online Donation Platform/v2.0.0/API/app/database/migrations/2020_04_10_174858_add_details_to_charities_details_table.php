<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToCharitiesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('charities_details', function (Blueprint $table) {
			$table->longText('address_line_1')->nullable();
			$table->longText('address_line_2')->nullable();
			$table->longText('address_town_city')->nullable();
			$table->longText('address_postcode')->nullable();
			$table->longText('description_of_charity')->nullable();
        });

		Schema::table('charities', function (Blueprint $table) {
			$table->boolean('data_captured_from_commission')->default(false);
			$table->string('companies_house_number')->nullable();
			$table->string('commission_name')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('charities_details', function (Blueprint $table) {
			$table->dropColumn('address_line_1');
			$table->dropColumn('address_line_2');
			$table->dropColumn('address_town_city');
			$table->dropColumn('address_postcode');
			$table->dropColumn('description_of_charity');
        });

		Schema::table('charities', function (Blueprint $table) {
			$table->dropColumn('data_captured_from_commission');
			$table->dropColumn('companies_house_number');
			$table->dropColumn('commission_name');
		});
    }
}
