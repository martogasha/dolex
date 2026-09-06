<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePulltransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pulltransactions', function (Blueprint $table) {
            $table->id();
            $table->string('transactionId')->unique();
            $table->datetime('trxDate')->nullable();
            $table->string('msisdn')->nullable();
            $table->string('sender')->nullable();
            $table->string('transactiontype')->nullable();
            $table->string('billreference')->nullable();
            $table->integer('amount')->nullable();
            $table->string('organizationname')->nullable();
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
        Schema::dropIfExists('pulltransactions');
    }
}
