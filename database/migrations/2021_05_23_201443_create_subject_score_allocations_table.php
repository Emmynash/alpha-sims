<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectScoreAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_score_allocations', function (Blueprint $table) {
            $table->id();
            $table->integer('examsfull')->nullable();
            $table->integer('ca1full')->nullable();
            $table->integer('ca2full')->nullable();
            $table->integer('ca3full')->nullable();
            $table->integer('schoolid')->nullable();
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
        Schema::dropIfExists('subject_score_allocations');
    }
}
