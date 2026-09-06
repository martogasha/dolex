<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesas', function (Blueprint $table) {
            $table->id();
            $table->string('ido')->nullable();
            $table->string('topic')->nullable();
            $table->string('createdAt')->nullable();
            $table->string('eventType')->nullable();
            $table->string('resourceId')->nullable();
            $table->string('status')->nullable();
            $table->string('reference')->unique();
            $table->datetime('originationTime')->nullable();
            $table->string('senderPhoneNumber')->nullable();
            $table->integer('amount')->nullable();
            $table->string('currency')->nullable();
            $table->string('tillNumber')->nullable();
            $table->string('system')->nullable();
            $table->string('senderFirstName')->nullable();
            $table->string('senderMiddleName')->nullable();
            $table->string('senderLastName')->nullable();
            $table->string('linkSelf')->nullable();
            $table->string('linkResource')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->integer('invoice_balance')->nullable();
            $table->integer('currentMonth')->nullable();
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
        Schema::dropIfExists('mpesas');
    }
}
