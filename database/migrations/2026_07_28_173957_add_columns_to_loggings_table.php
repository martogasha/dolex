<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToLoggingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loggings', function (Blueprint $table) {
            $table->string('password')->nullable();
            $table->string('account')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('package')->nullable();
            $table->integer('package_amount')->nullable();
            $table->integer('current_balance')->nullable();
            $table->integer('add_balance')->nullable();
            $table->datetime('payment_date')->nullable();
            $table->datetime('due_date')->nullable();
            $table->integer('duplicate_id')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loggings', function (Blueprint $table) {
            //
        });
    }
}
