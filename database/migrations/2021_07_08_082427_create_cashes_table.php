<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('invoice_id')->nullable();
            $table->integer('amount');
            $table->integer('invoice_balance')->nullable();
            $table->datetime('date');
            $table->string('reason')->nullable();
            $table->integer('status')->nullable();
            $table->integer('currentMonth');
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
        Schema::dropIfExists('cashes');
    }
}
