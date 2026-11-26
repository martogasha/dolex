<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miks', function (Blueprint $table) {
            $table->id();
            $table->datetime('last_logout')->nullable();
            $table->string('name')->nullable();
            $table->integer('cpu')->nullable();
            $table->integer('ram')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('miks');
    }
}
