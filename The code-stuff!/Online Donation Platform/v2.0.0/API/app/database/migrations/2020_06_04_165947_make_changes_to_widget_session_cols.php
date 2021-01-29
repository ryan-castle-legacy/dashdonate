<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeChangesToWidgetSessionCols extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('widget_sessions', function (Blueprint $table) {
			$table->dropColumn('date_created');
			$table->dropColumn('date_updated');
			$table->dropColumn('session_start');
        });

        Schema::table('widget_sessions', function (Blueprint $table) {
			$table->timestamp('date_created')->useCurrent();
			$table->timestamp('date_updated')->useCurrent();
			$table->timestamp('session_start')->nullable();
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
