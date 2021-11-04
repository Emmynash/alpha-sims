<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddStudentsToHostelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_student_to_hostels', function (Blueprint $table) {
            $table->id();
            $table->integer('schoolid');
            $table->integer('hostelid');
            $table->integer('systemid');
            $table->integer('roomid');
            $table->string('regno');
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
        Schema::dropIfExists('add_students_to_hostels');
    }
}
