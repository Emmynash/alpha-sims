<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalenderModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calender_models', function (Blueprint $table) {
            $table->id();
            $table->integer('schoolid');
            $table->string('color')->nullable();
            $table->string('startdate');
            $table->string('starttime')->nullable();
            $table->string('title');
            $table->string('enddate')->nullable();
            $table->string('endtime')->nullable();
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
        Schema::dropIfExists('calender_models');
    }
}
