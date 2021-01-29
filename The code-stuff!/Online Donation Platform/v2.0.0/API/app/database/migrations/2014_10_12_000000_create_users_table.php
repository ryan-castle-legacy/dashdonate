<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
			$table->text('user_role')->nullable();
            $table->boolean('is_admin')->default(false);
			$table->longText('stripe_customer_id')->nullable();
			$table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
			$table->boolean('is_email_confirmed')->default(false);
			$table->string('email_confirm_code')->nullable();
			$table->string('stripe_customer_token')->nullable();
			$table->boolean('needs_password_reset')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
