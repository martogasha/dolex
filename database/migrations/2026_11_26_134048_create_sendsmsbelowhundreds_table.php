<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendsmsbelowhundredsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sendsmsbelowhundreds', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->nullable();
            $table->integer('statas')->nullable();
            $table->timestamps();
        });
           DB::table('sendsmsbelowhundreds')->insert([
            'status' => 0,
            'statas' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sendsmsbelowhundreds');
    }
}
