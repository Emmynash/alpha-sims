<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddmotoPrisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addmoto_pris', function (Blueprint $table) {
            $table->id();
            $table->integer('moto_id');
            $table->integer('moto_score');
            $table->integer('schoolid');
            $table->string('session');
            $table->integer('term');
            $table->integer('student_id');
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
        Schema::dropIfExists('addmoto_pris');
    }
}
