<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePppoeclientdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pppoeclientdetails', function (Blueprint $table) {
            $table->id();
            $table->string('uptime')->nullable();
            $table->datetime('last_logged_out')->nullable();
            $table->string('status')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->integer('statusOne')->nullable();
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
        Schema::dropIfExists('pppoeclientdetails');
    }
}
