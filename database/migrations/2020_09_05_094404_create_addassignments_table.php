<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddassignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addassignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('classid')->nullable();
            $table->string('datefrom')->nullable();
            $table->string('dateto')->nullable();
            $table->string('content');
            $table->string('type');
            $table->string('schoolid');
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
        Schema::dropIfExists('addassignments');
    }
}
