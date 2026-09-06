<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class   CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('quotation_id')->nullable();
            $table->string('invoice_date');
            $table->string('payment_due')->nullable();
            $table->integer('amount');
            $table->integer('cash_id')->nullable();
            $table->integer('mpesa_id')->nullable();
            $table->integer('payment_id')->nullable();
            $table->integer('cash_amount')->nullable();
            $table->integer('mpesa_amount')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('time_difference')->nullable();
            $table->integer('usage_time')->nullable();
            $table->string('current_time')->nullable();
            $table->integer('balance');
            $table->integer('status');
            $table->integer('statas');
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
        Schema::dropIfExists('invoices');
    }
}
