<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddgradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addgrades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gpafor');
            $table->string('schoolid');
            $table->string('gpaname');
            $table->string('point');
            $table->string('marksfrom');
            $table->string('marksto');
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
        Schema::dropIfExists('addgrades');
    }
}
