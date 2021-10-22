<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores_tables', function (Blueprint $table) {
            $table->id();
            $table->integer("regno");
            $table->integer('schoolid');
            $table->integer('classid');
            $table->integer("sectionid");
            $table->integer('subjectid');
            $table->bigInteger('marks');
            $table->integer("term");
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
        Schema::dropIfExists('scores_tables');
    }
}
