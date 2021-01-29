<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTableAndAddDetailsToCharitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_uploads', function (Blueprint $table) {
			$table->increments('id');
			$table->timestamp('date_created')->useCurrent();
			$table->integer('user_id');
			$table->string('s3_url')->unique();
			$table->string('filename');
			$table->string('intent')->default('feed_media');
        });

		Schema::table('charities_details', function (Blueprint $table) {
			$table->longText('display_name')->nullable();
			$table->longText('display_bio')->nullable();
			$table->integer('logo_file_id')->nullable();
			$table->string('twitter_handle')->nullable();
			$table->string('facebook_handle')->nullable();
			$table->string('instagram_handle')->nullable();
			$table->string('linkedin_handle')->nullable();
			$table->string('brand_colour')->nullable();
			$table->string('brand_colour_alt')->nullable();
			$table->string('support_email')->nullable();
			$table->string('support_telephone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_uploads');
    }
}
