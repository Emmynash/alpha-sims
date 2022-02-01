<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddstudentSecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addstudent_secs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('classid');
            $table->string('schoolid');
            $table->string('usernamesystem')->unique();
            $table->string('renumberschoolnew');
            $table->string('nationality');
            $table->string('studentsection');
            $table->string('schoolsession');
            $table->string('gender');
            $table->string('studenthouse');
            $table->string('studentreligion');
            $table->string('bloodgroup');
            $table->string('studentclub');
            $table->string('studentshift');
            $table->string('studentfathername');
            $table->string('studentfathernumber');
            $table->string('studentmothersname');
            $table->string('studentmothersnumber');
            $table->string('studentpresenthomeaddress');
            $table->string('studentpermanenthomeaddress');
            $table->string('dateOfBirth');
            $table->string('sessionstatus')->nullable();
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
        Schema::dropIfExists('addstudent_secs');
    }
}
