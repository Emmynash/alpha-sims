<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentResultModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_result_models', function (Blueprint $table) {
            $table->id();
            $table->string('assessmentcatname');
            $table->string('assessmentcatnamesub');
            $table->integer('term');
            $table->integer('regno');
            $table->string('session');
            $table->bigInteger('total');
            $table->string('average');
            $table->string('grade');
            $table->integer('space_id');
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
        Schema::dropIfExists('assessment_result_models');
    }
}
