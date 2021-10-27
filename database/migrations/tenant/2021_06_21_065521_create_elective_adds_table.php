<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectiveAddsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elective_adds', function (Blueprint $table) {
            $table->id();
            $table->integer('userid');
            $table->integer('regno');
            $table->integer('subjectid');
            $table->integer('schoolid');
            $table->integer('subjecttype');
            $table->integer('classid');
            $table->integer('sectionid');
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
        Schema::dropIfExists('elective_adds');
    }
}
