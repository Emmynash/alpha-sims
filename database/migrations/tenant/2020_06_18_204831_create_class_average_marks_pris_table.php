<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassAverageMarksPrisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_average_marks_pris', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subjectid');
            $table->string('schoolid');
            $table->string('classid');
            $table->string('average');
            $table->string('term');
            $table->string('session');
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
        Schema::dropIfExists('class_average_marks_pris');
    }
}
