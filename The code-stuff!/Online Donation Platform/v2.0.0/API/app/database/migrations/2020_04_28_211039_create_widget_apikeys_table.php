<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWidgetApikeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widget_apikeys', function (Blueprint $table) {
            $table->increments('id');
			$table->timestamp('date_generated')->useCurrent();
			$table->string('key')->unique();
			$table->integer('charity_id');
			$table->boolean('is_enabled')->default(true);
        });
		// Add API site key record for charity
		Schema::table('charities', function (Blueprint $table) {
			$table->string('api_site_id')->nullable();
		});
		// Create default API key for DashDonate site
		DB::table('widget_apikeys')->truncate();
		// Create default API key for DashDonate site
		DB::table('widget_apikeys')->insert([
			'key'			=> 'DashDonate',
			'charity_id'	=> 0,
		]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('widget_apikeys');
    }
}
