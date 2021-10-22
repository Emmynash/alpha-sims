<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarksTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks_tables', function (Blueprint $table) {
            $table->id();
            $table->integer('regno');
            $table->integer('schoolid');
            $table->integer('classid');
            $table->integer('subjectid');
            $table->bigInteger('totals');
            $table->bigInteger('position');
            $table->string('grades');
            $table->integer('points');
            $table->integer('term');
            $table->integer('section');
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
        Schema::dropIfExists('marks_tables');
    }
}
