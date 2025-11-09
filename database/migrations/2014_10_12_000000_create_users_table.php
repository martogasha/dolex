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
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('location')->nullable();
            $table->integer('bandwidth')->nullable();
            $table->datetime('payment_date')->nullable();
            $table->datetime('due_date')->nullable();
            $table->datetime('sms_date')->nullable();
            $table->integer('time_difference')->nullable();
            $table->datetime('date_to_send_sms')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('amount_supposed_to_be_paid')->nullable();
            $table->integer('package_amount')->nullable();
            $table->integer('balance')->nullable();
            $table->integer('role');
            $table->integer('status')->nullable();
            $table->integer('products')->nullable();
            $table->integer('users')->nullable();
            $table->integer('customers')->nullable();
            $table->integer('payments')->nullable();
            $table->integer('expenses')->nullable();
            $table->integer('estimate')->nullable();
            $table->integer('invoice')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
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
