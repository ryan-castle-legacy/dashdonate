<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApikeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apikeys', function (Blueprint $table) {
			$table->increments('id');
			$table->string('key');
			$table->string('author_ip');
            $table->timestamp('date_generated')->useCurrent();
        });

		// Create default API key for DashDonate site
		DB::table('apikeys')->insert([
			'key' 				=> 'demo_token',
			'author_ip' 		=> env('FRONTEND_URI'),
			'date_generated' 	=> date('Y-m-d H:i:s', time()),
		]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apikeys');
    }
}
