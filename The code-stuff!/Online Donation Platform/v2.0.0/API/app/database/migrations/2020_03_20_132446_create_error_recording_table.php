<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorRecordingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('error_recording', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			$table->boolean('resolved')->default(false);
			$table->timestamp('date_resolved')->nullable();
			$table->longText('line_number')->nullable();
			$table->longText('error_trace')->nullable();
			$table->longText('error_message')->nullable();
			$table->integer('error_count')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('error_recording');
    }
}
