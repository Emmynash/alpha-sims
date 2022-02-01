<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms_models', function (Blueprint $table) {
            $table->id();
            $table->string('roomname');
            $table->bigInteger('roomcapacity');
            $table->bigInteger('roomcount');
            $table->integer('schoolid');
            $table->integer('hostelid');
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
        Schema::dropIfExists('rooms_models');
    }
}
