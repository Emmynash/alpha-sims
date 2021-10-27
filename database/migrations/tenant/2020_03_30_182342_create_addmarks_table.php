<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addmarks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('regno');
            $table->string('schoolid');
            $table->string('classid');
            $table->string('subjectid');
            $table->string('exams')->nullable();
            $table->string('ca1')->nullable();
            $table->string('ca2')->nullable();
            $table->string('ca3')->nullable();
            $table->string('totalmarks')->nullable();
            $table->string('grades')->nullable();
            $table->string('term');
            $table->string('session');
            $table->string('shift');
            $table->string('section');
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
        Schema::dropIfExists('addmarks');
    }
}
