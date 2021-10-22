<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_marks', function (Blueprint $table) {
            $table->id();
            $table->integer('assesment_id');
            $table->integer('subassessment_id');
            $table->bigInteger('scrores');
            $table->integer('student_id');
            $table->integer('school_id'); //----
            $table->string('session'); //----
            $table->integer('term'); //----
            $table->integer('class_id');
            $table->integer('section_id');
            $table->integer('subjectid');
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
        Schema::dropIfExists('record_marks');
    }
}
