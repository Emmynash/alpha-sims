<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddsubjectSecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addsubject_secs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('schoolid');
            $table->string('classid');
            $table->string('subjectcode');
            $table->string('subjectname');
            $table->string('subjecttype');
            $table->string('gradesystem');
            $table->string('totalfull');
            $table->string('totalpass');
            $table->string('examfull');
            $table->string('exampass');
            $table->string('ca1full');
            $table->string('ca1pass');
            $table->string('ca2full');
            $table->string('ca2pass');
            $table->string('ca3full');
            $table->string('ca3pass');
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
        Schema::dropIfExists('addsubject_secs');
    }
}
