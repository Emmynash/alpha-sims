<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultReadyModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_ready_models', function (Blueprint $table) {
            $table->id();
            $table->integer('classid');
            $table->integer('sectionid');
            $table->integer('schoolid');
            $table->integer('term');
            $table->string('session');
            $table->integer('status');
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
        Schema::dropIfExists('result_ready_models');
    }
}
