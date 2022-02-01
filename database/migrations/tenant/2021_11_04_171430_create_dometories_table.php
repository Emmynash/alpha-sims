<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDometoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dometories', function (Blueprint $table) {
            $table->id();
            $table->integer('schoolid');
            $table->string('hostelname');
            $table->bigInteger('roomcount');
            $table->bigInteger('studentcount');
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
        Schema::dropIfExists('dometories');
    }
}
