<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_tables', function (Blueprint $table) {
            $table->id();
            $table->date('startdate');
            $table->date('submissiondate');
            $table->integer('subjectid');
            $table->integer('classid');
            $table->integer('sectionid');
            $table->text('description');
            $table->string('filelink')->nullable();
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
        Schema::dropIfExists('assignment_tables');
    }
}
